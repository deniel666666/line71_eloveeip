<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use App\Repositories\ProductRepository;
use App\Repositories\ProductCategoryRepository;
use App\Repositories\ProductTypeRepository;
use App\Repositories\LangRepository;
use App\Repositories\MiscellaneousRepository;
use App\Repositories\CategoryTagRepository;
use App\Repositories\CategoryProOrderRepository;
use App\Repositories\ProductLabelTagRepository;
use App\Repositories\ProductTabsTagRepository;
use App\Repositories\SortOrderRepository;

use App\Repositories\Cms\Product\CmsRepository;

use App\Helpers\AppHelper;
use \File;
use \DB;
use App\Services\FileService;
use Storage;

use App\Http\Controllers\Api\Cms\Product\CmsApiController;
use App\Http\Controllers\Api\Record\ViewRecordApiController;
use App\Http\Controllers\Api\Record\LoveRecordApiController;

use App\Services\AccountService;

class ProductApiController extends Controller
{
    protected $mainRepository;
    protected $publicFilePath =  '/public/upload/product/';
    protected $uploadFilePath =  '/upload/product/';
    private   $fileService;
    public function __construct(
        AccountService $accountService,
        CategoryTagRepository       $categoryTagRepository,
        CategoryProOrderRepository  $categoryProOrderRepository,
        ProductRepository           $mainRepository,
        ProductCategoryRepository   $productCategoryRepository,
        ProductTypeRepository       $productTypeRepository,
        LangRepository              $langRepository,
        MiscellaneousRepository     $miscellaneousRepository,
        FileService                 $fileService,
        ProductLabelTagRepository   $productLabelTagRepository,
        ProductTabsTagRepository    $productTabsTagRepository,
        CmsRepository               $cmsRepository,
        CmsApiController            $cmsApiController,
        ViewRecordApiController     $viewRecordApiController,
        LoveRecordApiController     $loveRecordApiController
    ){
        $this->accountService               = $accountService;
        $this->categoryTagRepository        = $categoryTagRepository;
        $this->categoryProOrderRepository   = $categoryProOrderRepository;
        $this->mainRepository               = $mainRepository;
        $this->productCategoryRepository    = $productCategoryRepository;
        $this->productTypeRepository        = $productTypeRepository;
        $this->langRepository               = $langRepository;
        $this->miscellaneousRepository      = $miscellaneousRepository;
        $this->fileService                  = $fileService;
        $this->productLabelTagRepository    = $productLabelTagRepository;
        $this->productTabsTagRepository     = $productTabsTagRepository;
        $this->cmsRepository                = $cmsRepository;
        $this->cmsApiController             = $cmsApiController;
        $this->viewRecordApiController      = $viewRecordApiController;
        $this->loveRecordApiController      = $loveRecordApiController;
    }

    public function index(){
    }

    /* 串接資料用 --------------------------------------------------------------------*/
    /*搜尋商品列表*/
    /*依條件搜取得商品資料(list)*/
    public function getProducts($request_obj, $productNum){
        $request_obj['productNum']     = $productNum;
        // dump($request_obj);exit;
        $user = $this->accountService->getUserInfo();
        $request_obj['user'] = $user;
        $res = $this->mainRepository->getProducts($request_obj);
        $res = $res->toArray();

        foreach($res as $resKey => $resValue){
            // 顯示標籤完整階層
            $res[$resKey]['tag_with_layer_name'] = $this->categoryTagRepository->show_tag_with_layer_name($resValue['category_tag']);

            // 取得多圖
            $res[$resKey]['productImg'] = $this->mainRepository->getProductImg($resValue['prod_id'], 'secondary');

            // 取得cms內容
            $res[$resKey]['cms'] = [];
            $prodContent = $this->cmsRepository->getCms($resValue['prod_id'], $viewEnd='admin')->toArray();
            foreach ($prodContent as $contKey => $contValue){
                $res[$resKey]['cms'][$contKey] = $contValue;
                $res[$resKey]['cms'][$contKey]['content'] =  json_decode($contValue['content']);
            }

            // 紀錄瀏覽
            $res[$resKey]['recordView'] = $this->viewRecordApiController->getRecordCount($model_name='product',  $primary_id=$resValue['prod_id'], $lang_id=1);
            $res[$resKey]['recordLove'] = $this->loveRecordApiController->getRecordCount($model_name='product',  $primary_id=$resValue['prod_id'], $lang_id=1);

            // 註記過往、當前、預告
            if($resValue['prod_show_e_datetime'] < date('Y-m-d H:i:s')){
                $res[$resKey]['timeStatus'] = "過往";
            }else if($resValue['prod_show_s_datetime'] > date('Y-m-d H:i:s')){
                $res[$resKey]['timeStatus'] = "預告";
            }else{
                $res[$resKey]['timeStatus'] = "當期";
            }

            $res[$resKey]['user_name']=$this->accountService->getUserName($res[$resKey]['own_user']);
        }
        return $res;
    }
    /*後台搜尋(list)*/
    public function showProductsAdmin(Request $request, $productNum){
        $request_obj = $request->all();
        $res = $this->getProducts($request_obj, $productNum);

        /* 計算數量、總頁數 */
        $count = count($res);
        $countOfPage = $request->get('countOfPage');
        $currentPage = $request->get('currentPage') ? $request->get('currentPage') : 1;
        $pageCount = $countOfPage!=0 ? (int)($count/$countOfPage) : 0;
        if($countOfPage!=0){
            if ($count%$countOfPage != 0) {
                $pageCount +=1;
            }
        }

        /* 製作出當前頁數的商品列表 */
        $res = array_slice($res, ($currentPage-1)*$countOfPage, $countOfPage);

        $retData = ['items'=>$res, 'count'=>$count, 'pageCount'=>$pageCount];
        return $retData;
    }
    /*前台搜尋(list)*/
    public function showProductsClient(Request $request, $productNum){
        $request_obj = $request->all();

        /* 計算商品總數、總頁數 */
        unset($request_obj['countOfPage']);
        $res_all = $this->getProducts($request_obj, $productNum);
        $frontres_all = [];
        foreach($res_all as $resKey => $resValue){
            $msg = $this->check_show_client($resValue);
            if($msg == 0){
                array_push($frontres_all, $resValue);
            }
        }
        $count = count($frontres_all);
        $currentPage = $request->get('currentPage');
        $countOfPage = $request->get('countOfPage');
        $pageCount = $countOfPage!=0 ? (int)($count/$countOfPage) : 0;
        if($countOfPage!=0){
            if ($count%$countOfPage != 0) {
                $pageCount +=1;
            }

            /* 製作出當前頁數的商品列表 */
            $startIndex = ($currentPage-1) * $countOfPage;
            $frontres = array_slice($frontres_all, $startIndex,$countOfPage);
        }else{
            $frontres = $frontres_all;
        }

        $retData = ['items'=>$frontres, 'count'=>$count, 'pageCount'=>$pageCount];
        return $retData;
    }

