<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuLangController extends Controller
{
    public function index (Request $request) {
        $viewData['pageTitle'] 		= '選單語系';
		$viewData['langCollapse'] 	= "show";
		$viewData['menuActive'] 	= "active";

		return view("admin.lang.menuLang",$viewData);
    }
}
