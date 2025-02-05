<?php
namespace App\Repositories\Cms\Product;

use App\Models\ProductModel;
use App\Models\Cms\Product\CmsModel;
use App\Models\Cms\Product\CmsLayoutModel;
use App\Models\Cms\Product\CmsLayoutRelationModel;
use App\Models\Cms\Product\CmsLayoutTypeModel;

use App\Repositories\Cms\Template\TemplateCmsLayoutTypeRepository;

class CmsLayoutTypeRepository extends TemplateCmsLayoutTypeRepository
{

	public function __construct(
		ProductModel 			$cmsTypeModel,
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
            $type_primaryKey    = "prod_id",
            $type_order_column  = 'prod_order',

			/*type function*/
            $cmsLayoutTypeModel,
            $layout_type_primaryKey     = "id",
            $layout_type_order_column   = 'cate_order'
        );
    }
}