    /*搜尋單一商品*/
    /*取得商品資料(one)*/
    public function getOneProduct($productId){
        $item = $this->mainRepository->getOneProduct_sql($productId);

        if($item){
            $item = $item->toArray();
            $productNum = $item['product_num'];
            $langId = $item['lang_id'];
            $getCategoryTagsByLang = $this->mainRepository->getCategoryTagsByLangNum($langId,$productNum);
            //-------------------------------------------------------------------------------start
            $pid = 0; $level = 1;
            $getCategoryTagsByLang = $this->categoryTagRepository->tree($getCategoryTagsByLang,$pid,$level);
            //-------------------------------------------------------------------------------end

            // 紀錄瀏覽
            $item['recordView'] = $this->viewRecordApiController->getRecordCount($model_name='product',  $primary_id=$item['prod_id'], $lang_id=1);
            $item['recordLove'] = $this->loveRecordApiController->getRecordCount($model_name='product',  $primary_id=$item['prod_id'], $lang_id=1);

            $tag_selected = [];
            $getCategoryTagsByProduct = $this->mainRepository->getCategoryTagsByProduct($productId);
            foreach ($getCategoryTagsByLang as $lKey => $lValue) {
                $getCategoryTagsByLang[$lKey]['status'] = 0;
                foreach ($getCategoryTagsByProduct as $pKey => $pValue) {
                    if ($lValue['cate_tag_id']  == $pValue['cate_tag_id']) {
                        $getCategoryTagsByLang[$lKey]['status'] = 1;
                        array_push($tag_selected, $pValue);
                    }
                }
            }

            //-------------------------------------------------------------------------------start20200411
            $hasTags=[]; /*有勾選的tag*/
            $allTags=[]; /*所有的tag*/
            foreach ($getCategoryTagsByLang as $key => $value) {
                if ($value['status']  == 1) {
                    array_push($hasTags, $value['cate_tag_id'] );
                }
                array_push($allTags, $value['cate_tag_id'] );
            }
            $whereInTagIds =  $this->mainRepository->get_prop_tag_id_array($hasTags);
            $whereNotInIds =  $this->mainRepository->get_prop_tag_id_array($allTags);
            $getPropertyTag = $this->mainRepository->getPropertyTagByNumAndIds($langId,$productNum ,$whereInTagIds ,$whereNotInIds);
            $getProductProperty = $this->mainRepository->getProductPropertyDataByProdId($productId , $whereInTagIds ,$whereNotInIds);
            // dump($whereInTagIds);
            // dump($whereNotInIds);
            // dump($getPropertyTag);
            // dump($getProductProperty);
            //-------------------------------------------------------------------------------start
      
            foreach ($getPropertyTag as $key => $value) {
                $getPropertyTag[$key]['prod_prop'] = '';
                $getPropertyTag[$key]['prod_img_path'] = '';
                foreach ($getProductProperty as $pKey => $pValue) {
                    if ($value['prop_tag_id']  == $pValue['prop_tag_id']) {
                        $getPropertyTag[$key]['prod_prop'] = $pValue['prod_prop'] ;
                        $getPropertyTag[$key]['prod_img_path'] = $pValue['prod_img_path'] ;
                    }
                }
            }

            $getProductDescribe = $this->mainRepository->getProductDescribe($productId);
            $getTabsTag     = $this->productTabsTagRepository->show($langId,$productNum,$productId);
            $getSeo         = $this->mainRepository->getSeoPropertyTagNumByProdId($langId,$productNum,$productId);
            $getProductType = $this->mainRepository->getProductType($productId);
            $getProductSpec = $this->mainRepository->getProductSpec($productId);
            $getProductImg  = $this->mainRepository->getProductImg($productId, 'secondary');
            $getProductFile = $this->mainRepository->getProductImg($productId, 'attach');
            $request_obj_cms = new Request([]);
            $contents       = $this->cmsApiController->clientGetView($request_obj_cms, $productId); //$cmsTypeId
            // $contents       = $this->cmsApiController->clientShowCmsByTypeId( $request_obj_cms, $productId); //$cmsTypeId

            $data = [
                'status'=> 200,
                'item' => $item,
                'lang' => $item['lang'],
                'categoryTags' => $getCategoryTagsByLang,
                'categoryTags_selected' => $tag_selected,
                'productDescribe' => $getProductDescribe,
                'tabsTag' => $getTabsTag,
                'seo'     => $getSeo,
                'propertyTag' => $getPropertyTag,
                'productType' => $getProductType,
                'productSpec' => $getProductSpec,
                'productImg' => $getProductImg,
                'productFile' => $getProductFile,
                'contents' => $contents,
            ];

        }else{
            $data = [
                'status'=> 400,
                'item' => [],
                'lang' => [],
                'categoryTags' => [],
                'categoryTags_selected' => [],
                'productDescribe' => [],
                'tabsTag'     => [],
                'seo'         => [],
                'propertyTag' => [],
                'productType' => [],
                'productSpec' => [],
                'productImg' => [],
                'productFile' => [],
                'contents' => [],
            ];
        }
        return $data;
    }
    /*後台搜尋(one)*/
    public function getDetailToEdit(Request $request)
    {
        $productId = $request->get('productId');
        $data = $this->getOneProduct($productId);
        return response()->json($data);
    }
    /*前台搜尋(one)*/
    public function showProductOne(Request $request,$productId){ 
        $item = $this->mainRepository->getOneProduct_sql($productId);
        $item = $item ? $item->toArray() : [];
        // 檢查狀態
        //1:未完成新增
        //2:下架中
        //3:未到上架時間
        //4:已過期
        $msg = $this->check_show_client($item);

        if($msg == 0){
            $data = $this->getOneProduct($productId);
        }else{
            $data = [
                'status'=> 200,
                'msg' => $msg ,
                'item' => [],
            ];
        }

        return $data;
    }
    /* 檢查是否顯示於消費者端 */
    public function check_show_client($item){
        if(!$item){
            return 5;
        }

        if($item['prod_status'] != 0){
            return 1;
        }

        if ($item['prod_shelf'] == 0) {
            return 2;
        }

        $ds = new \DateTime($item['prod_s_datetime']);
        $dn = new \DateTime($item['prod_e_datetime']);
        $now = new \DateTime();

        if($ds > $now ){
            return 3;
        }

        if($item['prod_e_datetime'] != '2222-01-01 00:00:00'){
            if($dn < $now){
                return 4;
            }
        }

        return 0;
    }
    /*-------------------------------------------------------------------------------*/

    public function getProductImg(Request $request, $imgColumn="", $productId=""){
        try {
            $product = $this->showProductOne($request, $productId);
            if($product['item']){
                $img = isset($product['item'][$imgColumn]) ? $product['item'][$imgColumn] : "";
                $img = "https://".$_SERVER['HTTP_HOST']."/upload/product/".$productId."/".$img;
                $fp = fopen($img, 'rb');
            }
            else{
                $fp = fopen("https://".$_SERVER['HTTP_HOST']."/upload/empty.png", 'rb');
            }
        } catch (\Exception $e) {
            $fp = fopen("https://".$_SERVER['HTTP_HOST']."/upload/empty.png", 'rb');
        }

        header('Content-type: image/jpeg;');
        foreach ($http_response_header as $h) {
            if (strpos($h, 'Content-Length:') === 0) {
                header($h);
                break;
            }
        }
        fpassthru($fp);
    }
    
    /*列表頁功能---------------------------------------*/
    /* 子階層建立商品 */
    public function tag_add_pord (Request $request) {
        $productNum =$request->input('productNum');
        $item = $this->mainRepository->getLastAddNotFinishItem($productNum); /*查詢是否有建立中的商品*/
        if($item == null){
            /*無則建立商品*/
            $tag =$request->input('tag');
            $this->addPro($tag ,$productNum ,0);
            $data = [
                'status'=> 200,
            ];
        }else{
            /*有則跳題示*/
            $data = [
                'status'=> 400,
            ];
        }

        return response()->json($data);
    }
    /* 刪除未建立完的商品 再建立商品 */
    public function tag_del_add_pord (Request $request) {
        /*找出前次新增未完的商品*/
        $productNum =$request->input('productNum');
        $item = $this->mainRepository->getLastAddNotFinishItem($productNum);

        /*刪除商品*/
        $request_array = [
            'prod_id' => $item['prod_id'],
        ];
        $request_obj = new Request($request_array);
        $return_data = $this->deleteProduct($request_obj);

        if ($return_data['status'] == '400') {
            $data = [
                'status'=> '400',
            ];
        } else {
            $tag =$request->input('tag');
            $this->addPro($tag ,$productNum ,0);
            $data = [
                'status'=> '200'
            ];
        }
        return $data;
    }
    /* 依給定資料建立商品 */
    public function addPro($tag ,$productNum , $memory) {
        $addData=[
            "prod_s_datetime" => "2020-07-24 10:29:08",
            "prod_e_datetime" => "2222-01-01 00:00:00",
            "prod_status" => 1,
            "lang_id" => 1,
            "product_num" => $productNum,
            "memory" =>$memory, //0 無 1有記憶
        ];
        $getInsertId = $this->mainRepository->addProduct($addData);
        $item = $this->mainRepository->getLastAddNotFinishItem($productNum);

        $productDescribeData = array(
            array('prod_id'=>$getInsertId, 'prod_describe_type'=> 'ProdNo', 'lang_id'=> $item['lang_id'],'created_at'=>date('Y-m-d H:i:s'),'updated_at'=> date('Y-m-d H:i:s')),
            array('prod_id'=>$getInsertId, 'prod_describe_type'=> 'ProdKey', 'lang_id'=> $item['lang_id'],'created_at'=>date('Y-m-d H:i:s'),'updated_at'=> date('Y-m-d H:i:s')),
            array('prod_id'=>$getInsertId, 'prod_describe_type'=> 'ProdSimpleIntro', 'lang_id'=> $item['lang_id'],'created_at'=>date('Y-m-d H:i:s'),'updated_at'=> date('Y-m-d H:i:s'))
        );
        $this->mainRepository->addProductDescribe($productDescribeData);        

        // $tag start
        if(!empty($tag)){
            if($memory == 0){ //子階層建立
                $this->mainRepository->addProdCategoryTag($tag['cate_tag_id'],$item['prod_id']);
                $addTagByProId = $this->categoryProOrderRepository->addOne($tag['cate_tag_id'],$item['prod_id']);
            }else if($memory == 1){   //新建->記憶
                if(count($tag)!=0){
                    foreach ($tag  as $num => $tValue) {
                        $this->mainRepository->addProdCategoryTag( $tValue ,$item['prod_id']);
                        $addTagByProId = $this->categoryProOrderRepository->addOne($tValue ,$item['prod_id']);
                    }
                }
            }
        }
        // $tag end

        // order increase start
        $SortOrderRepository = new SortOrderRepository();
        $retData = $SortOrderRepository->productSort($productNum ,$item, $check_edit_target=false);
        // order increase end

        return $item;
    }

