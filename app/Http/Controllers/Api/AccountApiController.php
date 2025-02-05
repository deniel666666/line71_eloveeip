<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Repositories\AccountRepository;

class AccountApiController extends Controller
{
	protected $accountRepository;

	public function __construct(AccountRepository $accountRepository)
	{
		$this->accountRepository = $accountRepository;
	}

	public function index(Request $request){
		$search_key=$request->get('searchKey') ?? "";
		$expired_type=$request->get('expiredType') ?? "";
		
		if($search_key!=null || $expired_type!=null){
			$res = $this->accountRepository->getAllAccountByKey($search_key,$expired_type);
			//dd($search_key);
		}else{
			$res = $this->accountRepository->getAllAccount();
		}
		
		

		foreach ($res as $rKey => $rValue){
			if ($rValue['user_status'] == 1){
				$res[$rKey]['user_status'] = '啟用';
			}else{
				$res[$rKey]['user_status'] = '停用';
			}
			unset($res[$rKey]['user_pw']);
		}


		$data = [
			'accountList' => $res,
			'accountLimint' => config('system.accountLimint'),
		];

		return response()->json($data);
	}


	public function show(Request $request,$acctId){

		$res = $this->accountRepository->show($acctId);

		$res['user_status'] = (string)$res['user_status'];

		unset($res['user_pw']);

		$data = [
			'status' => '200',
			'account' => $res
		];

		return response()->json($data);
	}



	public function update(Request $request,$acctId){
		$updData['acct'] 		= $request->input('acct');
		$updData['user_name'] 	= $request->input('user_name');
		$updData['user_status'] = $request->input('user_status');
		$updData['email'] = $request->input('email');
		$updData['cost'] = $request->input('cost');
		$updData['start_time'] = $request->input('start_time');
		$updData['end_time'] = $request->input('end_time');
		//dd($updData);
		$hasAccountRec = $this->accountRepository->hasRecByAccount($updData['acct'], $acctId);
		if ($hasAccountRec){
			return response()->json([
				'status' 	=> 408,
				'msg'		=> '帳號重複',
			]);
		}

		if ($request->input('user_pw')){
			$updData['user_pw'] = $request->input('user_pw');
		}

		$res = $this->accountRepository->update($acctId,$updData);

		$data = [
			'res'   => $res,
			'status'=> 200
		];
		return response()->json($data);
	}


	public function create(Request $request) {
		$insData['acct'] 		= $request->input('acct');
		$insData['user_name'] 	= $request->input('user_name');
		$insData['user_status'] = $request->input('user_status');
		$insData['email'] = $request->input('email');
		$insData['cost'] = $request->input('cost');
		$insData['start_time'] = $request->input('start_time');
		$insData['end_time'] = $request->input('end_time');
		$backend 				= $request->input('backend');

		$res = $this->accountRepository->getAllAccount();
		if(config('system.accountLimint')>0){
			if(count($res)+1>config('system.accountLimint')){
				return $data = [
					'status' => 408,
					'msg' => '超出帳號上限',
				];
			}
		}

		if($backend){
			$insData['user_role'] 	= '["member","manager"]';
			$insData['user_active']	=	1;
		}else{
			$insData['user_role'] 	= '["member"]';
		}
		$insData['active_code'] = '';
		$insData['user_type'] 	= 1;
		$insData['active_code'] = '';
		

		if ($request->input('user_pw')){
			$insData['user_pw'] = $request->input('user_pw');
		}

		$hasAccountRec = $this->accountRepository->hasRecByAccount($insData['acct']);
		if ($hasAccountRec){
			$data = [
				'status' 	=> 408,
				'msg'		=> '帳號重複',
			];
		}else{
			$insertId = $this->accountRepository->store($insData);
			$data = [
				'insertId' 	=> $insertId,
				'status' 	=> 200
			];
		}//else

		return response()->json($data);
	}


	public function destroy(Request $request,$acctId){
		$res = $this->accountRepository->delete($acctId);

		$data = [
			'res'   => $res,
			'status'=> 200
		];
		return response()->json($data);
	}

}
