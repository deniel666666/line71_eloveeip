<?php
namespace App\Repositories\Cms;

use App\Models\Cms\CmsTypeModel;
use App\Models\Cms\CmsModel;
use App\Models\Cms\CmsLayoutModel;
use App\Models\Cms\CmsLayoutRelationModel;
use App\Models\Cms\CmsLayoutTypeModel;

use App\Repositories\Cms\Template\TemplateCmsLayoutTypeRepository;

class CmsLayoutTypeRepository extends TemplateCmsLayoutTypeRepository
{

	public function __construct(
		CmsTypeModel 			$cmsTypeModel,
		CmsModel 				$cmsModel,
		CmsLayoutModel 			$cmsLayoutModel,
		CmsLayoutRelationModel	$cmsLayoutRelationModel,
        CmsLayoutTypeModel      $cmsLayoutTypeModel
    ){
        parent::__construct(
        	/*layout function*/
        	$cmsTypeModel,
			$cmsModel,
			$cmsLayoutModel,
			$cmsLayoutRelationModel,
            $type_primaryKey    = "id",
            $type_order_column  = 'cate_order',

			/*type function*/
            $cmsLayoutTypeModel,
            $primaryKey  	   = "id",
            $type_order_column = 'cate_order'
        );
    }
}