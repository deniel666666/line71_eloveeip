<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ProductApiController;

class ProfileMarqueeComposer 
{
	protected $productApiController;
	public function __construct(ProductApiController $productApiController)
	{
		$this->productApiController = $productApiController;
	}

	public function compose(View $view)
	{	
		$routeData = app('request')->route()->getAction();
		// dump($routeData);
		$langId = isset($routeData['langeId']) ? $routeData['langeId'] : 1;
		
		// 跑馬燈    	
		$request_obj = new Request([
		    'langId' => $langId,
		    'promote' => 1,
		]);
		$products = $this->productApiController->showProductsClient($request_obj, $productNum=3);
		$view->with('marquees', $products['items']);
		// dump($products['items']);
	}
}