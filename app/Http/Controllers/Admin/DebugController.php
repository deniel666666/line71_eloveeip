<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DebugController extends Controller
{
	public function index (Request $request) {

//		$viewData['pageTitle'] = 'Debug';
//
//		return view("admin.debug",$viewData);

		$cart = [];
		$cart['cartage']	= 80;
		$cart['free'] 		= 30;
		$cart['item'][0]['sku'] 	= 'wallet';
		$cart['item'][0]['price'] 	= '99';
		$cart['item'][0]['qty'] 	= 2;
		$cart['item'][1]['sku'] 	= 'dress';
		$cart['item'][1]['price'] 	= '299';
		$cart['item'][1]['qty'] 	= 1;


		function recursion($item){
			$x = $item;
			if (is_array($item)){
				foreach ($item as $key => $value){
					recursion($value);
				}
			}else{
				echo $item."<br>";
			}
		}

		recursion($cart);
	}
}
