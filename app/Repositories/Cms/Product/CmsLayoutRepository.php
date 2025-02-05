<?php
namespace App\Repositories\Cms\Product;

use App\Models\Cms\Product\CmsLayoutTypeModel;
use App\Models\Cms\Product\CmsLayoutModel;

use App\Repositories\Cms\Template\CmsTemplateRepository;

class CmsLayoutRepository extends CmsTemplateRepository
{
	public function __construct(
							CmsLayoutTypeModel	$cmsTypeModel,
							CmsLayoutModel 			$cmsModel
  ){
    parent::__construct(
        $cmsTypeModel,
        $cmsModel,
        $primaryKey       = "cms_id",
        $type_primaryKey  = "id"
    );
  }
}