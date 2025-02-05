<?php
namespace App\Repositories\Cms;

use App\Models\Cms\CmsTypeModel;

use App\Repositories\Cms\Template\CmsTypeTemplateRepository;

class CmsTypeRepository extends CmsTypeTemplateRepository
{
	public function __construct(
        CmsTypeModel               $cmsTypeModel
    ){
        parent::__construct(
            $cmsTypeModel,
            $primaryKey   		= "id",
            $type_order_column  = 'cate_order'
        );
    }
}