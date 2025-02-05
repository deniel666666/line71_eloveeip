<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Storage;
use Illuminate\Http\Request;
use App\Repositories\sampleRepository;

class SampleApiController extends Controller
{
	protected $uploadPath = "/public/upload/sample/";

	protected $sampleRepository;

	public function __construct(SampleRepository $sampleRepository){
		$this->sampleRepository = $sampleRepository;
	}

	public function index(Request $request){

	}

	public function show(Request $request,$id){
		$res = $this->sampleRepository->show($id);

		$retData = ['status' => '200'];

		return $retData;
	}

	public function create(Request $request) {

		$insData = $request;

		$insId = $this->sampleRepository->create($insData);

		return $insId;
	}

	public function update(Request $request,$id){

		$updData = $request;

		$this->sampleRepository->update($id,$updData);

		$retData = ['status' => '200'];

		return $retData;
	}

	public function destroy(Request $request,$id){

		$retData = ['status' => '200'];

		return $retData;
	}

	//------------------------------
	// Multiple Using foreach ()
	//------------------------------
	public function multiUpdate(Request $request){

		$items = $request->get('items');

		foreach($items as $itemKey => $itemValue){
			$this->sampleRepository->update($itemValue['id'],$itemValue);
		}

		$retData = ['status' => '200'];

		return $retData;
	}

	public function multiDestroy(Request $request){

		$items = $request->get('items');

		foreach($items as $itemKey => $itemValue){
			$this->sampleRepository->delete($itemValue['id']);
		}

		$retData = ['status' => '200'];

		return $retData;
	}

	//---------------------------
	// Batch Using Where In
	//---------------------------
	public function batchUpdate(Request $request){

		$ids = $request->get('ids');

		$updData = $request->get('updData');

		$this->sampleRepository->batchUpdate($ids,$updData);

		$retData = ['status' => '200'];

		return $retData;
	}

	public function batchDestroy(Request $request){

		$ids = $request->get('ids');

		$this->sampleRepository->batchDestroy($ids);

		$retData = ['status' => '200'];

		return $retData;
	}

	//------------------------------
	// Dedicate Function
	//------------------------------
	public function page(Request $request){

		$currentPage	= $request->get('currentPage');
		$countOfPage	= $request->get('countOfPage');

		$pageParam = [
			'currentPage'	=> $currentPage,
			'countOfPage'	=> $countOfPage,
		];

		$res		= $this->sampleRepository->page($pageParam);
		$totalItem	= $this->sampleRepository->itemCount($pageParam);

		$retData 	= ['pageData'=>$res,'totalPage'=>$totalItem];
		return $retData;
	}
}
