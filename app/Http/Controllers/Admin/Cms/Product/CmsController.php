<?php

namespace App\Http\Controllers\Admin\Cms\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;
use App\Http\Controllers\Api\Cms\Product\CmsApiController;

use DB;

class CmsController extends Controller
{
  protected $use_end			= "admin";
  protected $content_table	= "product_cms";
  protected $extends_layouts	= "layouts.masterAdmin";
  private $cmsTypeRepository;
  private $cmsApiController;

  public function __construct(
                  ProductRepository $cmsTypeRepository,
                  CmsApiController  $cmsApiController
                )
  {
    $this->cmsTypeRepository = $cmsTypeRepository;
    $this->cmsApiController  = $cmsApiController;
  }

    public function index (Request $request, $cmsTypeId) {
      $viewData['use_end'] 		= $this->use_end;
    $viewData['content_table'] 	= $this->content_table;
    $viewData['extends_layouts']= $this->extends_layouts;
      $viewData['topTitle'] 		= "商品管理";

    $cmsType = $this->cmsTypeRepository->get(['primary_key'=>$cmsTypeId])->toArray();
    if(!$cmsType){ return; }
    $cmsType = $cmsType[0];

    $viewData['pageTitle']			= $cmsType['prod_name'];
    $viewData['cms_type_id']		= $cmsType['prod_id'];
    $viewData['lang_id']			= $cmsType['lang_id'];
    $viewData['child_template_id']	= $cmsType['child_template_id'];

    /*處理編輯顯示畫面*/
    // $edit_view = "product_cms";				/*預設編輯模板*/
    $edit_view = "product_cms_haslayout";	/*預設顯示模板(有子母模板)*/
    $view_view = "cmsViewTemplate";			/*預設顯示模板(非挖空式)*/
    $current_child_template = (array)DB::table($this->content_table.'_layout_relation')
              ->where('cms_type_id','=',$cmsType['prod_id'])
              ->where('child_template_id','=',$cmsType['child_template_id'])
              ->get()->first();
    if($current_child_template){
      if($current_child_template['edit_view']){
        $edit_view = $current_child_template['edit_view'];
      }
      if($current_child_template['view_view']){
        $view_view = $current_child_template['view_view'];
      }
    }
    $blade_path = "admin.cms.".$edit_view;
    $viewData['edit_view'] = $edit_view;
    $viewData['view_view'] = $view_view;

    $viewData['productActive'.$cmsType['product_num']]	= 'active';
    $viewData['prodCollapse'.$cmsType['product_num']] 	= "show";
    $viewData['editPageUrl'] = '/admin/product/edit/detail/'.$cmsType['product_num'].'/'.$cmsType['prod_id'];
    $viewData['listPageUrl'] = '/admin/product/'.$cmsType['product_num'];


    if($cmsType['product_num'] == 1){
      $viewData['topTitle'] 		= "關於我們";
      return view("admin.cms.product_cms",$viewData);
        }
        else if($cmsType['product_num'] == 2){
          $viewData['topTitle'] 		= "最新消息";
          return view("admin.cms.product_cms",$viewData);
        }
        else if($cmsType['product_num'] == 3){
          $viewData['topTitle'] 		= "跑馬燈";
          return view("admin.cms.product_cms",$viewData);
        }
        else if($cmsType['product_num'] == 4){
          $viewData['topTitle'] 		= "課程介紹";
          return view("admin.cms.product_cms",$viewData);
        }
        else if($cmsType['product_num'] == 5){
          $viewData['topTitle'] 		= "場地介紹";
          return view("admin.cms.product_cms",$viewData);
        }
        else if($cmsType['product_num'] == 7){
          $viewData['topTitle'] 		= "網路活動";
          $viewData['onlineCollapse']	= "show";
          return view("admin.cms.product_cms_haslayout",$viewData);
        }
        else if($cmsType['product_num'] == 10){
          $viewData['topTitle'] 		= "成功案例";
          $viewData['Caseollapse']	= "show";
          return view("admin.cms.product_cms",$viewData);
        }

        // return view($blade_path, $viewData);
    }
}

