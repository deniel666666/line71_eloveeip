<?php
namespace App\Repositories\Member\Template;

use App\Helpers\AppHelper;

class TemplateMemberRepository{

	protected $memberModel;
	protected $primaryKey = "id";

	public function __construct($memberModel, $primaryKey){
		$this->memberModel 	= $memberModel;
		$this->primaryKey 	= $primaryKey;
	}

	public function store($insData){
		if(isset($insData['birth_day'])){
			$insData['birth_day'] = AppHelper::instance()->arrange_date_time($insData['birth_day']);
		}
		$res = $this->memberModel->create($insData);
		return $res[$this->primaryKey];
	}

	public function show($id){
		$res = $this->memberModel->where($this->primaryKey,'=',$id)->first();
		return $res;
	}

	public function update($id,$updData){
		if(isset($updData['birth_day'])){
			$updData['birth_day'] = AppHelper::instance()->arrange_date_time($updData['birth_day']);
		}
		$res = $this->memberModel->where($this->primaryKey,'=',$id)->update($updData);
		return $res;
	}
	public function ArrayUpdate($memberId,$updData){
		foreach ($memberId as $IdKey => $IdValue){
			$this->memberModel->where('id',$IdValue)->update($updData);
		}

		return ['status' => '200'];
	}

	public function find($cond){
		$res = $this->memberModel->where($cond)->get();
		return $res;
	}


	public function showMemberPage($cond){

		$res = $this->memberModel->select('*');

		foreach ($cond as $key => $value) {
			if($key!='' && $value!=''){
				if(in_array($key, ['acct','user_name','email','road','telephone','id_code','cellphone'] )){
					$res = $res->where($key,'like', '%'.$value.'%');
				}
				else if($key!='currentPage' && $key!='countOfPage'){
					$res = $res->where($key,'=', $value);
				}
			}
		}

		//all item
		$allRes = $res;
		$count 	= $allRes->get()->count();

		if(isset($cond['countOfPage'])){
			if($cond['countOfPage']!='' && $cond['countOfPage']!=0){

				//limited item
				$offset = ($cond['currentPage']-1)*$cond['countOfPage'];
				$limit 	= $cond['countOfPage'];

				$res = $res->offset($offset)->limit($limit);

				/*處理頁數*/
				$pageMod = $count%$cond['countOfPage'];
				$pageDiv = (int)($count/$cond['countOfPage']);
				if ( $pageMod == 0){
					$totalPage = $pageDiv;
				}else{
					$totalPage = $pageDiv+1;
				}
			}
		}else{
			$totalPage = 1;
		}	
		// echo $res->toSql();
		
		$res = $res->orderBy('id', 'desc')->get();
		return ['res' => $res,'totalItem'=>$count,'totalPage'=>$totalPage];
	}
}
