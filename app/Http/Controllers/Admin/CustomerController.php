<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
	public function index (Request $request) {
		$viewData = ['pageTitle' => '消費者管理'];
		// $viewData['accountCollapse'] = "show";
		$viewData['sysCollapse'] 	= "show";
		$viewData['customerActive'] = 'active';
		return view("admin.customer.member",$viewData);
	}//public function index

	public function edit (Request $request) {
		$viewData = ['pageTitle' => '消費者管理'];
		// $viewData['accountCollapse'] = "show";
		$viewData['sysCollapse'] 	= "show";
		$viewData['customerActive'] = 'active';

		return view("admin.customer.memberEdit",$viewData);
	}//public function index
}

