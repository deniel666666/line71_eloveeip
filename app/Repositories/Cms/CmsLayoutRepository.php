<?php
namespace App\Repositories\Cms;

use App\Models\Cms\CmsLayoutTypeModel;
use App\Models\Cms\CmsLayoutModel;

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
        $primaryKey     = "cms_id",
        $type_primaryKey= "id"
    );
  }
}