    /* 修改主排序 */
    public function updateMainOrder(Request $request,$prodId){
        $item = $request->get('item');
        unset($updData);

        if (isset($item['prod_order'])){
            $updData['prod_order'] = $item['prod_order'];
        }

        // order increase start
        $productNum = $request->get('productNum');
        $SortOrderRepository = new SortOrderRepository();
        $retData = $SortOrderRepository->productSort($productNum ,$item);
        // order increase end

        if($retData['status'] == 200 ){
            // $this->mainRepository->update($prodId,$updData);
            $this->mainRepository->editOne('Product', $whereData = [['prod_id','=',$prodId]] ,$updData);
        }

        return $retData;
    }
    /* 修改分類排序 */
    public function updateClassOrder(Request $request,$prodId){
        $item = $request->get('item');
        $updData=[
            'prod_id'           =>$item['prod_id'],
            'category_id'       =>$item['category_id'],
            'category_order'    =>$item['category_order'],
        ];

        // order increase start
        $SortOrderRepository = new SortOrderRepository();
        $retData = $SortOrderRepository->productCategorySort($updData);
        // order increase end

        $this->categoryProOrderRepository->updateOne($updData);
        $retData['status']=200;
        return $retData;
    }
    /* 單筆修改狀態(上下架、推薦、購買、新增狀態) */
    public function changeStatus(Request $request)
    {
        $productId = $request->input('productId');
        $status = $request->input('status');
        $type = $request->input('type');
        $owner= $request->input('owner');
        
        //change product status
        $whereData = [['prod_id','=',$productId]];
        $updateStatusData = [ $type => $status];
        $updateOwnerData = ['own_user'=>$owner];
        
        DB::beginTransaction();
        if($type=='prod_status' && $status==0){ // 完成商品建立時
            // $product = $this->getOneProduct($productId)['item'];
        }
        
        $checkVal = $this->mainRepository->editOne('Product', $whereData, $updateStatusData);
        $checkVal = $this->mainRepository->editOne('Product', $whereData, $updateOwnerData);
        if ($checkVal > 0) {
            DB::rollback();
        } else {
            DB::commit();
        }
        $data = [
            'status'=> 200
        ];

        return $data;
    }
    /* 批次修改狀態(上下架、推薦、購買) */
    public function changeMultiStatus(Request $request)
    {
        $productIds = $request->input('ids');
        $status = $request->input('status');
        $type = $request->input('type');
        $whereData = [['prod_id',$productIds]];
        $updateStatusData = [ $type => $status];

        DB::beginTransaction();
        $checkVal = $this->mainRepository->editMulti('Product', 'prod_id' ,$productIds, $updateStatusData);
        if ($checkVal > 0) {
            DB::rollback();
        } else {
            DB::commit();
        }
        $data = [
            'status'=> 200
        ];
        return $data;
    }
    //刪除商品
    public function deleteProduct(Request $request){
        $productId = $request->get('productId');
        $productId = is_array($productId) ? $productId : [$productId];


        $actionArray = ['Product'=>'del',
                        // 'ProductDescribe'=>'del',
                        // 'ProductImg'=>'del',
                        // 'ProdSpecification'=>'del',
                        // 'ProductType'=>'del',
                        // 'ProdContent'=>'del',
                        // 'ProductCategory'=>'del',
                        // 'ProductProperty'=>'del'
                        ];
        $whereData = ['prod_id',$productId];

        $checkVal = 0;
        DB::beginTransaction();     

        foreach ($actionArray  as $key => $value) {
            $checkVal += $this->mainRepository->deleteMulti($key, $whereData);
        }
        if ($checkVal > 0) {
            DB::rollback();
            $data = [
                'status'=> '400',
                'msg'   => '資料庫錯誤'
            ];
        } else {
            DB::commit();
            $data = [
                'status'=> '200'
            ];
        }
        return $data;
    }


