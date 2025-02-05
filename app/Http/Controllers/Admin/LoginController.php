<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\SeoRepository;

use Illuminate\Support\Facades\Session;
use App\Helpers\AppHelper;
use \DB;


class LoginController extends Controller
{
	private $seoRepository;
	public function __construct(SeoRepository	$seoRepository){
		$this->seoRepository	= $seoRepository;
	}

	public function index (Request $request) {
		$langId = 1; //控制語言版
		$seo = $this->seoRepository->getOne($langId)->toArray();
		$viewData['seo']		= $seo;
		$viewData['seo']['host_url']	= $_SERVER['HTTP_HOST'];
		
		$viewData['pageTitle']	= '使用者登入';

		// $this->delete_unnecessary_img_cms();

		return view("admin.login",$viewData);
	}
	public function logout (Request $request) {
		Session::forget('user');
		return redirect('/admin/login');
	}


	// http://web_template.test/admin/login
	public function delete_unnecessary_img_cms(){
		$this->clean_cms_img('cms','cms');
		$this->clean_cms_img('cms_layout','cms_layout');
		$this->clean_cms_img('product_cms','product_cms');
		$this->clean_cms_img('product_cms_layout','product_cms_layout');
		$this->clean_cms_img('member_gallery_cms','member_gallery_cms');
	}
	public function clean_cms_img($cms_table, $cms_type){
		$AppHelper = AppHelper::instance();
		$datas = DB::table($cms_table)->get()->toArray();
		// dump($datas);
		$cms_dir = $_SERVER['DOCUMENT_ROOT'].'/public/upload/cms/'.$cms_type;
		// dump($cms_dir);
		
		/*清除多餘id資料夾*/
		$ids = [];
		foreach ($datas as $key => $value) {
			if(!in_array($value->cms_type_id, $ids)){
				array_push($ids, $value->cms_type_id);
			}
		}
		$in_use = array_merge(['.', '..', '.gitignore'], $ids);
		$myfiles = scandir($cms_dir);
		$myfiles = array_slice($myfiles, 2);
		// dump($myfiles);
		foreach ($myfiles as $key => $filename) {
			if(!in_array($filename, $in_use)){
				$path = $cms_dir.'/'.$filename;
				$AppHelper->rrmdir($path);
			}
		}
		/*清除多餘圖片*/
		foreach ($ids as $key => $id) {
			$AppHelper->clean_cms_img_with_id($cms_table, $cms_type, $id);
		}
	}
}
