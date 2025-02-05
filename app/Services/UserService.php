<?php

namespace App\Services;

use App\Repositories\AccountRepository;
use App\Services\AccountService;

class UserService
{

	private $accountService;
	private $accountRepository;

	public function __construct(
							AccountRepository 	$accountRepository,
							AccountService 		$accountService)
	{
		$this->accountRepository = $accountRepository;
		$this->accountService = $accountService;
	}

//	public function getRegisterInfo(){
//
//		$userData = $this->accountService->getUserInfo();
//
//		$account = $this->accountRepository->show($userData['id']);
//
//
////		$userInfo = $this->accountRepository->show($id);
//		return $account;
//	}

//	public function getUserRole(){
//		$userInfo = $this->accountService->getUserRole();
//		return $userInfo;
//	}
}