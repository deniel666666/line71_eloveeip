<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Repositories\PropertyTagRepository;



use App\Helpers\AppHelper;

use App\Repositories\SortOrderRepository;





class PropertyTagApiController extends Controller



{



    protected $PropertyTagRepository;



	public function __construct(

		PropertyTagRepository $propertyTagRepository

	){

		$this->mainRepository = $propertyTagRepository;

	}







	public function save(Request $request){



		$item = $request->input('item');

		$id = $item['prop_tag_id'];

		$treesSelect = $item['treesSelect'];

		$updateDate=[];

        foreach ($treesSelect as $key => $value) {

            array_push($updateDate,['prop_tag_id'=>$id ,'cate_tag_id'=> $value]  );

		}

		unset($item['prop_tag_id']);

		unset($item['lang']);

		unset($item['created_at']);

		unset($item['updated_at']);

		unset($item['prop_tag_status_name']);

		unset($item['treesSelect']);

		unset($item['itemColor']);

		unset($item['prop_type_name']);



		// order increase start

        $SortOrderRepository = new SortOrderRepository();

        $retData = $SortOrderRepository->productPropertyTagSort($item, $id);

        // order increase end

		$this->mainRepository->edit($id,$item);

		$this->mainRepository->editHasCategoryTags($id,$updateDate);



		$data = [

			'status'=> 200

		];



		return response()->json($data);



	}







    public function show(Request $request){



		$selectLangItem = $request->get('selectLangItem');

		$searchByText = $request->get('searchByText');

		$currentPage	= $request->get('currentPage');

		$countOfPage	= $request->get('countOfPage');

		$startIndex = $currentPage * $countOfPage - $countOfPage;

		$items = $this->mainRepository->get($selectLangItem,$startIndex,$countOfPage,$searchByText);

		$count = $this->mainRepository->count($selectLangItem,$searchByText);

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


    public function showId(Request $request,$propertyTagId){

		$selectLangItem = $request->get('selectLangItem');

		$searchByText = $request->get('searchByText');

		$currentPage	= $request->get('currentPage');

		$countOfPage	= $request->get('countOfPage');

		$startIndex = $currentPage * $countOfPage - $countOfPage;

		$items = $this->mainRepository->getId($selectLangItem,$startIndex,$countOfPage,$searchByText,$propertyTagId);



        foreach ($items as $key => $value) {

			$items[$key]['treesSelect'] = $this->mainRepository->showHasCateTagId($value['prop_tag_id']);

			// return $this->mainRepository->showHasCateTagId($value['prop_tag_id']); 

		}

		$count = $this->mainRepository->countId($selectLangItem,$searchByText,$propertyTagId);

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

		$treesSelect = $item['treesSelect'];

		unset($item['treesSelect']);

		if(empty($item['prop_tag_order'])){

			$item['prop_tag_order'] = 0;

		}

		

		// order increase start

		$SortOrderRepository = new SortOrderRepository();

		$retData = $SortOrderRepository->productPropertyTagSort($item);

		// order increase end



		$item = $this->mainRepository->add($item);



		$id=$item['prop_tag_id'];

		$updateDate=[];

        foreach ($treesSelect as $key => $value) {

            array_push($updateDate,['prop_tag_id'=>$id ,'cate_tag_id'=> $value]);

		}

		

		$this->mainRepository->editHasCategoryTags($id,$updateDate);



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

		$updData['prop_tag_status'] = $request->input('status');

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