    /*新增、編輯商品(主體+細節)---------------------------------------*/
    /*取得最後未建立完成的商品資料(main+detail)*/
    public function getLastProductlNotFinish(Request $request,$productNum)
    {
        $item = $this->mainRepository->getLastAddNotFinishItem($productNum);
        $langs = AppHelper::instance()->getAllLangs();
        $productId = $item['prod_id'];
        $product = $this->getOneProduct($productId);

        $productNum = $item['product_num'];
        $langId = $item['lang_id'];
        $getCategoryTagsByLang = $this->mainRepository->getCategoryTagsByLangNum($langId,$productNum);
        //-------------------------------------------------------------------------------start
        $pid = 0; $level = 1;
        $getCategoryTagsByLang = $this->categoryTagRepository->tree($getCategoryTagsByLang,$pid,$level);
        //-------------------------------------------------------------------------------end
        $getCategoryTagsByProduct = $this->mainRepository->getCategoryTagsByProduct($productId);
        foreach ($getCategoryTagsByLang as $lKey => $lValue) {
            $getCategoryTagsByLang[$lKey]['status'] = 0;
            foreach ($getCategoryTagsByProduct as $pKey => $pValue) {
                if ($lValue['cate_tag_id']  == $pValue['cate_tag_id']) {
                    $getCategoryTagsByLang[$lKey]['status'] = 1;
                }
            }
        }

        $data = [
            'status'        => 200,
            'item'          => $item,
            'langs'         => $langs,
            'product'       => $product,
            'categoryTags'  => $getCategoryTagsByLang,
        ];

        return response()->json($data);
    }
    /* 編輯主體 */
    public function editMain(Request $request)
    {
        $user=$this->accountService->getUserInfo();
        $role = $user['role'][0];
        
        $item = $request->input('item');
        
        $productId = $request->input('productId');
        $msg = 'Success';
        $oldItem = $this->mainRepository->getOneProduct_sql($productId);

        // order increase start
        $productNum =$oldItem['product_num'];
        $SortOrderRepository = new SortOrderRepository();
        $retData = $SortOrderRepository->productSort($productNum ,$item);
        // order increase end

        // 主圖
        if (!empty($item['prod_img'])) {
            if($item['prod_img']==-1){ /*刪除圖片*/
                $item['prod_img'] = null;
            }else{
                $img = $item['prod_img'];
                /* $size =  getimagesize($img);
                switch($item['style']){
                    case 1:                         
                    case 2:
                    case 5:
                        if($size[0] > 400 || $size[1] > 400){                        
                            $data = [
                                'status'=> 100,
                                'msg'=>'圖片太大,請依照建議尺吋之內及圖片比例',
                            ];                
                            return response()->json($data);
                        }
                        if($size[0]/$size[1] != 400/400){
                            $data = [
                                'status'=> 100,
                                'msg'=>'圖片請依照圖片比例',
                            ];                
                            return response()->json($data);
                        }
                        break;
                    case 3:
                        if($size[0] > 400 || $size[1] > 600){                        
                            $data = [
                                'status'=> 100,
                                'msg'=>'圖片太大,請依照建議尺吋之內及圖片比例',
                            ];                
                            return response()->json($data);
                        }
                        if($size[0]/$size[1] != 400/600){
                            $data = [
                                'status'=> 100,
                                'msg'=>'圖片請依照圖片比例',
                            ];                
                            return response()->json($data);
                        }
                        break;
                    case 4:
                        if($size[0] > 400 || $size[1] > 800){                        
                            $data = [
                                'status'=> 100,
                                'msg'=>'圖片太大,請依照建議尺吋之內及圖片比例',
                            ];                
                            return response()->json($data);
                        }
                        if($size[0]/$size[1] != 400/800){
                            $data = [
                                'status'=> 100,
                                'msg'=>'圖片請依照圖片比例',
                            ];                
                            return response()->json($data);
                        }
                        break;
                    
                } */
                
                //dd($size[0].'X'.$size[1]);
                $oldImg = $this->uploadFilePath.$productId.'/'.$oldItem['prod_img'];
                if ($img != $oldImg) {
                    AppHelper::instance()->deleteImg(base_path().$oldImg);
                    $fileName = AppHelper::instance()->renameFile($img);
                    $item['prod_img'] = $fileName;
                    if (!File::exists(base_path().$this->publicFilePath.$productId)) {
                        File::makeDirectory(base_path().$this->publicFilePath.$productId, 0775);
                    }
                    AppHelper::instance()->uploadFile($this->publicFilePath.$productId, $fileName, $img);
                } else {
                    unset($item['prod_img']);
                }
            }
        } else {
            unset($item['prod_img']);
        }

        // 主圖2
        if (!empty($item['prod_img2'])) {
            if($item['prod_img2']==-1){ /*刪除圖片*/
                $item['prod_img2'] = null;
            }else{
                $img = $item['prod_img2'];
                $oldImg = $this->uploadFilePath.$productId.'/'.$oldItem['prod_img2'];
                if ($img != $oldImg) {
                    AppHelper::instance()->deleteImg(base_path().$oldImg);
                    $fileName = AppHelper::instance()->renameFile($img);
                    $item['prod_img2'] = $fileName;
                    if (!File::exists(base_path().$this->publicFilePath.$productId)) {
                        File::makeDirectory(base_path().$this->publicFilePath.$productId, 0775);
                    }
                    AppHelper::instance()->uploadFile($this->publicFilePath.$productId, $fileName, $img);
                } else {
                    unset($item['prod_img2']);
                }
            }
        } else {
            unset($item['prod_img2']);
        }

        // 主圖3
        if (!empty($item['prod_img3'])) {
            if($item['prod_img3']==-1){ /*刪除圖片*/
                $item['prod_img3'] = null;
            }else{
                $img = $item['prod_img3'];
                $oldImg = $this->uploadFilePath.$productId.'/'.$oldItem['prod_img3'];
                if ($img != $oldImg) {
                    AppHelper::instance()->deleteImg(base_path().$oldImg);
                    $fileName = AppHelper::instance()->renameFile($img);
                    $item['prod_img3'] = $fileName;
                    if (!File::exists(base_path().$this->publicFilePath.$productId)) {
                        File::makeDirectory(base_path().$this->publicFilePath.$productId, 0775);
                    }
                    AppHelper::instance()->uploadFile($this->publicFilePath.$productId, $fileName, $img);
                } else {
                    unset($item['prod_img3']);
                }
            }
        } else {
            unset($item['prod_img3']);
        }
        
        unset($item['lang']);
        unset($item['created_at']);
        unset($item['updated_at']);

        unset($item['recordView']);
        unset($item['recordLove']);

        $whereData = [['prod_id','=',$productId]];
        $checkVal = 0;
        if(isset($item['selectUser'])){
            $item['own_user']=$item['selectUser'];
            
        }else{
            if($role=='member'){
                $item['own_user']=$user['id'];               
            }
        }
        unset($item['selectUser']);
        $item['create_user']=$user['id'];
        //dd($item);
        DB::beginTransaction();
        $checkVal += $this->mainRepository->editOne('Product', $whereData, $item);            
        if($checkVal > 0){
            DB::rollback();
        }else{
            DB::commit();
        }
       
        $newItem = $this->mainRepository->getOneProduct_sql($productId);

        $data = [
            'status'=> 200,
            'item'=>$newItem,
        ];

        return response()->json($data);
    }

    /* 編輯 category tag */
    public function editProdCategoryTag(Request $request){
        if ($request->input('productId') == 0) {
            $productNum = $request->input('productNum');
            $item = $this->mainRepository->getLastAddNotFinishItem($productNum);
            $productId = $item->prod_id;
        } else {
            $productId = $request->input('productId');
            $item = $this->mainRepository->getOneProduct_sql($productId);
            $productNum = $item['product_num'];
        }

        $items = $request->input('item');
        // dump($items);

        DB::beginTransaction();
        foreach ($items as $key => $value) {
            if ($value['status'] == 1) {
                $getProdCategoryTagOne = $this->mainRepository->searchProdCategoryTag($value['cate_tag_id'], $productId);
                
                $need_add = false;
                if(!$getProdCategoryTagOne){
                    $need_add = true;
                }elseif (!$getProdCategoryTagOne['prod_cate_id']) {
                    $need_add = true;
                }
                if($need_add){
                    $getValue = $this->mainRepository->addProdCategoryTag($value['cate_tag_id'], $productId);
                    $addTagByProId = $this->categoryProOrderRepository->addOne($value['cate_tag_id'] , $productId);  
                    if ($getValue == 0) {
                        DB::rollback();
                    }
                }
            } else {
                $categoryTags = $this->mainRepository->getCategoryTagsByProduct($productId);
                //dump($categoryTags);
                if(count($categoryTags) >= 1){ /* 以勾選的tag數量比1大才可刪除 */
                    $whereData = [['prod_id','=',$productId],['cate_tag_id','=',$value['cate_tag_id']]];
                    //dump($whereData);
                    $getValue = $this->mainRepository->deleteOne('ProductCategory', $whereData);
                    $deleteTagByProId = $this->categoryProOrderRepository->deleteOne($value['cate_tag_id'] , $productId);
                    if ($getValue == 1) {
                        DB::rollback();
                    }
                }
            }
        }
        DB::commit();
        $langId = $item['lang_id'];
        $categoryTagByProduct = $this->getCategoryTagByProductNum($productId,$langId,$productNum);
        //-------------------------------------------------------------------------------start
        $pid = 0; $level = 1;
        $categoryTagByProduct = $this->categoryTagRepository->tree($categoryTagByProduct,$pid,$level);
        //-------------------------------------------------------------------------------end
        $data = [
            'status'=> 200,
            'categoryTags'=> $categoryTagByProduct
        ];
        return response()->json($data);
    }
    public function getCategoryTagByProductNum($productId,$langId,$productNum)
    {

        $getCategoryTagsByLang = $this->mainRepository->getCategoryTagsByLangNum($langId,$productNum);

        $getCategoryTagsByProduct = $this->mainRepository->getCategoryTagsByProduct($productId,$productNum);

        foreach ($getCategoryTagsByLang as $lKey => $lValue) {

            $getCategoryTagsByLang[$lKey]['status'] = 0;

            foreach ($getCategoryTagsByProduct as $pKey => $pValue) {

                if ($lValue['cate_tag_id']  == $pValue['cate_tag_id']) {

                    $getCategoryTagsByLang[$lKey]['status'] = 1;

                }

            }

        }

        return $getCategoryTagsByLang;
    }

