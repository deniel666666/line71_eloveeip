<?php

namespace App\Http\Controllers\Api\Record;
use App\Http\Controllers\Api\Record\Template\TemplateRecordApiController;
use Illuminate\Http\Request;

use App\Models\Record\LoveRecordModel;

class LoveRecordApiController extends TemplateRecordApiController
{
	public function __construct(LoveRecordModel $recordModel)
	{
		parent::__construct(
			$recordModel,
			$target_user = "customer"
		);
	}

	public function changeCount(Request $request){
		$request_array = $request->all();
		$request_array['count'] = 1;
		$request_obj = new Request($request_array);

		$result = parent::changeCount($request_obj);
		return $result;
	}
}
