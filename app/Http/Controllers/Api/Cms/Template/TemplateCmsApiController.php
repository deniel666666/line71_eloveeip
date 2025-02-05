<?php
namespace App\Http\Controllers\Api\Cms\Template;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\AppHelper;
use File;
use \DB;

use App\Repositories\SortOrderRepository;

class TemplateCmsApiController extends Controller
{
  private $fileService;
  private $cmsRepository;
  private $public_file_target;
  private $public_file_path;

  public function __construct(
    $fileService,
    /*對應資料庫*/
    $cmsRepository,
    $cmsModel,
    /*圖片路徑*/
    $public_file_target
  ){
    $this->fileService 			= $fileService;
    $this->cmsRepository 		= $cmsRepository;
    $this->cmsModel 			= $cmsModel;
    $this->public_file_target	= $public_file_target;
    $this->public_file_path		= '/public/upload/cms/'.$public_file_target.'/';
  }

  /*顯示cms內容(client)*/
  public function clientShowCmsByTypeId(Request $request, $cmsTypeId){
    $cms = $this->arrangeCms($cmsTypeId, $viewEnd='client');
    $data = [
      'status'=> 200,
      'cms'=> $cms
    ];
    return $data;
  }
  /*顯示cms內容(admin)*/
  public function showCmsByTypeId(Request $request, $cmsTypeId){
    $cms = $this->arrangeCms($cmsTypeId);
    $data = [
      'status'=> 200,
      'cms'=> $cms
    ];
    return $data;
  }

  /*取得渲染後CMS(admin)*/
  public function GetView(Request $request, $cmsTypeId){
    $cmsId = isset($_GET['cmsId']) ? $_GET['cmsId'] : "";

    $viewData['show_order'] = true;
    $viewData['cms'] = [];
    $viewData['cms'] = $this->arrangeCms($cmsTypeId, $viewEnd='admin', $cmsId);

    return $this->return_view_view($viewData, $cmsTypeId);
    }
  /*取得渲染後CMS(client)*/
  public function clientGetView(Request $request, $cmsTypeId){
    $viewData['show_order'] = '';
    $viewData['cms'] = [];
    $viewData['cms'] = $this->arrangeCms($cmsTypeId, $viewEnd='client');

    return $this->return_view_view($viewData, $cmsTypeId);
  }
  /*依是否指定展示顯示畫面回傳對應view*/
  public function return_view_view($viewData, $cmsTypeId){
    /*逐個內容渲染*/
    $cms_views = "";
    foreach ($viewData['cms'] as $key => $value) {
      $cms_views .= $this->get_one_cms_content_html($value, $viewData['show_order']);
    }
    $viewData['cms_views'] = $cms_views;

      /*判斷是否有指定回傳畫面*/
    $cmsType = $this->cmsRepository->getCmsType($cmsTypeId);
    $typePrimaryKey = $cmsType->getKeyName();
    $cmsType = $cmsType->toArray();
    if($cmsType['child_template_id']!=0){ /*套用子模板不是0*/
      $relation_table = $this->cmsModel->getTable().'_layout_relation';
      // dump($relation_table);
      if(\Schema::hasTable($relation_table)){ /*有存在模板關係表*/
        $current_child_template = (array)DB::table($relation_table)
              ->where('cms_type_id','=',$cmsType[$typePrimaryKey])
              ->where('child_template_id','=',$cmsType['child_template_id'])
              ->get()->first();
        // dump($current_child_template);
        if($current_child_template){ /*有當前對應的子模板關係*/
          if($current_child_template['view_view']){ /*展示顯示畫面有設定值*/
            return view("admin.cms.view_template.".$current_child_template['view_view'], $viewData); /*依設定回傳畫面*/
          }
        }
      }
    }

    return view("admin.cms.view_template.cmsViewTemplate", $viewData); /*預設回傳標準模板cms*/
  }

