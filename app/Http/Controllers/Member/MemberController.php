<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class MemberController extends Controller
{
	private $baseUrl;
	public function __construct(
	){
		$this->baseUrl				= env('APP_URL');
	}

	public function index(Request $request)
	{	
		$viewData['webTitle']  = '店家專區';
		$viewData['pageTitle'] = '店家資料修改';
		return view("member.member", $viewData);//registeredNewMember.html
	}

	public function login(Request $request)
	{
		$viewData['webTitle']  = '店家專區';
		$viewData['pageTitle'] = '店家登入';
		return view("member.login.memberLogin", $viewData);//registered.html
	}

	public function logout (Request $request) {
		Session::forget('member');
		return redirect('/member/login');
	}

	public function register (Request $request) {
		$viewData['webTitle']  = '店家專區';
		$viewData['pageTitle'] = '店家登入';
		return view("member.login.register", $viewData);
	}

	public function forgetPassword (Request $request) {
		$viewData['webTitle']  = '店家專區';
		$viewData['pageTitle'] = '忘記密碼';
		return view("member.login.forgetPassword", $viewData);
	}
}
