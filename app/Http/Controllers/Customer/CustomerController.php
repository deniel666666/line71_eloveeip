<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Helpers\AppHelper;

use App\Http\Controllers\Api\Customer\MemberApiController;

class CustomerController extends Controller
{
	private $memberApiController;
	public function __construct(
		MemberApiController $memberApiController
	){
		$this->memberApiController = $memberApiController;
	}

	public function index(Request $request)
	{	
		$viewData['webTitle']   = '消費者專區';
		$viewData['webTitle']	= '消費者專區';
		return view("customer.member", $viewData);
	}

	public function login(Request $request)
	{
		$viewData['webTitle']  = '消費者專區';
		$viewData['pageTitle'] = '消費者登入';
		return view("customer.login.memberLogin", $viewData);
	}

	public function logout (Request $request) {
		Session::forget('customer');
		return redirect('/customer/login');
	}

	public function register (Request $request) {
		$viewData['line_id'] 	= $request->get('line_id');
        $viewData['line_name'] 	= $request->get('line_name');

        $viewData['webTitle']  = '消費者專區';
		$viewData['pageTitle'] = '消費者註冊';
		return view("customer.login.register", $viewData);
	}

	public function forgetPassword (Request $request) {
		$viewData['webTitle']  = '消費者專區';
		$viewData['pageTitle'] = '忘記密碼';
		return view("customer.login.forgetPassword", $viewData);
	}

	/*----------------------------------------------------------*/
	/*消費者額外功能----------------------*/

	/*跳轉line畫面*/
	public function goLinePage(Request $request){
		$auth_url = 'https://access.line.me/oauth2/v2.1/authorize?response_type=code&';
        $auth_url.= 'client_id=' . env('LINE_CHANNEL_ID') . '&';
        $auth_url.= 'redirect_uri=' . env('LINE_CALL_BACK_URL') . '&';
        $auth_url.= 'state=' . '12345abcde' . '&';
        $auth_url.= 'scope=' . 'openid%20profile%20email' . '&';
        $auth_url.= 'nonce=' . '09876xyz';
        
        return redirect($auth_url);
	}

	/*補足註冊資料(完成註冊、可以登入)*/
	public function fillRegister(Request $request){
		$viewData['webTitle']  = '消費者專區';
		$viewData['pageTitle'] = '消費者資料填補';
		$viewData['line_id'] 	= $request->get('line_id');
        $viewData['line_name'] 	= $request->get('line_name');
		
		$registerInfo = $this->memberApiController->getRegisterInfo( Session::get('customer.id') );
		if(!$registerInfo){
			return redirect('/customer/rapidlogin')->withErrors(['請先登入帳號再進行資料填補']);
		}else if($registerInfo['complete_reg']==1){
			return redirect('/customer')->withErrors(['此帳號已完成註冊，請由此登入']);
		}else{
			return view("customer.login.fillRegister", $viewData);
		}
	}

	/*追蹤店家頁面*/
	public function shop(Request $request){
		$viewData['webTitle']  = '消費者專區';
		$viewData['pageTitle'] = '追蹤店家';
		return view("customer.shop", $viewData);
	}
}
