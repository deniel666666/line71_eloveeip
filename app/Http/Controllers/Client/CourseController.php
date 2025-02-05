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

class CourseController extends Controller
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

  public function course (Request $request, $id="") {
    $this->viewData['active_menu'] = 'course';
    $this->viewData['pageTitle'] = "課程介紹";
    // 列表資料
    $this->get_data($productNum=4, $id, $seo_prefix='course');

    // dump($this->viewData);
    return view("client.course", $this->viewData);
  }
  public function site (Request $request, $id="") {
    $this->viewData['active_menu'] = 'site';
    $this->viewData['pageTitle'] = "場地介紹";
    // 列表資料
    $this->get_data($productNum=5, $id, $seo_prefix='site');

    // dump($this->viewData);
    return view("client.course", $this->viewData);
  }

  public function get_data($productNum, $id, $seo_prefix){
    // 列表資料
      $request_obj = new Request([
        'langId' =>  1,
      ]);
      $products = $this->productApiController->showProductsClient($request_obj, $productNum);
      $this->viewData['list_data'] = $products['items'];
      if(!$products['items']){ /*如果沒有介紹文章*/
        return abort(404, "尚未上架介紹內容");
      }

    // 文章資料
      if($id==""){ /*未提供id*/
          $id = $products['items'][0]['prod_id']; /*預設開啟排序第一個的文章*/
        }
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

