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

class FaqController extends Controller
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

	public function index (Request $request, $cate_tag_id='0',$currentPage='1') {
		// 撈 FAQ 類別資料
		$request_items = new Request([
			'productNum' =>  3,
		]);
		$this->viewData['categories'] = $this->categoryTagApiController->clientShowLayerId($request_items)->getData()->items;
		//dump($this->viewData['categories']);

		//沒有指定看分類，給第一筆分類
		if($cate_tag_id=='0'){
			// if(count($this->viewData['categories'])==0){ abort(404, '無資料'); }
			if(count($this->viewData['categories'])>0){
				$cate_tag_id = $this->viewData['categories'][0]->cate_tag_id;
			}
		//有指定分類 (會有id)
		}else{
			$allow_view = false;
			foreach ($this->viewData['categories'] as $key => $value) {
				if($value->cate_tag_id == $cate_tag_id){
					$allow_view = true;
					break;
				}
			}
			if(!$allow_view){abort(404, '此頁面不存在');  }
		}
		$this->viewData['cate_tag_id'] = $cate_tag_id;

		// 撈 FAQ 問題列表
		$request_obj = new Request([
			'cate_tag_id' => $cate_tag_id,
			'currentPage' => $currentPage,
			'countOfPage' => 5, /*顯示商品數 */
		]);
		$faq = $this->productApiController->showProductsClient($request_obj, $productNum=3);
		$this->viewData['faq'] = $faq['items'];		
		
		// dump($faq);

		/*處理分頁*/
		$this->viewData['current_tag']= $cate_tag_id;
		$this->viewData['currentPage'] = $currentPage;
		parent::deal_pages($currentPage, $faq['pageCount']);
		// dump($faq);

		// seo設定
		parent::set_page_seo($request, 'about_contact'); // 字串與需cms_type=2的cms的content對應

		// dump($this->viewData);
		return view("client.faq", $this->viewData);
	}
}

