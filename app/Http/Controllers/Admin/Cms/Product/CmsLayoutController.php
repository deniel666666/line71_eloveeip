<?php

namespace App\Http\Controllers\Admin\Cms\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Cms\Product\CmsLayoutTypeRepository;
use App\Http\Controllers\Api\Cms\Product\CmsLayoutApiController;

class CmsLayoutController extends Controller
{
	protected $use_end		 	= "admin";
	protected $content_table	= "product_cms_layout";
	protected $extends_layouts	= "layouts.masterAdmin";
	private	$cmsTypeRepository;

	public function __construct(
									CmsLayoutTypeRepository $cmsTypeRepository,
									CmsLayoutApiController  $cmsApiController
								)
	{
		$this->cmsTypeRepository = $cmsTypeRepository;
		$this->cmsApiController  = $cmsApiController;
	}

    public function index (Request $request, $cmsTypeId) {
    	$viewData['use_end'] 		= $this->use_end;
		$viewData['content_table'] 	= $this->content_table;
		$viewData['extends_layouts']= $this->extends_layouts;
    	// $viewData['topTitle'] 		= "商品模板管理 / 模板管理";
		// $viewData['pageTitle'] 		= "模板管理";
		$viewData['topTitle'] 		= "網路活動 / EDM模版";
		$viewData['pageTitle'] 		= "EDM模版";
		
		$cmsType = $this->cmsTypeRepository->get(['primary_key'=>$cmsTypeId])->toArray()[0];
		$viewData['cms_type_id']		= $cmsType['id'];
		$viewData['lang_id']			= $cmsType['lang_id'];
		$viewData['pageTitle']			= $cmsType['cms_type_name'].'-'.$cmsType['cont_type'];
		$viewData['child_template_id']	= $cmsType['child_template_id'];

		$viewData['prodcutCmaLayoutCollapse'] 	= "show";
		$viewData['onlineCollapse'] 	= "show";
		$viewData['prodcuCmsLayoutActive']		= 'active';

		return view("admin.cms.cms",$viewData);
    }

    public function createType (Request $request) {
    	$viewData['use_end'] 		= $this->use_end;
		$viewData['content_table'] 	= $this->content_table;
		$viewData['extends_layouts']= $this->extends_layouts;
		// $viewData['topTitle'] 		= "商品模板管理";
		// $viewData['pageTitle'] 		= "模板管理";
		$viewData['topTitle'] 		= "網路活動";
		$viewData['pageTitle'] 		= "EDM模版";

		$viewData['prodcutCmaLayoutCollapse'] 	= "show";
		$viewData['onlineCollapse'] 	= "show";
		$viewData['prodcuCmsLayoutActive']		= 'active';

		return view("admin.cms.cms_template.cmsLayoutType",$viewData);
    }
}
