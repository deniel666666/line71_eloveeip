<?php

namespace App\Http\Controllers\Api\Member;

Use App\Services\AccountService;
use App\Services\FileService;
use App\Repositories\Member\MemberRepository;
use App\Repositories\MailboxRepository;
use App\Models\Member\MemberTypeRelationModel;

use App\Models\Gallery\MemberAssociateTypeGalleryModel;

use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use File;
use DB;
use Mail;

use App\Http\Controllers\Api\Member\Template\TemplateMemberApiController;
use App\Http\Controllers\Api\ExportApiController;
use Maatwebsite\Excel\Facades\Excel;

class MemberApiController extends TemplateMemberApiController
{
	protected $accountService;
	protected $FileService;
	protected $memberRepository;
	protected $mailboxRepository;

	protected $baseUrl;
	protected $publicFilePath =  '/public/upload/member/';

	public function __construct(
		AccountService 			$accountService,
		FileService 			$fileService,
		MemberRepository 		$memberRepository,
		MailboxRepository 		$mailboxRepository
	){
		parent::__construct(
			$accountService,
			$fileService,
			$memberRepository,
			$target_table = 'member',
			$email_column = 'acct'
		);

		$this->baseUrl 				= 'http://'.$_SERVER['HTTP_HOST'];
		$this->memberRepository 	= $memberRepository;
		$this->mailboxRepository 	= $mailboxRepository;
	}

	/*覆寫 儲存會員資料(註冊):有額外欄位，且需寄送驗證碼*/
	public function storeRegister(Request $request,$insData=[]){
		$user = $request->all();
		if(!isset($user['acct'])){
			$user['acct'] = isset($user['account']) ? $user['account'] : "";
		}
		
		$insData['user_ids'] 		= isset($user['user_ids'])?$user['user_ids']:'';
		$insData['id_code'] 		= isset($user['id_code'])?$user['id_code']:'';
		$insData['service_type'] 	= isset($user['service_type'])?$user['service_type']:'';
		
		$insData['city'] 		= isset($user['county'])?$user['county']:'';
		$insData['district'] 	= isset($user['district'])?$user['district']:'';
		$insData['zipcode'] 	= isset($user['zipcode'])?$user['zipcode']:'';
		$insData['road'] 		= isset($user['road'])?$user['road']:'';
		if($insData['zipcode'] == ""){ unset($insData['zipcode']); }

		$insData['cellphone'] 	= isset($user['cellPhone'])?$user['cellPhone']:'';
		$insData['telephone'] 	= isset($user['contactPhone'])?$user['contactPhone']:'';

		$insData['contact_name'] 	= isset($user['contact_name'])?$user['contact_name']:'';
		$insData['number_id'] 		= isset($user['number_id'])?$user['number_id']:'';
		$insData['email'] 			= isset($user['email'])?$user['email']:'';

		
		$userInfo['web']		= isset($user['web'])?$user['web']:'';
		$userInfo['resttime']	= isset($user['resttime'])?$user['resttime']:'';
		$userInfo['wroktime']	= isset($user['wroktime'])?$user['wroktime']:'';
		$insData['user_info'] 	= json_encode($userInfo, JSON_UNESCAPED_UNICODE);

		$insData['member_company_type'] = isset($user['member_company_type'])?$user['member_company_type']:'';
		$insData['member_area'] 		= isset($user['member_area'])?$user['member_area']:'';
		$insData['member_prod_type'] 	= isset($user['member_prod_type'])?$user['member_prod_type']:'';
		$insData['member_category'] 	= isset($user['member_category'])?$user['member_category']:'';

		$insData['user_status'] = 1;
		$insData['show_status'] = 0;
		$insData['user_active']	= 0;
		$insData['active_code']	= sha1(uniqid(time()));

		$retData = parent::storeRegister($request, $insData);

		if($retData['status']=='200'){
			unset($mailData);
			$mailData['activeCodeUrl'] = $this->baseUrl."/api/member/activecode/".$insData['active_code'];
			$mailData['userMail']	= $user[$this->email_column];
			$this->mailActiveCodeToUser($mailData);
		}

		return $retData;
	}

