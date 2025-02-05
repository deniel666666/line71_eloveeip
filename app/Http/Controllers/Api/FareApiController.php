<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use App\Repositories\FareRepository;
use App\Helpers\AppHelper;

class FareApiController extends Controller
{
    protected $fareRepository;
    public function __construct(FareRepository $fareRepository)
    {
        $this->mainRepository = $fareRepository;
    }

    public function save(Request $request)
    {
        $item = $request->input('item');
        $id = $item['fare_id'];
        unset($item['fare_id']);
        unset($item['lang']);
        unset($item['lang_id']);
        unset($item['itemColor']);
        unset($item['created_at']);
        unset($item['updated_at']);
        $this->mainRepository->edit($id, $item);
        $data = [
            'status'=> 200
        ];

        return response()->json($data);
    }

    public function changeMultiStatus(Request $request)
    {
        $updData['fare_status'] = $request->input('status');
        $this->mainRepository->setMultiStatus($request->input('ids'), $updData);
        $data = [
            'status'=> 200
        ];
        return response()->json($data);
    }

    public function setStatus(Request $request)
    {
        $fareId = $request->input('fareId');
        $status = $request->input('status');
        $type = $request->input('type');
        $updateData = [ $type => $status];
        $this->mainRepository->setStatus($fareId, $updateData);
        $data = [
            'status'=> 200
        ];
        return response()->json($data);
    }

    public function show(Request $request)
    {
        $selectLangItem = $request->get('selectLangItem');
        $searchByText = $request->get('searchByText');
        $currentPage	= $request->get('currentPage');
        $countOfPage	= $request->get('countOfPage');
        $startIndex = $currentPage * $countOfPage - $countOfPage;
        $items = $this->mainRepository->get($selectLangItem, $startIndex, $countOfPage, $searchByText);
        $count = $this->mainRepository->count($selectLangItem, $searchByText);
        $pageCount = (int)($count/$countOfPage);

        if ($count%$countOfPage != 0) {
            $pageCount +=1;
        }
        $langs = AppHelper::instance()->getAllLangs();
        $data = [
            'status' => '200',
            'langs' => $langs ,
            'items' => $items,
            'count' => $count,
            'pageCount' => $pageCount
        ];

        return response()->json($data);
    }

    public function add(Request $request)
    {
        $item = $request->get('item');
        $this->mainRepository->add($item);
        $data = [
            'status'=> 200
        ];
        return response()->json($data);
    }
 
    public function delete(Request $request)
    {
        $this->mainRepository->delete($request->input('ids'));
        $data = [
            'status'=> 200
        ];
        return response()->json($data);
    }
}

