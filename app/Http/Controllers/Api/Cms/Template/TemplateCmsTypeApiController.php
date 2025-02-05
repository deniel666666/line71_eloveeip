<?php
namespace App\Http\Controllers\Api\Cms\Template;

use Illuminate\Http\Request;
use \File;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
class TemplateCmsTypeApiController extends Controller
{
	private $cmsTypeRepository;
    protected $upload_file_path;

	public function __construct(
							$cmsTypeRepository,
							$public_file_target
	){
		$this->cmsTypeRepository	= $cmsTypeRepository;
		$this->upload_file_path		= '/upload/cms/'.$public_file_target.'/';
	}

	public function typeAdd(Request $request){
		$cms_type_name 		= $request->input('item.cms_type_name');
		$item = $request->get('item');
		
		$user = Session::get('user');
		$item['own_user'] = $user['id'];
		$item['create_user'] = $user['id'];
		
		$addCmsTypeId = $this->cmsTypeRepository->add($item);
		$file = public_path($this->upload_file_path.$addCmsTypeId);
		// dump($file);exit;
		if (!File::exists($file)) {
			$addFile = File::makeDirectory($file, 0775);
		}
		$data = [
			'status'	=> 200,
			'id'	=> $addCmsTypeId
		];
		return response()->json($data);
	}

	public function save(Request $request){
		$id = $request->input('item.id');
		$item = $request->input('item');
		unset($item['lang']);
		unset($item['cms']);
		unset($item['id']);		
		unset($item['created_at']);
		unset($item['updated_at']);
		unset($item['selected']);
		$addCmsTypeId = $this->cmsTypeRepository->edit($id,$item);
		$data = [
			'status'=> 200
		];
		return response()->json($data);
	}

    public function show(Request $request){
    	$cond['primary_key']	= $request->get('primary_key');
    	$cond['primary_keys']	= $request->get('primary_keys');
		$cond['selectLangItem'] = $request->get('selectLangItem');
		$cond['searchByText'] 	= $request->get('searchByText');
		$cond['currentPage']	= (Int)$request->get('currentPage');
		$cond['countOfPage']	= (Int)$request->get('countOfPage');
		$cond['startIndex']		= $cond['countOfPage']!=0 ? ($cond['currentPage']-1) * $cond['countOfPage'] : 0;

		$user = Session::get('user');
		$cond['own_user'] = $user['id'];
		//dd($cond);
		$items = $this->cmsTypeRepository->get($cond)->toArray();
		$count = $this->cmsTypeRepository->count($cond);

		if($cond['countOfPage']!=0){
	        $pageCount = (int)($count/$cond['countOfPage']);
			if($count%$cond['countOfPage'] != 0){
				$pageCount +=1;
			}
		}else{
			$pageCount = 1;
		}

		$data = [
            'status' => '200',
			'items' => $items,
            'count' => $count,
			'pageCount' => $pageCount
		];
		return response()->json($data);
	}

	public function setStatus(Request $request){
		$updData['cate_status'] = $request->input('status');
		$ids = $request->input('ids');

		for ($i = 0; $i < count($ids); $i++) {
			$this->cmsTypeRepository->edit($ids[$i], $updData);
		}
		
		$data = [
			'status'=> 200
		];
		return response()->json($data);
	}

	public function delete(Request $request){
		$ids = $request->input('ids');
		for ($i = 0; $i < count($ids); $i++) {
			$this->cmsTypeRepository->deleteOneType($ids[$i]);
			$file = public_path($this->upload_file_path.$ids[$i]); 
			$deleteFile = File::deleteDirectory($file); 
		}
		$data = [
			'status'=> 200
		];
		return response()->json($data);
	}
}

