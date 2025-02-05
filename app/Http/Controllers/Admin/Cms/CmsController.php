<?php
namespace App\Http\Controllers\Admin\Cms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Cms\CmsTypeRepository;
use App\Http\Controllers\Api\Cms\CmsApiController;

use DB;

class CmsController extends Controller
{
  protected $use_end 			="admin";
  protected $content_table	= "cms";
  protected $extends_layouts	= "layouts.masterAdmin";
  private $cmsTypeRepository;
  private $cmsApiController;

  public function __construct(
    CmsTypeRepository $cmsTypeRepository,
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
          
    $cmsType = $this->cmsTypeRepository->get(['primary_key'=>$cmsTypeId])->toArray();
    if(!$cmsType){ return; }
    $cmsType = $cmsType[0];

    $viewData['pageTitle']			    = $cmsType['cms_type_name'];
    $viewData['cms_type_id']		    = $cmsType['id'];
    $viewData['lang_id']			      = $cmsType['lang_id'];
    $viewData['child_template_id']	= $cmsType['child_template_id'];

    /*處理編輯顯示畫面*/
    $edit_view = "cms";				        /*預設編輯模板*/
    // $edit_view = "cms_haslayout";	/*預設顯示模板(有子母模板)*/
    $view_view = "cmsViewTemplate";	  /*預設顯示模板(非挖空式)*/
    $current_child_template = (array)DB::table($this->content_table.'_layout_relation')
                                        ->where('cms_type_id','=',$cmsType['id'])
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
    $viewData['edit_view']                = $edit_view;
    $viewData['view_view']                = $view_view;

    $viewData['cmsTypeId'] 		            = (int)$cmsTypeId;
    $viewData['cms'.$cmsTypeId.'Active']	= 'active';

    if($cmsTypeId ==1){
      $viewData['topTitle'] 		= "通用設定";
      return view("admin.cms.customize.public",$viewData);
    }
    else if($cmsTypeId ==2){
      $viewData['topTitle'] 		= "系統管理";
      $viewData['sysCollapse'] 	= "show";
      return view("admin.cms.customize.seo_cms", $viewData);
    }
    else if($cmsTypeId ==3){
      $viewData['topTitle'] 		= "首頁";
      $viewData['homeCollapse'] 	= "show";
      return view("admin.cms.customize.home_dig_cms", $viewData);
    }
    else if($cmsTypeId ==4){
      $viewData['topTitle'] 		= "報名位置";
      return view($blade_path, $viewData);
    }
    else if($cmsTypeId ==5){
      $viewData['topTitle'] 		= "體檢須知";
      return view($blade_path, $viewData);
    }
    else if($cmsTypeId ==6){
      $viewData['topTitle'] 		= "線上報名";
      $viewData['onlineCollapse'] 	= "show";
      return view($blade_path, $viewData);
    }
    else if($cmsTypeId ==7){
      $viewData['topTitle'] 		= "線上報名";
      $viewData['onlineCollapse'] 	= "show";
      return view($blade_path, $viewData);
    }
    else if($cmsTypeId ==8){
      $viewData['topTitle'] 		= "線上報名";
      $viewData['onlineCollapse'] 	= "show";
      return view($blade_path, $viewData);
    }
    else if($cmsTypeId ==9){
      $viewData['topTitle'] 		= "首頁";
      $viewData['homeCollapse'] 	= "show";
      return view($blade_path, $viewData);
    }
    
    $viewData['topTitle'] 		= "CMS管理";
    $viewData['cmsCollapse'] 	= "show";
    // return view($blade_path, $viewData);
  }

  public function createType (Request $request) {
    $viewData['use_end'] 		= $this->use_end;
    $viewData['content_table'] 	= $this->content_table;
    $viewData['extends_layouts']= $this->extends_layouts;
    $viewData['topTitle'] 		= "CMS管理";
    $viewData['pageTitle'] 		= "類別管理";
    
    $viewData['cmsCollapse'] 	= "show";
    $viewData['cmsTypeActive']	= 'active';
    
    return view("admin.cms.cms_template.cmsType",$viewData);
  }
}
