<?php
namespace App\Http\Controllers\Api\Cms;

use App\Repositories\Cms\CmsTypeRepository;

use App\Http\Controllers\Api\Cms\Template\TemplateCmsTypeApiController;

class CmsTypeApiController extends TemplateCmsTypeApiController
{
	public function __construct(
        CmsTypeRepository			$cmsTypeRepository
    ){
        parent::__construct(
            $cmsTypeRepository,
            $public_file_target = 'cms',
            $type_order_column  = 'cate_order'
        );
    }
}

