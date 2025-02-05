<?php

namespace App\Http\Controllers\Api\Gallery\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use App\Helpers\AppHelper;
use \DB;

use App\Repositories\SortOrderRepository;

use App\Http\Controllers\Controller;

class TemplateGalleryApiController extends Controller
{
    private $galleryRepository;
    private $galleryModel;
    private $fileService;
	private $targetTable;

	private $galleryImgPath = "upload/gallery/";

	public function __construct(
						$galleryRepository,
						$galleryModel,
						$fileService,

						$targetTable
	){
		$this->galleryRepository	= $galleryRepository;
		$this->galleryModel			= $galleryModel;
		$this->fileService			= $fileService;

		$this->targetTable			= $targetTable;
	}
	
	/* get one gallery */
    public function show(Request $request,$galleryId) {
        $gallery = $this->galleryRepository->getGalleryById($galleryId);

		$gallery['gallery_cont'] = $this->get_gallery_cont_data($gallery->gallery_cont);
		
		$gallery['img_name']!= "" ? $gallery['url'] = $this->galleryImgPath.$this->targetTable.'/'.$gallery['img_name']:$gallery['url'] = "";
		$gallery['img_name_mobile']!= "" ? $gallery['url_m'] = $this->galleryImgPath.$this->targetTable.'/'.$gallery['img_name_mobile']:$gallery['url_m'] = "";

		$langs = AppHelper::instance()->getAllLangsByOrder();
		$editLangs = AppHelper::instance()->getAllLangsByOrder();

		$data = [
            'gallery' => $gallery,
			'langs' => $langs,
			'editLangs' => $editLangs 
        ];
        return response()->json($data);
    }

	public function create(Request $request, $galleryTypeId, $insData=[]) {		
	    $gallery_cont = $request->input('gallery_cont');

		if(!empty($gallery_cont['note'])){
			// return  $gallery_cont['note'];
			//---------------------------
			// Extract and replace img
			//---------------------------
			$note = $gallery_cont['note'];
			$dom = new \domdocument();
			$dom->loadHtml(mb_convert_encoding($note,'HTML-ENTITIES','UTF-8'));
			// $dom->loadHtml(mb_convert_encoding($note,'HTML-ENTITIES','UTF-8'),LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
			$images = $dom->getelementsbytagname('img');
	
			foreach($images as $k => $img){
				$base64file	= $img->getattribute('src');
				$fileName 	= $img->getattribute('data-filename');
	
				if ($fileName != ''){
					$fileName = AppHelper::instance()->renameFile($base64file);
					$fileName = sha1(uniqid(time(), true)) . '_' . $fileName;
	
					$file = $this->fileService->base64Store($base64file, 'upload', 'gallery/'.$this->targetTable.'/', $fileName);
	
					$img->removeattribute('src');
					$img->removeattribute('data-filename');
					$img->setattribute('src', "/".$this->galleryImgPath.$this->targetTable.'/' . $fileName);
				}//if
			}//foreach
			$detail = $dom->savehtml($dom);
			$gallery_cont['note'] = $detail;
			if($gallery_cont['note']== 'undefined' ){
				$gallery_cont['note']="";
			}
		}

		//---------------------------

		$insData['gallery_type_id'] = $galleryTypeId;
		$insData['lang_id'] 		= $request->input('lang_id');

		$insData['alt'] 			= $request->input('alt');
		$insData['slider_order'] 	= $request->input('slider_order');
		$insData['img_status'] 		= $request->input('img_status');
		$insData['img_name'] 		= '';
		$insData['img_name_mobile'] = '';
        $insData['gallery_cont']    = json_encode($gallery_cont, JSON_UNESCAPED_UNICODE);

		if ($request->get('slider')) {
            $img = $request->get('slider');
			$fileName = AppHelper::instance()->renameFile($img);
			$fileName = sha1(uniqid(time(), true)).'_'.$fileName;
			$insData['img_name'] = $fileName;
			AppHelper::instance()->uploadFile("/public/".$this->galleryImgPath.$this->targetTable.'/', $fileName, $img);
		}
		if ($request->get('slider_m')) {
            $mobile_img = $request->get('slider_m');
			$mobile_fileName = AppHelper::instance()->renameFile($mobile_img);
			$mobile_fileName = sha1(uniqid(time(), true)).'_'.$mobile_fileName;
			$insData['img_name_mobile'] = $mobile_fileName;
			AppHelper::instance()->uploadFile("/public/".$this->galleryImgPath.$this->targetTable.'/', $mobile_fileName, $mobile_img);
		}


		// order increase start	
		$SortOrderRepository = new SortOrderRepository();
        $SortOrderRepository->gallerySort($this->galleryModel, $insData);
		// order increase end
		// dump($insData);exit;
		$inserId = $this->galleryRepository->create($insData);

		$data = [
			'inserId' 	=> $inserId,
			'status' 	=> 200
		];

		return response()->json($data);
	}

