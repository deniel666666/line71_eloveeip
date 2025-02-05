<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;
use App\Models\ProductModel;
use App\Repositories\SortOrderRepository;
use App\Repositories\CategoryProOrderRepository;

use \DB;
use App\Http\Controllers\Api\ProductApiController;

use App\Repositories\AccountRepository;
use App\Services\AccountService;
class ProductController extends Controller
{

    protected $mainRepository;
    public function __construct(
        ProductRepository $mainRepository,
        CategoryProOrderRepository $categoryProOrderRepository,
        ProductApiController    $ProductApiController,
        AccountRepository $accountRepository,
        AccountService $accountService,
    ){
        $this->mainRepository               = $mainRepository;
        $this->categoryProOrderRepository   = $categoryProOrderRepository;
        $this->ProductApiController         = $ProductApiController;
        $this->accountRepository = $accountRepository;
        $this->accountService = $accountService;
    }

    public function index (Request $request, $productNum) {
        $routeNum = $request->route( 'productNum');
        $productActive = 'productActive'.$routeNum;
        $viewData[$productActive]   = "active";
        $viewData['productNum']      = $routeNum;
        $prodCollapse               = 'prodCollapse'.$routeNum;
        $viewData[$prodCollapse]    = "show";

        if($productNum == 1){
            $viewData['topTitle']              = '關於我們';
            $viewData['pageTitle']             = '介紹列表';
            return view("admin.product.about_us.product",$viewData);
        }
        else if($productNum == 2){
            $viewData['topTitle']              = '最新消息';
            $viewData['pageTitle']             = '列表';
            return view("admin.product.news.product",$viewData);
        }
        else if($productNum == 3){
            $viewData['topTitle']              = '跑馬燈';
            $viewData['pageTitle']             = '列表';
            return view("admin.product.news.product",$viewData);
        }
        else if($productNum == 4){
            $viewData['topTitle']              = '課程介紹';
            $viewData['pageTitle']             = '列表';
            return view("admin.product.course.product",$viewData);
        }
        else if($productNum == 5){
            $viewData['topTitle']              = '場地介紹';
            $viewData['pageTitle']             = '列表';
            return view("admin.product.course.product",$viewData);
        }
        // else if($productNum == 6){
        //     $viewData['topTitle']              = '相關連結';
        //     $viewData['pageTitle']             = '連結列表';
        //     return view("admin.product.link.product",$viewData);
        // }
        else if($productNum == 7){
            $viewData['onlineCollapse']    = "show";
            $viewData['topTitle']              = '網路活動';
            $viewData['pageTitle']             = '行銷活動列表';
            //return view("admin.product.online.product",$viewData);
            return view("admin.product.online_act.product",$viewData);
        }
        else if($productNum == 8){
            $viewData['line_cardCollapse']    = "show";
            $viewData['topTitle']              = 'LINE電子名片';
            $viewData['pageTitle']             = '名片管理';
            if(!env('LIFF_ID_SELECT_SHARE_TARGET')){ abort(404, '請先設定.env LIFF_ID_SELECT_SHARE_TARGET 參數'); }
            $viewData['LIFF_ID_SELECT_SHARE_TARGET'] = env('LIFF_ID_SELECT_SHARE_TARGET');
            return view("admin.product.line_card.product",$viewData);
        }
        else if($productNum == 9){
            $viewData['topTitle']              = 'FAQ';
            $viewData['pageTitle']             = 'FAQ列表';
            $viewData['FAQCollapse'] 	       = "show";
            return view("admin.product.faqlist.product", $viewData);

        }
        else if($productNum == 10){
            $viewData['topTitle']              = '成功案例';
            $viewData['pageTitle']             = '案例列表';
            $viewData['Caseollapse'] 	     =     "show";
            return view("admin.product.case.product", $viewData);
        }

        $viewData['topTitle']       = '商品'.$productNum.'管理';
        $viewData['pageTitle']      = '商品'.$productNum;
        // return view("admin.product.product",$viewData);

    }

