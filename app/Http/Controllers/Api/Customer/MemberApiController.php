<?php

namespace App\Http\Controllers\Api\Customer;

Use App\Services\AccountService;
use App\Services\FileService;
use App\Repositories\Customer\MemberRepository;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Member\MemberApiController as shop_MemberApiController;

use App\Http\Controllers\Api\Member\Template\TemplateMemberApiController;
use App\Http\Controllers\Api\ExportApiController;
use Maatwebsite\Excel\Facades\Excel;

class MemberApiController extends TemplateMemberApiController
{
	protected $memberRepository;
	protected $shop_MemberApiController;

	public function __construct(
		AccountService 				$accountService,
		FileService 				$fileService,
		MemberRepository 			$memberRepository,
		shop_MemberApiController	$shop_MemberApiController
	){
		parent::__construct(
			$accountService,
			$fileService,
			$memberRepository,
			$target_table = 'customer',
			$email_column = 'email'
		);
		$this->memberRepository = $memberRepository;
		$this->shop_MemberApiController = $shop_MemberApiController;
	}

	/*覆寫 儲存會員資料(註冊):有額外欄位，且需檢查LINE id重複*/
	public function storeRegister(Request $request,$insData=[]){
		$user = $request->all();
		
		$insData['email']		= isset($user['email'])?$user['email']:'';
		$insData['birth_day']	= isset($user['birth_day'])?$user['birth_day']:'';
		$insData['city'] 		= isset($user['county'])?$user['county']:'';
		$insData['district'] 	= isset($user['district'])?$user['district']:'';
		$insData['zipcode'] 	= isset($user['zipcode'])?$user['zipcode']:'';
		$insData['road'] 		= isset($user['road'])?$user['road']:'';
		if($insData['zipcode'] == ""){ unset($insData['zipcode']); }

		$insData['telephone'] 	= isset($user['contactPhone'])?$user['contactPhone']:'';
		$insData['line_id'] 	= isset($user['line_id'])?$user['line_id']:'';

		$insData['user_status']  = 1;
		$insData['complete_reg'] = 1;
		
		$hasLineId = parent::check_repeat(['line_id'=>$insData['line_id']]);
		if($hasLineId && $insData['line_id']!=''){
			$retData = ['status' => '400','message'=>'Line帳號重複'];
		}else{
			/*資料驗證*/
			if( !$user['name'] ){
				return $retData = ['status' => '400','message'=>'請輸入姓名'];
			}
			if( !preg_match('/^09\d{8}$/' ,$user['account']) ){
				return $retData = ['status' => '400','message'=>'會員帳號請輸入09開頭的10碼手機'];
			}
			if( !preg_match('/[^@ \t\r\n]+@[^@ \t\r\n]+\.[^@ \t\r\n]+/' ,$insData['email']) ){
				return $retData = ['status' => '400','message'=>'請輸入信箱 或 信箱格式有誤'];
			}
			if( !$insData['city'] || !$insData['district'] || !$insData['road'] ){
				return $retData = ['status' => '400','message'=>'請輸入地址'];
			}
			
			$retData = parent::storeRegister($request, $insData);
		}
		return $retData;
	}

	/*實體化 會員狀態判斷*/
	public function account_status_check($account){
		if ($account['complete_reg'] == 0){
			return ['status'=>'400','message'=>'此帳號未完成註冊，請完成後再登入'];
		}else if ($account['user_status'] == 0){
			return ['status'=>'500','message'=>'帳號已停用'];
		}else{
			return ['status'=>'200'];
		}
	}

	/*實體化 會員是否顯示判斷*/
	public function account_show_check($account){
		if ($account['complete_reg'] == 0){
			return ['status'=>'400','message'=>'此帳號未完成註冊，請完成後再登入'];
		}else if ($account['user_status'] == 0){
			return ['status'=>'500','message'=>'帳號已停用'];
		}else{
			return ['status'=>'200'];
		}
	}

	/*覆寫 整理顯示時的資料格式*/
	public function arrange_show_data($user){
		// 追蹤店家
		$tracking_shop = $user['tracking_shop'] ? explode(',', $user['tracking_shop']) : [];
		$tracking_shop = array_reverse($tracking_shop);/*反轉，越後(新)追蹤排越前*/
		$tracking_shop_filtered = [];
		$request_obj = new Request([]);
		array_walk($tracking_shop, function($item)use(&$tracking_shop_filtered,$request_obj){
			$shop = $this->shop_MemberApiController->clientShowMemberInfo($request_obj, $item);
			if($shop){
				array_push($tracking_shop_filtered, $shop->getOriginalContent());
			}
		});
		$user['trackingShop'] = $tracking_shop_filtered;

		return $user;
	}

