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

class HomeController extends Controller
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

  public function index (Request $request){
    // 強制跳轉第一個未關閉的活動
    return redirect('/0/online_page.html');

    // 大圖輪播
      $request_obj = new Request(['selectLangItem' =>1,]);
      $this->viewData['gallerys'] = $this->galleryApiController->showClient($request_obj, $galleryTypeId=1)->getData()->items;

    // 自訂介紹內容
      $this->viewData['cms_html'] = $this->cmsApiController->clientGetView($request_obj, $cmsTypeId=2);

    // 挖空介紹內容
      $this->viewData['cmss'] = $this->cmsApiController->clientShowCmsByTypeId($request_obj, $cmsTypeId=3)['cms'];

    // 推薦 最新消息
      $request_news = new Request([
        'langId' => 1,
        'promote' => 1,
        'currentPage' => 1,
        'countOfPage' => 5,
      ]);
      $this->viewData['news'] = $this->productApiController->showProductsClient($request_news, $productNum=2)['items'];

    // 友站連結 前7個
      $request_obj = new Request([
        'selectLangItem' =>1,
        'currentPage' => 1,
        'countOfPage' => 7,
      ]);
      $this->viewData['link_friend'] = $this->galleryApiController->showClient($request_obj, $galleryTypeId=4)->getData()->items;

    // 服務連結 前7個
      $request_obj = new Request([
        'selectLangItem' =>1,
        'currentPage' => 1,
        'countOfPage' => 7,
      ]);
      $this->viewData['link'] = $this->galleryApiController->showClient($request_obj, $galleryTypeId=3)->getData()->items;

    // seo設定
		  parent::set_page_seo($request, 'home'); // 字串與需cms_type=2的cms的content對應

    // dump($this->viewData);
    return view("client.home", $this->viewData);
  }
}

