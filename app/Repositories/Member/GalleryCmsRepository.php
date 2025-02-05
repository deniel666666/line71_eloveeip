<?php
namespace App\Repositories\Member;

use App\Models\Member\GalleryModel;
use App\Models\Member\GalleryCmsModel;

use App\Repositories\Cms\Template\CmsTemplateRepository;

class GalleryCmsRepository extends CmsTemplateRepository
{
	public function __construct(
							GalleryModel	  $cmsTypeModel,
							GalleryCmsModel $cmsModel
  ){
    parent::__construct(
        $cmsTypeModel,
        $cmsModel,
        $primaryKey     = "cms_id",
        $type_primaryKey= "gallery_id"
    );
  }
}