<?php

namespace App\Services;

use \App\Repositories\RoleTaskRepository;
use \App\Services\AccountService;

class AclService
{
	private $roleTaskRepository;
	private $accountService;
	public function __construct(
							RoleTaskRepository		$roleTaskRepository,
							AccountService			$accountService)
	{
		$this->roleTaskRepository 	= $roleTaskRepository;
		$this->accountService		= $accountService;
	}

	public function canAccessController(){
		$routeArray 							= app('request')->route()->getAction();
		$controllerAction 						= class_basename($routeArray['controller']);

		list($this->controller, $this->method) 	= explode('@', $controllerAction);
		$cond = [
			['controller','like','%'.$this->controller.'%']
		];

		$res =  $this->roleTaskRepository->find($cond)->toArray();

		$taskRole = [];
		foreach($res as $resKey => $resValue){
			$taskRole[] = $resValue['role'];
		}

		switch ($routeArray['prefix']) {
			case '/member':
				$userInfo = $this->accountService->getMemberInfo();
				break;
			
			default:
				$userInfo = $this->accountService->getUserInfo();
				break;
		}

		$userRole = $userInfo['role'];

		$canAccess = false;
		foreach($taskRole as $trKey => $trValue){
			if(in_array($trValue,$userRole,true)){
				$canAccess = true;
			};
		}

		return $canAccess;
	}//public function canAccessController()

}