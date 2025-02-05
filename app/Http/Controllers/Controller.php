<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Repositories\SeoRepository;

class Controller extends BaseController
{
    public $langId;
    public $viewData;
    public function __construct(){
        $routeData = app('request')->route()->getAction();
        $langId = isset($routeData['langeId']) ? $routeData['langeId'] : 1;
        $this->langId = $langId;
        $this->viewData = [ 'langId' => $this->langId ];
    }

    // 設定頁面SEO
    public function set_page_seo($request, $prefix=''){
        $seoCms = $this->cmsApiController->clientShowCmsByTypeId($request, $cmsTypeId=2)['cms'];
        // dump($seoCms);exit;
        if (count($seoCms) == 0) {
            $this->viewData['web_title'] = '';
            $this->viewData['fb_title'] = '';
            $this->viewData['web_keywords'] = '';
            $this->viewData['web_description'] = '';
            $this->viewData['fb_description'] = '';
        } else {
            $seoCms = $seoCms[0];
            if(isset($seoCms['template'][$prefix.'_title'])){
                if($seoCms['template'][$prefix.'_title']){
                    $this->viewData['web_title'] = $seoCms['template'][$prefix.'_title'];
                    $this->viewData['fb_title'] = $seoCms['template'][$prefix.'_title'];
                }
            }
            if(isset($seoCms['template'][$prefix.'_keyword'])){
                if($seoCms['template'][$prefix.'_keyword']){
                    $this->viewData['web_keywords'] = $seoCms['template'][$prefix.'_keyword'];
                }
            }
            if(isset($seoCms['template'][$prefix.'_description'])){
                if($seoCms['template'][$prefix.'_description']){
                    $this->viewData['web_description'] = $seoCms['template'][$prefix.'_description'];
                    $this->viewData['fb_description'] = $seoCms['template'][$prefix.'_description'];	
                }
            }
        }
    }

	// 處理分頁
	public function deal_pages($currentPage, $totalPage){
		$pages = [];
		$pages_start_add = -2;
		while(true){
        	$p = $currentPage + $pages_start_add;
        	if( $p> 0){
        		if( $p <= $totalPage){
        			array_push($pages, $p);
        		}else{
        			break;
        		}
        	}
        	if(count($pages)>=5)
        		break;
        	$pages_start_add +=1;
        }
        $this->viewData['pages'] = $pages;
        $this->viewData['p_prev'] = $currentPage-1>0 ? $currentPage-1 : '';
        $this->viewData['p_next'] = $currentPage+1<=$totalPage ? $currentPage+1 : '';
    }

    // 發送請求
    public function http_request($url, $data = null){
        $curl = curl_init();  
        curl_setopt($curl, CURLOPT_URL, $url);  
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (! empty($data)) {  
            curl_setopt($curl, CURLOPT_POST, 1);  
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);  
        }  
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $output = curl_exec($curl);  
        curl_close($curl);  
        return $output;  
    }
    
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}