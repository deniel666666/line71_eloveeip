<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ProdTabsRepository;
use App\Helpers\AppHelper;

use Illuminate\Support\Facades\Storage;
use \File;
use \DB;
use App\Services\FileService;
use App\Repositories\SortOrderRepository;


class ProdTabsApiController extends Controller
{

    protected $publicFilePath =  '/public/upload/prodTabs/';
    protected $uploadFilePath =  '/upload/prodTabs/';

    protected $ProdTabsRepository;
	public function __construct(ProdTabsRepository $prodTabsRepository){
		$this->mainRepository = $prodTabsRepository;
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
		$retData = $SortOrderRepository->productTabsSort($item);
		// order increase end
        $fileId = $this->mainRepository->add($item);
		$data = [
			'status'=> 200
		];
		return response()->json($data);
	}

	public function save(Request $request){

		$item = $request->input('item');

		$id = $item['tabs_tag_id'];

		$upData = [
			'tabs_prod_num' 		=> $item['tabs_prod_num'],
            'tabs_name' 			=> $item['tabs_name'],
			'tabs_order'           => $item['tabs_order'],
			'tabs_status' 		    => $item['tabs_status'],
			'lang_id' 		    	=> $item['lang_id'],
		];

		// order increase start
		$SortOrderRepository = new SortOrderRepository();
		$retData = $SortOrderRepository->productTabsSort($item, $id);
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
		// foreach ($request->input('ids') as $id ){
		// 	$disk->deleteDirectory('/prodTabs/'.$id);
		// }
		$data = [
			'status'=> 200
		];
		return response()->json($data);
	}



	public function setStatus(Request $request){
		$updData['tabs_status'] = $request->input('status');
		$ids = $request->input('ids');
        $this->mainRepository->setStatus($request->input('ids'),$updData);
		$data = [
			'status'=> 200
		];
		return response()->json($data);
	}



}

