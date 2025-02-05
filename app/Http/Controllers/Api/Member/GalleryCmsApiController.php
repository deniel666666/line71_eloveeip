<?php
namespace App\Http\Controllers\Api\Member;

use App\Services\FileService;
use App\Repositories\Member\GalleryCmsRepository;
use \App\Models\Member\GalleryCmsModel;

use App\Http\Controllers\Api\Cms\Template\TemplateCmsApiController;

class GalleryCmsApiController extends TemplateCmsApiController
{   
	public function __construct(
		FileService		$fileService,
        GalleryCmsRepository   $cmsRepository,
        GalleryCmsModel        $cmsModel
    ){
        parent::__construct(
        	$fileService,
            $cmsRepository,
            $cmsModel,
            $public_file_target = 'member_gallery_cms'
        );
    }
}
