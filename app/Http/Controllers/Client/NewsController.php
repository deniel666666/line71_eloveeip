<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//----------------------------------------------------------------------------------------------

use App\Http\Controllers\Api\Gallery\GalleryApiController;
use App\Http\Controllers\Api\Cms\CmsTypeApiController;
use App\Http\Controllers\Api\Cms\CmsApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\CategoryTagApiController;
use App\Http\Controllers\Api\AllPagesController;
use App\Http\Controllers\Api\MiscellaneousApiController;

class NewsController extends Controller
{
	private $countOfPage = 5;

    public function __construct(
		GalleryApiController		$galleryApiController,
		CmsTypeApiController		$cmsTypeApiControlle,
		CmsApiController			$cmsApiController,
		ProductApiController		$productApiController,
		CategoryTagApiController	$categoryTagApiController,
		AllPagesController			$allPagesController,
		MiscellaneousApiController  $miscellaneousApiController
	){
		parent::__construct();
		$this->galleryApiController			= $galleryApiController;
		$this->cmsTypeApiControlle			= $cmsTypeApiControlle;
		$this->cmsApiController				= $cmsApiController;
		$this->productApiController			= $productApiController;
		$this->categoryTagApiController		= $categoryTagApiController;
		$this->allPagesController			= $allPagesController;
		$this->miscellaneousApiController	= $miscellaneousApiController;
	}
	// parent::deal_pages($currentPage, $totalPage)		處理分頁
	// parent::http_request($request_url, $post_data)	請求外部資料
	// abort(404, msg)									錯誤訊息+跳轉

    public function news (Request $request, $page=1) {
    	$this->viewData['active_menu'] = 'news';
    	$this->viewData['pageTitle'] = "最新消息";
    	// 列表資料
    	$this->get_list_data($productNum=2, $page, $seo_prefix='news');

		// dump($this->viewData);
		return view("client.news", $this->viewData);
    }
    public function news_content(Request $request, $page=1, $id="0"){
    	$this->viewData['active_menu'] = 'news';
    	$this->viewData['pageTitle'] = "最新消息";
    	// 列表資料
    	$this->get_one_data($id, $seo_prefix='news');
    	$this->viewData['currentPage'] = $page;

    	// dump($this->viewData);
    	return view("client.news_content", $this->viewData);
    }

    public function marquee (Request $request, $page=1) {
    	$this->viewData['active_menu'] = 'marquee';
    	$this->viewData['pageTitle'] = "跑馬燈";
    	// 列表資料
    	$this->get_list_data($productNum=3, $page, $seo_prefix='marquee');

		// dump($this->viewData);
		return view("client.news", $this->viewData);
    }
    public function marquee_content(Request $request, $page=1, $id="0"){
    	$this->viewData['active_menu'] = 'marquee';
    	$this->viewData['pageTitle'] = "跑馬燈";
    	// 列表資料
    	$this->get_one_data($id, $seo_prefix='marquee');
    	$this->viewData['currentPage'] = $page;

    	// dump($this->viewData);
    	return view("client.news_content", $this->viewData);
    }

    public function get_list_data($productNum, $currentPage, $seo_prefix){
    	// 列表資料
	    	$this->viewData['currentPage'] = $currentPage;
	    	$request_obj = new Request([
			    'langId' =>  1,
			    'currentPage' => $currentPage,
	    		'countOfPage' => $this->countOfPage,
			]);
			$products = $this->productApiController->showProductsClient($request_obj, $productNum);
			$this->viewData['list_data'] = $products['items'];

		// 分頁資料
			parent::deal_pages($currentPage, $products['pageCount']);

		// seo設定
			$this->viewData['seo_prefix'] = $seo_prefix;
			$request_obj = new Request([]);
    		$seoCms = $this->cmsApiController->clientShowCmsByTypeId($request_obj, $cmsTypeId=9)['cms'][0];
	    	if($seoCms['template'][$seo_prefix.'_title']){
		    	$this->viewData['web_title'] = $seoCms['template'][$seo_prefix.'_title'];
		    	$this->viewData['fb_title'] = $seoCms['template'][$seo_prefix.'_title'];
	    	}
	    	if($seoCms['template'][$seo_prefix.'_keyword']){
	    		$this->viewData['web_keywords'] = $seoCms['template'][$seo_prefix.'_keyword'];
	    	}
	    	if($seoCms['template'][$seo_prefix.'_description']){
		    	$this->viewData['web_description'] = $seoCms['template'][$seo_prefix.'_description'];
		    	$this->viewData['fb_description'] = $seoCms['template'][$seo_prefix.'_description'];	
	    	}
    }
    public function get_one_data($id, $seo_prefix){
    	// 文章資料
	    	$request_obj = new Request([]);
	    	$product_one = $this->productApiController->showProductOne($request_obj, $id);
	    	if(!$product_one['item']){
	    		abort(404, "無此介紹頁面");
	    	}
	    	$this->viewData['product_one'] = $product_one;
	    	$this->viewData['id'] = $id;

    	// seo設定
			$this->viewData['seo_prefix'] = $seo_prefix;
	    	if($product_one['seo'][0]['prod_prop']){
		    	$this->viewData['web_title'] = $product_one['seo'][0]['prod_prop'];
		    	$this->viewData['fb_title'] = $product_one['seo'][0]['prod_prop'];
	    	}
	    	if($product_one['seo'][1]['prod_prop']){
	    		$this->viewData['web_keywords'] = $product_one['seo'][1]['prod_prop'];
	    	}
	    	if($product_one['seo'][2]['prod_prop']){
		    	$this->viewData['web_description'] = $product_one['seo'][2]['prod_prop'];
		    	$this->viewData['fb_description'] = $product_one['seo'][2]['prod_prop'];	
	    	}
    }
}

