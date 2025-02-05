<?php
namespace App\Http\Controllers\Api\Cms\Product;

use App\Services\FileService;
use App\Repositories\Cms\Product\CmsLayoutRepository;
use App\Models\Cms\Product\CmsLayoutModel;

use App\Http\Controllers\Api\Cms\Template\TemplateCmsApiController;

class CmsLayoutApiController extends TemplateCmsApiController
{   
	public function __construct(
		FileService		    $fileService,
        CmsLayoutRepository $cmsRepository,
        CmsLayoutModel      $cmsLayoutModel
    ){
        parent::__construct(
        	$fileService,
            $cmsRepository,
            $cmsLayoutModel,
            $public_file_target = 'product_cms_layout'
        );
    }
}
