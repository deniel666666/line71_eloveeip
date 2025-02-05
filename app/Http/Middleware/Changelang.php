<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class Changelang
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

        $changelang = Session::get('changelang');
        if(!$changelang){
            Session::put('changelang', true);

            $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            $routeData = app('request')->route()->getAction();
            $langId = isset($routeData['langeId']) ? $routeData['langeId'] : 1;

            $uri = '';
            if($lang=='zh' && $langId!='1'){ /*使台灣瀏覽器 但看的語言不是繁體*/
                $uri = explode('/', $_SERVER['REQUEST_URI']);
                $uri = array_slice($uri, 2);
                $uri = '/'.implode('/', $uri);
            }

            if($uri){
                return redirect($uri);
            }
        }

        return $next($request);
    }
}

