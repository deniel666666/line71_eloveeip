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

class CaseController extends Controller
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

	public function index (Request $request, $cate_tag_id='0') {
		$productNum='4';
	
		// 撈案例
		$request_obj = new Request([
			'cate_tag_id' => $cate_tag_id,
		]);
		$case = $this->productApiController->showProductsClient($request_obj, $productNum);
		$this->viewData['case'] = $case['items'];
		$this->viewData['cate_tag_id'] = $cate_tag_id;

		// seo設定
		parent::set_page_seo($request, 'news'); // 字串與需cms_type=2的cms的content對應

		return view("client.case", $this->viewData);
	}

	public function case_info (Request $request, $prod_id='') {
		$request_info = new Request([]);
		$content = $this->productApiController->showProductOne($request_info, $prod_id);
		$this->viewData['content'] = $content;
		// dump($content);
	

		// $this->viewData['content'] = $this->productApiController->showProductOne($request_info,$prod_id);
		if(!$this->viewData['content']['item']){
			abort(404, "無此內容");
			}
		// seo設定
		parent::set_page_seo($request, 'news'); // 字串與需cms_type=2的cms的content對應

		//dump($this->viewData['content']);
		return view("client.case-info", $this->viewData);
	}
}