	/*實體化 會員狀態判斷*/
	public function account_status_check($account){
		if($account['id']=="0"){
			return ['status'=>'500','message'=>'無此帳號'];
		}
		else if ($account['user_active'] == 0){
			return ['status'=>'500','message'=>'帳號未激活'];
		}else if ($account['user_status'] == 0){
			return ['status'=>'500','message'=>'帳號已停用'];
		}else{
			return ['status'=>'200'];
		}
	}

	/*實體化 會員是否顯示判斷*/
	public function account_show_check($account){
		if($account['id']=="0"){
			return ['status'=>'500','message'=>'無此帳號'];
		}
		else if ($account['user_active'] == 0){
			return ['status'=>'500','message'=>'帳號未激活'];
		}else if ($account['user_status'] == 0){
			return ['status'=>'500','message'=>'帳號已停用'];
		}else if($account['show_status']==0){
			return ['status'=>'500','message'=>'帳號不可顯示'];
		}else{
			$request = new Request([]);
			$memberTypes = AppHelper::instance()->getMemberTypes($account['id'],$timeToStr=false);
			$account = AppHelper::instance()->getArrangedMemberTypes($account, $memberTypes); // 找出當前使用方案

			if($account['type']){
				return ['status'=>'200'];
			}else{
				return ['status'=>'500','message'=>'帳號未購買方案'];
			}
		}
	}
	
	/*覆寫 整理顯示時的資料格式*/
	public function arrange_show_data($user){
		// 使用者內容
		$userInfo = isset($user['user_info']) ? json_decode($user['user_info'],true) : [];
		foreach ($userInfo as $key => $value) {
			$user['userInfo'][$key] 	= $value;
		}

		if(isset($user['pic'])){
			$user['pic'] 	= $this->publicFilePath.$user['id'].'/'.$user['pic']; //主圖
		}else{
			$user['pic'] 	= "";
		}
		if(isset($user['logo'])){
			$user['logo'] 	= $this->publicFilePath.$user['id'].'/'.$user['logo']; //logo
		}else{
			$user['logo'] 	= "";
		}

		// 副圖
		$sub_pics_urls = [];
		if(isset($user['sub_pics'])){
			if($user['sub_pics']!==null){
				foreach (json_decode($user['sub_pics'],true) as $key => $value) {
					array_push($sub_pics_urls, $this->publicFilePath.$user['id'].'/'.$value);
				}
			}
		}
		$user['sub_pics'] 		= $sub_pics_urls;

		// 購物車連結
		$request = new Request([]);
		$memberTypes = AppHelper::instance()->getMemberTypes($user['id'],$timeToStr=false);
		$user = AppHelper::instance()->getArrangedMemberTypes($user, $memberTypes);

		// 會員相關分類
		$member_associate_gallery = [
			'member_area' => 1,
			'member_prod_type' => 2,
			'member_category' => 3,
			'member_company_type' => 5,
		];
		foreach ($member_associate_gallery as $key => $value) {
			if(isset($user[$key])){
				$user[$key.'_detail'] 	= MemberAssociateTypeGalleryModel::whereIn('gallery_id', explode(',', $user[$key]))
																		->where('gallery_type_id',$value)
																		->orderBy('slider_order', 'asc')
																		->orderBy('gallery_id', 'desc')->get()->toArray();
				foreach ($user[$key.'_detail'] as $k2 => $v2) {
					$user[$key.'_detail'][$k2]['gallery_cont'] = (Array)json_decode($v2['gallery_cont']);
				}
				$user[$key] 		= explode(',', $user[$key]);
			}else{
				$user[$key.'_detail'] = [];
			}

		}

		return $user;
	}

