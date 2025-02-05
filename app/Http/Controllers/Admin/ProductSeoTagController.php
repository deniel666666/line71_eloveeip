<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductSeoTagController extends Controller
{



    public function index (Request $request,$productNum) {
        $routeNum = $request->route( 'productNum');
		$prodCollapse = 'prodCollapse'.$routeNum;
        $propertyTagActive = 'prodSeoTagActive'.$routeNum;
        $viewData['pageTitle'] 		= 'SEO管理';
		$viewData[$prodCollapse] 		= "show";
		$viewData[$propertyTagActive] 	= "active";

    	if($productNum == 1){
	        // $viewData['pageMainTitle'] 			= '產品介紹管理';
			// return view("admin.product.product.seoTagId",$viewData);
		}else if($productNum == 2){
	        // $viewData['pageMainTitle'] 			= '影片專區管理';
			// return view("admin.product.video.seoTagId",$viewData);
		}else if($productNum == 3){
	        // $viewData['pageMainTitle'] 			= '口碑推薦管理';
			// return view("admin.product.recommend.seoTagId",$viewData);
		}else if($productNum == 4){
	        // $viewData['pageMainTitle'] 			= '最新活動管理';
			// return view("admin.product.news.seoTagId",$viewData);
		}else{
	        $viewData['pageMainTitle'] 			= 'PRODUCT1管理';
			return view("admin.product.seoTagId",$viewData);
		}
		$viewData['pageMainTitle'] 			= 'PRODUCT1管理';
		return view("admin.product.seoTagId",$viewData);
    }

}

