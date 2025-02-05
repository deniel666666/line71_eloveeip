<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Cms\CmsApiController;

class ProfilePublicCmsComposer 
{
	protected $cmsApiController;
	public function __construct(CmsApiController $cmsApiController)
	{
		$this->cmsApiController = $cmsApiController;
	}

	public function compose(View $view)
	{	
		$routeData = app('request')->route()->getAction();
		// dump($routeData);
		$langId = isset($routeData['langeId']) ? $routeData['langeId'] : 1;
		
		// 聯絡資料
		$request_obj = new Request([]);
		$cmsPublic = $this->cmsApiController->clientShowCmsByTypeId($request_obj, $cmsTypeId=1)['cms'];

        foreach ($cmsPublic as $key => $value) {
            $b = '<body>';

            $text = $value['cont']['text'];

            $start = strpos($text, '<body>');
            $end = strpos($text, '</body>');

            $real_text = substr($text, $start + strlen($b), $end - $start - (strlen($b) + 1));

            $cmsPublic[$key]['cont']['text'] = $real_text;
        }

		$view->with('cmsPublic', $cmsPublic);
		// dump($cmsPublic);
	}
}