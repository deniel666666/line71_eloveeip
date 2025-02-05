<?php

namespace App\Http\Controllers\Api\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Member\MemberApiController;

use App\Repositories\Member\GalleryRepository;
use App\Models\Member\GalleryModel;
use App\Services\FileService;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\Api\Gallery\Template\TemplateGalleryApiController;

class MemberGalleryApiController extends TemplateGalleryApiController
{
	protected $memberApiController;
	public function __construct(
						MemberApiController	$memberApiController,
						GalleryRepository 	$galleryRepository,
						GalleryModel 		$galleryModel,
						FileService			$fileService
	)
	{
		parent::__construct(
			$galleryRepository,
			$galleryModel,
			$fileService,

			$targetTable	= "member_gallery"
		);

		$this->memberApiController = $memberApiController;
	}

	/* 依條件取得gallery(admin) */
	public function showAll(Request $request,$galleryTypeId){
        $request_obj = $request->all();
        $memberInfo	 = (array)$this->memberApiController->getRegisterInfo( Session::get('member.id') );

		$request_obj['galleryTypeId'] = $galleryTypeId;		//gallery類型id
		$request_obj['memberId']	  = $memberInfo['id'];	//member Id
        $data = $this->get_gallery($request_obj);
        return response()->json($data);
	}

	/* 覆寫create: 由後端設定meberId */
	public function create(Request $request, $galleryTypeId, $insData=[]){
		$request_obj = $request->all();
        $memberInfo	 = (array)$this->memberApiController->getRegisterInfo( Session::get('member.id') );

        /*會員特有欄位*/
		$insData['member_id'] = $memberInfo['id'];	//member Id
		if($request->input('member_article_type')){
			$updData['member_article_type'] = $request->input('member_article_type');
		}

        $reasult = parent::create($request, $galleryTypeId, $insData);

        return $reasult;
	}

	/* 覆寫update: 由後端設定meberId */
	public function update(Request $request, $galleryTypeId, $updData=[]) {
		$request_obj = $request->all();
        $memberInfo	 = (array)$this->memberApiController->getRegisterInfo( Session::get('member.id') );

        /*會員特有欄位*/
        $updData['member_id'] = $memberInfo['id'];	//member Id
		if($request->input('member_article_type')){
			$updData['member_article_type'] = $request->input('member_article_type');
		}

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

    /*覆寫show：額外顯示member_article_type資料*/
	public function show(Request $request, $galleryId) {
		$response = parent::show($request, $galleryId);
		$response = $response->getData();

		$response->gallery->member_article_type = explode(",", $response->gallery->member_article_type);
		return response()->json($response);
	}
}
