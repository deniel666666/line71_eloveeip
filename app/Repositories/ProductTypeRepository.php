<?php

namespace APP\Repositories;

use \App\Models\ProductTypeModel as ProductTypeModel;

class ProductTypeRepository{

	public function __construct(){

	}

	//-------------------
	// ProductTypeModel
	//-------------------
	//CURD
	public function create($insData){
		// return AccountModel::insertGetId($insData);
	}

	public function show($id){
		$res = ProductTypeModel::where('prod_type_id','=',$id)->first();
		return $res;
	}


	public function update($acctId,$updData){
		// $res = AccountModel::where('id','=',$acctId)->update($updData);
		// return $res;
	}

	public function delete($acctId){
		// $res = AccountModel::where('id','=',$acctId)->delete();
		// return $res;
	}

	//-----------------------
	// Dedicate Function
	//-----------------------
	public function showProduct($id){
		$res = ProductTypeModel::find($id)->product;
		return $res;
	}








}