    /* 編輯 describe */
    public function editProductDescribe(Request $request)
    {
        $items = $request->input('item');
        $prod_id = $items[0]['prod_id'];
        $find_contact_type = $this->mainRepository->getProductContactId($prod_id);
        // return $items[2]['prod_describe'] ;

        //---------------------------
        // Extract and replace img
        //---------------------------
        if(!empty($items[2]['prod_describe'])){
            $note =$items[2]['prod_describe'] ;

            $dom = new \domdocument();
            $dom->loadHtml(mb_convert_encoding($note,'HTML-ENTITIES','UTF-8'));
            // $dom->loadHtml(mb_convert_encoding($note,'HTML-ENTITIES','UTF-8'),LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $images = $dom->getelementsbytagname('img');
            foreach($images as $k => $img){
                $base64file = $img->getattribute('src');
                $fileName   = $img->getattribute('data-filename');
                if ($fileName != ''){
                    $ext = explode('.', $fileName);
                    $ext = end($ext);
                    $fileName = sha1(uniqid(time(), true)).'.'.$ext;
                    $file = $this->fileService->base64Store($base64file, 'upload', 'product/'.$items[2]['prod_id'].'/', $fileName);  //$items[2]['prod_id']=>$productId 
                    $img->removeattribute('src');
                    $img->removeattribute('data-filename');
                    $img->setattribute('src','/upload/product/'.$items[2]['prod_id'].'/'.$fileName);
                }//if
            }//foreach

            $detail = $dom->savehtml($dom);
            // $item['cont']['text'] = $detail;
            $items[2]['prod_describe'] = $detail;
        }
        //---------------------------

        $checkVal = 0;

        DB::beginTransaction();
        foreach ($items as $key => $value) {
            $whereData = [['prod_describe_id','=',$value['prod_describe_id']]];
            $updateLangData = ['prod_describe' => $value['prod_describe']];
            $checkVal += $this->mainRepository->editOne('ProductDescribe', $whereData, $updateLangData);
        }
        if ($checkVal > 0) {
            DB::rollback();
        } else {
            DB::commit();
        }

        if(!empty($request->input('productNum') )){
            $data = $this->mainRepository->getLastAddNotFinishItem($request->input('productNum'));
            $getProductDescribe = $this->mainRepository->getProductDescribe($data['prod_id']);
        }else{
            $getProductDescribe = $this->mainRepository->getProductDescribe($request->input('productId'));
        }

        $data = [
            'status'=> 200,
            'productDescribe'=>$getProductDescribe,
        ];
        return response()->json($data);
    }

    /* 編輯 property */
    public function editProductProperty(Request $request)
    {
        if ($request->input('productId') == 0) {
            $productNum = $request->input('productNum');
            $item = $this->mainRepository->getLastAddNotFinishItem($productNum);
            $productId = $item->prod_id;
        } else {
            $productId = $request->input('productId');
            $item = $this->mainRepository->getOneProduct_sql($productId);
        }
        $langId = $item->lang_id;
        $items = $request->input('item');
        //dd($items);
        // foreach($items as $key => $item){
        //     if(in_array($item['prop_tag_id'],[2,4,6,9,13,15,17,19])){
                
        //         if(trim($item['prod_prop'])==""){
        //             $items[$key]['prod_prop']="#030303";
        //         }
                
        //     }
        //     if(in_array($item['prop_tag_id'],[10,11])){
        //         if(trim($item['prod_prop'])==""){
        //             $items[$key]['prod_prop']="#FFFFFF";
        //         }                
        //     }

        //     if($item['prop_tag_id']==3){
        //         if(trim($item['prod_prop'])==""){
        //             $items[$key]['prod_prop']="中文名";
        //         }                
        //     }

        //     /* if($item['prop_tag_id']==5){
        //         if(trim($item['prod_prop'])==""){
        //             $items[$key]['prod_prop']="介紹文字";
        //         }                
        //     } */

        //     /* if($item['prop_tag_id']==8){
        //         if(trim($item['prod_prop'])==""){
        //             $items[$key]['prod_prop']="職稱";
        //         }                
        //     } */
            
        //     if($item['prop_tag_id']==12){
        //         if(trim($item['prod_prop'])==""){
        //             $items[$key]['prod_prop']="英文名";
        //         }                
        //     }

        //     if($item['prop_tag_id']==14){
        //         if(trim($item['prod_prop'])==""){
        //             $items[$key]['prod_prop']="標題";
        //         }                
        //     }

        // }
        
        DB::beginTransaction();
        foreach ($items as $key => $value) {
            if($value['prop_type']==1){ /*文字*/
                $propertyTagId = $value['prop_tag_id']; 
                if($value['prod_prop'] != '' || !empty($value['prod_prop'])){
                    $property = $value['prod_prop'];
                }else{
                    $property = " ";
                }
                $getValue = $this->mainRepository->editProductProperty($productId, $propertyTagId,  $langId, 'prod_prop', $property);
                if ($getValue == 0) {
                    DB::rollback();
                }
            }else if($value['prop_type']==2){ /*圖片*/
                $img = $value['prod_img_path'];

                if( !empty($img)){                   
                    $fileName = AppHelper::instance()->renameFile($img);
                    $oldItem = $this->mainRepository->getOneProductProperty($productId,$value['prop_tag_id']);
                    if ($img != $oldItem['prod_img_path']) {
                        if(!empty($oldItem['prod_img_path'])){
                            AppHelper::instance()->deleteImg(base_path().$oldItem['prod_img_path']);
                        }
                        if (!File::exists(base_path().$this->publicFilePath.$productId)) {
                            File::makeDirectory(base_path().$this->publicFilePath.$productId, 0775);
                        }
                        if (!File::exists(base_path().$this->publicFilePath.$productId.'/property')) {
                            File::makeDirectory(base_path().$this->publicFilePath.$productId.'/property', 0775);
                        }
                        $ext = explode('.', $fileName);
                        $ext = end($ext);
                        $saveFileName = 'file_'.date("Y-m-d", time()).'_'.substr( sha1(uniqid(time(), true))  ,0 , 10 ).'.'.$ext;
                        AppHelper::instance()->uploadFile($this->publicFilePath.$productId.'/property', $saveFileName, $img);
                        // $value['prod_img_path']=$this->publicFilePath.$productId.'/property/'.$saveFileName;
                        // ----------------------------------------------------------------------------------------------

                        $propertyTagId = $value['prop_tag_id']; 
                        if($value['prod_img_path'] != '' || !empty($value['prod_img_path'])){
                            $property = $this->publicFilePath.$productId.'/property/'.$saveFileName;
                        }else{
                            $property = "";
                        }
                        $getValue = $this->mainRepository->editProductProperty($productId, $propertyTagId, $langId, 'prod_img_path', $property);
                        if ($getValue == 0) {
                            DB::rollback();
                        }
                    }
                }
                // $updateNum +=1;
            }    
        }

        DB::commit();
        $data = [
            'status'=> 200
        ];
        return response()->json($data);
    }

    /*PRODUCT TYPE*/
    public function addProductType(Request $request)
    {
        if ($request->get('productId') == 0) {
            $productNum = $request->input('productNum');
            $item = $this->mainRepository->getLastAddNotFinishItem($productNum);
            $productId = $item->prod_id;
        } else {
            $productId = $request->get('productId');
            $item = $this->mainRepository->getOneProduct_sql($productId);
        }

        $langId = $item->lang_id;
        $addItem = $request->get('item');
        $addItem['prod_id'] = $productId;
        $addItem['lang_id'] = $langId;
        $this->mainRepository->addProductType($addItem);
        $getProductType= $this->mainRepository->getProductType($productId);
        $data = [
            'status'=> 200,
            'productType' => $getProductType
        ];

        return response()->json($data);
    }
    public function editProductType(Request $request)
    {
        if ($request->input('productId') == 0) {
            $productNum = $request->input('productNum');
            $item = $this->mainRepository->getLastAddNotFinishItem($productNum);
            $productId = $item->prod_id;
        } else {
            $productId = $request->input('productId');
        }

        $editItem = $request->input('item');
        $getId = $editItem['prod_type_id'];
        unset($editItem['prod_type_id']);

        DB::beginTransaction();

        $checkVal = $this->mainRepository->editOne('ProductType', $whereData = [['prod_type_id','=',$getId]], $editItem);
        if ($checkVal > 0) {
            DB::rollback();
        } else {
            DB::commit();
        }

        $getProductType= $this->mainRepository->getProductType($productId);
        $data = [
            'status'=> 200,
            'productType' => $getProductType
        ];

        return response()->json($data);
    }
    public function deleteProductType(Request $request)
    {
        if ($request->input('productId') == 0) {
            $productNum = $request->input('productNum');
            $item = $this->mainRepository->getLastAddNotFinishItem($productNum);
            $productId = $item->prod_id;
        } else {
            $productId = $request->input('productId');
        }

        DB::beginTransaction();

        $checkVal = $this->mainRepository->deleteOne('ProductType',  [['prod_type_id','=', $request->get('id')]]);
        if ($checkVal > 0) {
            DB::rollback();
        } else {
            DB::commit();
        }

        $getProductType= $this->mainRepository->getProductType($productId);
        $data = [
            'status'=> 200,
            'productType' => $getProductType
        ];

        return response()->json($data);
    }

