<?php

namespace APP\Repositories;

use \App\Models\RoleTaskModel;
use http\Env\Request;

class RoleTaskRepository{

	protected $model;
	const PrimaryKey = "id";
	public function __construct(RoleTaskModel $roleTaskModel){
		$this->model = $roleTaskModel;
	}

	//-------------------
	// SampleModel
	//-------------------
	//CURD
	public function index(){
		return RoleTaskModel::all();
	}

	public function store($insData){
		$res = RoleTaskModel::create($insData);
		return $res[self::PrimaryKey];
	}

	public function show($id){
		// $res = SampleModel::where(self::PrimaryKey,'=',$id)->first();
		$res = RoleTaskModel::findOrFaila($id);

		return $res;
	}

	public function update($id,$updData){
		// $res = SampleModel::where(self::PrimaryKey,'=',$id)->update($updData);
		$res = RoleTaskModel::findOrFail($id);
		$res = $res->update($updData);

		return $res;
	}

	public function destroy($id){
		// $res = SampleModel::where(self::PrimaryKey,'=',$id)->delete();
		$res = RoleTaskModel::fincOrFail($id);
		$res = $res->delete();

		return $res;
	}

	public function find($cond){//equal or like
		// $cond = [['a','=',1],.....]
		$res = RoleTaskModel::where($cond)->get();
		return $res;
	}

	// public function search($cond){//use  like
		// 可用 find() 來做
	// }

	//---------------------------
	// Use foreach
	//---------------------------
	public function multiUpdate($updData){
		foreach ($updData as $updKey => $updValue){
			RoleTaskModel::where('id',$updValue['id'])->update($updData);
		}

		return ['status' => '200'];
	}

	//---------------------------
	// Use Where In
	//---------------------------
	public function batchUpdate($ids,$updData){
		$res = RoleTaskModel::whereIn('id',$ids)->update($updData);//???

		return $res;
	}

	public function batchDestroy($ids){
		$res = RoleTaskModel::whereIn('id',$ids)->delete();//???

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

	//--------------------
	// Dedicated function
	//--------------------

	public function showPage($pageParam){
		$offset = ($pageParam['currentPage']-1)*$pageParam['countOfPage'];
		$limit 	= $pageParam['countOfPage'];

		$res = $this->model->offset($offset)->limit($limit);
		$res->orderBy('created_at', 'desc');

		// echo $res->toSql();
		$res = $res->get();
		return $res;
	}

	public function itemCount($pageParam){
		$res = $this->model->where('cont_id','!=',0);
		return $res->count();
	}
}