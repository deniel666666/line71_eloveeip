<?php
namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \DB;
use App\Helpers\AppHelper;

//----------------------------------------------------------------------------------------------

use App\Http\Controllers\Api\Gallery\GalleryApiController;
use App\Http\Controllers\Api\Cms\CmsTypeApiController;
use App\Http\Controllers\Api\Cms\CmsApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\CategoryTagApiController;
use App\Http\Controllers\Api\AllPagesController;
use App\Http\Controllers\Api\MiscellaneousApiController;

class LinecardController extends Controller
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
  // parent::deal_pages($currentPage, $totalPage)   處理分頁
  // parent::http_request($request_url, $post_data) 請求外部資料
  // abort(404, msg)                                錯誤訊息+跳轉

  public function select_share_target (Request $request){
    $rand = $request->get('rand');
    $type = $request->get('type');
    $this->viewData['rand'] = $rand;
    
    // 判斷連結是否有效
    $liff_state = $request->get('liff_state');
    $line_card = DB::table('line_card')->where('rand', '=', $rand)->get()->toArray();
    $check_result = $this->check_line_card($line_card);
    if($check_result[0] && !$liff_state){ abort(404, $check_result[0]); }

    $state = $request->get('state');
    $this->viewData['state'] = empty($state) == true ? "" : $state;

    $this->viewData['LIFF_ID_SELECT_SHARE_TARGET'] = env('LIFF_ID_SELECT_SHARE_TARGET');

    // dump($this->viewData);

    if($liff_state){ /*liff app跳轉化面*/
      return view("client.line_select_share_target_blank", $this->viewData);
    }
    if($type == 'webshare'){ /*是後台分享好開啟的畫面*/
      return view("client.line_select_share_target", $this->viewData);
    }else{  /*是LINE分享好友按鈕開啟的畫面*/
      return view("client.line_select_share_target2", $this->viewData);
    }
  }
  public function get_line_card (Request $request, $rand=""){
    $line_card = DB::table('line_card')->where('rand', '=', $rand)->orderBy('id', 'desc')->get()->toArray();

    // 判斷連結是否有效
    $check_result = $this->check_line_card($line_card);
    if($check_result[0]){ $line_card = []; }

    if(count($line_card)==0){
      return response()->json();
    }else{
      $return_data = $line_card[0];
      $prod_ids = $return_data->prod_ids ? json_decode($return_data->prod_ids, true) : [];
      $template = $return_data->template ? json_decode($return_data->template, true) : [];
      $template_allow = [];
      foreach ($prod_ids as $key => $prod_id) {
        if(in_array($prod_id, $check_result[1])){ /*有在可瀏覽的id中*/
          if(isset($template[$key])){
            array_push($template_allow, $template[$key]);
          }
        }
      }
      $return_data->template = json_encode($template_allow, JSON_UNESCAPED_UNICODE);
      return response()->json($return_data);
    }
  }
  private function check_line_card($line_card=[]){
    $allowd_ids = [];
    if(count($line_card)==0){ return ['連結有誤', $allowd_ids]; }

    /*檢查有效期限*/
    $prod_ids_json = $line_card[0]->prod_ids;
    $prod_ids = json_decode($prod_ids_json);
    if(!$prod_ids){ return ['無可分享的名片', $allowd_ids]; }
    $request_obj = new Request([
      'includeIds' => $prod_ids_json,
    ]);
    $products = $this->productApiController->showProductsClient($request_obj, 8);
    // dump($products);exit;
    if($products['count']==0){ /*回傳量為0(可能因刪除、下架、過期)*/
      return ['無可分享的名片', $allowd_ids];
    }
    if(count($prod_ids)!=$products['count']){ /*指定量與回傳量不符(可能因刪除、下架、過期)*/
      // return ['連結失效，請重新取得分享連結', $allowd_ids];
    }

    foreach ($products['items'] as $product) {
      array_push($allowd_ids, $product['prod_id']);
    }

    return ['', $allowd_ids];
  }

  public function add(Request $request){
    $template = $request->get('template');
    // dump($template);
    if(!$template){
      response()->json([
        'status'=> 500,
        'msg'	=> '請設定名片內容',
      ]);
    }

    $rand = AppHelper::instance()->geraHash(32);
    $add_data = [
      'rand' => $rand,
      'template' => $template,
      'prod_ids' => $request->get('id_array'),
    ];
    $result = DB::table('line_card')->insert($add_data);

    if($result){
      $return_data = [
        'status'=> 200,
        'msg'	=> $rand,
      ];
    }else{
      $return_data = [
        'status'=> 500,
        'msg'	=> '新增失敗',
      ];
    }

    return response()->json($return_data);
  }
}

