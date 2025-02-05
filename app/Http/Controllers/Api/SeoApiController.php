<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Repositories\SeoRepository;
use App\Helpers\AppHelper;

class SeoApiController extends Controller
{
    protected $seoRepository;

	public function __construct(SeoRepository $seoRepository){
		$this->seoRepository = $seoRepository;
    }
    
    public function getOne(Request $request){
        $langId = $request->get('langId');
        
        $langs = AppHelper::instance()->getAllLangs();
        if($langId == 0){
            $langId = $langs[0]['lang_id'];
        }
        $item = $this->seoRepository->getOne($langId);
        $item['fb_share_img'] = '/upload/fb/'.$item['fb_share_img'];
        $item['map_img'] = '/upload/map/'.$item['map_img'];
        $langs = AppHelper::instance()->getAllLangs();

        $data = [
            'status' => '200',
            'item' => $item,
            'langs'=>$langs
        ];
        return response()->json($data);
    }

    public function update(Request $request){
        $seoId =  $request->input('seo_id');
        $updData['web_title'] = $request->input('web_title');
        $updData['web_keyword'] = $request->input('web_keyword');
        $updData['web_description'] = $request->input('web_description');
        $updData['fb_company'] = $request->input('fb_company');
        $updData['fb_title'] = $request->input('fb_title');
        $updData['fb_description'] = $request->input('fb_description');
        $updData['fb_share_img'] = $request->input('fb_share_img');
        $updData['tiwt_company'] = $request->input('tiwt_company');
        $updData['tiwt_title'] = $request->input('tiwt_title');
        $updData['tiwt_description'] = $request->input('tiwt_description');
        $updData['google_verify'] = $request->input('google_verify');
        $updData['google_analysis_code'] = $request->input('google_analysis_code');
        $updData['google_sales_code'] = $request->input('google_sales_code');
        $updData['yahoo_sales_code'] = $request->input('yahoo_sales_code');
        $updData['hiden_description'] = $request->input('hiden_description');
        $updData['robots'] = $request->input('robots');
        $updData['map_img'] = $request->input('map_img');

        $getOne = $this->seoRepository->getOne($seoId);
        if(!empty($updData['fb_share_img']) ){
            $img = $updData['fb_share_img'];
            $oldImg = '/upload/fb/'.$getOne['fb_share_img'];
            if($img != $oldImg){
                if(!empty($getOne['fb_share_img'])){
                    $this->deleteImg(base_path().'/public/upload/fb/'.$getOne['fb_share_img']);
                }
                $t=time();
                $getType = explode(";",$img)[0];
                $getType = explode("/",$getType)[1];
                $gethash = AppHelper::instance()->geraHash(8);
                $fileName = $t.$gethash.'.'.$getType;
                $filePath = base_path().'/public/upload/fb/'.$fileName;
                $imgData = substr($img,strpos($img,",") + 1);
                $decodedData = base64_decode($imgData);
                file_put_contents($filePath,$decodedData );
                $updData['fb_share_img'] = $fileName;
            }else{
                $updData['fb_share_img'] = $getOne['fb_share_img'];
            }
        }
        if(!empty($updData['map_img']) ){
            $img = $updData['map_img'];
            $oldImg = '/upload/map/'.$getOne['map_img'];
            if($img != $oldImg){
                if(!empty($getOne['map_img'])){
                    $this->deleteImg(base_path().'/public/upload/map/'.$getOne['map_img']);
                }
                $t=time();
                $getType = explode(";",$img)[0];
                $getType = explode("/",$getType)[1];
                $gethash = AppHelper::instance()->geraHash(8);
                $fileName = $t.$gethash.'.'.$getType;
                $filePath = base_path().'/public/upload/map/'.$fileName;
                $imgData = substr($img,strpos($img,",") + 1);
                $decodedData = base64_decode($imgData);
                file_put_contents($filePath,$decodedData );
                $updData['map_img'] = $fileName;
            }else{
                $updData['map_img'] = $getOne['map_img'];
            }
		}
		// unset($item['name']);
		// unset($item['cmsId']);
		// $updData['content'] = 	json_encode($item,JSON_UNESCAPED_UNICODE);
	
		$this->seoRepository->update($seoId,$updData);
		$data = [
            'status'=> 200,
            'item'=>$updData
		];
		return $data;
	}
    public function deleteImg($path){
		if (file_exists($path)) {
			unlink($path);
		}
	}
}
