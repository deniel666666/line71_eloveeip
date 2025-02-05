<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ProdLabelTagRepository;


use App\Helpers\AppHelper;

use Illuminate\Support\Facades\Storage;
use \File;
use \DB;
use App\Services\FileService;
use App\Repositories\SortOrderRepository;


class ProdLabelTagApiController extends Controller
{

    protected $publicFilePath =  '/public/upload/prodLabel/';
    protected $uploadFilePath =  '/upload/prodLabel/';

    protected $ProdLabelTagRepository;
	public function __construct(ProdLabelTagRepository $prodLabelTagRepository){
		$this->mainRepository = $prodLabelTagRepository;
	}



    public function show(Request $request,$productNum){
		$selectLangItem = $request->get('selectLangItem');
		$searchByText = $request->get('searchByText');
		$currentPage	= $request->get('currentPage');	//1
        $countOfPage	= $request->get('countOfPage'); //顯示2
		$startIndex = $currentPage * $countOfPage - $countOfPage; //第幾個開始
		$items = $this->mainRepository->getId($selectLangItem,$startIndex,$countOfPage,$searchByText,$productNum);
		$count = $this->mainRepository->countId($selectLangItem,$searchByText,$productNum);
        $pageCount = (int)($count/$countOfPage);
		if($count%$countOfPage != 0){
			$pageCount +=1;
		}
		$langs = AppHelper::instance()->getAllLangs();
		$editLangs = AppHelper::instance()->getAllLangsByOrder();
		$data = [
            'status' => '200',
			'langs' => $langs ,
			'editLangs' => $editLangs,
			'items' => $items,
            'count' => $count,
			'pageCount' => $pageCount
		];
		return response()->json($data);
	}




	public function add(Request $request){
		$item = $request->get('item');

		// order increase start
		$SortOrderRepository = new SortOrderRepository();
		$retData = $SortOrderRepository->productLabelTagSort($item);
		// order increase end
        DB::beginTransaction();
        unset($item['label_img']);
        $fileId = $this->mainRepository->add($item);
        if(!empty($fileId)){
            $updateImgItem =$request->get('item');
            if (!File::exists(base_path().$this->publicFilePath.$fileId)) {
                File::makeDirectory(base_path().$this->publicFilePath.$fileId, 0775);
            }
            if(!empty($updateImgItem['label_img']) ){
                $img = $updateImgItem['label_img'];
                $fileName = AppHelper::instance()->renameFile( $updateImgItem['label_img'] );
                $ext = explode('.', $fileName);
                $ext = end($ext);
                $saveFileName = 'file_'.date("Y-m-d", time()).'_'.substr( sha1(uniqid(time(), true))  ,0 , 10 ).'.'.$ext;
                $itemImgName=$this->publicFilePath.$fileId.'/'.$saveFileName;
                AppHelper::instance()->uploadFile($this->publicFilePath.$fileId, $saveFileName, $img);
    
                $this->mainRepository->editImg($fileId,['label_img'=> $itemImgName]);
            }
            DB::commit();
        }else{
            DB::rollback();
        }

		$data = [
			'status'=> 200
		];
		return response()->json($data);
	}

	public function save(Request $request){

		$item = $request->input('item');

		$id = $item['label_tag_id'];

		$upData = [
			'label_prod_num' 		=> $item['label_prod_num'],
            'label_name' 			=> $item['label_name'],
            'label_img_desc' 	    => $item['label_img_desc'],
			'label_tag_cont' 		=> $item['label_tag_cont'],
			'label_order'           => $item['label_order'],
			'label_status' 		    => $item['label_status'],
			'lang_id' 		    	=> $item['lang_id'],
		];

		if(!empty($item['label_img']) ){
			
			$img = $item['label_img'];
			$old_name = $this->mainRepository->getImgOne($id);
			if( $img != $old_name  ){
				if (!File::exists(base_path().$this->publicFilePath.$id)) {
					File::makeDirectory(base_path().$this->publicFilePath.$id, 0775);
				}
				if(!empty($old_name) ){
					AppHelper::instance()->deleteImg(base_path().$old_name);
				}
				$fileName = AppHelper::instance()->renameFile( $item['label_img'] );
				$ext = explode('.', $fileName);
				$ext = end($ext);
				$saveFileName = 'file_'.date("Y-m-d", time()).'_'.substr( sha1(uniqid(time(), true))  ,0 , 10 ).'.'.$ext;
				$itemImgName=$this->publicFilePath.$id.'/'.$saveFileName;
				AppHelper::instance()->uploadFile($this->publicFilePath.$id, $saveFileName, $img);
				$this->mainRepository->editImg($id,['label_img'=> $itemImgName]);
			}
		}

		// order increase start
		$SortOrderRepository = new SortOrderRepository();
		$retData = $SortOrderRepository->productLabelTagSort($upData, $id);
		// order increase end

		$this->mainRepository->edit($id,$upData);
		$data = [
			'status'=> 200
		];
		return response()->json($data);
	}


	public function delete(Request $request){

		$this->mainRepository->delete($request->input('ids'));
		
		$disk = Storage::disk('upload_use');
		foreach ($request->input('ids') as $id ){
			$disk->deleteDirectory('/prodLabel/'.$id);
		}

		$data = [
			'status'=> 200
		];
		return response()->json($data);
	}



	public function setStatus(Request $request){
		$updData['label_status'] = $request->input('status');
		$ids = $request->input('ids');
		// if($request->input('status') == 0){
		// 	for ($i = 0; $i < count($ids); $i++) {
		// 		$this->mainRepository->edit($ids[$i], $updData);
		// 	}
		// }else{
			$this->mainRepository->setStatus($request->input('ids'),$updData);
		// }
		$data = [
			'status'=> 200
		];
		return response()->json($data);
	}



}

