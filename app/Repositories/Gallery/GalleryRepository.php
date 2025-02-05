<?php

namespace App\Repositories\Gallery;

use App\Models\Gallery\GalleryTypeModel;
use App\Models\Gallery\GalleryModel;

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