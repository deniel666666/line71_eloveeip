<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Repositories\JournalOrderRepository;

class JournalOrderApiController extends Controller
{
	public function __construct(JournalOrderRepository		$journalOrderRepository)
	{
		$this->journalOrderRepository	= $journalOrderRepository;
	}

	//-------------------
	// OrderMode
	//-------------------
	public function show(Request $request,$orderId){
		$order = $this->journalOrderRepository->show($orderId);

		$odData['od_id'] 			= $order->od_id;
		$odData['od_sn'] 			= $order->od_sn;
		$odData['product_num'] 		= $order->product_num;
		$odData['pay_status'] 		= (string)$order->pay_status;
		$odData['shipping_status'] 	= (string)$order->shipping_status;
		$odData['od_cont'] 			= json_decode($order->od_cont,true);
		$odData['od_info'] 			= json_decode($order->od_info,true);

		return $odData;
	}

	public function page(Request $request){
		$prodNum		= $request->get('prodNum');
		$currentPage	= $request->get('currentPage');
		$countOfPage	= $request->get('countOfPage');
		$orderStatus	= $request->get('orderStatus');
		$keyword		= $request->get('keyword');

		$pageData = [
			'currentPage'	=> $currentPage,
			'countOfPage'	=> $countOfPage,
			'prodNum' 		=> $prodNum
		];

		if (isset($orderStatus)){
			$pageData['orderStatus'] = $orderStatus;
		}

		if (isset($keyword)){
			$pageData['keyword'] = $keyword;
		}

		$res = $this->journalOrderRepository->showPage($pageData);

		$pageCount = $this->journalOrderRepository->orderCount($pageData);

		$pageMod = $pageCount%$countOfPage;

		if ($pageMod == 0){
			$totalPage = (int)($pageCount/$countOfPage);
		}else{
			$totalPage = (int)($pageCount/$countOfPage)+1;
		}

		$retData['pageData'] 	= $res;
		$retData['totalPage'] 	= $totalPage;

		return $retData;
	}


	public function updatePayStatus(Request $request,$orderId){
		$payStatus = $request->get('payStatus');
		$updData = ['pay_status' => $payStatus];
		$res = $this->journalOrderRepository->update($orderId,$updData);

		return $res;
	}

	public function updateShippingStatus(Request $request,$orderId){
		$shippingStatus = $request->get('shippingStatus');
		$updData = ['shipping_status' => $shippingStatus];
		$res = $this->journalOrderRepository->update($orderId,$updData);

		return $res;
	}
}