    public function add (Request $request, $productNum) {
        $routeNum = $request->route( 'productNum');
        $productActive = 'productActive'.$routeNum;
        $viewData[$productActive]   = "active";
        $prodCollapse               = 'prodCollapse'.$routeNum;
        $viewData[$prodCollapse]    = "show";

        $user = $this->accountService->getUserInfo();
        $viewData['role'] = $user['role'][0];
        $viewData['user_id'] = $user['id'];
        $viewData['member_list']=$this->accountRepository->getMemberAccount($user);        
        
        
        /* 取得建立未完成的商品 */
        // if($productNum == 8){ abort(404, "無法新增");return; }

        $item = $this->mainRepository->getLastAddNotFinishItem($productNum);
        if($item == null){
            /*若無*/
            /*取得最新建立的商品*/
            $proIdByMemory = $this->mainRepository->getLastAddFinishItemHasMemory($productNum);
            /*取得商品階層*/
            $tagArr =  $this->mainRepository->getCategoryTagsByProduct($proIdByMemory);
            $tags = [];
            foreach ($tagArr  as $k => $v) {
                array_push($tags , $v['cate_tag_id'] );
            }
            /*自動建立商品*/
            $item = $this->ProductApiController->addPro($tags ,$routeNum ,1); 
        }
        $viewData['productId'] = $item['prod_id'];

        if($productNum == 1){
            $viewData['topTitle']              = '關於我們';
            $viewData['pageTitle']             = '介紹列表';
            return view("admin.product.about_us.productMainCreate",$viewData);
        }
        else if($productNum == 2){
            $viewData['topTitle']              = '最新消息';
            $viewData['pageTitle']             = '列表';
            return view("admin.product.news.productMainCreate",$viewData);
        }
        else if($productNum == 3){
            $viewData['topTitle']              = '跑馬燈';
            $viewData['pageTitle']             = '列表';
            return view("admin.product.news.productMainCreate",$viewData);
        }
        else if($productNum == 4){ 
            $viewData['topTitle']              = '課程介紹';
            $viewData['pageTitle']             = '列表';
            return view("admin.product.course.productMainCreate",$viewData);
        }
        else if($productNum == 5){
            $viewData['topTitle']              = '場地介紹';
            $viewData['pageTitle']             = '列表';
            return view("admin.product.course.productMainCreate",$viewData);
        }
        // else if($productNum == 6){
        //     $viewData['topTitle']              = '相關連結';
        //     $viewData['pageTitle']             = '連結列表';
        //     return view("admin.product.link.productMainCreate",$viewData);
        // }
        else if($productNum == 7){
            $viewData['onlineCollapse']    = "show";
            $viewData['topTitle']              = '網路活動';
            $viewData['pageTitle']             = '行銷活動列表';
            return view("admin.product.online_act.productMainCreate",$viewData);
        }
        else if($productNum == 8){
            $viewData['line_cardCollapse']    = "show";
            $viewData['topTitle']              = 'LINE電子名片';
            $viewData['pageTitle']             = '名片管理';
            if(!env('LIFF_ID_SELECT_SHARE_TARGET')){ abort(404, '請先設定.env LIFF_ID_SELECT_SHARE_TARGET 參數'); }
            $viewData['LIFF_ID_SELECT_SHARE_TARGET'] = env('LIFF_ID_SELECT_SHARE_TARGET');
            return view("admin.product.line_card.productMainCreate",$viewData);
        }
        else if($productNum == 9){
            $viewData['topTitle']              = 'FAQ';
            $viewData['pageTitle']             = 'FAQ列表';
            $viewData['FAQCollapse'] 	       = "show";
            return view("admin.product.faqlist.productMainCreate", $viewData);
        }
        else if($productNum == 10){ 
            $viewData['topTitle']              = '成功案例';
            $viewData['pageTitle']             = '案例列表';
            $viewData['Caseollapse'] 	     =     "show";
            return view("admin.product.case.productMainCreate", $viewData);
        }

        $viewData['topTitle']            = '商品'.$productNum.'管理';
        $viewData['pageTitle']           = '商品'.$productNum;
        // return view("admin.product.productMainCreate", $viewData);
    }

