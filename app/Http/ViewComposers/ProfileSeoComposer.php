<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Repositories\SeoRepository;

class ProfileSeoComposer
{
	protected $seoRepository;
	public function __construct(SeoRepository $seoRepository)
	{
		$this->seoRepository = $seoRepository;
	
	}

	public function compose(View $view)
	{	
		$routeData = app('request')->route()->getAction();
		// dump($routeData);
		$langId = isset($routeData['langeId']) ? $routeData['langeId'] : 1;
		$seo = $this->seoRepository->getOne($langId)->toArray();
		$seo['host_url'] = $_SERVER['HTTP_HOST'];
		$view->with('seo', $seo);

	}
}