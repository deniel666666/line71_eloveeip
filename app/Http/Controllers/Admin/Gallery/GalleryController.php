<?php

namespace App\Http\Controllers\Admin\Gallery;

use Illuminate\Http\Request;
use App\Services\AclService;

use App\Repositories\Gallery\GalleryRepository;
use App\Http\Controllers\Controller;

class GalleryController extends Controller
{
	protected $use_end 			= "admin";
	protected $content_table	= "gallery";
	protected $extends_layouts	= "layouts.masterAdmin";
	protected $galleryRepository;
	protected $aclService;
	public function __construct(
					GalleryRepository		$galleryRepository,
					AclService				$aclService
					)
    {
        $this->galleryRepository	= $galleryRepository;
        $this->aclService			= $aclService;
    }

	public function index (Request $request,$galleryTypeId) {
		$viewData['use_end'] 		= $this->use_end;
		$viewData['content_table'] 	= $this->content_table;
		$viewData['extends_layouts']= $this->extends_layouts;

		$viewData['galleryTypeId'] 	= $galleryTypeId;
		$viewData['Gall'.$galleryTypeId.'Active'] 	= "active";
		
		$canAccessController = $this->aclService->canAccessController();
		if (!$canAccessController){
			return redirect('/admin/login');
		}

		$gallery = $this->galleryRepository->getGalleryTypeByTypeId($galleryTypeId);
		$viewData['pageTitle'] = $gallery['gallery_name'];

		if($galleryTypeId==1){
			$viewData['topTitle']		= '首頁';
			$viewData['homeCollapse'] 	= "show";
			return view("admin.gallery.customize.homeGallery",$viewData);
		}
		else if($galleryTypeId==2){
			$viewData['topTitle']		= '線上報名';
			$viewData['onlineCollapse'] 	= "show";
			return view("admin.gallery.customize.onlineGallery",$viewData);
		}
		else if($galleryTypeId==3){
			$viewData['topTitle']		= '相關連結';
			$viewData['linkCollapse'] 	= "show";
			return view("admin.gallery.customize.linkGallery",$viewData);
		}
		else if($galleryTypeId==4){
			$viewData['topTitle']		= '相關連結';
			$viewData['linkCollapse'] 	= "show";
			return view("admin.gallery.customize.linkGallery",$viewData);
		}


		$viewData['topTitle']		= '大圖管理';
		$viewData['gallCollapse'] 	= "show";
		// return view("admin.gallery.template.gallery",$viewData);
	}


	public function create ($galleryTypeId,Request $request) {
		$viewData['use_end'] 		= $this->use_end;
		$viewData['content_table'] 	= $this->content_table;
		$viewData['extends_layouts']= $this->extends_layouts;

		$gallery = $this->galleryRepository->getGalleryTypeByTypeId($galleryTypeId);
		$viewData['pageTitle'] = $gallery['gallery_name'];
		
		$viewData['galleryTypeId'] 	= $galleryTypeId;
		$viewData['galleryId'] 		= 0;
		$viewData['Gall'.$galleryTypeId.'Active'] 	= "active";

		if($galleryTypeId==1){
			$viewData['topTitle']		= '首頁';
			$viewData['homeCollapse'] 	= "show";
			return view("admin.gallery.customize.homeGalleryDetail",$viewData);
		}
		else if($galleryTypeId==2){
			$viewData['topTitle']		= '線上報名';
			$viewData['onlineCollapse'] 	= "show";
			return view("admin.gallery.customize.onlineGalleryDetail",$viewData);
		}
		else if($galleryTypeId==3){
			$viewData['topTitle']		= '相關連結';
			$viewData['linkCollapse'] 	= "show";
			return view("admin.gallery.customize.linkGalleryDetail",$viewData);
		}
		else if($galleryTypeId==4){
			$viewData['topTitle']		= '相關連結';
			$viewData['linkCollapse'] 	= "show";
			return view("admin.gallery.customize.linkGalleryDetail",$viewData);
		}

		$viewData['topTitle']		= '大圖管理';
		$viewData['gallCollapse'] 	= "show";
		// return view("admin.gallery.template.galleryDetail",$viewData);
	}


	public function edit (Request $request,$galleryTypeId,$galleryId) {
		$viewData['use_end'] 		= $this->use_end;
		$viewData['content_table'] 	= $this->content_table;
		$viewData['extends_layouts']= $this->extends_layouts;

		$gallery = $this->galleryRepository->getGalleryTypeByTypeId($galleryTypeId);
		$viewData['pageTitle'] = $gallery['gallery_name'];
		
		$viewData['galleryTypeId'] 	= $galleryTypeId;
		$viewData['galleryId'] 		= $galleryId;
		$viewData['Gall'.$galleryTypeId.'Active'] 	= "active";

		if($galleryTypeId==1){
			$viewData['topTitle']		= '首頁';
			$viewData['homeCollapse'] 	= "show";
			return view("admin.gallery.customize.homeGalleryDetail",$viewData);
		}
		else if($galleryTypeId==2){
			$viewData['topTitle']		= '線上報名';
			$viewData['onlineCollapse'] 	= "show";
			return view("admin.gallery.customize.onlineGalleryDetail",$viewData);
		}
		else if($galleryTypeId==3){
			$viewData['topTitle']		= '相關連結';
			$viewData['linkCollapse'] 	= "show";
			return view("admin.gallery.customize.linkGalleryDetail",$viewData);
		}
		else if($galleryTypeId==4){
			$viewData['topTitle']		= '相關連結';
			$viewData['linkCollapse'] 	= "show";
			return view("admin.gallery.customize.linkGalleryDetail",$viewData);
		}

		$viewData['topTitle']		= '大圖管理';
		$viewData['gallCollapse'] 	= "show";
		// return view("admin.gallery.template.galleryDetail",$viewData);
	}

}