    /*PRODUCT SPEC*/
    public function addProductSpec(Request $request)
    {
        if ($request->get('productId') == 0) {
            $productNum = $request->input('productNum');
            $item = $this->mainRepository->getLastAddNotFinishItem($productNum);
            $productId = $item->prod_id;
        } else {
            $productId = $request->get('productId');
            $item = $this->mainRepository->getOneProduct_sql($productId);
        }
        $langId = $item->lang_id;
        $addItem = $request->get('item');
        $addItem['prod_id'] = $productId;
        $addItem['lang_id'] = $langId;
        $this->mainRepository->addProductSpec($addItem);
        $getProductSpec= $this->mainRepository->getProductSpec($productId);
        $data = [
            'status'=> 200,
            'productSpec' => $getProductSpec
        ];
        return response()->json($data);
    }
    public function editProductSpec(Request $request)
    {
        if ($request->input('productId') == 0) {
            $productNum = $request->input('productNum');
            $item = $this->mainRepository->getLastAddNotFinishItem($productNum);
            $productId = $item->prod_id;
        } else {
            $productId = $request->input('productId');
        }

        $editItem = $request->input('item');
        $getId = $editItem['prod_spec_id'];
        unset($editItem['prod_spec_id']);

        DB::beginTransaction();

        $checkVal = $this->mainRepository->editOne('ProdSpecification', [['prod_spec_id','=',$getId]], $editItem);
        if ($checkVal > 0) {
            DB::rollback();
        } else {
            DB::commit();
        }

        $getProductSpec= $this->mainRepository->getProductSpec($productId);
        $data = [
            'status'=> 200,
            'productSpec' => $getProductSpec
        ];

        return response()->json($data);
    }
    public function deleteProductSpec(Request $request)
    {
        if ($request->input('productId') == 0) {
            $productNum = $request->input('productNum');
            $item = $this->mainRepository->getLastAddNotFinishItem($productNum);
            $productId = $item->prod_id;
        } else {
            $productId = $request->input('productId');
        }

        DB::beginTransaction();

        $checkVal = $this->mainRepository->deleteOne('ProdSpecification',  [['prod_spec_id','=',$request->input('id')]]);

        if ($checkVal > 0) {
            DB::rollback();
        } else {
            DB::commit();
        }
        $getProductSpec= $this->mainRepository->getProductSpec($productId);

        $data = [
            'status'=> 200,
            'productSpec' => $getProductSpec
        ];

        return response()->json($data);
    }

    /*PRODUCT IMG*/
    public function addProductImg(Request $request)
    {
        if ($request->input('productId') == 0) {
            $productNum = $request->input('productNum');
            $item = $this->mainRepository->getLastAddNotFinishItem($productNum);
            $productId = $item->prod_id;
        } else {
            $productId = $request->input('productId');
            $item = $this->mainRepository->getOneProduct_sql($productId);
        }

        $langId = $item->lang_id;
        if (!empty($request->get('item'))) {
            DB::beginTransaction();
            $img = $request->get('item');
            $fileName = AppHelper::instance()->renameFile($img);
            $imgAddData['prod_id'] = $productId;
            $imgAddData['prod_img_name'] = $fileName;
            $imgAddData['prod_name'] = $request->input('imgName');
            $imgAddData['prod_order'] = $request->input('imgOrder');
            $imgAddData['prod_img_type'] = 'secondary';
            $imgAddData['lang_id'] = $langId;
            $this->mainRepository->addProductImg($imgAddData);
            $getInsertId = $productId;
            if ($getInsertId != 0) {
                if (!File::exists(base_path().$this->publicFilePath.$getInsertId)) {
                    File::makeDirectory(base_path().$this->publicFilePath.$getInsertId, 0775);
                }
                AppHelper::instance()->uploadFile($this->publicFilePath.$getInsertId, $fileName, $img);
                DB::commit();
            } else {
                DB::rollback();
            }
        }

        $getProductImg= $this->mainRepository->getProductImg($productId, 'secondary');
        $data = [
            'status'=> 200,
            'productImg'=>$getProductImg
        ];

        return response()->json($data);
    }
    public function modifyProductImg(Request $request, $productId)
    {
        $prod_img_id =  $request->input('prod_img_id');
        $whereData = [['prod_id','=',$productId],['prod_img_id','=', $prod_img_id ]];
        $imgAddData['prod_name'] = $request->input('fileName');
        $imgAddData['img_desc'] = $request->input('imgDesc');
        $imgAddData['prod_order'] = $request->input('fileOrder');

        DB::beginTransaction();

        if (!empty($request->get('prod_img_name'))) {
            $img = $request->get('prod_img_name');
            if(mb_substr($img, 0, 4)=="data"){
                $fileName = AppHelper::instance()->renameFile($img);
                $imgAddData['prod_img_name'] = $fileName;
                if ($productId != 0) {
                    $current_img= $this->mainRepository->getProductImg($productId, 'secondary', $prod_img_id);
                    $current_img = $current_img ? $current_img[0] : [];
                    AppHelper::instance()->deleteImg(base_path()."/public/upload/product/".$productId."/".$current_img['prod_img_name']);

                    if (!File::exists(base_path().$this->publicFilePath.$productId)) {
                        File::makeDirectory(base_path().$this->publicFilePath.$productId, 0775);
                    }
                    AppHelper::instance()->uploadFile($this->publicFilePath.$productId, $fileName, $img);
                }
            }else if($img=="delete"){
                $imgAddData['prod_img_name'] = "";
                $current_img= $this->mainRepository->getProductImg($productId, 'secondary', $prod_img_id);
                $current_img = $current_img ? $current_img[0] : [];
                AppHelper::instance()->deleteImg(base_path()."/public/upload/product/".$productId."/".$current_img['prod_img_name']);
            }
        }
        if (!empty($request->get('prod_img_name2'))) {
            $img = $request->get('prod_img_name2');
            if(mb_substr($img, 0, 4)=="data"){
                $fileName = AppHelper::instance()->renameFile($img);
                $imgAddData['prod_img_name2'] = $fileName;
                if ($productId != 0) {
                    $current_img= $this->mainRepository->getProductImg($productId, 'secondary', $prod_img_id);
                    $current_img = $current_img ? $current_img[0] : [];
                    AppHelper::instance()->deleteImg(base_path()."/public/upload/product/".$productId."/".$current_img['prod_img_name2']);

                    if (!File::exists(base_path().$this->publicFilePath.$productId)) {
                        File::makeDirectory(base_path().$this->publicFilePath.$productId, 0775);
                    }
                    AppHelper::instance()->uploadFile($this->publicFilePath.$productId, $fileName, $img);
                }
            }else if($img=="delete"){
                $imgAddData['prod_img_name2'] = "";
                $current_img= $this->mainRepository->getProductImg($productId, 'secondary', $prod_img_id);
                $current_img = $current_img ? $current_img[0] : [];
                AppHelper::instance()->deleteImg(base_path()."/public/upload/product/".$productId."/".$current_img['prod_img_name2']);
            }
        }
        if (!empty($request->get('prod_img_name3'))) {
            $img = $request->get('prod_img_name3');
            if(mb_substr($img, 0, 4)=="data"){
                $fileName = AppHelper::instance()->renameFile($img);
                $imgAddData['prod_img_name3'] = $fileName;
                if ($productId != 0) {
                    $current_img= $this->mainRepository->getProductImg($productId, 'secondary', $prod_img_id);
                    $current_img = $current_img ? $current_img[0] : [];
                    AppHelper::instance()->deleteImg(base_path()."/public/upload/product/".$productId."/".$current_img['prod_img_name3']);

                    if (!File::exists(base_path().$this->publicFilePath.$productId)) {
                        File::makeDirectory(base_path().$this->publicFilePath.$productId, 0775);
                    }
                    AppHelper::instance()->uploadFile($this->publicFilePath.$productId, $fileName, $img);
                }
            }else if($img=="delete"){
                $imgAddData['prod_img_name3'] = "";
                $current_img= $this->mainRepository->getProductImg($productId, 'secondary', $prod_img_id);
                $current_img = $current_img ? $current_img[0] : [];
                AppHelper::instance()->deleteImg(base_path()."/public/upload/product/".$productId."/".$current_img['prod_img_name3']);
            }
        }

        // 插入排序功能
        $current_img= $this->mainRepository->getProductImg($productId, 'secondary', $prod_img_id);
        $SortOrderRepository = new SortOrderRepository();
        $retData = $SortOrderRepository->productImgSort($current_img[0], $new_order=$imgAddData['prod_order']);
        /*儲存編輯*/
        $res = $this->mainRepository->editProductImg($whereData ,$imgAddData);
        if ($res == 0) {
            DB::commit();
            $data = [
                'status'=> 200,
            ];
        } else {
            DB::rollback();
        }

        $getProductImg= $this->mainRepository->getProductImg($productId, 'secondary');

        $data['getProductImg']=$getProductImg;

        return response()->json($data);
    }
    public function deleteProductImg(Request $request)
    {
        $delItem = $request->get('item');

        if ($request->input('productId') == 0) {
            $delProdId = $delItem['prod_id'];
        } else {
            $delProdId = $request->input('productId');
        }

        $delName = $delItem['prod_img_name'];

        DB::beginTransaction();

        $checkVal = $this->mainRepository->deleteOne('ProductImg', [['prod_img_id','=',$delItem['prod_img_id']]]);

        if ($checkVal > 0) {
            DB::rollback();
        } else {
            DB::commit();
        }

        AppHelper::instance()->deleteImg(base_path()."/public/".$delName);
        $getProductImg= $this->mainRepository->getProductImg($delProdId, 'secondary');

        $data = [
            'status'=> 200,
            'productImg' => $getProductImg
        ];

        return response()->json($data);
    }

