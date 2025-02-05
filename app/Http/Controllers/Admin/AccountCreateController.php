<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountCreateController extends Controller
{
	public function index (Request $request) {

		$viewData['pageTitle'] = '帳號管理';
		$viewData['sysCollapse'] = "show";
		$viewData['accountActive'] = "active";

		return view("admin.account.accountCreate",$viewData);
	}
}
