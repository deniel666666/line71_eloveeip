<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
	public function index (Request $request) {
		$viewData = ['pageTitle' => '店家管理'];
		// $viewData['accountCollapse'] = "show";
		$viewData['sysCollapse'] 	= "show";
		$viewData['memberActive'] = 'active';
		return view("admin.member.member",$viewData);
	}//public function index

	public function create (Request $request) {
		$viewData = ['pageTitle' => '店家管理'];
		// $viewData['accountCollapse'] = "show";
		$viewData['sysCollapse'] 	= "show";
		$viewData['memberActive'] = 'active';

		return view("admin.member.memberEdit",$viewData);
	}//public function index

	public function edit (Request $request) {
		$viewData = ['pageTitle' => '店家管理'];
		// $viewData['accountCollapse'] = "show";
		$viewData['sysCollapse'] 	= "show";
		$viewData['memberActive'] = 'active';

		return view("admin.member.memberEdit",$viewData);
	}//public function index
}

