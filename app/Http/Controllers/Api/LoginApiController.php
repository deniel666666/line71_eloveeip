<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Mail;

use App\Services\AccountService;
use App\Services\FileService;
use App\Repositories\AccountRepository;


class LoginApiController extends Controller
{
	protected $accountService;

	public function __construct(
		AccountService 		$accountService,
		FileService			$fileService,
		AccountRepository 	$accountRepository
	){
		$this->accountService		= $accountService;
		$this->fileService			= $fileService;
		$this->accountRepository	= $accountRepository;
	}


	public function index(Request $request){

		$reqData['account'] 	= $request->input('acct');
		$reqData['password'] = $request->input('user_pw');

		$auth = $this->accountService->accountAuth($reqData);

		if ($auth){
			$auth['status'] ='200';
		}else{
			$auth['status'] ='400';
		}

		return response()->json($auth);
	}

	public function accountLogin(Request $request){
		$user = $request->input('user');

		$userData['login_type'] = isset($user['login_type'])?$user['login_type']:'admin';
		$userData['account'] 	= $user['account'];
		$userData['password']	= $user['password'];

		$auth = $this->accountService->accountAuth($userData);


		if ($auth['status']){
			return ['status' => '200'];
		}else{
			return ['status' => '400', 'message' => $auth['message']];
		}
	}//public function accountLogin()
}
