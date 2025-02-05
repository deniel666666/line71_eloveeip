<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class AdminMiddleware
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
		$userSes = Session::get('user');

		$userRole = $userSes['role'];
		$roleSeach = array_search('admin',$userRole);

		if ($userSes){
			if ($roleSeach===false){
				$canAccess = false;
			}else{
				$canAccess = true;
			}
		}else{
			$canAccess = false;
		}

		return $canAccess ? $next($request) : redirect('/admin/login');
    }
}

