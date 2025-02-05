<?php

namespace App\Http\Controllers\Api\Member\Template;

use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DB;
use Mail;

use App\Http\Controllers\Controller;

abstract class TemplateMemberApiController extends Controller
{
	protected $accountService;
	protected $FileService;
	protected $memberRepository;

	public function __construct(
		$accountService,
		$fileService,
		$memberRepository,
		$target_table,
		$email_column
		// StatusRepository 		$statusRepository,
		// OrderFormRepository		$orderFormRepository,
	){
		$this->accountService 		= $accountService;
		$this->fileService 			= $fileService;
		$this->memberRepository 	= $memberRepository;
		$this->target_table 		= $target_table;
		$this->email_column			= $email_column;
	}

	public function check_repeat($cond){
		$res = $this->memberRepository->find($cond)->toArray();
		return (count($res)>0) ? true : false;
	}

	public function storeRegister(Request $request,$insData){
		$user = $request->all();
		$user['acct'] = $user['account'];
		// dump($user);exit;

		unset($cond);
		$cond['acct'] = $user['account'];
		$hasMember = $this->check_repeat($cond);
		if ($hasMember){
			$retData = ['status' => '400','message'=>'帳號重複'];
		}
		else{
			if(!isset($user['name'])){
				if(isset($user['user_name'])){
					$user['name'] = $insData['user_name'];
				}else{
					return ['status' => '400','message'=>'請輸入姓名'];
				}
			}
			if(!isset($user['password'])){
				if(isset($user['user_pw'])){
					$user['password'] = $insData['user_pw'];
				}else{
					return ['status' => '400','message'=>'請輸入密碼'];
				}
			}

			// 整理註冊資料
			$insData['acct'] 			= $user['account'];
			$insData['user_pw'] 		= $this->accountService->pwDecode($user['password']);
			$insData['user_name'] 		= $user['name'];

			// dump($insData);exit;
			$this->memberRepository->store($insData);
			$retData = ['status' => '200'];
		}

		return $retData;
	}//public function register()

	/*會員 取得會員資料*/
	public function memberShowRegister(Request $request){
		$user = $this->getRegisterInfo( Session::get($this->target_table.'.id') );
		$user = $this->arrange_show_data($user);
		// dump($reg);
		return $user;
	}
	/*整理顯示時的資料格式*/
	public function arrange_show_data($user){
		return $user;
	}

	/*會員 更新會員資料*/
	public function memberUpdateRegister(Request $request){
		
		$updData = $this->arrang_upload_data($request);

		$res = $this->getRegisterInfo( Session::get($this->target_table.'.id') );
		$this->memberRepository->update($res['id'],$updData);

		return ['status' => 200];
	}
	/*整理更新時的資料格式*/
	public function arrang_upload_data($request){
		$updData = $request->all();

		unset($updData['id']);
		unset($updData['account']);
		unset($updData['acct']);
		unset($updData['password']);

		if (isset($updData['user_pw'])){
			$updData['user_pw'] = $this->accountService->pwDecode($updData['user_pw']);
			unset($updData['passwordConfirm']);
		}

		return $updData;
	}

	// public function updateByAccountPassword(Request $request){
	// 	$updData = $request->all();

	// 	$cond['acct']	 = $updData['account'];
	// 	$cond['user_pw'] = $updData['password'];

	// 	$res = $this->memberRepository->find($cond)->toArray();
	// 	unset($updData['id']);
	// 	unset($updData['account']);
	// 	unset($updData['acct']);
	// 	unset($updData['password']);
	// 	unset($updData['user_pw']);

	// 	unset($updData['user_status']);
	// 	unset($updData['complete_reg']);
	// 	unset($updData['tracking_shop']);
	// 	unset($updData['created_at']);
	// 	unset($updData['updated_at']);

	// 	$user_id = $res[0]['id'];
	// 	$this->memberRepository->update($user_id, $updData);

	// 	return ['status' => 200];
	// }

	public function getRegisterInfo($userInfo){
		$account = (array)DB::table($this->target_table)->where('id','=',$userInfo)->get()->first();
		if($account){
			$account['account'] = $account['acct'];
			unset($account['acct']);
			unset($account['user_pw']);
		}else{
			$account['id'] = "0";
			$account['account'] = "";
		}

		return $account;
	}

	public function forgetPassword(Request $request){
		$account = $request->input('account');

		if(empty($account)) return ['status'=> '400', 'message' => '請輸入帳號'];
		unset($cond);
		$cond['acct'] = $account;
		$res = $this->memberRepository->find($cond)->toArray();

		// dump($res);
		if(count($res)>0){
			$res = $res[0];
			$newPw = $this->accountService->pwEncode($this->fileService->geraHash(6));
			$mailData['password']	= $newPw;
			$mailData['userMail']	= $res[$this->email_column];

			$this->mailPasswordToUser($mailData);

			unset($updData);
			$updData['user_pw'] = $newPw;
			$this->memberRepository->update($res['id'],$updData);

			return ['status' => '200'];
		}else{
			return ['status'=> '400', 'message' => '查無此帳號'];
		}
	}//public function forgetPassword()

