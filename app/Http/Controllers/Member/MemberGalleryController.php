<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;

use App\Repositories\Member\GalleryRepository;
use App\Http\Controllers\Controller;

class MemberGalleryController extends Controller
{
	protected $use_end 			= "member";
	protected $content_table	= "member_gallery";
	protected $extends_layouts	= "member.layouts.layoutExtends";
	protected $galleryRepository;
	public function __construct(
					GalleryRepository		$galleryRepository
	){
        $this->galleryRepository	= $galleryRepository;
    }

	public function index (Request $request,$galleryTypeId) {
		$viewData['use_end'] 		= $this->use_end;
		$viewData['content_table'] 	= $this->content_table;
		$viewData['extends_layouts']= $this->extends_layouts;
		$viewData['topTitle']		= '會員專區';

		$gallery = $this->galleryRepository->getGalleryTypeByTypeId($galleryTypeId);
		$viewData['webTitle'] = $gallery['gallery_name'];
		$viewData['pageTitle'] = $gallery['gallery_name'];

		if($galleryTypeId==1){

		}else if($galleryTypeId==2){

		}else if($galleryTypeId==3){

		}

		$viewData['gallCollapse'] 	= "show";
		$viewData['galleryTypeId'] 	= $galleryTypeId;
		$viewData['Gall'.$galleryTypeId.'Active'] 	= "active";

		return view("admin.gallery.gallery_has_cms",$viewData);
	}//public function index ()


	public function create ($galleryTypeId,Request $request) {
		$viewData['use_end'] 		= $this->use_end;
		$viewData['content_table'] 	= $this->content_table;
		$viewData['extends_layouts']= $this->extends_layouts;
		$viewData['topTitle']		= '會員專區';

		$gallery = $this->galleryRepository->getGalleryTypeByTypeId($galleryTypeId);
		$viewData['webTitle'] = $gallery['gallery_name'];
		$viewData['pageTitle'] = $gallery['gallery_name'];

		$viewData['galleryTypeId'] 	= $galleryTypeId;
		$viewData['galleryId'] 		= 0;
		$viewData['Gall'.$galleryTypeId.'Active'] 	= "active";

		if($galleryTypeId==1){

		}else if($galleryTypeId==2){

		}else if($galleryTypeId==3){

		}

		$viewData['gallCollapse'] = "show";
		return view("admin.gallery.template.galleryDetail",$viewData);
	}


	public function edit (Request $request,$galleryTypeId,$galleryId) {
		$viewData['use_end'] 		= $this->use_end;
		$viewData['content_table'] 	= $this->content_table;
		$viewData['extends_layouts']= $this->extends_layouts;
		$viewData['topTitle']		= '會員專區';

		$galleryType = $this->galleryRepository->getGalleryTypeByTypeId($galleryTypeId);
		$viewData['webTitle'] = $galleryType['gallery_name'];
		$viewData['pageTitle'] = $galleryType['gallery_name'];

		$viewData['galleryTypeId'] 	= $galleryTypeId;
		$viewData['galleryId'] 		= $galleryId;
		$viewData['Gall'.$galleryTypeId.'Active'] 	= "active";

		if($galleryTypeId==1){

		}else if($galleryTypeId==2){

		}else if($galleryTypeId==3){

		}

		$viewData['gallCollapse'] = "show";
		return view("admin.gallery.template.galleryDetail",$viewData);
	}

	public function get_seo($langId = 1){
		$seo = $this->seoRepository->getOne($langId)->toArray();
		$seo['host_url'] = $_SERVER['HTTP_HOST'];
		return $seo;
	}
}