  /*取得CMS中單一個內容渲染出的html*/
  public function get_one_cms_content_html($cmsItem, $show_order=false){
    $viewData['show_order'] = $show_order; /*是否按顯示排序*/

    $viewData['cmsItem'] = $cmsItem;
    $viewBlade = $cmsItem['template']['viewBlade'];
    // dump($viewData);
    return view("admin.cms.view_template.".$viewBlade, $viewData)->render();
  }


  /*新增一個cms區塊*/
  public function addCms(Request $request){
    $cmsTypeId 			= $request->get('cmsTypeId');
    $cms 				= $request->get('cms');
    $child_template_id	= $request->get('child_template_id');

    if(!empty($cms)){
      //---------------------------
      // extract and replace src
      //---------------------------
      foreach($cms as $cmsKey => $cmsValue){
        if(!empty($cms[$cmsKey]['cont']['text'])){
          $dom = new \domdocument();
          $dom->loadHtml(mb_convert_encoding($cms[$cmsKey]['cont']['text'],'HTML-ENTITIES','UTF-8'));
          // $dom->loadHtml(mb_convert_encoding($cms[$cmsKey]['cont']['text'],'HTML-ENTITIES','UTF-8'),LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
          $images = $dom->getelementsbytagname('img');
          foreach($images as $k => $img){
            $base64file	= $img->getattribute('src');
            $fileName 	= $img->getattribute('data-filename');
            if ($fileName != ''){
              $ext = explode('.', $fileName);
              $ext = end($ext);
              $fileName = sha1(uniqid(time(), true)) . '.' . $ext;

              $file = $this->fileService->base64Store($base64file, 'upload','cms/'.$this->public_file_target.'/'.$cmsTypeId, $fileName);

              $img->removeattribute('src');
              $img->removeattribute('data-filename');
              $img->setattribute('src', $this->public_file_path.$cmsTypeId.'/'.$fileName);
            }//if
          }//foreach
          $detail = $dom->savehtml($dom);
          $cms[$cmsKey]['cont']['text'] = $detail;
        }
      }//foreach
      //----------------------------------
    }

    // ---------------------------------
    
    try {
      $this->cmsRepository->addcms($cmsTypeId, $child_template_id, $cms);
      $data = [
        'status'=> 200,
      ];
    } catch (\Exception $e) {
      // dump($e->getMessage());exit;
      $data = [
        'status' => 500,
        'msg' => '新增有誤，請重新整理後再試一次'
      ];

    }

    $cms = $this->arrangeCms($cmsTypeId);
    $data['cms']	= $cms;

    return response()->json($data);
  }
  /*編輯一個cms區塊*/
  public function updateCms(Request $request){
    $cmsTypeId = $request->input('cmsTypeId');
    $item = $request->input('cms');
    // dump($item); exit;

    // order increase start
    if( isset($item['order_id']) ){
      if($item['order_id']!==''){
        $getOneByCms = $this->cmsRepository->getOneCms($item['cmsId']);
        $SortOrderRepository = new SortOrderRepository();
        $retData = $SortOrderRepository->cmsContSort($this->cmsModel,$item,$getOneByCms);
      }
    }
    // order increase end

    $cmsId = $item['cmsId'];
    $type = $item['type'];

    $getCms = $this->cmsRepository->getOneCms($cmsId);

    //---------------------------
    // extract and replace src
    //---------------------------
    if(!empty($item['cont']['text'])){ /* 處理編輯器內容 */      
      // foreach($item as $cmsKey => $cmsValue){
        $dom = new \domdocument();
        $dom->loadHtml(mb_convert_encoding($item['cont']['text'],'HTML-ENTITIES','UTF-8'));
        // $dom->loadHtml(mb_convert_encoding($item['cont']['text'],'HTML-ENTITIES','UTF-8'),LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getelementsbytagname('img');
        foreach($images as $k => $img){
          $base64file = $img->getattribute('src');
          $fileName   = $img->getattribute('data-filename');

          if ($fileName != ''){
            $ext = explode('.', $fileName);
            $ext = end($ext);
            $fileName = sha1(uniqid(time(), true)) . '.' . $ext;
            $file = $this->fileService->base64Store($base64file, 'upload','cms/'.$this->public_file_target.'/'.$cmsTypeId, $fileName);

            $img->removeattribute('src');
            $img->removeattribute('data-filename');
            $img->setattribute('src', $this->public_file_path.$cmsTypeId.'/'.$fileName);
          }//if
        }//foreach

        $detail = $dom->savehtml($dom);
        $item['cont']['text'] = $detail;
      // }//foreach
    }

    // 處理圖片
    if(!empty($item['imageSrc']) ){
      $img = $item['imageSrc'];
      $oldImg = '//'.$_SERVER['HTTP_HOST'].$this->public_file_path.$cmsTypeId.'/'.$getCms['cms_img'];
      // dump($img); dump($oldImg); exit;
      if($img != $oldImg){
        if( mb_substr($img, 0, 5) == "data:"){
          if(!empty($getCms['cms_img'])){
            $this->deleteImg(base_path().$this->public_file_path.$cmsTypeId.'/'.$getCms['cms_img']);
          }
          $t=time();
          $getType = explode(";",$img)[0];
          $getType = explode("/",$getType)[1];
          // $fileName = $t.$this->cmsRepository->geraHash(8).'.'.$getType;
          $gethash = AppHelper::instance()->geraHash(8);
          $fileName = $t.$gethash.'.'.$getType;
          $directory_path = base_path().$this->public_file_path.$cmsTypeId;
          if(!File::exists($directory_path)) {
            File::makeDirectory($directory_path, 0777);
          }

          $filePath = $directory_path.'/'.$fileName;
          $imgData = substr($img,strpos($img,",") + 1);
          $decodedData = base64_decode($imgData);
          file_put_contents($filePath, $decodedData);
          unset($item['imageSrc']);
          $updData['cms_img'] = $fileName;
        }
      }
    }

    // 處理 template的參數
    if(isset($item['template'])){
      $template_keys = array_keys($item['template']);
      // dump($template_keys);
      foreach ($template_keys as $key) {
        if( preg_match("/^pic_/", $key) ) { // 處理圖片
          $ori_content = $getCms['content'] ? (array)json_decode($getCms['content']) : [];
          $ori_template = isset($ori_content['template']) ? (array)$ori_content['template'] : [];	           
          $img = $item['template'][$key];	
          if( mb_substr($img, 0, 5) == "data:"){
            /*刪除舊圖片*/
            if(isset($ori_template[$key])){
              if($ori_template[$key]){
                if( File::exists(base_path().$this->public_file_path.$cmsTypeId.'/'.$ori_template[$key]) ){
                  $this->deleteImg(base_path().$this->public_file_path.$cmsTypeId.'/'.$ori_template[$key]);
                }
              }
            }
            $t=time();
            $getType = explode(";",$img)[0];
            $getType = explode("/",$getType)[1];
            // $fileName = $t.$this->cmsRepository->geraHash(8).'.'.$getType;
            $gethash = AppHelper::instance()->geraHash(8);
            $fileName = 'template_'.$t.$gethash.'.'.$getType;
            $directory_path = base_path().$this->public_file_path.$cmsTypeId;
            if(!File::exists($directory_path)) {
              File::makeDirectory($directory_path, 0777);
            }

            $filePath = $directory_path.'/'.$fileName;
            $imgData = substr($img,strpos($img,",") + 1);
            $decodedData = base64_decode($imgData);
            file_put_contents($filePath, $decodedData);
            
            $item['template'][$key] = $fileName;
          }
          else{
            $item['template'][$key] = $ori_template[$key];
          }
        }

        if( preg_match("/^content_/", $key) ){ // 處理編輯器
          if(!empty($item['template'][$key])){ /* 處理編輯器內容 */
            $dom = new \domdocument();
            $dom->loadHtml(mb_convert_encoding($item['template'][$key],'HTML-ENTITIES','UTF-8'));
            // $dom->loadHtml(mb_convert_encoding($item['template'][$key],'HTML-ENTITIES','UTF-8'),LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $images = $dom->getelementsbytagname('img');
            foreach($images as $k => $img){
              $base64file = $img->getattribute('src');
              $fileName   = $img->getattribute('data-filename');

              if ($fileName != ''){
                $ext = explode('.', $fileName);
                $ext = end($ext);
                $fileName = sha1(uniqid(time(), true)) . '.' . $ext;
                $file = $this->fileService->base64Store($base64file, 'upload','cms/'.$this->public_file_target.'/'.$cmsTypeId, $fileName);

                $img->removeattribute('src');
                $img->removeattribute('data-filename');
                $img->setattribute('src', $this->public_file_path.$cmsTypeId.'/'.$fileName);
              }//if
            }//foreach
            $detail = $dom->savehtml($dom);
            $item['template'][$key] = $detail;
          }
        }
      }
    }

    if( isset($item['order_id']) ){
      if($item['order_id']!==''){
        $updData['order_id'] = $item['order_id'];
      }
    }

    // unset($item['name']);
    unset($item['imageSrc']);
    unset($item['cmsId']);
    unset($item['order_id']);
    $updData['content'] = json_encode($item, JSON_UNESCAPED_UNICODE);

    /*更新資料*/
    $this->cmsRepository->updateCms($cmsId, $updData);

    AppHelper::instance()->clean_cms_img_with_id($getCms->getTable(), $getCms->getTable(), $getCms['cms_type_id']);

    $cms = $this->arrangeCms($cmsTypeId);
    $data = [
      'status'=> 200,
      'cms'=> $cms
    ];
    return $data;
  }

