<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductTabsController extends Controller
{
    public function index (Request $request,$productNum) {

        $routeNum = $request->route( 'productNum');
		$prodCollapse = 'prodCollapse'.$routeNum;
        $propertyTagActive = 'prodTabsActive'.$routeNum;
		$viewData['pageTitle'] 			= '介紹管理';
		$viewData[$prodCollapse] 		= "show";
		$viewData[$propertyTagActive] 	= "active";

    	if($productNum == 1){

    	}else if($productNum == 2){

		}else if($productNum == 3){

		}else if($productNum == 4){

		}

		$viewData['pageMainTitle'] 	= 'PRODUCT1管理';
		return view("admin.product.tabsTagId",$viewData);
    }
}



