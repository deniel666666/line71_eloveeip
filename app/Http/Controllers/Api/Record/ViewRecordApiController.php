<?php

namespace App\Http\Controllers\Api\Record;
use App\Http\Controllers\Api\Record\Template\TemplateRecordApiController;
use Illuminate\Http\Request;

use App\Models\Record\ViewRecordModel;
use Illuminate\Support\Facades\Session;
use App\Helpers\AppHelper;

class ViewRecordApiController extends TemplateRecordApiController
{
	public function __construct(ViewRecordModel $recordModel)
	{
		parent::__construct(
			$recordModel,
			$target_user = "customer"
		);
		$this->recordModel = $recordModel;
	}

	public function changeCount(Request $request){

		$model_name = $request->get('model_name');
		$primary_id = $request->get('primary_id');
		$method 	= $request->get('method');
		$user_id 	= Session::get($this->target_user.'.id') ? Session::get($this->target_user.'.id') : 0;	
		$lang_id 	= $request->get('lang_id') ? $request->get('lang_id') : 1;
		$ip = AppHelper::instance()->get_clinet_ip();

		$laset_record = $this->recordModel
						->where('model', '=', $model_name)
						->where('primary_id', '=', $primary_id)
						->where('user_id', '=', $user_id)
						->where('lang_id', '=', $lang_id)
						->where('ip', '=', $ip)
						->orderBy('id', 'desc')->get()->toArray();
		if($laset_record){
			$laset_record = $laset_record[0];
			$diff = strtotime(date('Y-m-d H:i:s')) - strtotime($laset_record['created_at']);
			if($diff/60 <5){ // 同ip距離上次瀏覽5分鐘內將不會產生新的瀏覽紀錄
				$count = parent::getRecordCount($model_name, $primary_id, $lang_id);
				return ['status'=>200, 'msg'=>"成功", 'count'=>$count];
			}
		}

		// 新增紀錄
		$request_array = $request->all();
		$request_array['method'] = '+';
		$request_array['count'] = 1;
		$request_obj = new Request($request_array);
		$result = parent::changeCount($request_obj);

		return $result;
	}
}