	public function update(Request $request,$galleryId, $updData=[]){
        $gallery_cont = $request->input('gallery_cont');

		if(!empty($gallery_cont['note'])){
			//---------------------------
			// Extract and replace img
			//---------------------------
			if(!empty($gallery_cont['note'])){
				$note = $gallery_cont['note'];
	
				$dom = new \domdocument();
				$dom->loadHtml(mb_convert_encoding($note,'HTML-ENTITIES','UTF-8'));
				// $dom->loadHtml(mb_convert_encoding($note,'HTML-ENTITIES','UTF-8'),LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
				$images = $dom->getelementsbytagname('img');
	
				foreach($images as $k => $img){
					$base64file	= $img->getattribute('src');
					$fileName 	= $img->getattribute('data-filename');
	
					if ($fileName != ''){
			        	$fileName = AppHelper::instance()->renameFile($base64file);
						$fileName = sha1(uniqid(time(), true)) . '_' . $fileName;
	
						$file = $this->fileService->base64Store($base64file, 'upload', 'gallery/'.$this->targetTable.'/', $fileName);
	
						$img->removeattribute('src');
						$img->removeattribute('data-filename');
						$img->setattribute('src', "/".$this->galleryImgPath.$this->targetTable.'/' . $fileName);
					}//if
				}//foreach
	
				$detail = $dom->savehtml($dom);
	
				$gallery_cont['note'] = $detail;
			}
		}

		$updData['gallery_type_id'] = $request->input('gallery_type_id');
		$updData['lang_id'] 		= $request->input('lang_id');

        $updData['gallery_id']		= $galleryId;
        $updData['alt'] 			= $request->input('alt');
		$updData['slider_order'] 	= $request->get('slider_order');
		$updData['img_status'] 		= $request->get('img_status');

        $updData['gallery_cont']    = json_encode($gallery_cont, JSON_UNESCAPED_UNICODE);

		// order increase start
		$SortOrderRepository = new SortOrderRepository();
        $SortOrderRepository->gallerySort($this->galleryModel, $updData);
		// order increase end

		if(!empty($request->get('slider'))){
			$judgmentSlider =$request->get('slider');
			if($judgmentSlider!='/'){
				$judgmentSlider =AppHelper::instance()->renameFile($judgmentSlider);
				$judgmentSliderExt = explode('.', $judgmentSlider);
				$judgmentSliderExt = end($judgmentSliderExt);

				if ($judgmentSliderExt != "upload") {
					$img = $request->get('slider');
					$fileName = AppHelper::instance()->renameFile($img);
					$fileName = sha1(uniqid(time(), true)).'_'.$fileName;
					$updData['img_name'] = $fileName;
					AppHelper::instance()->uploadFile("/public/".$this->galleryImgPath.$this->targetTable.'/', $fileName, $img);
				}
			}
		}
		
		if(!empty($request->get('slider_m'))){
			$judgmentSlider_m =$request->get('slider_m');
			if($judgmentSlider_m!='/'){
				$judgmentSlider_m =AppHelper::instance()->renameFile($judgmentSlider_m);
				$judgmentSlider_mExt = explode('.', $judgmentSlider_m);
				$judgmentSlider_mExt = end($judgmentSlider_mExt);

				if ($judgmentSlider_mExt != "upload") {
		            $mobile_img = $request->get('slider_m');
					$mobile_fileName = AppHelper::instance()->renameFile($mobile_img);
					$mobile_fileName = sha1(uniqid(time(), true)).'_'.$mobile_fileName;
					$updData['img_name_mobile'] = $mobile_fileName;
					AppHelper::instance()->uploadFile("/public/".$this->galleryImgPath.$this->targetTable.'/', $mobile_fileName, $mobile_img);
				}
			}
		}
		
		// dump($updData);exit;
        $res = $this->galleryRepository->update($galleryId,$updData);

        $data = [
            'res'   => $res,
            'status'=> 200
        ];
        return response()->json($data);
	}
	
