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
    $this->viewData['rand'] = $rand;

    $this->viewData['LIFF_ID_SELECT_SHARE_TARGET'] = env('LIFF_ID_SELECT_SHARE_TARGET');

    // dump($this->viewData);
    return view("client.line_select_share_target", $this->viewData);
  }

  public function get_line_card (Request $request, $rand=""){
    $line_card = DB::table('line_card')->where('rand', '=', $rand)->orderBy('id', 'desc')->get()->toArray();
    if(count($line_card)==0){
      return response()->json();
    }else{
      return response()->json($line_card[0]);
    }
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

