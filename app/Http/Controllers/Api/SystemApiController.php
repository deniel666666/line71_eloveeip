<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Repositories\SystemRepository;
use App\Helpers\AppHelper;


use Illuminate\Support\Facades\Storage;
use \File;
use \DB;
use App\Services\FileService;

class SystemApiController extends Controller
{
    protected $systemRepository;

    public function __construct(
        SystemRepository $systemRepository
    ){
		$this->systemRepository = $systemRepository;
    }
    
    protected $publicFilePath =  '/public/upload/admin/system_development/';
    protected $uploadFilePath =  '/upload/admin/system_development/';

    protected $systemIntroModel =  'SystemIntro';
    protected $systemDevelopmentModel =  'SystemDevelopment';
    protected $id = 1 ;


    public function devTeamShow(Request $request){
        $item = $this->systemRepository->getOne(  $this->systemDevelopmentModel,$this->id);
        $data = [
            'status'=> 200,
            'item'=>$item
        ];
        return $data;
    }
    
    public function devTeamSave(Request $request){
        
        $item = $request->input('item');
        $whereData = [['system_id','=', 1]];
		if(!empty($item['client_logo']) ){
            $img = $item['client_logo'] ;
            $searchData ='client_logo';
            $this->saveImg($whereData,$searchData,$img);
        }
		if(!empty($item['dev_team_img']) ){
            $img = $item['dev_team_img'] ;
            $searchData ='dev_team_img';
            $this->saveImg($whereData,$searchData,$img);
        }
		if(!empty($item['marketing_img']) ){
            $img = $item['marketing_img'] ;
            $searchData ='marketing_img';
            $this->saveImg($whereData,$searchData,$img);
        }
        unset($item['client_logo']);
        unset($item['dev_team_img']);
        unset($item['marketing_img']);

        $system_id =$item['system_id'];
        DB::beginTransaction();
        $error_msg = $this->systemRepository->update($this->systemDevelopmentModel, $system_id, $item);
        if($error_msg == ""){
            DB::commit();
            $data = [
                'status'=> 200,
            ];
        }else{
            DB::rollback();
            $data = [
                'status'=> 500,
                'msg'=> $error_msg,
            ];
        }
        
        return response()->json($data);
    }


    public function saveImg( $whereData,$searchData,$img){
        $old_name = $this->systemRepository->getImgOne($whereData ,$searchData);
        if( $img != $old_name  ){
            if(!empty($old_name) ){
                if(file_exists(base_path().$old_name) ){
                    AppHelper::instance()->deleteImg(base_path().$old_name);
                }
            }
            $fileName = AppHelper::instance()->renameFile( $img );
            $ext = explode('.', $fileName);
            $ext = end($ext);
            $saveFileName = 'file_'.date("Y-m-d", time()).'_'.substr( sha1(uniqid(time(), true))  ,0 , 10 ).'.'.$ext;
            $newImgName=$this->publicFilePath.'/'.$saveFileName;
            AppHelper::instance()->uploadFile($this->publicFilePath, $saveFileName, $img);
            return $this->systemRepository->editImg( $whereData ,[$searchData=> $newImgName]);
        }
    }


    public function sysIntroShow(Request $request){
        $item = $this->systemRepository->getOne( $this->systemIntroModel,$this->id);
        $data = [
            'status'=> 200,
            'item'=>$item
        ];
        return $data;
    }


    public function sysIntroSave(Request $request){
        $item = $request->input('item');
        $system_id =$item['system_id'];
        DB::beginTransaction();
        $error_msg = $this->systemRepository->update($this->systemIntroModel,$system_id, $item);
        if($error_msg == ""){
            DB::commit();
            $data = [
                'status'=> 200,
            ];
        }else{
            DB::rollback();
            $data = [
                'status'=> 500,
                'msg'=> $error_msg,
            ];
        }
        return response()->json($data);
    }




}