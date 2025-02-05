<?php

namespace App\Http\Controllers\Api\Gallery;

use Illuminate\Http\Request;
use App\Repositories\Gallery\GalleryRepository;
use App\Models\Gallery\GalleryModel;
use App\Services\FileService;

use App\Http\Controllers\Api\Gallery\Template\TemplateGalleryApiController;

class GalleryApiController extends TemplateGalleryApiController
{
	public function __construct(
						GalleryRepository 	$galleryRepository,
						GalleryModel 		$galleryModel,
						FileService			$fileService
	)
	{
		parent::__construct(
			$galleryRepository,
			$galleryModel,
			$fileService,

			$targetTable	= "gallery"
		);
	}

	/* 覆寫create: 由後端設定meberId */
	public function create(Request $request, $galleryTypeId, $insData=[]){
        /*特有欄位*/
		// if($request->input('member_article_type')){
		// 	$updData['member_article_type'] = $request->input('member_article_type');
		// }

        $reasult = parent::create($request, $galleryTypeId, $insData);

        return $reasult;
	}

	/* 覆寫update: 由後端設定meberId */
	public function update(Request $request, $galleryTypeId, $updData=[]) {
        /*特有欄位*/
		// if($request->input('member_article_type')){
		// 	$updData['member_article_type'] = $request->input('member_article_type');
		// }

        $reasult = parent::update($request, $galleryTypeId, $updData);

        return $reasult;
	}

	/*覆寫get_gallery_cont_data：整理gallery_cont的內容*/
    public function get_gallery_cont_data($cont){
		$cont = (array)json_decode($cont);
		// dump($cont);
        $cont['sub_title'] = isset($cont['sub_title']) ? $cont['sub_title'] : '';
        $cont['link']	   = isset($cont['link']) ? $cont['link'] : '';
        $cont['note']	   = isset($cont['note']) ? $cont['note'] : '';

        /*額外欄外，避免跳用時因無資料而報錯*/
        // $cont['sub_title2'] = isset($cont['sub_title2']) ? $cont['sub_title2'] : '';
        // $cont['link2']	    = isset($cont['link2']) ? $cont['link2'] : '';

        return $cont;
    }
}