	public function mailPasswordToUser($data){
		$seo_data = AppHelper::instance()->get_seo_data();

		//data['userMail'] data['password']
		Mail::send('emails.forgetPassword', $data, function ($message) use($seo_data, $data) {
			$mailAddr = env('MAIL_USERNAME');
			$mailArray = explode('@',$mailAddr);
			$message->from($mailAddr, $mailArray[0]);
			$message->subject($seo_data['web_title'].' 新密碼');
			$message->to($data['userMail']);
		});

	}//public function mailPasswordToUser($data)

////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function accountLogin(Request $request){
		$res = $this->findAccount($request);

		if (count($res) > 0){
			$result = $this->account_status_check($res[0]);
			if($result['status']=='200'){
				$this->storeUserInfo($res[0]);
			}
			return $result;
		}else{
			return ['status'=>'500','message'=>'帳密不符'];
		}
	}
	abstract public function account_status_check($account); /*檢查帳號登入狀態*/
	abstract public function account_show_check($account); 	 /*檢查帳號顯示狀態*/

	/*line 授權*/
	public function lineAuth(Request $request){
		$line_code = $request->get('code');

		try {
			/*get id_token*/
			$post_data = "
						grant_type=authorization_code&
						code=". $line_code ."&
						client_id=". env('LINE_CHANNEL_ID') ."&
						client_secret=". env('LINE_SECRET') ."&
						redirect_uri=".urlencode(env('LINE_CALL_BACK_URL'));
			$post_data = str_ireplace(array("\t","\n",'\t','\n'),'', $post_data);
			// dump($post_data);
			$post_url = "https://api.line.me/oauth2/v2.1/token";
			$token_resp = AppHelper::instance()->http_request($post_url,$post_data);
			$token_resp = (array)json_decode($token_resp);
			// dump($token_resp);

			/*get line id、name*/
			$post_data = "
						id_token=". $token_resp['id_token'] ."&
						client_id=". env('LINE_CHANNEL_ID');
			$post_data = str_ireplace(array("\t","\n",'\t','\n'),'', $post_data);
			// dump($post_data);
			$post_url = "https://api.line.me/oauth2/v2.1/verify";
			$line_info_resp = AppHelper::instance()->http_request($post_url,$post_data);
			$line_info_resp = (array)json_decode($line_info_resp);
			// dump($line_info_resp);

			$line_id = $line_info_resp['sub'];
			$line_name = $line_info_resp['name'];

			$cond = ['line_id'=>$line_id];
			$has_lineid = $this->check_repeat($cond);

			$viewData['line_id']   = $line_id;
			$viewData['line_name'] = $line_name;

			if($has_lineid && !session::get($this->target_table.'.id')){ // 已註冊過Line 且 未登入
				$viewData['webTitle'] = '社群登入';
				return view($this->target_table.".login.lineLogin", $viewData); /*自動登入*/
			}
			else if($has_lineid && session::get($this->target_table.'.id')){ /*已註冊過Line 且 已登入，無法綁定*/
				echo "<script>
						alert('此Line帳號已註冊成會員，無法進行綁定');
						location.href = '/".$this->target_table."';
					</script>"; /*返回會員頁面*/
			}
			else if(!$has_lineid && session::get($this->target_table.'.id')){ /*未註冊過Line 且 已登入，進行綁定*/
				$this->memberRepository->update(session::get($this->target_table.'.id'), ['line_id'=>$line_id]);
				return redirect('/'.$this->target_table); /*返回會員頁面*/
			}
			else{ // 未註冊過 且 未登入
				$viewData['pageTitle'] = '消費者註冊';
				return view($this->target_table.".login.register", $viewData); /*註冊畫面(帶入Line資料)*/
			}

		} catch (\Exception $e) {
			return redirect('/'.$this->target_table."/login"); /*登入畫面*/
		}
	}
	/*社群登入*/
	public function socialLogin(Request $request){
		$request_obj = $request->all();
		$res = $this->memberRepository->find($request_obj)->toArray();

		$viewData = $request_obj;
		$result = $this->account_status_check($res[0]);
		if($result['status']=='200'){
			$this->storeUserInfo($res[0]);
		}
		if($result['status']=='400'){
			return view($this->target_table.".login.fillRegister", $viewData); /*快速登入(補資料)*/
		}else if($result['status']=='200'){
			return redirect('/'.$this->target_table); /*會員畫面*/
		}else{
			return $result;
		}
	}


	public function findAccount(Request $request){
		$user = $request->all();	

		$acct 		= $user['account'];
		$user_pw 	= $this->accountService->pwEncode($user['password']);
		unset($cond);

		$cond = [
			['acct',	'=', $acct],
			['user_pw',	'=', $user_pw]
		];
		$res = $this->memberRepository->find($cond)->toArray();

		return $res;
	}//public function auth()
	public function storeUserInfo($userData){
		Session::put($this->target_table,[]);
		Session::put($this->target_table.'.id',			$userData['id']);
		Session::put($this->target_table.'.account',	$userData['acct']);
		Session::put($this->target_table.'.name',		$userData['user_name']);
		Session::put($this->target_table.'.status',		$userData['user_status']);
	}

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/*台列表功能------------------------*/
	/*分頁列表(client)(無分頁)*/
	public function clientShowPage(Request $request){		
		$request_obj = $request->all();
		$currentPage = $request->get('currentPage') ?  $request->get('currentPage') : 0;
		$countOfPage = $request->get('countOfPage') ?  $request->get('countOfPage') : 0;
		unset($request_obj['currentPage']);
		unset($request_obj['countOfPage']);
		$res = $this->memberRepository->showMemberPage($request_obj);
		$users = $res['res']->toArray();

		/*排除不顯示的user*/
		$users_filtered = [];
		array_walk($users, function($item)use(&$users_filtered){
			$result = $this->account_show_check($item); /*判斷帳號狀態*/
			if($result['status']=='200'){
				array_push($users_filtered, $this->arrange_show_data($item));
			}
		});
		$res['totalItem'] = count($users_filtered);/*更新總數*/

		if($countOfPage!=0){
			/*計算總頁數*/
			$res['totalPage'] = (int)($res['totalItem'] / $countOfPage);
			if($res['totalItem'] % $countOfPage!=0){
				$res['totalPage'] += 1;
			}

			/*處理回傳user*/
			$start_index = ($currentPage-1) * $countOfPage;
			$users_filtered = array_slice($users_filtered, $start_index, $countOfPage); 
		}

		$res['res'] = $users_filtered;
		return $res;
	}
	/*分頁列表(admin)*/
	public function adminShowPage(Request $request){		
		$request_obj = $request->all();
		$res = $this->memberRepository->showMemberPage($request_obj);
		$res['res'] = $res['res']->toArray();

		return $res;
	}

	/*以id取得會員資料(client)*/
	public function clientShowMemberInfo(Request $request, $memberId){
		$account = $this->getRegisterInfo($memberId);
		if($account['id']==0){
			return response([]);
		}

		$result = $this->account_show_check($account); /*判斷帳號狀態*/
		if($result['status']=='200'){
			$account = $this->arrange_show_data($account);
			return response($account);
		}else{
			return response([]);
		}
	}
	/*以id取得會員資料(admin)*/
	public function adminShowMemberInfo(Request $request, $memberId){
		$account = $this->getRegisterInfo($memberId);
		$account = $this->arrange_show_data($account);
		return response($account);
	}

	/*更新資料*/
	public function adminUpdateMemberInfo(Request $request, $memberId){
		$updData = $this->arrang_upload_data($request);

		if($memberId=='0'){ /*新增*/
			$result = $this->storeRegister($request, $updData);
			return $result;

			// if($updData['acct']==""){
			// 	return ['status' => '400','message'=>'請輸入帳號'];
			// }

			// $cond['acct'] = $updData['acct'];
			// $hasMember = $this->check_repeat($cond);
			// if($hasMember){
			// 	return ['status' => '400','message'=>'帳號重複'];
			// }

			// if($updData['user_pw']==""){
			// 	return ['status' => '400','message'=>'請輸入密碼'];
			// }
			// $updData['user_pw']	= $this->accountService->pwEncode($updData['user_pw']);

			// if($updData['user_name']==""){
			// 	return ['status' => '400','message'=>'請輸入姓名'];
			// }

			// $this->memberRepository->store($updData);

		}else{ /*編輯*/
			// dump($updData);exit;
			unset($updData['password']);
			$this->memberRepository->update($memberId, $updData);
		}
		return ['status' => '200'];
	}

	/*更新狀態*/
	public function adminUpdateUserStatus(Request $request){
		$member_array 	= $request->input('member_array');
		$status_column 	= $request->input('status_column');
		$status_value 	= $request->input('status_value');

		$memberId 				 = $member_array;
		$updData[$status_column] = $status_value;

		$this->memberRepository->ArrayUpdate($memberId,$updData);

		return ['status' => '200'];
	}
}