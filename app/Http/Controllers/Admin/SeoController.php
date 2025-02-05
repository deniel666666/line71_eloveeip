<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SeoController extends Controller
{
    public function index (Request $request) {

        $viewData['pageTitle'] 		= 'SEO設定修改';
		$viewData['sysCollapse'] 	= "show";
		$viewData['seo1Active'] 		= "active";

        return view("admin.seo.seo",$viewData);
    }


    public function marketing (Request $request) {

        $viewData['pageTitle'] 		= 'SEO行銷/發布修改';
		$viewData['sysCollapse'] 	= "show";
		$viewData['seo2Active'] 		= "active";

        return view("admin.seo.seoMarketing",$viewData);
    }

    public function advanced (Request $request) {

        $viewData['pageTitle'] 		= '進階SEO修改';
		$viewData['sysCollapse'] 	= "show";
		$viewData['seo3Active'] 		= "active";

        return view("admin.seo.seoAdvanced",$viewData);
    }
}
