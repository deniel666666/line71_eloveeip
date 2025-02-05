<?php

namespace App\Repositories\Gallery\Template;

use App\Repositories\Gallery\Template\TemplateGalleryRepository;

class TemplateGalleryHasCmsRepository extends TemplateGalleryRepository{
	protected $galleryTypeModel;
	protected $galleryModel;
	public function __construct(
		$galleryTypeModel,
		$galleryModel
	){
		parent::__construct(
			$galleryTypeModel,
			$galleryModel
		);

		$this->galleryTypeModel 				= $galleryTypeModel;
		$this->galleryModel 					= $galleryModel;
	}

	//-------------------
	// GalleryTypeModel
	//-------------------

    /* 根據條件取得gallery */
	public function get($cond){
		$res = $this->galleryModel::with(['lang','cms'])->select('*');
		$res = parent::deal_where_sql($res, $cond);
		$gallery_table = $this->galleryModel->getTable();
		return $res->orderBy($gallery_table.'.slider_order', 'asc')
					->orderBy($gallery_table.'.gallery_id','desc')
					->get()->toArray();
	}
}