	/*覆寫 整理上傳資料格式*/
	public function arrang_upload_data($request){
		unset($updData);
		$updData = $request->all();

		$user_id = $updData['id'];

		/*使用者內容*/
		$updData['userInfo'] = isset($updData['userInfo']) ? $updData['userInfo'] : [];
		$updData['user_info'] = json_encode($updData['userInfo'], JSON_UNESCAPED_UNICODE);
		unset($updData['userInfo']);
		
		unset($updData['type']);
		unset($updData['show_shop_link']);
		unset($updData['member_area_detail']);
		unset($updData['member_prod_type_detail']);
		unset($updData['member_category_detail']);
		unset($updData['member_company_type_detail']);

		/*主圖*/
		$pic = $updData['pic'];
		if(!empty($pic) && strpos($pic, $this->publicFilePath) === false ){
			$img = $pic;
			$fileName = AppHelper::instance()->renameFile($img);
			$updData['pic'] = $fileName;
			$getInsertId = $user_id;
            if ($getInsertId != 0) {
                if (!File::exists(base_path().$this->publicFilePath.$getInsertId)) {
                    File::makeDirectory(base_path().$this->publicFilePath.$getInsertId, 0775);
                }
                AppHelper::instance()->uploadFile($this->publicFilePath.$getInsertId, $fileName, $img);
                DB::commit();
            } else {
                $msg = 'Insert DB error.';
                DB::rollback();
            }
		}else{
			unset($updData['pic']);
		}

		/*logo圖*/
		$logo = $updData['logo'];
		if(!empty($logo) && strpos($logo, $this->publicFilePath) === false ){
			$img = $logo;
			$fileName = AppHelper::instance()->renameFile($img);
			$updData['logo'] = $fileName;
			$getInsertId = $user_id;
            if ($getInsertId != 0) {
                if (!File::exists(base_path().$this->publicFilePath.$getInsertId)) {
                    File::makeDirectory(base_path().$this->publicFilePath.$getInsertId, 0775);
                }
                AppHelper::instance()->uploadFile($this->publicFilePath.$getInsertId, $fileName, $img);
                DB::commit();
            } else {
                $msg = 'Insert DB error.';
                DB::rollback();
            }
		}else{
			unset($updData['logo']);
		}

		/*副圖*/
		foreach ($updData['sub_pics'] as $key => $value) {
			if(!empty($value) && strpos($value, $this->publicFilePath) === false && strlen($value) > 100){
				$img = $value;
				$fileName = AppHelper::instance()->renameFile($img);
				$updData['sub_pics'][$key] = $fileName;
				$getInsertId = $user_id;
	            if ($getInsertId != 0) {
	                if (!File::exists(base_path().$this->publicFilePath.$getInsertId)) {
	                    File::makeDirectory(base_path().$this->publicFilePath.$getInsertId, 0775);
	                }
	                AppHelper::instance()->uploadFile($this->publicFilePath.$getInsertId, $fileName, $img);
	                DB::commit();
	            } else {
	                $msg = 'Insert DB error.';
	                DB::rollback();
	            }
	        }else{
	        	$sub_pics_url = explode('/', $value);
	        	$updData['sub_pics'][$key] = end($sub_pics_url);
	        }
		}
		$updData['sub_pics'] = json_encode($updData['sub_pics']);

		/*密碼*/
		if (isset($updData['user_pw'])){
			$updData['user_pw'] = $this->accountService->pwDecode($updData['user_pw']);
			unset($updData['passwordConfirm']);
		}

		/*刪除不準修改及額外欄位*/
		if($user_id=="0"){
			$updData['acct'] = $updData['account'];
			$updData['user_pw'] = isset($updData['user_pw']) ? $updData['user_pw'] : "";
			$updData['user_name'] = isset($updData['user_name']) ? $updData['user_name'] : "";
		}else{
			unset($updData['acct']);
		}
		unset($updData['id']);
		unset($updData['account']);

		return $updData;
	}

	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/*member特有功能--------------------------------------------*/
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
			],
			/* 資料 */
			'data' => $res['res'],
		];
		// dump($res);exit;
		return Excel::download(new ExportApiController($excel), $file_name.'.xlsx');
	}

	/*後台 寄送驗證碼*/
	public function sendActiveCode(Request $request){
		$id = $request->input('id');
		$member = $this->memberRepository->show($id)->toArray();

		$data['activeCodeUrl'] 	= $this->baseUrl."/api/member/activecode/".$member['active_code'];
		$data['userMail'] 		= $member[$this->email_column];

		$this->mailActiveCodeToUser($data);

		return ['status' => '200'];
	}//public function sendActiveCode()
	
	/*寄送驗證碼信*/
	public function mailActiveCodeToUser($data){
		Mail::send('emails.activeCode', $data, function ($message) use($data) {
			$mailAddr = env('MAIL_USERNAME');
			$mailArray = explode('@',$mailAddr);
			$message->from($mailAddr, $mailArray[0]);
			$message->subject('會員帳號驗證信');
			$message->to($data['userMail']);
		});
	}// public function mailActiveCodeToUser()

	/*開通顯示店家*/
	public function notify_show(Request $request){
		$data['user'] = parent::memberShowRegister($request);

		$hostMail = $this->mailboxRepository->getAllMailbox();
        foreach($hostMail as $hmKey => $hmValue){
        	if ($hmValue['mb_status'] == 1){
            	Mail::send('emails.notify_show', $data, function ($message) use($data, $hmValue) {
		        	$mailAddr = env('MAIL_USERNAME');
		            $mailArray = explode('@',$mailAddr);
		            $message->from($mailAddr, $mailArray[0]);
		            $message->subject("店家開通顯示請求");
		            $message->to($hmValue['rx_mail']);
		        });
            }
        }
	}

	/*激活*/
	public function active (Request $request,$code) {
		unset($cond);
		$cond = [['active_code','=',$code]];
		$res = $this->memberRepository->find($cond)->toArray();
		$count = count($res);
		if ($count >0){
			unset($updData);
			$updData['user_active'] = 1;
			$this->memberRepository->update($res[0]['id'],$updData);

		// return $code;
			return redirect('/member/login');
		}else{
			return response('無此激活碼');
		}
	}//public function active ()

	/*取得會員購買方案*/
	public function getMemberTypes(Request $request,$memberId, $timeToStr=true) {
		$memberTypes = AppHelper::instance()->getMemberTypes($memberId, $timeToStr);

		return $memberTypes;
	}

	/*新增會員購買方案*/
	public function addMemberTypes(Request $request) {
		$insertData = [
			'user_id' 			=> $request->get('user_id'),
			'type' 				=> $request->get('type'),
			'start_time' 		=> AppHelper::instance()->arrange_date_time( $request->get('start_time') ),
			'end_time' 			=> AppHelper::instance()->arrange_date_time( $request->get('end_time') ),
			'contract_number' 	=> $request->get('contract_number'),
			'note' 				=> $request->get('note')
		];

		$result = MemberTypeRelationModel::create($insertData);
		return $result;
	}

	/*刪除(假刪除)會員購買方案*/
	public function deleteMemberTypes(Request $request){
		$id = $request->get('id');
		$result = MemberTypeRelationModel::where('id', '=', $id)->update(['online'=>0]);
		return $result;
	}

	/*編輯會員購買方案*/
	public function updateMemberTypes(Request $request) {
		$updateData = $request->all();
		$id = $updateData['id'];
		unset($updateData['id']);
		unset($updateData['user_id']);
		unset($updateData['updated_at']);
		unset($updateData['updated_at']);
		unset($updateData['days']);

		$updateData['start_time'] 	= AppHelper::instance()->arrange_date_time( $updateData['start_time'] );
		$updateData['end_time']		= AppHelper::instance()->arrange_date_time( $updateData['end_time'] );
		$result = MemberTypeRelationModel::where('id', '=', $id)->update($updateData);
		return $result;
	}
}//class MemberApiController extends Controller
