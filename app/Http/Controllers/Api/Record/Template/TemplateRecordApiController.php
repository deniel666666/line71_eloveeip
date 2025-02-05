<?php

namespace App\Http\Controllers\Api\Record\Template;
use App\Http\Controllers\Controller;

use App\Helpers\AppHelper;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class TemplateRecordApiController extends Controller
{
	protected $recordModel;
	protected $target_user;
	public function __construct($recordModel, $target_user)
	{
		$this->recordModel = $recordModel;
		$this->target_user = $target_user;
	}

	/*修改數量*/
	public function changeCount(Request $request){

		$model_name = $request->get('model_name');
		$primary_id = $request->get('primary_id');
		$method 	= $request->get('method');
		$lang_id 	= $request->get('lang_id') ? $request->get('lang_id') : 1;
		$user_id 	= Session::get($this->target_user.'.id') ? Session::get($this->target_user.'.id') : 0;

		/*檢查傳入值*/
		if(!$model_name || $model_name=='null'){ return response(['status'=>500, 'msg'=>'請提供資料表名稱']); }
		if(!$primary_id || $primary_id=='null'){ return response(['status'=>500, 'msg'=>'請提供主鍵值']); }
		if(!$method || $method=='null'){ return response(['status'=>500, 'msg'=>'請提供操作方式']); }

		/*取得使用者ip*/
		$ip = AppHelper::instance()->get_clinet_ip();

		/*根據方法操作加減*/
		if($method=='+'){
			$this->recordModel->create([
				'model' 		=> $model_name,
				'primary_id' 	=> $primary_id,
				'user_id' 		=> $user_id,
				'ip'			=> $ip,
				'lang_id'		=> $lang_id,
			]);
		}elseif ($method=='-') {
			$this->recordModel->where('model','=',$model_name)
							->where('primary_id','=',$primary_id)
							->where('user_id','=',$user_id)
							->limit(1)->orderBy('id','desc')->delete();
		}else{
			return response()->view('errors.404', [], 500);
		}

		$count = $this->getRecordCount($model_name, $primary_id, $lang_id);
		return ['status'=>200, 'msg'=>"成功", 'count'=>$count];
	}
	/*取得筆數*/
	public function getRecordCount($model_name, $primary_id, $lang_id){
		$count = (int)$this->recordModel->where('model','=',$model_name)
									->where('primary_id','=',$primary_id)
									->where('lang_id','=',$lang_id)
									->count();
		return $count;
	}
}
