<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryTagController extends Controller
{
	/*樹顯示*/
    public function index (Request $request ,$propertyTagId) {
		$prouteNum = $request->route('propertyTagId');
		$categoryTagActive = 'categoryTagActive'.$prouteNum;
		$viewData[$categoryTagActive] 	= "active";
        $prodCollapse = 'prodCollapse'.$prouteNum;
        $viewData[$prodCollapse]        = "show";

    	if($propertyTagId == 1){
            // $viewData['exhibitionCollapse'] = "show";
            // $viewData['topTitle']           = '商品介紹';
            // $viewData['pageTitle']          = '分類管理';
            // return view("admin.product.productIntro.categoryTag",$viewData);
		}
        else if($propertyTagId == 2){
    	}
        else if($propertyTagId == 3){
    	}
        else if($propertyTagId == 6){
            $viewData['prodCollapse6'] = "show";
            $viewData['topTitle']           = '相關連結';
            $viewData['pageTitle']          = '分類管理';
            return view("admin.product.link.categoryTag",$viewData);    /*樹呈現*/
    	}
        else if($propertyTagId == 7){
            $viewData['onlineCollapse'] = "show";
            $viewData['topTitle']           = '網路活動';
            $viewData['pageTitle']          = '活動類別設定';
            //return view("admin.product.online.categoryTag",$viewData);    /*樹呈現*/
            return view("admin.product.online_act.categoryTag",$viewData);
        }
        else if($propertyTagId == 8){
            $viewData['line_cardCollapse'] = "show";
            $viewData['topTitle']           = 'LINE電子名片';
            $viewData['pageTitle']          = '分類管理';
            return view("admin.product.line_card.categoryTag",$viewData);    /*樹呈現*/
        }
        else if($propertyTagId == 9){
            $viewData['topTitle']              = 'FAQ';
            $viewData['pageTitle']             = 'FAQ類別';
            $viewData['FAQCollapse'] 	     =     "show";
            return view("admin.product.faqlist.categoryTagList",$viewData);
    	}
        else if($propertyTagId == 10){
            $viewData['topTitle']              = '成功案例';
            $viewData['pageTitle']             = '分類管理';
            $viewData['Caseollapse'] 	     =     "show";
            return view("admin.product.case.categoryTagList",$viewData);
    	}

        $viewData['topTitle']  = 'PRODUCT1管理';
        $viewData['pageTitle'] = '分類管理';
		// return view("admin.product.categoryTag",$viewData);    /*樹呈現*/
        // return view("admin.product.categoryTagList",$viewData); /*列表呈現*/
	}
}



