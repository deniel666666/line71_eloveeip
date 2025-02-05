<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FareController extends Controller
{
    public function index (Request $request) {
        $viewData['pageTitle'] 		= '運費管理';

		$viewData['fareCollapse']	= "show";
		$viewData['fareActive'] 	= "active";

		return view("admin.fare.fare",$viewData);
    }
}
