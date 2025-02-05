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

class LinkController extends Controller
{
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

		$this->viewData['active_menu'] = 'link';
	}
	// parent::deal_pages($currentPage, $totalPage)		處理分頁
	// parent::http_request($request_url, $post_data)	請求外部資料
	// abort(404, msg)									錯誤訊息+跳轉

    public function link (Request $request) {
    	$this->get_data($galleryTypeId=3);

	    // dump($this->viewData);exit;
		return view("client.link", $this->viewData);
	}
	public function link_friend (Request $request) {
    	$this->get_data($galleryTypeId=4);

	    // dump($this->viewData);exit;
		return view("client.link", $this->viewData);
	}

	public function get_data($galleryTypeId){
    	// 連結列表
	    	$request_obj = new Request(['selectLangItem' => 1,]);
	    	$this->viewData['gallerys'] = $this->galleryApiController->showClient($request_obj, $galleryTypeId)->getData()->items;
			$this->viewData['galleryTypeId'] = $galleryTypeId;

    	// seo設定
			$request_obj = new Request([]);
    		$seoCms = $this->cmsApiController->clientShowCmsByTypeId($request_obj, $cmsTypeId=9)['cms'][0];
	    	if($seoCms['template']['link_title']){
		    	$this->viewData['web_title'] = $seoCms['template']['link_title'];
		    	$this->viewData['fb_title'] = $seoCms['template']['link_title'];
	    	}
	    	if($seoCms['template']['link_keyword']){
	    		$this->viewData['web_keywords'] = $seoCms['template']['link_keyword'];
	    	}
	    	if($seoCms['template']['link_description']){
		    	$this->viewData['web_description'] = $seoCms['template']['link_description'];
		    	$this->viewData['fb_description'] = $seoCms['template']['link_description'];	
	    	}
    }
}

