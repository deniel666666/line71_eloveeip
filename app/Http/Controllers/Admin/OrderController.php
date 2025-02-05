<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
	public function index (Request $request,$prodNum) {

		$viewData['pageTitle'] 	= '商品訂單';

		$viewData['orderCollapse']					= "show";
		$viewData['prod'.$prodNum.'OrderActive'] 	= "active";

		return view("admin.order.order",$viewData);
	}


	public function edit (Request $request,$prodNum) {

		$viewData['pageTitle'] 	= '訂單管理';

		$viewData['orderCollapse']	= "show";
		$viewData['prod'.$prodNum.'OrderActive'] 	= "active";

		return view("admin.order.orderEdit",$viewData);
	}
}
