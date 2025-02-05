<?php

namespace App\Services;

use App\Repositories\AccountRepository;
use Illuminate\Support\Facades\Session;

class AccountService
{

	private $accountRepository;

	public function __construct(AccountRepository $accountRepository)
	{
		$this->accountRepository = $accountRepository;
	}

	public function pwEncode($pw){
		return $pw;
	}

	public function pwDecode($pw){
		return $pw;
	}

	public function login(){
	}//public function login()

	public function logout(){
	}//public function logout()



	//-------------------
	// Role
	//-------------------
	public function hasRole($role){

		$canAccess = false;

		$userInfo = $this->getUserInfo();
		$userRole = $userInfo ? $userInfo['role'] : [];

		if(!empty($userRole)){
			if (count($userRole)>0){
				foreach ($userRole as $rKey => $rValue){
					if (in_array($rValue,$role)){
						$canAccess = true;
					};//if
				}//foreach
			}//if
		}

		return $canAccess;
	}//public function hasRole()

	public function getUserRole(){
		$userRole = Session::get('user.role');
		return $userRole;
	}//public function getUserRole()


	//-----------------
	// Auth
	///-----------------
	public function accountAuth($accountData){
		//$accountData['account'];$accountData['password']

		$account['login_type'] 	= $accountData['login_type'];
		$account['acct'] 		= $accountData['account'];
		$account['user_pw'] 	= $this->pwEncode($accountData['password']);

		unset($cond);

		$cond = [
			['acct',	'=',$account['acct']],
			['user_pw',	'=',$account['user_pw']]
		];
		$res = $this->accountRepository->find($cond)->toArray();

		if (count($res) > 0){
			if ($res[0]['user_active'] == 0){
				return ['status'=>false,'message'=>'帳號未激活'];
			}elseif ($res[0]['user_status'] == 0){
				return ['status'=>false,'message'=>'帳號已停用'];
			}else{
				$userData['account'] = $res[0];
				$this->storeUserInfo($userData);
				return ['status'=>true];
			}
		}else{
			return ['status'=>false,'message'=>'帳密不符'];
		}
	}//public function auth()


	//--------------
	// User
	//--------------
	public function getRegisterInfo(){
		$userData = $this->getUserInfo();
		$account = $this->accountRepository->show($userData['id']);
	}
	public function getUserInfo(){
		$userInfo = Session::get('user');
		return $userInfo;
	}

	public function storeUserInfo($userData){
		Session::put('user',[]);
		Session::put('user.id',			$userData['account']['id']);
		Session::put('user.account',	$userData['account']['acct']);
		Session::put('user.name',		$userData['account']['user_name']);
		Session::put('user.role',		json_decode($userData['account']['user_role']),true);
		Session::put('user.status',		$userData['account']['user_status']);
		Session::put('user.loginType',	'acct');
	}//public function storeUserInfo()
	public function clearUserInfo(){
		Session::flush();
	}//public function clearUserInfo()

	public function getUserName($user_id){
		
		$username = $this->accountRepository->getOneUserName($user_id);

		return $username;

	}
}