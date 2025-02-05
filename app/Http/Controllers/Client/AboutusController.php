<?php



namespace App\Http\Controllers\Client;



use Illuminate\Http\Request;

use App\Http\Controllers\Controller;



//----------------------------------------------------------------------------------------------



use App\Http\Controllers\Api\Gallery\GalleryApiController;

use App\Http\Controllers\Api\Cms\CmsTypeApiController;

use App\Http\Controllers\Api\Cms\CmsApiController;

use App\Http\Controllers\Api\ProductApiController;

use App\Http\Controllers\Api\CategoryTagApiController;

use App\Http\Controllers\Api\AllPagesController;

use App\Http\Controllers\Api\MiscellaneousApiController;



class AboutusController extends Controller

{

    public function __construct(

		GalleryApiController		$galleryApiController,

		CmsTypeApiController		$cmsTypeApiControlle,

		CmsApiController			$cmsApiController,

		ProductApiController		$productApiController,

		CategoryTagApiController	$categoryTagApiController,

		AllPagesController			$allPagesController,

		MiscellaneousApiController  $miscellaneousApiController

	){

		parent::__construct();

		$this->galleryApiController			= $galleryApiController;

		$this->cmsTypeApiControlle			= $cmsTypeApiControlle;

		$this->cmsApiController				= $cmsApiController;

		$this->productApiController			= $productApiController;

		$this->categoryTagApiController		= $categoryTagApiController;

		$this->allPagesController			= $allPagesController;

		$this->miscellaneousApiController	= $miscellaneousApiController;



		$this->viewData['active_menu'] = 'about_us';

	}

	// parent::deal_pages($currentPage, $totalPage)		處理分頁

	// parent::http_request($request_url, $post_data)	請求外部資料

	// abort(404, msg)									錯誤訊息+跳轉



    public function about_us (Request $request, $id='') {

    	$productNum = 1;



    	// 介紹列表

	    	$request_obj = new Request([

			    'langId' =>  1,

			]);

			$products = $this->productApiController->showProductsClient($request_obj, $productNum);

			if(!$products['items']){ /*如果沒有介紹文章*/

				return redirect('/about_us_contact.html'); /*跳轉至聯絡我們-回函頁面*/

			}

			$this->viewData['products'] = $products['items'];



    	// 介紹詳細內容

	    	if($id==""){ /*未提供id*/

	    		$id = $products['items'][0]['prod_id']; /*預設開啟排序第一個的文章*/

	    	}

	    	$product_one = $this->productApiController->showProductOne($request_obj, $id);

	    	if(!$product_one['item']){

	    		abort(404, "無此介紹頁面");

	    	}

	    	$this->viewData['product_one'] = $product_one;

	    	$this->viewData['id'] = $id;



    	// seo設定

	    	if($product_one['seo'][0]['prod_prop']){

		    	$this->viewData['web_title'] = $product_one['seo'][0]['prod_prop'];

		    	$this->viewData['fb_title'] = $product_one['seo'][0]['prod_prop'];

	    	}

	    	if($product_one['seo'][1]['prod_prop']){

	    		$this->viewData['web_keywords'] = $product_one['seo'][1]['prod_prop'];

	    	}

	    	if($product_one['seo'][2]['prod_prop']){

		    	$this->viewData['web_description'] = $product_one['seo'][2]['prod_prop'];

		    	$this->viewData['fb_description'] = $product_one['seo'][2]['prod_prop'];	

	    	}



		// dump($this->viewData);

		return view("client.about_us", $this->viewData);

    }





    public function contact (Request $request, $id='') {

    	$productNum = 1;



    	// 介紹列表

	    	$request_obj = new Request([

			    'langId' =>  1,

			]);

			$products = $this->productApiController->showProductsClient($request_obj, $productNum);
			$this->viewData['products'] = $products['items'];



    	// seo設定

    		$seoCms = $this->cmsApiController->clientShowCmsByTypeId($request, $cmsTypeId=9)['cms'][0];

	    	if($seoCms['template']['about_contact_title']){

		    	$this->viewData['web_title'] = $seoCms['template']['about_contact_title'];

		    	$this->viewData['fb_title'] = $seoCms['template']['about_contact_title'];

	    	}

	    	if($seoCms['template']['about_contact_keyword']){

	    		$this->viewData['web_keywords'] = $seoCms['template']['about_contact_keyword'];

	    	}

	    	if($seoCms['template']['about_contact_description']){

		    	$this->viewData['web_description'] = $seoCms['template']['about_contact_description'];

		    	$this->viewData['fb_description'] = $seoCms['template']['about_contact_description'];	

	    	}



		// dump($this->viewData);

		return view("client.about_us_contact", $this->viewData);

    }

}