    /*PRODUCT FIEL*/
    public function addProductFile(Request $request, $productId)
    {
        $img = $request->file('uploadedFile');
        $file_size = $img->getSize(); 
        $file_size = $this->formatBytes($file_size);
        $saveFileName =$img->getClientOriginalName();
        $ext = explode('.', $saveFileName);
        $ext = end($ext);
        $saveFileName = 'file_'.date("Y-m-d", time()).'_'.substr( sha1(uniqid(time(), true))  ,0 , 10 ).'.'.$ext;
        if ($productId == 0) {
            $productNum = $request->input('productNum');
            $item = $this->mainRepository->getLastAddNotFinishItem($productNum);
            $productId = $item->prod_id;

        } else {
            $item = $this->mainRepository->getOneProduct_sql($productId);
        }

        $langId = $item->lang_id;
        DB::beginTransaction();
        $imgAddData['prod_id'] = $productId;
        $imgAddData['prod_name'] = $request->input('fileName');
        $imgAddData['prod_order'] = $request->input('fileOrder');
        $imgAddData['prod_file_size'] = $file_size;
        $imgAddData['prod_img_name'] = $saveFileName;
        $imgAddData['prod_img_type'] = 'attach';
        $imgAddData['lang_id'] = $langId;

        $this->mainRepository->addProductImg($imgAddData);
        if (!File::exists(base_path() . $this->publicFilePath . $productId)) {
            File::makeDirectory(base_path() . $this->publicFilePath . $productId, 0775);
        }

        $directory = '/upload/product/' . $productId . '/';
        $img->move(public_path() . $directory, $saveFileName);

        DB::commit();

        $getProductFile= $this->mainRepository->getProductImg($productId, 'attach');
        $data = [
            'status'=> 200,
            'productFile'=>$getProductFile
        ];

        return response()->json($data);
    }
    public function modifyProductFile(Request $request, $productId)
    {
        $prod_img_id =  $request->input('prod_img_id');
        $whereData = [['prod_id','=',$productId],['prod_img_id','=', $prod_img_id ]];
        $imgAddData['prod_name'] = $request->input('fileName');
        $imgAddData['prod_order'] = $request->input('fileOrder');

        DB::beginTransaction();

        $res = $this->mainRepository->editProductImg($whereData ,$imgAddData);
        if ($res == 0) {
            DB::commit();

            $data = [
                'status'=> 200,
            ];
        } else {
            DB::rollback();
        }
        $getProductFile= $this->mainRepository->getProductImg($productId, 'attach');
        $data['productFile']=$getProductFile;

        return response()->json($data);
    }
    public function deleteProductFile(Request $request)
    {
        $delItem = $request->input('item');
        if ($request->input('productId') == 0) {
            $delProdId = $delItem['prod_id'];
        } else {
            $delProdId = $request->input('productId');
        }

        $delName = $delItem['prod_img_name'];
        $delPath= $delItem['prod_img_path'];

        DB::beginTransaction();

        $checkVal = $this->mainRepository->deleteOne('ProductImg', [['prod_img_id','=',$delItem['prod_img_id']]]);
        if ($checkVal > 0) {
            DB::rollback();
        } else {
            DB::commit();
        }

        AppHelper::instance()->deleteImg(base_path()."/public/".$delPath);
        $getProductFile= $this->mainRepository->getProductImg($delProdId, 'attach');
        $data = [
            'status'=> 200,
            'productFile' => $getProductFile
        ];

        return response()->json($data);
    }
    public static function formatBytes($size, $precision = 2)
    {
        if ($size > 0) {
            $size = (int) $size;
            $base = log($size) / log(1024);
            $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');
            return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
        } else {
            return $size;
        }
    }

    // seo start
    public function getSeoProperty(Request $request)
    {
        $productId = $request->get('productId');
        $item = $this->mainRepository->getOneProduct_sql($productId);
        $num = $item['product_num'];
        $langId = $item['lang_id'];
        $getSeoProperty = $this->mainRepository->getSeoPropertyTagNumByProdId($langId,$num ,$productId);
        $data = [
            'status'=> 200,
            'getSeoProperty' => $getSeoProperty 
        ];
        return $data ;
    }
    public function editProductSeoProperty(Request $request)
    {
        if ($request->input('productId') == 0) {
            $productNum = $request->input('productNum');
            $item = $this->mainRepository->getLastAddNotFinishItem($productNum);
            $productId = $item->prod_id;
        } else {
            $productId = $request->input('productId');
            $item = $this->mainRepository->getOneProduct_sql($productId);
        }
        $langId = $item->lang_id;
        $items = $request->input('item');
        // return $items;

        DB::beginTransaction();
        $updateNum = 0 ;
        foreach ($items as $key => $value) {
            if($value['seo_type']==1){
                if( !empty($value['prod_prop']) || $value['prod_prop']!= null ){
                    $getValue = $this->mainRepository->editProductSeoProperty($productId, $value, $langId);
                    $updateNum +=1;
                }else{
                    $getValue = $this->mainRepository->deleteProductSeoProperty($productId, $value, $langId);
                    $updateNum +=1;
                }
            }else if($value['seo_type']==2){
                $img = $value['prod_img_path'];
                if( !empty($img)){
                    $fileName = AppHelper::instance()->renameFile($img);
                    $oldItem = $this->mainRepository->getSeoPropertyImgName($value['prod_type_id']);
                    if ($img != $oldItem['prod_img_path']) {
                        if(!empty($oldItem['prod_img_path'])){
                            AppHelper::instance()->deleteImg(base_path().$oldItem['prod_img_path']);
                        }
                        if (!File::exists(base_path().$this->publicFilePath.$productId.'/seo')) {
                            File::makeDirectory(base_path().$this->publicFilePath.$productId.'/seo', 0775);
                        }
                        $ext = explode('.', $fileName);
                        $ext = end($ext);
                        $saveFileName = 'file_'.date("Y-m-d", time()).'_'.substr( sha1(uniqid(time(), true))  ,0 , 10 ).'.'.$ext;
                        AppHelper::instance()->uploadFile($this->publicFilePath.$productId.'/seo', $saveFileName, $img);
                        $value['prod_img_path']=$this->publicFilePath.$productId.'/seo/'.$saveFileName;
                    }
                    $getValue = $this->mainRepository->editProductSeoProperty($productId, $value, $langId);
                }
                $updateNum +=1;
            }         
        }
        if(count($items) == $updateNum ){
            DB::commit();
        }else{
            DB::rollback();
        }
        $data = [
            'status'=> 200
        ];
        return response()->json($data);
    }

