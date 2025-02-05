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

class OnlineController extends Controller
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

    $this->viewData['active_menu'] = 'online';
  }
  // parent::deal_pages($currentPage, $totalPage)		處理分頁
  // parent::http_request($request_url, $post_data)	請求外部資料
  // abort(404, msg)									錯誤訊息+跳轉

  public function online (Request $request, $tag="0"){
    $productNum = 7;

    // 報名項目分類
      $request_obj = new Request([
        'langId' =>  1,
        'productNum' =>  $productNum,
      ]);
      $this->viewData['categoryTags'] = $this->categoryTagApiController->clientShowLayerId($request_obj)->getData()->items;
      if($tag=='0' && $this->viewData['categoryTags']){
        $tag = $this->viewData['categoryTags'][0]->cate_tag_id;
      }
      $this->viewData['current_tag'] = $tag;

    // 報名項目
      $request_obj = new Request([
        'langId' =>  1,
        'cate_tag_id' => $tag,
      ]);
      $this->viewData['products'] = $this->productApiController->showProductsClient($request_obj, $productNum)['items'];

    // 報名說明、課程時段、注意事項
      $this->viewData['online_info_cms'] = $this->cmsApiController->clientGetView($request_obj, $cmsTypeId=6);
      $this->viewData['online_time_cms'] = $this->cmsApiController->clientGetView($request_obj, $cmsTypeId=7);
      $this->viewData['online_notify_cms'] = $this->cmsApiController->clientGetView($request_obj, $cmsTypeId=8);

    // dump($this->viewData);exit;
    return view("client.online", $this->viewData);
  }

  public function online_page(Request $request){
    $this->viewData['online_class'] = $request->get('online_class');
    $this->viewData['online_type'] = $request->get('online_type');
    $this->viewData['online_text'] = $request->get('online_text');

    if(empty($this->viewData['online_class'])){ return redirect('/online.html'); }
    if(empty($this->viewData['online_type'])){ return redirect('/online.html'); }

    $this->viewData['productId'] = '0';
    $this->viewData['productImg'] = ""; /*輪播圖片*/
    $this->viewData['contents'] = [];	/*EDM內容*/
    $this->viewData['productType'] = [];/*簡易問答*/

    // dump($this->viewData);
    return view("client.online_page", $this->viewData);
  }

  public function online_page_by_id(Request $request, $id='0'){
    if($id==='0'){
      $productNum = 7;
      $request_obj = new Request([
        'langId' =>  1,
      ]);
      $products = $this->productApiController->showProductsClient($request_obj, $productNum)['items'];
      if($products){
        // dump($products);exit();
        $id = $products[0]['prod_id'];
      }
    }

    // 報名項目
      $request_obj = new Request([]);
      $product = $this->productApiController->showProductOne($request_obj, $id);

      if(empty($product['item'])){ abort(404, "無此報名項目"); }
      // dump($product);exit;

      if( $product['item']['prod_main_sku']=='已額滿' ){ abort(404, "已額滿，無法報名"); }

      $this->viewData['productId'] = $id;
      $this->viewData['online_class'] = $product['item']['prod_name'];
      $this->viewData['productDescribe'] = isset($product['productDescribe'][2]) ? $product['productDescribe'][2]['prod_describe'] : "";
      $this->viewData['online_type'] = $product['item']['prod_subtitle'];
      $this->viewData['online_text'] = $product['propertyTag'] ? $product['propertyTag'][0]['prod_prop'] : "";

      $this->viewData['productImg'] = $product['productImg'];   /*輪播圖片*/
      $this->viewData['contents'] = $product['contents'];       /*EDM內容*/
      $this->viewData['productType'] = $product['productType']; /*簡易問答*/
      $this->viewData['product'] = $product;                    /*全商品資料*/
    
    // 成功案例
    $case = $this->get_list_by_cate_name($product['item']['prod_name'], 10);
    // dump($case);exit;
    $this->viewData['case'] = $case['list'];
    $this->viewData['case_cate_tag_id'] = $case['cate_tag_id'];

    // QA
    $faq = $this->get_list_by_cate_name($product['item']['prod_name'], 9);
    // dump($faq);exit;
    $this->viewData['faq'] = $faq['list'];

    // seo設定
      if($product['seo'][0]['prod_prop'] ?? ''){
        $this->viewData['web_title'] = $product['seo'][0]['prod_prop'] ?? '';
        $this->viewData['fb_title'] = $product['seo'][0]['prod_prop'] ?? '';
      }
      if($product['seo'][1]['prod_prop'] ?? ''){
        $this->viewData['web_keywords'] = $product['seo'][1]['prod_prop'] ?? '';
      }
      if($product['seo'][2]['prod_prop'] ?? ''){
        $this->viewData['web_description'] = $product['seo'][2]['prod_prop'] ?? '';
        $this->viewData['fb_description'] = $product['seo'][2]['prod_prop'] ?? '';	
      }
      if(count($product['productImg'])>0){
        $this->viewData['fb_img'] = '/upload/product/'.$product['productImg'][0]['prod_img_id'].'/'.$product['productImg'][0]['prod_img_name'];
      }

    // dump($this->viewData);
    return view("client.online_page", $this->viewData);
  }
  private function get_list_by_cate_name($name, $productNum){
    $list = [];
    $cate_tag_id = '0';
    $request_qa_cat = new Request([
      'searchByText' => $name,
      'productNum' => $productNum,
    ]);
    $qa_cat = $this->categoryTagApiController->clientShowLayerId($request_qa_cat)->getData()->items;
    if(count($qa_cat)>0){
      $cate_tag_id = $qa_cat[0]->cate_tag_id;
      $request_case = new Request([
        'cate_tag_id' => $cate_tag_id,
    ]);
      $list = $this->productApiController->showProductsClient($request_case, $productNum)['items'];
    }
    return ['list'=>$list, 'cate_tag_id'=>$cate_tag_id];
  }
}