  /*刪除一個cms區塊*/
  public function destroy(Request $request){
    $cmsTypeId = $request->input('cmsTypeId');
    $cmsId = $request->input('cmsId');
    $type = $request->input('type');

    $getCms = $this->cmsRepository->getOneCms($cmsId);

    /*刪除cms_img圖片*/
    $image = $getCms['cms_img'];
    if( !empty($image) ){
      $this->deleteImg(base_path().$this->public_file_path.$cmsTypeId.'/'.$image);
    }

    /*刪除content text圖片*/
    if(!empty($content['cont']['text'])){ /* 處理編輯器內容 */      
            $dom = new \domdocument();
            $dom->loadHtml(mb_convert_encoding($content['cont']['text'],'HTML-ENTITIES','UTF-8'));
            $images = $dom->getelementsbytagname('img');
            foreach($images as $k => $img){
                $fileName = $img->getattribute('src');
                $fileName = explode('/', $fileName);
                $fileName = end($fileName);
                $this->deleteImg(base_path().$this->public_file_path.$cmsTypeId.'/'.$fileName);
            }
        }

    /*刪除template圖片*/
    $content = $getCms['content'] ? json_decode($getCms['content'], true) : [];
    if( isset($content['template']) ){
      $template_keys = array_keys($content['template']);
      foreach ($template_keys as $key) {
        if( preg_match("/^pic_/", $key) ){ /*圖片*/
          $this->deleteImg(base_path().$this->public_file_path.$cmsTypeId.'/'.$content['template'][$key]);
        }

        if( preg_match("/^content_/", $key) ){ // 編輯器
          if(!empty($content['template'][$key])){ /* 處理編輯器內容 */
                    $dom = new \domdocument();
                    $dom->loadHtml(mb_convert_encoding($content['template'][$key],'HTML-ENTITIES','UTF-8'));
                    $images = $dom->getelementsbytagname('img');
                    foreach($images as $k => $img){
                        $fileName = $img->getattribute('src');
                      $fileName = explode('/', $fileName);
                      $fileName = end($fileName);
                      $this->deleteImg(base_path().$this->public_file_path.$cmsTypeId.'/'.$fileName);
                    }
              }
        }
      }
    }

    $this->cmsRepository->deleteCms($cmsId);

    $cms = $this->arrangeCms($cmsTypeId);
    $data = [
      'status'=> 200,
      'cms'=> $cms
    ];
    return $data;
  }
  /*刪除一個cms圖片區塊圖片*/
  public function destroyImg(Request $request){
    $cmsId = $request->input('cmsId');
    $item = $request->input('item');
    $templateVirable = $request->input('templateVirable');

    $getCms = 	$this->cmsRepository->getOneCms($cmsId);
    $cmsTypeId = $getCms['cms_type_id'];
        // return $cmsTypeId;

    $checkVal = 'error';
    if($templateVirable==""){ /*刪除主圖*/
      if (!empty($getCms['cms_img'])) {
        $updData = [];        
        $updData['cms_img'] = '';
        $this->cmsRepository->updateCms( $cmsId, $updData);
        
        if (File::exists(base_path().$this->public_file_path.$cmsTypeId.'/'.$getCms['cms_img'] )) {
          $this->deleteImg(base_path().$this->public_file_path.$cmsTypeId.'/'.$getCms['cms_img']);
        } 
        $checkVal = 'success';
      }
    }
    else{ /*刪除template參數的圖*/
      $ori_content = $getCms['content'] ? (array)json_decode($getCms['content']) : [];
      $ori_template = isset($ori_content['template']) ? (array)$ori_content['template'] : [];
            
            if (File::exists(base_path().$this->public_file_path.$cmsTypeId.'/'.$ori_template[$templateVirable] )){
                $this->deleteImg(base_path().$this->public_file_path.$cmsTypeId.'/'.$ori_template[$templateVirable]);
            }

            $ori_content['template']->$templateVirable = '';
            $updData['content'] = json_encode($ori_content, JSON_UNESCAPED_UNICODE);
            $this->cmsRepository->updateCms( $cmsId, $updData);
            
            $checkVal = 'success';
    }

    $data = [
            'status'=> 200,
            'message' => $checkVal,
            'cmsId' => $cmsId,
        ];
        return $data;
  }
  /*刪除檔案*/
  public function deleteImg($path){
    $file = explode('/', $path);
    $file = end($file);
    if(!$file){
      return;
    }
    if (file_exists($path)) {
      unlink($path);
    }
  }

