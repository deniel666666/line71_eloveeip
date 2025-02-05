<?php
namespace App\Repositories\Cms\Template;

use App\Helpers\AppHelper;

class CmsTemplateRepository{
  private $cmsTypeModel;
  private $cmsModel;
  private $primaryKey;

  public function __construct(
    $cmsTypeModel,
    $cmsModel,
    $primaryKey,
    $type_primaryKey
  ){
    $this->cmsTypeModel     = $cmsTypeModel;
    $this->cmsModel         = $cmsModel;
    $this->primaryKey       = $primaryKey;
    $this->type_primaryKey  = $type_primaryKey;
  }

  public function addCms($cmsTypeId, $child_template_id, $cms){

    foreach ($cms as $key => $value) {
      $order_id = $value['order_id'];
      unset($insertData);
      unset($value['order_id']);
      $insertData = [
        'cms_type_id'       => $cmsTypeId,
        'child_template_id' => $child_template_id,
        'content'           => json_encode($value,JSON_UNESCAPED_UNICODE),
        'order_id'          => $order_id
      ];

      if($value['type'] == 'img'){
        $fileName = '';
        if(!empty($value['imageSrc']) ){
          $img = $value['imageSrc'];
          //file name 
          $t=time();
          $getType = explode(";",$img)[0];
          $getType = explode("/",$getType)[1];
          $gethash = AppHelper::instance()->geraHash(8);
          $fileName = $t.$gethash.'.'.$getType;
          // $filePath = base_path().$this->public_file_path.$cmsTypeId.'/'.$fileName;
          // $imgData = substr($img,strpos($img,",") + 1);
          // $decodedData = base64_decode($imgData);
          // file_put_contents($filePath,$decodedData);
          unset($value['imageSrc']);

          $insertData['cms_img'] = $fileName;
        }
      }
      $this->cmsModel->create($insertData);      
    }
  }

  public function updateCms($cmsId, $cms){
    $res = $this->cmsModel->where($this->primaryKey,'=',$cmsId)->update($cms);
  }

  public function deleteCms($cmsId){
    $res = $this->cmsModel->where($this->primaryKey,'=',$cmsId)->delete();
  }

  public  function getCms($cmsTypeId, $viewEnd){
    $cmsType = $this->getCmsType($cmsTypeId);
    $cmsModel = $this->cmsModel;
    if($viewEnd=='client'){
      if(isset($cmsType['cate_status']) && $cmsType['cate_status'] == 0){
        $cmsModel->where('cms_type_id', '=', '0');
      }
    }
    
    $res = $cmsModel->where('cms_type_id', '=', $cmsType[$this->type_primaryKey])
                    ->where('child_template_id', '=', $cmsType['child_template_id'])
                    ->orderBy('order_id', 'asc')
                    ->orderBy('created_at', 'asc')
                    ->get();
    return $res ;
  }

  public function getOneCms($cmsId){
    return $this->cmsModel->where($this->primaryKey,'=',$cmsId)->first();
  }
  // public function getOneCms($cond){
  // 	return $this->cmsModel->where($cond)->first();
  // }

  public  function getCmsType($cmsTypeId){
    $res = $this->cmsTypeModel->where($this->type_primaryKey,'=',$cmsTypeId)->first();
    return $res ;
  }
}