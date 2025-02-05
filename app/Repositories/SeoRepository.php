<?php



namespace APP\Repositories;



use \App\Models\SeoModel;



class SeoRepository{



	public function __construct(){



  }

  

  public  function getOne($lang_id){

    $seo             = SeoModel::where('lang_id','=',$lang_id)->first();
    $seo['host_url'] = $_SERVER['HTTP_HOST'];
    return $seo;

  }



  public  function getFirstOne(){

    return SeoModel::orderBy('seo_id', 'asc')->first();

  }



  public function update($id,$item){

    $res = SeoModel::where('seo_id','=',$id)->update($item);

  }

}