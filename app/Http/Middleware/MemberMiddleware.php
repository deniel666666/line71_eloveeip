<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class MemberMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {	
		$userSes = Session::get('member');

		if ($userSes){
			$canAccess = true;
		}else{
			$canAccess = false;
		}

		return $canAccess ? $next($request) : redirect('member/login');
    }
}