	/*整理更新時的資料格式*/
	public function arrang_upload_data($request){
		$updData = $request->all();
		unset($updData['trackingShop']);

		$request_obj = new Request($updData);
		$updData = parent::arrang_upload_data($request_obj);

		return $updData;
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/*customer特有功能--------------------------------------------*/
	/*匯出列表(admin)*/
	public function adminExportPage(Request $request){		
		$request_obj = $request->all();

		$file_name = isset($request_obj['file_name']) ? $request_obj['file_name'] : '清單資料';
		unset($request_obj['file_name']);

		$res = $this->memberRepository->showMemberPage($request_obj);
		$res['res'] = $res['res']->toArray();

		$excel = [
			/* 表頭(對應資料key值，欄位名稱) */
			'head' => [
				'acct'=>'帳號',
				'user_name'=>'名稱',
				'email'=>'信箱',
			],
			/* 資料 */
			'data' => $res['res'],
		];
		// dump($res);exit;
		return Excel::download(new ExportApiController($excel), $file_name.'.xlsx');
	}

	/*消費者快速登入------------------*/
	public function outSideLogin(Request $request){
		$result = parent::accountLogin($request);

		if($result['status']=='200'){
			$account = $this->findAccount($request)[0];
			unset($account['user_pw']);
			unset($account['user_status']);
			unset($account['complete_reg']);
			return ['status'=>'200', 'user_id'=> $account];
		}else{
			return $result;
		}
	}

	/*登入額外紀錄line id*/
	public function storeUserInfo($userData){
		parent::storeUserInfo($userData);

		Session::put('customer.line_id', $userData['line_id']);
	}
	
	/*快速註冊(只建立會員資料、無法登入)*/
	public function rapidRegister(Request $request){
		$insData['user_status']	= 0; /*快速註冊先不可登入，補齊資料後才可登入*/
		
		$user = $request->all();
		$request_array  = [
				'account'		=> $user['account'],
		    	'password'		=> $user['account'],
		    	'name'			=> ''
		];
		$request_obj = new Request($request_array);

		$retData = parent::storeRegister($request_obj, $insData);
		return $retData;
	}

	/*登入(補充資料登入)*/
	public function rapidLogin(Request $request){
		$user = $request->all();
		$cond = [
			['acct','=', $user['account']]
		];
		$res = $this->memberRepository->find($cond)->toArray();

		if (count($res) > 0){
			if($res[0]['complete_reg'] == 1){
				return ['status'=>'200'];
			}else{
				$this->storeUserInfo($res[0]);
				return ['status'=>'400','message'=>'此帳號未完成註冊'];
			}
		}else{
			return ['status'=>'500','message'=>'無此帳號'];
		}
	}

	/*補充註冊資料*/
	public function fillUpRegister(Request $request){
		$request_obj = $request->all();
		$request_obj['user_status']  = 1;
		$request_obj['complete_reg'] = 1;
		$request_obj = new Request($request_obj);

		$retData = parent::memberUpdateRegister($request_obj);

		$user = $request->all();
		if($retData['status']=='200'){
			$request_array = [
		    	'account'	=> $user['account'],
		    	'password'	=> $user['user_pw'],
			];
			$request_obj = new Request($request_array);
			$res = parent::findAccount($request_obj);
			$this->storeUserInfo($res[0]);

			return ['status'=>'200','message'=>'註冊完成'];
		}else{
			return $retData;
		}
	}

	/*追蹤/取消追蹤店家*/
	public function tracking_shop(Request $request){
		$registerInfo 	= $this->getRegisterInfo( Session::get('customer.id') );
		$user_id 		= $registerInfo['id'];
		$tracking_shop 	= $registerInfo['tracking_shop'] ? explode(',', $registerInfo['tracking_shop']) : [];

		$shop_id = $request->get('shop_id');
		$method = $request->get('method');

		if($method=='add' && !in_array($shop_id, $tracking_shop)){
			array_push($tracking_shop, $shop_id);

			/*api 新增會店家員*/
			/*--------------------------------*/
			/*--------------------------------*/

		}else if($method=='subtract' && in_array($shop_id, $tracking_shop)){
			$key = array_search($shop_id, $tracking_shop);
			if (false !== $key) {
			    unset($tracking_shop[$key]);
			}

			/*api 刪除店家會員*/
			/*--------------------------------*/
			/*--------------------------------*/

		}else{
			return ['status'=>'400'];
		}

		$request_array['tracking_shop'] = implode(",", $tracking_shop);

		/*更新會員資料*/
		$request_obj = new Request($request_array);
		$retData = parent::memberUpdateRegister($request_obj);
		return $retData;
	}
}//class MemberApiController extends Controller
