<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ProdSeoTagRepository;
use App\Helpers\AppHelper;
use App\Repositories\SortOrderRepository;

class ProdSeoTagApiController extends Controller
{
    protected $ProdSeoTagRepository;
	public function __construct(ProdSeoTagRepository $prodSeoTagRepository){
		$this->mainRepository = $prodSeoTagRepository;
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
		$retData = $SortOrderRepository->productSeoTagSort($item);
		// order increase end
		$this->mainRepository->add($item);
		$data = [
			'status'=> 200
		];
		return response()->json($data);

	}

	public function save(Request $request){

		$item = $request->input('item');

		$upData = [
			'seo_prod_num' 		=> $item['seo_prod_num'],
			'seo_name' 			=> $item['seo_name'],
			'seo_meta_property' => $item['seo_meta_property'],
            'seo_placeholder' 	=> $item['seo_placeholder'],
			'seo_type' 			=> $item['seo_type'],
			'seo_tag_order' 	=> $item['seo_tag_order'],
			'seo_status' 		=> $item['seo_status'],
			'lang_id' 			=> $item['lang_id'],
		];

		$id = $item['seo_tag_id'];

		// order increase start
		$SortOrderRepository = new SortOrderRepository();
		$retData = $SortOrderRepository->productSeoTagSort($upData, $id);
		// order increase end

		$this->mainRepository->edit($id,$upData);
		$data = [
			'status'=> 200
		];
		return response()->json($data);
	}


	public function delete(Request $request){
		$this->mainRepository->delete($request->input('ids'));
		$data = [
			'status'=> 200
		];
		return response()->json($data);
	}


	public function setStatus(Request $request){
		$updData['seo_status'] = $request->input('status');
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

