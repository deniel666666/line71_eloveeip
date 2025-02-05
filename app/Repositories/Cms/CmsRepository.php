<?php
namespace App\Repositories\Cms;

use App\Models\Cms\CmsTypeModel;
use App\Models\Cms\CmsModel;

use App\Repositories\Cms\Template\CmsTemplateRepository;

class CmsRepository extends CmsTemplateRepository
{
	public function __construct(
							CmsTypeModel	$cmsTypeModel,
							CmsModel 			$cmsModel
  ){
    parent::__construct(
        $cmsTypeModel,
        $cmsModel,
        $primaryKey     = "cms_id",
        $type_primaryKey= "id"
    );
  }
}