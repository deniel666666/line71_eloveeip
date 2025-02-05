<?php

namespace APP\Repositories;

use \App\Models\SampleModel;
use http\Env\Request;

class SampleRepository{

	protected $model;
	const PrimaryKey = "sample_id";

	public function __construct(SampleModel $sampleModel){
		$this->model = $sampleModel;
	}

	//-------------------
	// SampleModel
	//-------------------
	//CURD
	public function index(){
		return SampleModel::all();
	}

	public function store($insData){
		$res = SampleModel::create($insData);
		return $res[self::PrimaryKey];
	}

	public function show($id){
//		$res = SampleModel::where(self::PrimaryKey,'=',$id)->first();
		$res = SampleModel::findOrFaila($id);
		return $res;
	}

	public function update($id,$updData){
//		$res = SampleModel::where(self::PrimaryKey,'=',$id)->update($updData);
		$res = SampleModel::findOrFail($id);
		$res = $res->update($updData);
		return $res;

	}

	public function destroy($id){
//		$res = SampleModel::where(self::PrimaryKey,'=',$id)->delete();
		$res = SampleModel::fincOrFail($id);
		$res = $res->delete();
		return $res;
	}

	public function find($cond){//equal or like
//		$cond = [['a','=',1],.....]
		$res = SampleModel::where($cond)->get();
		return $res;
	}

//	public function search($cond){//use  like
//		可用 find() 來做
//	}

	//---------------------------
	// Use foreach
	//---------------------------
	public function multiUpdate($updData){

		foreach ($updData as $updKey => $updValue){
			SampleModel::where('id',$updValue['id'])->update($updData);
		}

		return ['status' => '200'];
	}


	//---------------------------
	// Use Where In
	//---------------------------
	public function batchUpdate($ids,$updData){
		$res = SampleModel::whereIn('id',$ids)->update($updData);//???

		return $res;
	}

	public function batchDestroy($ids){
		$res = SampleModel::whereIn('id',$ids)->delete();//???

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
//		echo $res->toSql();

		$res = $res->get();

		return $res;
	}

	public function itemCount($pageParam){

		$res = $this->model->where('cont_id','!=',0);

		return $res->count();
	}

}