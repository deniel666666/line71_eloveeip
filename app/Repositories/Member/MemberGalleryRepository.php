<?php

namespace App\Repositories\Member;

use App\Models\Member\GalleryTypeModel;
use App\Models\Member\GalleryModel;

use App\Repositories\Gallery\Template\TemplateGalleryRepository;

class GalleryRepository extends TemplateGalleryRepository{
	public function __construct(
		GalleryTypeModel 				$galleryTypeModel,
		GalleryModel					$galleryModel
	){
		parent::__construct(
			$galleryTypeModel,
			$galleryModel
		);
	}
}