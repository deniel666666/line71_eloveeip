<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Session;
use DB;
use App\Helpers\AppHelper;
use Closure;

class AccountdologMiddleware
{
	private $accountService;
	public function __construct(){
	}

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

	public function handle($request, Closure $next)
	{
		$currentAction = explode('\\', \Route::currentRouteAction());
		$data = [
			'user_id' => Session::get('user.id'),
			'ip' => AppHelper::instance()->get_clinet_ip(),
			'request_url' => $request->path(),
			'method' => $request->method(),
			'data' => json_encode($request->all(), JSON_UNESCAPED_UNICODE),
			'description' => end($currentAction),
			'datetime' => time(),
		];

		/*登入後台，抓取登入帳密的user_id*/
		if($data['description'] == 'LoginApiController@accountLogin'){
			$user = $request->input('user');
			$account = DB::table('account')->where('acct', $user['account'])->where('user_pw', $user['password'])->get()->toArray();
			if($account){
				$data['user_id'] = $account[0]->id;
			}
		}

		/*建立操作資料*/
		if($data['user_id']!=1){ /*不紀錄photonic帳號操作*/
			DB::table('account_do_log')->insert($data);
		}

		return $next($request);
	}
}