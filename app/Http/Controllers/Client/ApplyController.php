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

class ApplyController extends Controller
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
	}
	// parent::deal_pages($currentPage, $totalPage)		處理分頁
	// parent::http_request($request_url, $post_data)	請求外部資料
	// abort(404, msg)									錯誤訊息+跳轉

    public function apply (Request $request) {
    	$this->viewData['active_menu'] = 'apply';
    	$this->viewData['pageTitle'] = "報名位置";
    	// 列表資料
    	$this->get_data($cmsTypeId=4, $seo_prefix='apply');

		// dump($this->viewData);
		return view("client.apply", $this->viewData);
    }

    public function examination (Request $request) {
    	$this->viewData['active_menu'] = 'examination';
    	$this->viewData['pageTitle'] = "體檢須知";
    	// 列表資料
    	$this->get_data($cmsTypeId=5, $seo_prefix='examination');

		// dump($this->viewData);
		return view("client.apply", $this->viewData);
    }

    public function get_data($cmsTypeId, $seo_prefix){
    	// 列表資料
	    	$request_obj = new Request([]);
			$cms_html = $this->cmsApiController->clientGetView($request_obj, $cmsTypeId);
			$this->viewData['cms_html'] = $cms_html;

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
}