    public function destroy(Request $request,$galleryTypeId,$galleryId){
		// Storage::delete('file.jpg');
        $res = $this->galleryRepository->delete($galleryId);
        
        $data = [
            'res'   => $res,
            'status'=> 200
        ];
        return response()->json($data);
    }

    /* 依條件取得gallery(admin) */
	public function showAll(Request $request,$galleryTypeId){
        $request_obj = $request->all();
		$request_obj['galleryTypeId'] = $galleryTypeId; //gallery類型id
        $data = $this->get_gallery($request_obj);
        return response()->json($data);
	}
	/* 依條件取得gallery(client) */
	public function showClient(Request $request,$galleryTypeId){
		$request_obj = $request->all();
		$request_obj['galleryTypeId'] = $galleryTypeId; //gallery類型id
		$request_obj['imgStatus'] = 1; 					//只允許取得啟用的
        $data = $this->get_gallery($request_obj);
        return response()->json($data);
	}
	public function get_gallery($request_obj){
		if(isset($request_obj['countOfPage'])){
			$countOfPage = $request_obj['countOfPage'];
			if($countOfPage!='' && $countOfPage!=0){
				$currentPage = isset($request_obj['currentPage']) ? $request_obj['currentPage'] : 1;
				$request_obj['startIndex'] = $currentPage * $countOfPage - $countOfPage;//計算起始index值 
			}
		}else{
			$countOfPage = 0;
		}
        $items = $this->galleryRepository->get($request_obj);
		foreach ($items as $gk => $gv) {
			$items[$gk]['url'] 	= $gv['img_name'] != ""			? "/".$this->galleryImgPath.$this->targetTable.'/'.$gv['img_name'] : "";
			$items[$gk]['url_m']	= $gv['img_name_mobile'] != "" 	? $this->galleryImgPath.$this->targetTable.'/'.$gv['img_name_mobile'] : "";
			
		    $items[$gk]['gallery_cont'] 		= $this->get_gallery_cont_data($gv['gallery_cont']);
		}
        $count = $this->galleryRepository->count($request_obj);
        if($countOfPage!=0){
	        $pageCount = (int)($count/$countOfPage);
	        if ($count%$countOfPage != 0) {
	            $pageCount +=1;
	        }
	    }else{
	    	$pageCount = 1;
	    }

        $langs = AppHelper::instance()->getAllLangs();
        $data = [
            'status' => '200',
            'langs' => $langs,
            'items' => $items,
            'count' => $count,
            'pageCount' => $pageCount
        ];
        return $data;
	}

    public function changeMultiStatus(Request $request){
        $productIds = $request->input('ids');
        $status = $request->input('status');
        $type = $request->input('type');
        
        $whereData = [['prod_id',$productIds]];
        $updateStatusData = [ $type => $status];
    	// return $updateStatusData;

        DB::beginTransaction();
        $checkVal = $this->galleryRepository->editMulti($productIds, $updateStatusData);
        if ($checkVal > 0) {
            DB::rollback();
        } else {
            DB::commit();
        }
        $data = [
            'status'=> 200
        ];
        return $data;
    }

    public function deleteGallery(Request $request){
        $galleryId = $request->get('galleryId');

		$galleryId = is_array($galleryId) ? $galleryId : [$galleryId];

        $checkVal = 0;
        DB::beginTransaction();

        $whereData = ['gallery_id','=',$galleryId];
        $checkVal += $this->galleryRepository->deleteGallery($whereData);

        if ($checkVal > 0) {
            DB::rollback();
			$data = [
				'status'=> '400',
				'msg' 	=> '資料庫錯誤'
			];
        } else {
            DB::commit();
			$data = [
				'status'=> '200'
			];
        }
        return $data;
    }

    /*整理gallery_cont的內容*/
    public function get_gallery_cont_data($cont){
		$cont = (array)json_decode($cont);
		// dump($cont);
        $cont['sub_title'] = isset($cont['sub_title']) ? $cont['sub_title'] : '';
        $cont['link']	   = isset($cont['link']) ? $cont['link'] : '';
        $cont['note']	   = isset($cont['note']) ? $cont['note'] : '';
        return $cont;
    }
}