    public function editDetail (Request $request, $productNum, $productId) {
        $routeNum = $request->route( 'productNum');
        $productActive = 'productActive'.$routeNum;
        $viewData[$productActive]   = "active";
        $prodCollapse = 'prodCollapse'.$routeNum;
        $viewData[$prodCollapse]    = "show";

        $user = $this->accountService->getUserInfo();
        $viewData['role'] = $user['role'][0];
        $viewData['user_id'] = $user['id'];
        $viewData['member_list']=$this->accountRepository->getMemberAccount($user);
        
        $viewData['productId'] = $productId;

        if($productNum == 1){
            $viewData['topTitle']              = '關於我們';
            $viewData['pageTitle']             = '介紹列表';
            return view("admin.product.about_us.productDetailUpdate",$viewData);
        }
        else if($productNum == 2){
            $viewData['topTitle']              = '最新消息';
            $viewData['pageTitle']             = '列表';
            return view("admin.product.news.productDetailUpdate",$viewData);
        }
        else if($productNum == 3){
            $viewData['topTitle']              = '跑馬燈';
            $viewData['pageTitle']             = '列表';
            return view("admin.product.news.productDetailUpdate",$viewData);
        }
        else if($productNum == 4){
            $viewData['topTitle']              = '課程介紹';
            $viewData['pageTitle']             = '列表';
            return view("admin.product.course.productDetailUpdate",$viewData);
        }
        else if($productNum == 5){
            $viewData['topTitle']              = '場地介紹';
            $viewData['pageTitle']             = '列表';
            return view("admin.product.course.productDetailUpdate",$viewData);
        }
        // else if($productNum == 6){
        //     $viewData['topTitle']              = '相關連結';
        //     $viewData['pageTitle']             = '連結列表';
        //     return view("admin.product.link.productDetailUpdate",$viewData);
        // }
        else if($productNum == 7){
            $viewData['onlineCollapse']    = "show";
            $viewData['topTitle']              = '網路活動';
            $viewData['pageTitle']             = '行銷活動列表';
            return view("admin.product.online_act.productDetailUpdate",$viewData);
        }
        else if($productNum == 8){
            $viewData['line_cardCollapse']    = "show";
            $viewData['topTitle']              = 'LINE電子名片';
            $viewData['pageTitle']             = '名片管理';
            if(!env('LIFF_ID_SELECT_SHARE_TARGET')){ abort(404, '請先設定.env LIFF_ID_SELECT_SHARE_TARGET 參數'); }
            $viewData['LIFF_ID_SELECT_SHARE_TARGET'] = env('LIFF_ID_SELECT_SHARE_TARGET');
            return view("admin.product.line_card.productDetailUpdate",$viewData);
        }
        else if($productNum == 9){
            $viewData['topTitle']              = 'FAQ';
            $viewData['pageTitle']             = 'FAQ列表';
            $viewData['FAQCollapse'] 	       = "show";
            return view("admin.product.faqlist.productDetailUpdate", $viewData);
        }
        else if($productNum == 10){
            $viewData['topTitle']              = '成功案例';
            $viewData['pageTitle']             = '案例列表';
            $viewData['Caseollapse'] 	     =     "show";
            return view("admin.product.case.productDetailUpdate", $viewData);
        }

        $viewData['topTitle']       = '商品'.$productNum.'管理';
        $viewData['pageTitle']      = '商品'.$productNum;
        // return view("admin.product.productDetailUpdate",$viewData);
    }
}

