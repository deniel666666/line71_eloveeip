<?php

namespace APP\Repositories;

use \App\Models\LangModel;
use \App\Models\MenuLangModel;
use \App\Models\SeoModel;

class LangRepository{

	protected $model;
	const PrimaryKey = "lang_id";
	public function __construct(LangModel $langModel){
		$this->model = $langModel;
	}

	public function show($id){
		$res = LangModel::where(self::PrimaryKey,'=',$id)->first();
		return $res;
	}
  static public function show_by_type($type){
    $res = LangModel::where('lang_type','=',$type)->first();
    return $res;
  }

  public  function getLang(){
    $res = LangModel::select('lang_id','lang_word','lang_status')->orderBy('lang_order', 'asc')->get();
    return $res ;
  }

  public  function getSetOnLang(){
    $res = LangModel::where('lang_status','=',1)->orderBy('lang_order', 'asc')->get();
    return $res ;
  }

  public function update($langId,$updData){
		$res = LangModel::where('lang_id','=',$langId)->update($updData);
		return $res;
  }

   public function add($type,$word,$color,$order){
		  $insert = LangModel::create([
        'lang_type'		=> $type,
        'lang_word' => $word,
        'lang_color' 		=> $color,
        'lang_order' 		=> $order,
        'lang_status' 		=> 1
      ]);

     $getLangId = $insert->lang_id;
      $res = MenuLangModel::select('menu_code','menu_color','menu_lang_order')->distinct('menu_code')->get();

      foreach ($res as $rKey => $rValue){
         MenuLangModel::create([
          'lang_id'		=> $getLangId,
          'menu_name' => $type,
          'menu_lang_order' => $rValue['menu_lang_order'],
          'menu_color' 		=> $rValue['menu_color'],
          'menu_code' 		=>  $rValue['menu_code'],
        ]);
      }

      SeoModel::create([
          'web_title' 	=> 't4',
          'web_keyword'	=> 't44',
          'web_description'	=> 't444',
          'fb_company'	=> 't4444',
          'fb_title'	=> 't4444',
          'fb_description'	=> 't4444444',
          'fb_share_img' => 't4444444',
          'tiwt_company'	=> 't4444',
          'tiwt_title'	=> 't4444',
          'tiwt_description'	=> 't4444',
          'google_verify'	=> 't4444',
          'google_analysis_code'	=> 't4444',
          'google_sales_code'	=> 't4444',
          'yahoo_sales_code' => 't4444',
          'hiden_description'	=> 't4444',
          'robots'	=> 't4444',
          'map_img'	=> 't4444',
          'lang_id'=> $getLangId,
        ]);
	}
}