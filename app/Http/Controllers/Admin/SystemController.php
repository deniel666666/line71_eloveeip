<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class SystemController extends Controller
{

    public function development (Request $request) {
            $viewData['admin_user']      = Session::get('user');

            $viewData['pageTitle'] 		= '開發團隊';
            $viewData['sysCollapse'] 	= "show";
            $viewData['devActive'] 		= "active";

            return view("admin.system.development",$viewData);
    }

    public function system (Request $request) {

            $viewData['pageTitle'] 		= '信統訊息';
            $viewData['sysCollapse'] 	= "show";
            $viewData['sysActive'] 		= "active";

            return view("admin.system.system",$viewData);
    }
}

