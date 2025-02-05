<?php
namespace App\Http\Controllers\Api\Cms;

use App\Services\FileService;
use App\Repositories\Cms\CmsRepository;
use \App\Models\Cms\CmsModel;

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
            $public_file_target = 'cms'
        );
    }
}