    // label start
    public function showLabel(Request $request)
    {
        if ($request->input('productId') == 0) {
            $productNum = $request->input('productNum');
            $item = $this->mainRepository->getLastAddNotFinishItem($productNum);
            $productId = $item->prod_id;
        }else {
            $productId = $request->get('productId');
            $item = $this->mainRepository->getOneProduct_sql($productId);
            $productNum = $item['product_num'];
        }

        $langId = $item['lang_id'];
        $proLabelTagArr = $this->productLabelTagRepository->show($langId,$productNum,$productId);
        foreach ($proLabelTagArr as $key => $value) {
            if($value['has_label'] != null ){
                $proLabelTagArr[$key]['has_label'] =true;
            }else{
                $proLabelTagArr[$key]['has_label'] =false;
            }
        }

        $data = [
            'status'=> 200,
            'getLabelTag' => $proLabelTagArr,
            'productId' => $productId ,
        ];
        return $data ;
    }
    public function editLabel(Request $request)
    {
        $productId = $request->get('productId');
        $items = $request->get('item');
        $res = $this->productLabelTagRepository->edit($productId ,$items);
        $data = [
            'status'=> 200,
        ];

        return $data ;
    }

    // tabs start
    public function showTabs(Request $request)
    {     
        if ($request->input('productId') == 0) {
            $productNum = $request->input('productNum');
            $item = $this->mainRepository->getLastAddNotFinishItem($productNum);
            $productId = $item->prod_id;
        }else {
            $productId = $request->get('productId');
            $item = $this->mainRepository->getOneProduct_sql($productId);
            $productNum = $item['product_num'];
        }
        $langId = $item['lang_id'];
        $proTabsTagArr = $this->productTabsTagRepository->show($langId,$productNum,$productId);

        $data = [
            'status'=> 200,
            'getTabsTag' => $proTabsTagArr,
            'productId' => $productId,
            'langId' => $langId,
        ];
        return $data ;
    }
    public function editTabs(Request $request)
    {
        $productId = $request->get('productId');
        $items = $request->get('item');
        $langId = $request->get('lang');

        //---------------------------------------------------------------------------------------------
        $prod_type_id = $items['prod_type_id'];
        $saveItems =[
            'prod_id'      => $productId,
            'prod_prop'    => $items['prod_prop'],
            'prop_tag_id'  => $items['prop_tag_id'],
            'lang_id'      => $langId,
            'created_at'   =>date('Y-m-d H:i:s'),
        ];

        //---------------------------------------------------------------------------------------------
        // Extract and replace img
        //---------------------------------------------------------------------------------------------
        if(!empty($saveItems['prod_prop'])){  
            $note =$saveItems['prod_prop'] ;
            $filePath = 'product/'.$productId.'/';  // FILE->/upload/->
            $saveItems['prod_prop'] = $this->noteEdit($note,$filePath);
        }
        //---------------------------------------------------------------------------------------------

        $res = $this->productTabsTagRepository->edit($prod_type_id ,$saveItems);
        $item = $this->mainRepository->getOneProduct_sql($productId);
        $productNum = $item['product_num'];
        $proTabsTagArr = $this->productTabsTagRepository->show($langId,$productNum,$productId);
        $data = [
            'status'=> 200,
            'getTabsTag' => $proTabsTagArr,
            'productId' => $productId,
            'langId' => $langId,
        ];

        return $data;
    }
    public function noteEdit($note,$filePath){
        $dom = new \domdocument();
        $dom->loadHtml(mb_convert_encoding($note,'HTML-ENTITIES','UTF-8'));

        // $dom->loadHtml(mb_convert_encoding($note,'HTML-ENTITIES','UTF-8'),LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getelementsbytagname('img');
        foreach($images as $k => $img){
            $base64file = $img->getattribute('src');
            $fileName   = $img->getattribute('data-filename');
            if ($fileName != ''){
                $ext = explode('.', $fileName);
                $ext = end($ext);
                $fileName = sha1(uniqid(time(), true)).'.'.$ext;
                $file = $this->fileService->base64Store($base64file, 'upload', $filePath, $fileName); 
                $img->removeattribute('src');
                $img->removeattribute('data-filename');
                $img->setattribute('src','/upload/'.$filePath.$fileName);
            }//if
        }//foreach
        $detail = $dom->savehtml($dom);
        return $detail;
    }


    /*------------------------------------------------------------------*/
    /*購物相關功能(暫無使用)----------------------------------------------*/
    public function getCart(Request $request,$langType){
        $products = $request->get('product');
        $fare = $request->get('fare');
        $newItem = [];
        $i = 0;
        $total = 0;
        foreach ($products as $key => $value) {
            $prodType = $this->productTypeRepository->show($value['prodTypeId']);
            $product = $this->mainRepository->getOneProduct_sql($prodType->prod_id);
            $getQty = $value['qty'];
            $getProductTypeId = $value['prodTypeId'];
            $getProductType = $this->mainRepository->getProductTypeFromCart($getProductTypeId );
            $newItem[$i]['prodName']        = $getProductType['prod_name'];
            $newItem[$i]['prodTypeId']      = $getProductType['prod_type_id'];
            $newItem[$i]['prodType']        = $getProductType['prod_type'];
            $newItem[$i]['qty']             = $value['qty'];
            $newItem[$i]['typePrice']       = $prodType['type_price'];
            $newItem[$i]['typeSalesPrice']  = $prodType['type_sales_price'];
            $newItem[$i]['prodSn']          = $prodType['prod_sn'];
            $newItem[$i]['prodImg']         = $product->prod_img;
            $newItem[$i]['prodId']          = $product->prod_id;
            $getTypeSalesPrice = $getProductType['type_sales_price'];
            $total += $getQty*$getTypeSalesPrice;
            $i++;
        }

        $getFare = $this->mainRepository->getFare($fare['fareId']);
        $newFare['fairId'] = $getFare['fare_id'];
        $newFare['fairName'] = $getFare['fare_name'];
        $newFare['fairCost'] = $getFare['fare_cost'];

        $freeFareData = $this->miscellaneousRepository->getFreeFare($langType);
        $freeFare = $freeFareData->misc_value;

        if ($total < $freeFare){
            $total += $getFare['fare_cost'];
        }

        $data = [
            'status'=> 200,
            'product'=>$newItem,
            'total'=>$total,
            'fare'=>$newFare,
            'freeFare' => $freeFare
        ];

        return $data;
    }

    public function showProductByTypeId($prodTypeId){
        $product    = $this->productTypeRepository->showProduct($prodTypeId);
        $prodType   = $this->productTypeRepository->show($prodTypeId);
        $res = [
            'product' => $product,
            'prodType' => $prodType,
        ];
        return $res;
    }

    public function setLayout(Request $request){

        $prod_id=$request->post('prod_id');
        $style=$request->post('style');
        
        $this->mainRepository->setStylelayout($prod_id,$style);
        
        $data = [
            'status'=> 200
        ];

        return $data;
    }

    public function setOwner(Request $request){

        $prod_id=$request->post('prod_id');
        $owner=$request->post('owner');
        
        $this->mainRepository->setOwner($prod_id,$owner);
        
        $data = [
            'status'=> 200
        ];
        return $data;
    }
}