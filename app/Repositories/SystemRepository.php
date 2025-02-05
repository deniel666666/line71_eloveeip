<?php

namespace APP\Repositories;

use \App\Models\SystemIntroModel;
use \App\Models\SystemDevelopmentModel;

class SystemRepository{

    public function __construct(
        SystemIntroModel        $systemIntroModel,
        SystemDevelopmentModel  $systemDevelopmentModel

    ){
		$this->systemIntroModel          = $systemIntroModel;
        $this->systemDevelopmentModel    = $systemDevelopmentModel;
        
		$this->modelArray = array(
			'SystemIntro'			=>$this->systemIntroModel,
			'SystemDevelopment'		=>$this->systemDevelopmentModel
		);
    }

    public  function create($modelName,$item){
        return $this->modelArray[$modelName]->create($item);
    }

    public function update($modelName,$id,$item){
		$error_msg = "";
		try {
            unset($item['created_at']);
            unset($item['updated_at']);
            $this->modelArray[$modelName]->where('system_id','=',$id)->update($item);
		} catch (\Exception $e) {
            $error_msg = $e->getMessage();
		}
        return $error_msg;
    }


    public  function getOne($modelName,$id){
        return $this->modelArray[$modelName]->where('system_id','=',$id)->first();
    }


    public  function getImgOne($whereData ,$searchData){
        return $this->systemDevelopmentModel->where($whereData)->select($searchData)->first()->$searchData;
    }

    public  function editImg($whereData ,$updateImg){
        $msg = 0;
		try {
            $this->systemDevelopmentModel->where($whereData)->update($updateImg);
		} catch (\Exception $e) {
			$msg = 1;
		}
        return $msg;
    }


}