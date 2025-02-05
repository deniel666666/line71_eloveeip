<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JournalOrderController extends Controller
{
	public function index (Request $request) {

		$viewData['pageTitle'] 	= '期刊訂單';

		$viewData['orderCollapse']		= "show";
		$viewData['journalOrderActive'] = "active";

		return view("admin.journal.journal",$viewData);
	}


	public function edit (Request $request) {

		$viewData['pageTitle'] 	= '期刊訂單';
		$viewData['orderCollapse']		= "show";
		$viewData['journalOrderActive'] = "active";

		return view("admin.journal.journalEdit",$viewData);
	}
}
