<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LangController extends Controller
{
     public function index (Request $request) {
        $viewData['pageTitle'] 		= '選擇語系';
        $viewData['langCollapse'] 	= "show";
		$viewData['langActive'] 	= "active";


		return view("admin.lang.lang",$viewData);
    }
}
