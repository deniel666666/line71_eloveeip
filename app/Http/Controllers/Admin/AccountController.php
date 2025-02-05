<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
	public function index (Request $request) {
		$viewData['pageTitle'] = '帳號管理';
		$viewData['sysCollapse'] = "show";
		$viewData['accountActive'] = "active";

		return view("admin.account.account",$viewData);
	}

	public function account_do_log(Request $request){
		$viewData['pageTitle'] = '帳號操作紀錄';
		$viewData['sysCollapse'] = "show";
		$viewData['account_do_logActive'] = "active";

		$account_do_log = DB::table('account_do_log')
								->join('account', 'account.id', '=', 'account_do_log.user_id') /*只看有user的操作紀錄*/
								// ->leftJoin('account', 'account.id', '=', 'account_do_log.user_id') /*所有操作紀錄*/
								->orderBy('account_do_log.id', 'desc')
								->select('account_do_log.*', 'account.acct', 'account.user_name')
								->get()->toArray();
		$viewData['account_do_log'] = $account_do_log;
		foreach ($account_do_log as $key => $value) {
			date_default_timezone_set('Asia/Taipei'); /*調整 date判斷的時區*/
			$account_do_log[$key]->datetime = $value->datetime ? date("Y-m-d H:i", $value->datetime) : "";
		}

		return view("admin.account.account_do_log",$viewData);
	}
}
