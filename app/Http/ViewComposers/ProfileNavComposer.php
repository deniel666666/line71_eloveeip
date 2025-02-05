<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use \DB;

class ProfileNavComposer
{
	protected $seoRepository;
	public function __construct()
	{
	}

	public function compose(View $view)
	{	
		// 語言版
			$routeData = app('request')->route()->getAction();
			$langId = isset($routeData['langeId']) ? $routeData['langeId'] : 1;
			$view->with('langId', $langId);

            $lang_menu = [];
            $lang_type = "";
            $lang = DB::table('lang')->where('lang_id', '=', $langId)->get()->toArray();
            if($lang){
            	$lang_menu = $lang[0]->menu ? json_decode($lang[0]->menu, true) : [];
            	$lang_type = $lang[0]->lang_type ? '/'.$lang[0]->lang_type : "";
            }
			$view->with('lang_menu', $lang_menu);
			$view->with('lang_type', $lang_type);
            // dump($lang_menu);
		
		// 購物車網址
			// $view->with('SHOP_URL', env('SHOP_URL_'.$langId));


        // 請求商品搜尋選單
        	// $url = env('SHOP_URL_'.$langId).'/index/ajax/get_prod_search_menu.html';
	        // $curl = curl_init();  
	        // curl_setopt($curl, CURLOPT_URL, $url);  
	        // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	        // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	        // $prod_search_menu = curl_exec($curl);  
	        // $view->with('prod_search_menu', $prod_search_menu);
	        // curl_close($curl);
	}
}