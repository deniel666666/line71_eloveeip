<?php
namespace App\Http\Controllers\Api\Cms\Product;

use App\Repositories\Cms\Product\CmsLayoutTypeRepository;

use App\Http\Controllers\Api\Cms\Template\TemplateCmsLayoutTypeApiController;

class CmsLayoutTypeApiController extends TemplateCmsLayoutTypeApiController
{
	public function __construct(
        CmsLayoutTypeRepository $cmsLayoutTypeRepository
    ){
        parent::__construct(
        	/*layout function*/
        	$cms_model_name			= 'cmsModel',
        	$cms_layout_model_name	= 'cmsLayoutModel',
        	$cms_type_id_column		= 'prod_id',
        	$use_layout_file 		= 'product_cms',
        	/*type function*/
            $cmsLayoutTypeRepository,
            $public_file_target		= 'product_cms_layout'
        );
    }
}

