<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CategoryTagRepository;
use App\Helpers\AppHelper;
use App\Services\FileService;
use App\Repositories\SortOrderRepository;
use App\Repositories\LangRepository;

//----------------------------start
use \DB;
use \File;
//----------------------------end

class CategoryTagApiController extends Controller
{
	private $mainRepository;
	private $LangRepository;
	protected $publicFilePath =  '/public/upload/categoryTag/';
    private $categoryTagRepository;
	private $fileService;
	public function __construct(
				CategoryTagRepository 		$categoryTagRepository,
				LangRepository 				$LangRepository,
				FileService					$fileService
	){
		$this->mainRepository 		= $categoryTagRepository;
		$this->LangRepository 		= $LangRepository;
		$this->fileService			= $fileService;
	}

	/* 儲存編輯 */
	public function save(Request $request){

		$item = $request->input('item');

		// order increase start
		$SortOrderRepository = new SortOrderRepository();
		$retData = $SortOrderRepository->categoryTagSort($item);
		// order increase end

		$tag_img_file = $item['tag_img'];
		$tag_img_wide_file = $item['tag_img_wide'];
		$id = $item['cate_tag_id'];

		unset($item['actionType']); 
		unset($item['trees']); 
		unset($item['treeFamily']); 
		unset($item['tag_img']); 
		unset($item['tag_img_wide']); 
		unset($item['hierarchy_count']);
		unset($item['hierarchy_id']);
		unset($item['parent_id']);
		unset($item['treesSelect']);
		unset($item['modify']);
		unset($item['treesSelect']); 
		unset($item['modify']); 
		unset($item['cate_tag_id']);
		unset($item['lang']);
		unset($item['created_at']);
		unset($item['updated_at']);
		unset($item['itemColor']);
		unset($item['pro']);
		unset($item['childTreesArr']);
		unset($item['showProAll']);
		unset($item['showProShelves']);

		$tagId = $id;
		if(!empty($tag_img_file)){
			if (!File::exists(base_path().$this->publicFilePath.$tagId)) {
				File::makeDirectory(base_path().$this->publicFilePath.$tagId, 0775);
			}

	        $fileName = AppHelper::instance()->renameFile($tag_img_file);
			$oldItem = $this->mainRepository->getLayerAll('', '', '', '', '', '', '', '', '', '['.$id.']')[0];
            if ($tag_img_file != $oldItem['tag_img'] ) {
				if($oldItem['tag_img'] != ""){
					if (!File::exists(base_path().$oldItem['tag_img'] )) {
						AppHelper::instance()->deleteImg(base_path().$oldItem['tag_img']);
					}
				}
		        AppHelper::instance()->uploadFile($this->publicFilePath.$tagId, $fileName, $tag_img_file);
				$item['tag_img'] =$this->publicFilePath.$tagId.'/'.$fileName ;
	            $this->mainRepository->edit($id,$item);
            }
		}else{
			$oldItem = $this->mainRepository->getLayerAll('', '', '', '', '', '', '', '', '', '['.$id.']')[0];
			if($oldItem['tag_img'] != ""){
				if (!File::exists(base_path().$oldItem['tag_img'] )) {
					AppHelper::instance()->deleteImg(base_path().$oldItem['tag_img']);
				}
			}
			$item['tag_img'] ='';
			$this->mainRepository->edit($id,$item);
		}

		if(!empty($tag_img_wide_file)){
			if (!File::exists(base_path().$this->publicFilePath.$tagId)) {
				File::makeDirectory(base_path().$this->publicFilePath.$tagId, 0775);
			}
	        $fileName = AppHelper::instance()->renameFile($tag_img_wide_file);
			$oldItem = $this->mainRepository->getLayerAll('', '', '', '', '', '', '', '', '', '['.$id.']')[0];
            if ($tag_img_wide_file != $oldItem['tag_img_wide'] ) {
				if($oldItem['tag_img_wide'] != ""){
					if (!File::exists(base_path().$oldItem['tag_img_wide'] )) {
						AppHelper::instance()->deleteImg(base_path().$oldItem['tag_img_wide']);
					}
				}
		        AppHelper::instance()->uploadFile($this->publicFilePath.$tagId, $fileName, $tag_img_wide_file);
				$item['tag_img_wide'] =$this->publicFilePath.$tagId.'/'.$fileName ;
	            $this->mainRepository->edit($id,$item);
            }
		}else{
			$oldItem = $this->mainRepository->getLayerAll('', '', '', '', '', '', '', '', '', '['.$id.']')[0];
			if($oldItem['tag_img_wide'] != ""){
				if (!File::exists(base_path().$oldItem['tag_img_wide'] )) {
					AppHelper::instance()->deleteImg(base_path().$oldItem['tag_img_wide']);
				}
			}
			$item['tag_img_wide'] ='';
			$this->mainRepository->edit($id,$item);
		}
		//--------------------------------------------------------------------------------------------------
		//--------------------------------------------------------------------------------------------------


		//---------------------------
		// Extract and replace img
		//---------------------------
		if(!empty($item['cate_tag_desc'])){	
			$note = $item['cate_tag_desc'];
			$dom = new \domdocument();	
			$dom->loadHtml(mb_convert_encoding($note,'HTML-ENTITIES','UTF-8'),LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
			$images = $dom->getelementsbytagname('img');
			foreach($images as $k => $img){
				$base64file	= $img->getattribute('src');
				$fileName 	= $img->getattribute('data-filename');
				if ($fileName != ''){
					$ext = explode('.', $fileName);
					$ext = end($ext);
					$fileName = sha1(uniqid(time(), true)).'.'.$ext;
					$file = $this->fileService->base64Store($base64file, 'upload', 'categoryTag/'.$id.'/', $fileName);
					$img->removeattribute('src');
					$img->removeattribute('data-filename');
					$img->setattribute('src', '/upload/categoryTag/'.$id.'/'.$fileName);
				}//if
			}//foreach	
			$detail = $dom->savehtml($dom);
		}else{
			$detail = '';
		}
		//---------------------------


		$item['cate_tag_desc'] = $detail;
		//-------------------------------------------------------------------------------start
		if( $request->input('item.modify') == true){
			DB::beginTransaction();
			if (  $request->input('item.treesSelect') != 0 ) {
				// return '修改';
				$treesSelect = $request->input('item.treesSelect');    
					$item['parent_id'] =$treesSelect['cate_tag_id'];
					$classNum = $treesSelect['hierarchy']+1;
					$item['hierarchy_count'] = $classNum ;
					$hierarchyArray =$request->input('item.treesSelect.hierarchyArray');
					$hierarchyArray[$classNum] =(string)$id ;
					$item['hierarchy_id']  =json_encode($hierarchyArray);
					unset($item['treesSelect']); 

				}else{
					// return '第0階';
					$item['parent_id'] =0;
					$item['hierarchy_count'] =1;
					$hierarchy_id = array(
					    "1" => (string)$id,
					);
					$item['hierarchy_id'] = json_encode($hierarchy_id);
				}

				$res = $this->mainRepository->edit($id,$item);				
				if( (int)$res >= 1){
		            DB::commit();
				}else{
		            DB::rollback();
				}
		}else{
			$this->mainRepository->edit($id,$item);
		}

		//-------------------------------------------------------------------------------end
		$data = [
			'status'=> 200
		];

		return response()->json($data);
	}

	/* 修改排序 */
	public function save_order(Request $request){
		$item = $request->input('item');

		// order increase start
		$SortOrderRepository = new SortOrderRepository();
		$retData = $SortOrderRepository->categoryTagSort($item);
		// order increase end

		$id = $item['cate_tag_id'];
		$tag_img_file = $item['tag_img'];
		$tag_img_wide_file = $item['tag_img_wide'];

		unset($item['actionType']); 
		unset($item['trees']); 
		unset($item['treeFamily']); 
		unset($item['tag_img']); 
		unset($item['tag_img_wide']); 
		unset($item['hierarchy_count']);
		unset($item['hierarchy_id']);
		unset($item['parent_id']);
		unset($item['treesSelect']);
		unset($item['modify']);
		unset($item['treesSelect']); 
		unset($item['modify']); 
		unset($item['cate_tag_id']);
		unset($item['lang']);
		unset($item['created_at']);
		unset($item['updated_at']);
		unset($item['itemColor']);
		unset($item['pro']);
		unset($item['childTreesArr']);
		unset($item['showProAll']);
		unset($item['showProShelves']);

		$this->mainRepository->edit($id,$item);
		// return $item;
	}

	/* 修改狀態 */
	public function setStatus(Request $request){

		$updData['cate_status'] = $request->input('status');
		$ids = $request->input('ids');
		if($request->input('status') == 0){
			for ($i = 0; $i < count($ids); $i++) {
                // status error------
				// $getLangId = $this->mainRepository->getLangIdByMainId($ids[$i]);
				// $getAllCategoryTagCountByLangId = $this->mainRepository->getAllCategoryTagCountByLangId($getLangId[0]['lang_id'] );
				// $getAllCategoryTagOffStatusCountByLangId = $this->mainRepository->getAllCategoryTagOffStatusCountByLangId($getLangId[0]['lang_id'] );
				// if($getAllCategoryTagCountByLangId - 1 > $getAllCategoryTagOffStatusCountByLangId){
					$this->mainRepository->edit($ids[$i], $updData);
				// }
			}
		}else{
			$this->mainRepository->setStatus($request->input('ids'),$updData);
		}

		$data = [
			'status'=> 200
		];

		return response()->json($data);
	}


	/* 串接資料用 --------------------------------------------------------------------*/
	/*依條件搜尋tag*/
	public function getTags($request_obj){
		$items = $this->mainRepository->getLayerAll($request_obj);
		foreach ($items as $resKey => $resValue){
			$showProAll 	= $this->mainRepository->showProAll($resValue['lang_id'],$resValue['cate_tag_id']);
			$showProShelves = $this->mainRepository->showProShelves($resValue['lang_id'],$resValue['cate_tag_id']);
			$items[$resKey]['showProAll']=$showProAll;
			$items[$resKey]['showProShelves']=$showProShelves ;
		}

		$countOfPage = isset($request_obj['countOfPage']) ? $request_obj['countOfPage'] : 0;
		$request_obj['countOfPage'] = 0;
		$items_all = $this->mainRepository->getLayerAll($request_obj);
		$count = count($items_all);
		$pageCount = $countOfPage!=0 ? (int)($count/$countOfPage) : 1;
        if($countOfPage!=0){
            if ($count%$countOfPage != 0) {
                $pageCount +=1;
            }
        }
		$data = [
            'status' 	=> '200',
			'items'  	=> $items,
			'count'		=> $count,
			'pageCount' => $pageCount,
		];
		return $data;
    }
    /*後台搜尋tag*/
    public function adminShowLayerId(Request $request){
    	$request_obj = $request->all();

		$data = $this->getTags($request_obj);
		return response()->json($data);
    }
	/*前台搜尋tag*/
    public function clientShowLayerId(Request $request){
    	$request_obj = $request->all();

    	$request_obj['cateStatus'] = 1; /*只允許看啟用的*/
		$data = $this->getTags($request_obj);
		return response()->json($data);
    }
	/*-------------------------------------------------------------------------------*/

    public function treeJson(Request $request,$cateId){

		$langId = $request->get('selectLangItem');
		$searchByText = $request->get('searchByText');
		$hierarchyCount = $request->get('hierarchy_count');

		$trees = $this->mainRepository->thisClassShowAll($cateId,$langId,$searchByText,$hierarchyCount);
		$items  =  $this->groundLoop($cateId,$langId,$searchByText,$hierarchyCount,$trees);
		$data = [
            'status' => '200',
			'items' => $items,
		];
		return response()->json($data);
	}

    public function groundLoop($cateId,$langId,$searchByText,$hierarchyCount,$trees){

		$hierarchyCount+=1;
		foreach ($trees as $key => $tree){

			// calculation start
			$showProAll 	= $this->mainRepository->showProAll($tree['lang_id'],$tree['cate_tag_id']);
			$showProShelves = $this->mainRepository->showProShelves($tree['lang_id'],$tree['cate_tag_id']);
			$showAllByTag = $this->mainRepository->showProAllForByTag($tree['lang_id'],$tree['cate_tag_id']);
	
			$trees[$key]['pro']['showProAll']=$showProAll;
			$trees[$key]['pro']['showProShelves']=$showProShelves;
			$trees[$key]['pro']['all']=$showAllByTag;

			// calculation end
			$itemsTrsss = $this->mainRepository->downSearchClassShowAll($cateId,$langId,$searchByText,$hierarchyCount,$tree['cate_tag_id']);		
			$trees[$key]['childTreesArr'] =$itemsTrsss;
			if( count($itemsTrsss)!=0 ){
				$trees[$key]['childTreesArr'] = $this->groundLoop($cateId,$langId,$searchByText, $hierarchyCount ,$trees[$key]['childTreesArr']);
			}
		}
		return $trees;
	}

	/* 新增tag */
	public function add(Request $request){

		$item = $request->get('item');
		unset($item['actionType']); 
		unset($item['trees']); 
		unset($item['treeFamily']); 

		if($item['tag_img'] != " "){
			$tag_img_file = $item['tag_img'];
			unset($item['tag_img']); 
		}

		if($item['tag_img_wide'] != " "){
			$tag_img_wide_file = $item['tag_img_wide'];
			unset($item['tag_img_wide']); 
		}

		if($item['lang_id'] == 0) $item['lang_id'] = 1;

	    //----------------------------start
		unset($item['treesSelect']); 
        DB::beginTransaction();
		//----------------------------end

		$id = $this->mainRepository->add($item);

	    //----------------------------start
		if ( $request->input('item.treesSelect') ) {
			$treesSelect = $request->input('item.treesSelect');    
			$item['parent_id'] =$treesSelect['cate_tag_id'];
			$classNum = $treesSelect['hierarchy']+1;
			$item['hierarchy_count'] = $classNum ;
			$hierarchyArray =$request->input('item.treesSelect.hierarchyArray');
			$hierarchyArray[$classNum] =(string)$id ;
			$item['hierarchy_id']  =json_encode($hierarchyArray);
			unset($item['treesSelect']); 

		}else{
			$item['parent_id'] =0;
			$item['hierarchy_count'] =1;
			$hierarchy_id = array(
			    "1" => (string)$id,
			);
			$item['hierarchy_id'] = json_encode($hierarchy_id);
		}

		// order increase start
		$SortOrderRepository = new SortOrderRepository();
		$retData = $SortOrderRepository->categoryTagSort($item);
		// order increase end

		$res = $this->mainRepository->edit($id,$item);
		if( (int)$res >= 1){
            DB::commit();
		}else{
            DB::rollback();
		}
	    //----------------------------end

		//--------------------------------------------------------------------------------------------------
		//--------------------------------------------------------------------------------------------------

		$tagId = $id;
		if(!empty($tag_img_file)){
			if (!File::exists(base_path().$this->publicFilePath.$tagId)) {
				File::makeDirectory(base_path().$this->publicFilePath.$tagId, 0775);
			}
	        $fileName = AppHelper::instance()->renameFile($tag_img_file);
			$oldItem = $this->mainRepository->getLayerAll('', '', '', '', '', '', '', '', '', '['.$id.']')[0];
            if ($tag_img_file != $oldItem['tag_img'] ) {
				if($oldItem['tag_img'] != ""){
					if (!File::exists(base_path().$oldItem['tag_img'] )) {
						AppHelper::instance()->deleteImg(base_path().$oldItem['tag_img']);
					}
				}

		        AppHelper::instance()->uploadFile($this->publicFilePath.$tagId, $fileName, $tag_img_file);
				$item['tag_img'] =$this->publicFilePath.$tagId.'/'.$fileName ;
	            $this->mainRepository->edit($id,$item);
            }
		}else{
			$oldItem = $this->mainRepository->getLayerAll('', '', '', '', '', '', '', '', '', '['.$id.']')[0];
			if($oldItem['tag_img'] != ""){
				if (!File::exists(base_path().$oldItem['tag_img'] )) {
					AppHelper::instance()->deleteImg(base_path().$oldItem['tag_img']);
				}
			}

			$item['tag_img'] ='';
			$this->mainRepository->edit($id,$item);
		}

		if(!empty($tag_img_wide_file)){
			if (!File::exists(base_path().$this->publicFilePath.$tagId)) {
				File::makeDirectory(base_path().$this->publicFilePath.$tagId, 0775);
			}

	        $fileName = AppHelper::instance()->renameFile($tag_img_wide_file);
			$oldItem = $this->mainRepository->getLayerAll('', '', '', '', '', '', '', '', '', '['.$id.']')[0];
            if ($tag_img_wide_file != $oldItem['tag_img_wide'] ) {
				if($oldItem['tag_img_wide'] != ""){
					if (!File::exists(base_path().$oldItem['tag_img_wide'] )) {
						AppHelper::instance()->deleteImg(base_path().$oldItem['tag_img_wide']);
					}
				}

		        AppHelper::instance()->uploadFile($this->publicFilePath.$tagId, $fileName, $tag_img_wide_file);
				$item['tag_img_wide'] =$this->publicFilePath.$tagId.'/'.$fileName ;
	            $this->mainRepository->edit($id,$item);
            }
		}else{
			$oldItem = $this->mainRepository->getLayerAll('', '', '', '', '', '', '', '', '', '['.$id.']')[0];
			if($oldItem['tag_img_wide'] != ""){
				if (!File::exists(base_path().$oldItem['tag_img_wide'] )) {
					AppHelper::instance()->deleteImg(base_path().$oldItem['tag_img_wide']);
				}
			}

			$item['tag_img_wide'] ='';
			$this->mainRepository->edit($id,$item);
		}
		//--------------------------------------------------------------------------------------------------
		//--------------------------------------------------------------------------------------------------

		// return $id;    

		//---------------------------
		// Extract and replace img
		//---------------------------
		if(!empty($item['cate_tag_desc'])){
			$note = $item['cate_tag_desc'];
			$dom = new \domdocument();		
				$dom->loadHtml(mb_convert_encoding($note,'HTML-ENTITIES','UTF-8'),LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
				$images = $dom->getelementsbytagname('img');
				foreach($images as $k => $img){
					$base64file	= $img->getattribute('src');
					$fileName 	= $img->getattribute('data-filename');
					if ($fileName != ''){
						$ext = explode('.', $fileName);
						$ext = end($ext);
						$fileName = sha1(uniqid(time(), true)).'.'.$ext;
						$file = $this->fileService->base64Store($base64file, 'upload', 'categoryTag/'.$id.'/', $fileName);
						$img->removeattribute('src');
						$img->removeattribute('data-filename');
						$img->setattribute('src','/upload/categoryTag/'.$id.'/'.$fileName);
					}//if
				}//foreach		
			$detail = $dom->savehtml($dom);	
		}else{
			$detail = '';
		}
		//---------------------------

		$item['cate_tag_desc'] = $detail;
		$this->mainRepository->edit($id,$item);
		$data = [
			'status'=> 200
		];

		return response()->json($data);
	}

	/* 刪除tag */
	public function delete(Request $request){

		$this->mainRepository->delete($request->input('ids'));

		$data = [

			'status'=> 200

		];

		return response()->json($data);

	}

	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------

 //    public function hierarchy(Request $request){
	// 	$selectLangItem = $request->get('selectLangItem');
	// 	$productNum = $request->get('productNum');

	// 	$items = $this->mainRepository->hierarchy($selectLangItem ,$productNum);
	// 	$pid = 0; $level = 1;
	// 	$trees = $this->mainRepository->tree($items,$pid,$level);

	// 	$pageData = [];
	// 	foreach ($trees as $resKey => $resValue){
	// 		$hierarchyObject = json_decode($resValue['hierarchy_id']);
	// 		$hierarchyArray =(array)$hierarchyObject;
	// 		////////////////////////////////////////////////////

	// 		$pageData[] = [
	// 			'cate_tag_id'			=> $resValue['cate_tag_id'],
	// 			'hierarchyArray' 		=> $hierarchyArray,
	// 			'hierarchy' 			=> count($hierarchyArray),
	// 			'cate_name'				=> $resValue['cate_name']
	// 		];
	// 	}

	// 	$data = [
 //            'status' => '200',
	// 		'items' => $pageData
	// 	];
	// 	return response()->json($data);
	// }

	///////////////////////////////////////////
	// -- edit tag show should has select -- //
	///////////////////////////////////////////

	/* 載入tag資料 (編輯用) */
    public function hierarchy_show(Request $request){

		$selectLangItem = $request->get('selectLangItem');
		$productNum 	= $request->get('productNum');
		$tagId			= $request->get('tagId');
		$classPid		= $request->get('pid');
		$classLevel		= $request->get('level');

		$items	   = $this->mainRepository->hierarchy($selectLangItem,$productNum ,$tagId);
		$treeIdArr = $this->mainRepository->treeIdArr($items,$classPid,$classLevel);
		$res   	   = $this->mainRepository->treeIdArrUp($treeIdArr,$selectLangItem,$productNum ,$tagId);

		$pid = 0; $level = 1;
		$trees 	   = $this->mainRepository->tree($res,$pid,$level);

		$pageData = [];
		foreach ($trees as $resKey => $resValue){
			$hierarchyObject = json_decode($resValue['hierarchy_id']);
			$hierarchyArray =(array)$hierarchyObject;
			$pageData[] = [
				'cate_tag_id'			=> $resValue['cate_tag_id'],
				'hierarchyArray' 		=> $hierarchyArray,
				'hierarchy' 			=> count($hierarchyArray),
				'cate_name'				=> $resValue['cate_name']
			];
		}
		$data = [
            'status' => '200',
			'items' => $pageData
		];
		return response()->json($data);
	}

	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------

	//判斷是否有子元素-----------------------------------
    public function judgeHasChild(Request $request){
		$selectLangItem = $request->get('selectLangItem');
		$productNum = $request->get('productNum');

		$tagId	= $request->get('tagId');
		$classPid	= $request->get('pid');
		$classLevel	= $request->get('level');

		$items	   = $this->mainRepository->hierarchy($selectLangItem ,$productNum);
		$treeIdArr = $this->mainRepository->treeIdArr($items,$classPid,$classLevel);
		return response()->json($treeIdArr);
	}

    // delete cate_tag_id start
    public function DeleteCheck(Request $request ){
		$langId 		 = $request->get('langId');
		$productNum 	 = $request->get('productNum');	
		$ids 	 		 = $request->get('ids');	

		$completeDeletionIds =[];
		$cannotDeletedIds =[];
		foreach ($ids as $key => $cateTagId){
			$tagIntro = $this->mainRepository->getOneByTagTd($productNum ,$cateTagId);
			$noCount 	= $this->mainRepository->searchSingleLowerclass( $tagIntro['hierarchy_count'] , $tagIntro['cate_tag_id'] );	 // tag是否有下階層 
			if($noCount == 0){			
				$showProAll 	= $this->mainRepository->showProAll($langId,$cateTagId);			//tag是否掛商品數量
				if($showProAll == 0){	
					DB::beginTransaction();
					$res = $this->mainRepository->deleteCateTagIdAndProCateTagId(  $cateTagId );
					if ($res == 0) {
						DB::commit();

					}else {
						array_push($cannotDeletedIds, $tagIntro['cate_name']  );
						DB::rollback();
					}

					array_push($completeDeletionIds, $tagIntro['cate_name']  ); 
					// Delete Features
				}else{
					array_push($cannotDeletedIds, $tagIntro['cate_name']  ); 
				}
			}else{
				array_push($cannotDeletedIds, $tagIntro['cate_name']  );
			}
		}
		
		$data = [
			'completeDeletionIds'	=>  $completeDeletionIds,
			'cannotDeletedIds'		=>$cannotDeletedIds
        ];

		return response()->json($data);
	}
    // delete cate_tag_id end
}



