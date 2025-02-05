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

class CmsController extends Controller{
	public function __construct(
		GalleryApiController		$galleryApiController,
		CmsTypeApiController		$cmsTypeApiControlle,
		CmsApiController			$cmsApiController,
		ProductApiController		$productApiController,
		CategoryTagApiController	$categoryTagApiController,
		AllPagesController			$allPagesController,
		MiscellaneousApiController  $miscellaneousApiController
	){
		parent::__construct($cmsApiController);
		$this->galleryApiController			= $galleryApiController;
		$this->cmsTypeApiControlle			= $cmsTypeApiControlle;
		$this->cmsApiController				= $cmsApiController;
		$this->productApiController			= $productApiController;
		$this->categoryTagApiController		= $categoryTagApiController;
		$this->allPagesController			= $allPagesController;
		$this->miscellaneousApiController	= $miscellaneousApiController;
	}
	// parent::deal_pages($currentPage, $totalPage)		處理分頁(若一頁中有多分頁功能，可利用回傳值)
	// parent::http_request($request_url, $post_data)	請求外部資料
	// abort(404, msg)									錯誤訊息+跳轉

	public function privacy_policy (Request $request) {
    // 同意書內容
    $privacy_policy_content = $this->cmsApiController->clientGetView($request, 3);
    $this->viewData['privacy_policy_content'] = $privacy_policy_content;

		// seo設定
		parent::set_page_seo($request, 'privacy_policy'); // 字串與需cms_type=2的cms的content對應
		// dump($this->viewData);
		return view("client.privacy_policy", $this->viewData);
	}
}