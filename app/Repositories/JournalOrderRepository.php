<?php

namespace APP\Repositories;

use \App\Models\JournalOrderModel as OrderModel;
use http\Env\Request;

class JournalOrderRepository{

	private $orderTable = 'journal_order';
	private $primaryKey = 'jn_od_id';

	public function __construct(){

	}

	//-------------------
	// OrderModel
	//-------------------
	//CURD
	public function index($insData){

	}

	public function create($insData){
		$res = OrderModel::create($insData);
		return $res->id;
	}

	public function show($id){
		$res = OrderModel::where($this->primaryKey,'=',$id)->first();
		return $res;
	}


	public function update($id,$updData){
		 $res = OrderModel::where($this->primaryKey,'=',$id)->update($updData);
		 return $res;
	}

	public function delete($Id){
		// $res = OrderModel::where($this->primaryKey,'=',$id)->delete();
		// return $res;
	}

	//--------------------
	// Dedicated function
	//--------------------
	public function showPage($pageData){

		$offset = ($pageData['currentPage']-1)*$pageData['countOfPage'];
		$limit 	= $pageData['countOfPage'];

		$res = OrderModel::offset($offset)->limit($limit);

		if(isset($pageData['orderStatus'])){
			if($pageData['orderStatus'] == 'new'){
				$res->whereRaw('pay_status = 0 and shipping_status = 0');
			}elseif($pageData['orderStatus'] == 'processing'){
				$res->whereRaw('(pay_status = 1 and shipping_status = 0)or(pay_status = 0 and shipping_status = 1)');
			}elseif($pageData['orderStatus'] == 'finish'){
				$res->whereRaw('pay_status = 1 and shipping_status = 1');
			}
		}

		if (isset($pageData['keyword'])){
			$res->where(function($query) use ($pageData){
				$query->where('od_sn','like','%'.$pageData['keyword'].'%')
//					->orWhere('buyer','like','%'.$pageData['keyword'].'%')
//					->orWhere('recipient','like','%'.$pageData['keyword'].'%')
					->orWhere('od_info','like','%'.$pageData['keyword'].'%');
			});
		}

		$res->orderBy('created_at', 'desc');
//		echo $res->toSql();

		$res = $res->get();

		return $res;
	}

	public function orderCount($pageData){

		$res = OrderModel::where($this->primaryKey,'!=',0);

		if(isset($pageData['orderStatus'])){
			if ($pageData['orderStatus'] = 'new') {
				$res->whereRaw('pay_status = 0 and shipping_status = 0');
			}elseif($pageData['orderStatus'] == 'processing'){
				$res->whereRaw('(pay_status =1 and shipping_status =0)or(pay_status =0 and shipping_status =1)');
			}elseif($pageData['orderStatus'] == 'finish'){
				$res->whereRaw('pay_status =1 and shipping_status =1');
			}
		}

		if (isset($pageData['keyword'])){
			$res->where(function($query) use ($pageData){
				$query->where('od_sn','like','%'.$pageData['keyword'].'%')
					->orWhere('buyer','like','%'.$pageData['keyword'].'%');
			});
		}

		return $res->count();
	}
}