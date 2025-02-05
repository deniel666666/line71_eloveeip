<?php
namespace APP\Repositories;

use \App\Models\ProdTabsModel;
use \App\Models\ProdTabsTagModel;

class ProductTabsTagRepository{

	const PrimaryKey = "label_tag_id";
	public function __construct(
        ProdTabsModel $prodTabsModel,
        ProdTabsTagModel $prodTabsTagModel
    ){
		$this->prodTabsModel = $prodTabsModel;
        $this->prodTabsTagModel = $prodTabsTagModel;
	}

    public function show($langId,$num ,$proId){
        return $this->prodTabsTagModel
        ->leftJoin('prod_tabs_property', function ($leftJoin) use ($proId) {
            $leftJoin->on('prod_tabs_property.prop_tag_id', '=', 'prod_tabs_property_tag.tabs_tag_id')
			->where('prod_tabs_property.prod_id','=', $proId );
        })
        ->select('prod_tabs_property.prod_type_id','prod_tabs_property_tag.tabs_tag_id as prop_tag_id','prod_tabs_property_tag.tabs_name','prod_tabs_property.prod_id','prod_tabs_property.prod_prop')
		->where('prod_tabs_property_tag.lang_id','=', $langId )
		->where('prod_tabs_property_tag.tabs_prod_num','=',$num)
        ->where('prod_tabs_property_tag.tabs_status','=',1)
        ->orderBy('prod_tabs_property_tag.tabs_order','asc')->orderBy('prod_tabs_property_tag.tabs_tag_id','asc')
        ->get()->toArray();
    }


    public function edit( $prodTypeId ,$items ){
        $msg = $this->prodTabsModel->where('prod_type_id','=', $prodTypeId)->count();
        if($msg  == 0){
            $this->prodTabsModel->insert($items);
        }else{
            $this->prodTabsModel->where('prod_type_id','=', $prodTypeId)->update($items);
        }

    }


    // public function showHasLabelById($langId,$num ,$proId){
    //     return $this->prodTabsTagModel
    //     ->leftJoin('prod_label', function ($leftJoin) use ($proId) {
    //         $leftJoin->on('prod_label.label_tag_id', '=', 'prod_label_tag.label_tag_id')
	// 		->where('prod_label.prod_id','=', $proId );
    //     })
    //     ->select('prod_label_tag.label_tag_id','prod_label_tag.label_name','label_img','prod_label_tag.label_img_desc','prod_label_tag.label_tag_cont','prod_label_tag.label_order','prod_label.prod_id','prod_label.label_tag_id as has_label')
	// 	->where('prod_label_tag.lang_id','=', $langId )
	// 	->where('prod_label_tag.label_prod_num','=',$num)
	// 	->where('prod_label_tag.label_status','=',1)
    //     ->where('prod_label.label_tag_id','!=',null)
    //     ->orderBy('prod_label_tag.label_order','asc')->orderBy('prod_label_tag.label_tag_id','asc')
    //     // ->whereNull('')
    //     ->get()->toArray();
    // }


}