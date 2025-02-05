<?php
namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Gallery\GalleryApiController;

class ProfileFooterLinkComposer 
{
	protected $galleryApiController;
	public function __construct(GalleryApiController $galleryApiController)
	{
		$this->galleryApiController = $galleryApiController;
	}

	public function compose(View $view)
	{		
		$request_array = [
		];
    $request_obj = new Request($request_array);
		$footerLink = $this->galleryApiController->showClient($request_obj, 3)->getData();
		$view->with('footerLink', $footerLink->items);
		// dump($footerLink->items);
	}
}