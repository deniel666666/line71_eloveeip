<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Repositories\Cms\CmsTypeRepository;
use App\Repositories\Gallery\GalleryRepository;

class ProfileAdminComposer
{
	protected $cmsTypeRepository;
	protected $galleryRepository;
	public function __construct(CmsTypeRepository 		$cmsTypeRepository,
								GalleryRepository 		$galleryRepository)
	{
		$this->cmsTypeRepository 		= $cmsTypeRepository;
		$this->galleryRepository 	= $galleryRepository;
	}
	public function compose(View $view)
	{
		$cms 		= $this->cmsTypeRepository->get([]);
		$gallery 	= $this->galleryRepository->getTypes();

		$view->with('cms', $cms);
		$view->with('gallery', $gallery);
		$view->with('LINE_BUSINESS_ID', env('LINE_BUSINESS_ID'));
		$view->with('LINE_BUSINESS_ADD_LINK', env('LINE_BUSINESS_ADD_LINK'));
	}
}