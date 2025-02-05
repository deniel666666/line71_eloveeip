<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Member\GalleryRepository;
use App\Http\Controllers\Api\Member\GalleryCmsApiController;

use App\Repositories\SeoRepository;

class GalleryCmsController extends Controller
{
	const primaryKey = "id";
	protected $use_end 			="member";
	protected $content_table	= "member_gallery_cms";
	protected $extends_layouts	= "member.layouts.layoutExtends";
	private $cmsTypeRepository;
	private $cmsApiController;

	public function __construct(
		GalleryRepository		$cmsTypeRepository,
		GalleryCmsApiController $cmsApiController
	){
		$this->cmsTypeRepository = $cmsTypeRepository;
		$this->cmsApiController  = $cmsApiController;
	}

    public function index (Request $request, $cmsTypeId) {
    	$viewData['use_end'] 		= $this->use_end;
		$viewData['content_table'] 	= $this->content_table;
		$viewData['extends_layouts']= $this->extends_layouts;
    	$viewData['webTitle'] 		= "會員專區";
    	$viewData['topTitle'] 		= "會員專區";
 	
		$cmsType = $this->cmsTypeRepository->get([self::primaryKey=>$cmsTypeId])[0];
		// $cmsType['gallery_cont'] = json_decode($cmsType['gallery_cont']);
		$viewData['pageTitle']			= $cmsType['alt'];
		$viewData['cms_type_id']		= $cmsType['gallery_id'];
		$viewData['lang_id']			= $cmsType['lang']['lang_id'];
		$viewData['child_template_id']	= $cmsType['child_template_id'];

		$viewData['cmsTypeId'] 		= (int)$cmsTypeId;
		$viewData['typePage']		= '/member/member_gallery/'.$cmsType['gallery_type_id'];

		if($cmsTypeId ==1){

		}else if($cmsTypeId ==2){

		}

		return view("member.gallery_cms",$viewData);
    }
}