  /*依區塊內容整理格式*/
  public function arrangeCms($cmsTypeId, $viewEnd='admin', $cmsId=""){
    if($cmsId){
      $cms = [$this->cmsRepository->getOneCms($cmsId)];
    }else{
      $cms = $this->cmsRepository->getCms($cmsTypeId, $viewEnd);
    }
    // $debug = $cms->toArray();
    $newCms = [];
    $i = 0;

    foreach ($cms as $key => $value) {
      $getCms= $value['content'];
      $tmpCms =  json_decode($getCms,true);
      $tmpCms['imageSrc'] = $value['cms_img'] ? '//'.$_SERVER['HTTP_HOST'].$this->public_file_path.$cmsTypeId.'/'.$value['cms_img'] : "";

      if(isset($tmpCms['cont'])){
        if(isset($tmpCms['cont']['text'])){
          $tmpCms['cont']['text'] = str_replace('src="/public', 'src="//'.$_SERVER['HTTP_HOST'].'/public', $tmpCms['cont']['text']);
        }
      }

      if(isset($tmpCms['template'])){
        $template = $tmpCms['template'];
        $template_keys = array_keys($template);
        // dump($template_keys);
        foreach ($template_keys as $key) {
          if( preg_match("/^pic_/", $key) ) {
            if($template[$key]){
              $tmpCms['template'][$key] = '//'.$_SERVER['HTTP_HOST'].$this->public_file_path.$cmsTypeId.'/'.$template[$key];
            }else{
              $tmpCms['template'][$key] = "";
            }
          }
        }

        if( !isset($tmpCms['template']['hide']) ){
          $tmpCms['template']['hide'] = 0;
        }
      }
      else{
        $tmpCms['template'] = [ 'hide' => 0 ];
      }

      $tmpCms['cmsId'] 		=  $value['cms_id'];
      $tmpCms['order_id'] 	=  $value['order_id'];
      $newCms[$i] =$tmpCms;
      $i++;
    }
    return $newCms;
  }
}

