<?php


namespace APP\Repositories;

use \App\Models\AccountModel;
use http\Env\Request;

class AccountRepository{

	protected $model;
	const PrimaryKey = "id";

	public function __construct(AccountModel $accountModel){
		$this->model = $accountModel;
	}

	//-------------------
	// SampleModel
	//-------------------
	//CURD
	public function index(){
		return AccountModel::all();
	}

	public function store($insData){
		$res = AccountModel::create($insData);
		return $res[self::PrimaryKey];
	}

	public function show($id){
		$res = AccountModel::where(self::PrimaryKey,'=',$id)->first();
		return $res;
	}

	public function show_popular(){
		$res = AccountModel::where(['show_status'=>'1','popular'=>'1'])->select('id','user_info','prod_img','small_img','title')->get();
		return $res;
	}

	public function show_new(){
		$res = AccountModel::where(['show_status'=>'1','new'=>'1'])->select('id','small_img')->get();
		return $res;
	}

	public function show_one($user_id){

		$res = AccountModel::where(['id'=>$user_id])->first();
		
		return $res;

		exit;
	}
	
	public function update($id,$updData){
		$res = AccountModel::where(self::PrimaryKey,'=',$id)->update($updData);
		return $res;
	}

	public function ArrayUpdate($memberId,$updData){

		foreach ($memberId as $IdKey => $IdValue){
			AccountModel::where('id',$IdValue)->update($updData);
		}

		return ['status' => '200'];
	}

	public function destroy($id){
		$res = AccountModel::where(self::PrimaryKey,'=',$id)->delete();
		return $res;
	}

	public function find($cond){//
//		$cond['ant'];		$cond['user_pw'];	$cond['user_name'];	$cond['ant'];	$cond['user_info'];
//		$cond['user_ids'];$	cond['user_role'];	$cond['user_status'];
//
		$res = AccountModel::where($cond)->get();

		return $res;
	}

//	public function search($cond){//use  like
//
//	}

	//---------------------------
	// Use foreach
	//---------------------------
	public function multiUpdate($updData){
		foreach ($updData as $updKey => $updValue){
			AccountModel::where('id',$updValue['id'])->update($updData);
		}

		return ['status' => '200'];
	}


	//---------------------------
	// Use Where In
	//---------------------------
	public function batchUpdate($ids,$updData){
		$res = AccountModel::whereIn('id',$ids)->update($updData);//???

		return $res;
	}

	public function batchDestroy($ids){
		$res = AccountModel::whereIn('id',$ids)->delete();//???

		return $res;

	}


	//-------------------------
	// Relation
	//-------------------------
	public function getCategoryTag($prodId){
		$res = ProductCategoryModel::with(
			['categoryTag'=>function($query){}]
		);

		$res = $res->where('prod_id',$prodId);

		$res = $res->get();

		return $res;
	}

	//-----------------------
	// Special function
	//-----------------------
	public function hasRecByAccount($acct, $exclude_id=''){
		$result = AccountModel::where('acct','=',$acct);
		if($exclude_id){
			$result = $result->where('id','!=',$exclude_id);
		}
		return $result->exists();
	}

	public function getAllAccount(){
		$res = AccountModel::where('admin_show','=',1)->orderby('end_time','asc')->get()->toArray();
		return $res;
	}

	public function getAllAccountByKey($keyword,$expired_type){
		$res = AccountModel::where('admin_show','=',1)->where(function($query)use($keyword,$expired_type){
			if($keyword!=''){
				$query->where('user_name','like','%'.$keyword.'%');
				$query->OrWhere('acct','like','%'.$keyword.'%');
			}
			if($expired_type==1){
				$limit_time_end=date("Y-m-d",strtotime(date("Y-m-d") . ' +7 day'));
				$limit_time_start=date("Y-m-d",strtotime(date("Y-m-d") . ' -1 day'));
				$query->where('end_time','<',$limit_time_end);
				$query->where('end_time','>',$limit_time_start);
			}else if($expired_type==2){
				$limit_time_end=date("Y-m-d",strtotime(date("Y-m-d") . ' +1 day'));
				$query->where('end_time','<',$limit_time_end);
			}

		})->orderby('end_time','asc')->get()->toArray();
		return $res;
	}

	public function getMemberAccount($user){
		$role = $user['role'][0];
		if($role=='admin'){
			$res = AccountModel::where('acct','<>','photonic')->get()->toArray();
		}else if($role=='member'){
			$res = AccountModel::where('id',$user['id'])->get()->toArray();
		}
		
		return $res;
	}
//
//	public function loginCheck($acct,$acct_pw){
//		return AccountModel::where([['acct','=',$acct],	['acct_pw','=',$acct_pw]])->exists();
//	}

	//--------------------
	// Dedicated function
	//--------------------
	public function showPage($pageParam){

		$offset = ($pageParam['currentPage']-1)*$pageParam['countOfPage'];
		$limit 	= $pageParam['countOfPage'];

		$res = $this->model->offset($offset)->limit($limit);

		$res->orderBy('created_at', 'desc');

		//echo $res->toSql();
		$res = $res->get();

		return $res;
	}

	public function showMemberPage($pageParam){

		$res = AccountModel::where('user_type','=',0);
		if(isset($pageParam['role'])){
			$res = $res->where('user_role','=','["'.$pageParam['role'].'"]');
		}
		
		if(isset($pageParam['keyword']) && $pageParam['selectItem'] != ''){

				$res = $res->where($pageParam['selectItem'],'like','%'.$pageParam['keyword'].'%' );

		}

		if(isset($pageParam['show_status'])){

			$res = $res->where('show_status','like','%'.$pageParam['show_status'].'%'  );

		}

		if(isset($pageParam['user_status'])){

			$res = $res->where('user_status','like','%'.$pageParam['user_status'].'%'  );

		}





		//all item
		$allRes = $res;
		$count 	= $allRes->get()->count();

		$pageMod = $count%$pageParam['countOfPage'];
		$pageDiv = (int)($count/$pageParam['countOfPage']);

		if ( $pageMod == 0){
			$totalPage = $pageDiv;
		}else{
			$totalPage = $pageDiv+1;
		}

		//limited item
		$offset = ($pageParam['currentPage']-1)*$pageParam['countOfPage'];
		$limit 	= $pageParam['countOfPage'];

		$res = $res->offset($offset)->limit($limit);

		//echo $res->toSql();
		$res = $res->get();

		return ['res' => $res,'totalItem'=>$count,'totalPage'=>$totalPage];

	}


	public function showMemberInfo($memberId){

//		$res = AccountModel::with('orderForm')->where('id','=',$memberId)->first();
		$res = AccountModel::where('id','=',$memberId)->first();
		return $res;
	}
	
	public function deleteaccount($acctId){
		$res = AccountModel::where(self::PrimaryKey,'=',$acctId)->delete();
		return $res;
	}



	public function delete($acctId){
		$res = AccountModel::where(self::PrimaryKey,'=',$acctId)->delete();
		return $res;
	}

	public function getOneUserName($user_id){
		$res = AccountModel::where('id',$user_id)->select('user_name')->first();

		return ($res->user_name) ?? "";
	}

}
