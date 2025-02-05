<?php
namespace App\Http\Controllers\Api\Cms;

use App\Repositories\Cms\CmsLayoutTypeRepository;

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
        	$cms_type_id_column		= 'id',
        	$use_layout_file 		= 'cms',
        	/*type function*/
            $cmsLayoutTypeRepository,
            $public_file_target		= 'cms_layout'
        );
    }
}

