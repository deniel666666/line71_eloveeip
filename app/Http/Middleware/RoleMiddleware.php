<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\AccountService;

class RoleMiddleware
{
	private $accountService;
	public function __construct(AccountService $accountService){
		$this->accountService = $accountService;
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
		$allowedRoles = array_slice(func_get_args(), 2);
		$canAccess = $this->accountService->hasRole($allowedRoles);

		$currentUrl = url()->current();
		$urlArr = explode('/',$currentUrl);

		if ($urlArr[3] == 'admin'){
			return $canAccess ? $next($request) : redirect('/admin/login');
		}else{
			return $canAccess ? $next($request) : redirect('/login');
		}
	}
}