<?php

namespace APP\Repositories;

use \App\Models\MenuLangModel;
use \App\Models\LangModel;

class MenuLangRepository{

	public function __construct(){

	}
  public function getLang(){
    $lang = LangModel::get();
		return $lang->toArray();
	}
  
  public function getMenuLang($getMenuCode,$startIndex,$countLangOfPage, $selectLangItem){
		if($selectLangItem == 0){
			return MenuLangModel::with(['lang'])->whereIn('menu_code', $getMenuCode)->orderBy('menu_lang_order', 'asc')->orderBy('menu_code', 'asc')->offset($startIndex)->limit($countLangOfPage)->get();
		}else{
			return MenuLangModel::with(['lang'])->whereIn('menu_code', $getMenuCode)->where('lang_id', '=', $selectLangItem)->orderBy('menu_lang_order', 'asc')->orderBy('menu_code', 'asc')->offset($startIndex)->limit($countLangOfPage)->get();
		}
	
	}
	public function editMenuName($id,$updData){
		MenuLangModel::where('menu_lang_id','=',$id)->update($updData);
	}
	
	public function editMenuColorNOrder($code,$updData){
		MenuLangModel::where('menu_code','=',$code)->update($updData);
  }
  
	public function add($menuLang,$color,$order,$code){
    foreach ($menuLang as $key => $value) {
       MenuLangModel::create([
          'menu_name'		=> $value,
          'lang_id' => $key,
          'menu_lang_order' => $order,
          'menu_color' => $color,
          'menu_code' => $code,
        ]);
    }
	}
	public function delete($code){
    MenuLangModel::where('menu_code','=',$code)->delete();
  }
	public function getLastMuneCode(){
		$res = MenuLangModel::select('menu_code')->distinct('menu_code')->orderBy('menu_code', 'desc')->first();
		return $res;
	}
	
	public function searchMenuCodeByName($searchByText){
			$res = MenuLangModel::select('menu_code')->distinct('menu_code')->where('menu_name','like', '%'.$searchByText.'%')->get();
			$getMuneCode = [];
			foreach ($res as $key => $value) {
				array_push($getMuneCode,$value['menu_code']);
			}
			return $getMuneCode;
	}

	public function count($getMenuCode){
			return MenuLangModel::whereIn('menu_code',$getMenuCode)->count();
	}
	
}