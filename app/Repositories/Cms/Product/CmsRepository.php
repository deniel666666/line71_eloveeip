<?php
namespace App\Repositories\Cms\Product;

use App\Models\ProductModel;
use App\Models\Cms\Product\CmsModel;

use App\Repositories\Cms\Template\CmsTemplateRepository;

class CmsRepository extends CmsTemplateRepository
{
	public function __construct(
							ProductModel	$cmsTypeModel,
							CmsModel 			$cmsModel
  ){
    parent::__construct(
        $cmsTypeModel,
        $cmsModel,
        $primaryKey     = "cms_id",
        $type_primaryKey= "prod_id"
    );
  }
}