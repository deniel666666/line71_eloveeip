<?php
namespace App\Http\Controllers\Api\Cms\Product;

use App\Services\FileService;
use App\Repositories\Cms\Product\CmsRepository;
use \App\Models\Cms\Product\CmsModel;

use App\Http\Controllers\Api\Cms\Template\TemplateCmsApiController;

class CmsApiController extends TemplateCmsApiController
{   
	public function __construct(
		FileService		$fileService,
        CmsRepository   $cmsRepository,
        CmsModel        $cmsModel
    ){
        parent::__construct(
        	$fileService,
            $cmsRepository,
            $cmsModel,
            $public_file_target = 'product_cms'
        );
    }
}
