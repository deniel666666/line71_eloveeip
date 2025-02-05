<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PropertyTagController extends Controller
{
    public function index (Request $request,$propertyTagId) {

		$routeNum = $request->route( 'propertyTagId');
		$prodCollapse = 'prodCollapse'.$routeNum;
		$propertyTagActive = 'propertyTagActive'.$routeNum;
        $viewData['pageTitle'] 			= '欄位管理';
		$viewData[$prodCollapse] 		= "show";
		$viewData[$propertyTagActive] 	= "active";

    	if($propertyTagId == 1){

		}else if($propertyTagId == 2){

		}else if($propertyTagId == 3){

		}else if($propertyTagId == 4){

		}


		$viewData['pageMainTitle'] 			= 'PRODUCT1管理';
		return view("admin.product.propertyTag",$viewData);
    }
}



