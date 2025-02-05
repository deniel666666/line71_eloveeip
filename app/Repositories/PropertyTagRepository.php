<?php
namespace APP\Repositories;

use \App\Models\PropertyTagModel;
use \App\Models\ProductPropertyHasTagModel;

class PropertyTagRepository{



    protected $mainId = 'prop_tag_id';
    protected $mainModel;


	public function __construct(
        PropertyTagModel $mainModel,
        ProductPropertyHasTagModel $productPropertyHasTagModel
    ){
        $this->mainModel                    = $mainModel;
        $this->productPropertyHasTagModel   = $productPropertyHasTagModel;
	}

    public function get($selectLangItem,$startIndex,$countOfPage,$searchByText){

        if($selectLangItem == 0){
            return $this->mainModel->with(['lang'])
            ->where('prop_tag_name','like', '%'.$searchByText.'%')
			->orderBy('prop_tag_order','asc')
			->orderBy('prop_tag_id','desc')
            ->offset($startIndex)->limit($countOfPage)->get()->toArray();

        }else{
            return $this->mainModel->with(['lang'])
            ->where('prop_tag_name','like', '%'.$searchByText.'%')
            ->where('lang_id','=', $selectLangItem)
			->orderBy('prop_tag_order','asc')
			->orderBy('prop_tag_id','desc')
            ->offset($startIndex)->limit($countOfPage)->get()->toArray();
        }
    }

    public function getId($selectLangItem,$startIndex,$countOfPage,$searchByText,$property_tag_id){
        if($selectLangItem == 0){
            return $this->mainModel->with(['lang'])
            ->where('prop_tag_name','like', '%'.$searchByText.'%')
            ->where('property_tag_id','=',$property_tag_id)
			->orderBy('prop_tag_order','asc')
			->orderBy('prop_tag_id','desc')
            ->offset($startIndex)->limit($countOfPage)->get()->toArray();
        }else{
            return $this->mainModel->with(['lang'])
            ->where('prop_tag_name','like', '%'.$searchByText.'%')
            ->where('lang_id','=', $selectLangItem)
            ->where('property_tag_id','=',$property_tag_id)
			->orderBy('prop_tag_order','asc')
			->orderBy('prop_tag_id','desc')
            ->offset($startIndex)->limit($countOfPage)->get()->toArray();
        }
    }


    public function getAll($langType,$cate_id){
        return $this->mainModel->where('lang_id', '=', $langType)->where('property_tag_id', '=', $cate_id)->orderBy('prop_tag_order','asc')->orderBy('prop_tag_id','desc')->get();
    }

    public function count($selectLangItem,$searchByText){
        if($selectLangItem == 0){
            return $this->mainModel->where('prop_tag_name','like', '%'.$searchByText.'%')
            ->count();
        }else{
            return $this->mainModel->where('prop_tag_name','like', '%'.$searchByText.'%')
            ->where('lang_id','=', $selectLangItem)
            ->count();
        }
    }


    public function countId($selectLangItem,$searchByText,$property_tag_id){
        if($selectLangItem == 0){
            return $this->mainModel->where('prop_tag_name','like', '%'.$searchByText.'%')->where('property_tag_id','=',$property_tag_id)
            ->count();
        }else{
            return $this->mainModel->where('prop_tag_name','like', '%'.$searchByText.'%')->where('property_tag_id','=',$property_tag_id)
            ->where('lang_id','=', $selectLangItem)
            ->count();
        }
    }

    public function add($insertData){
        return $this->mainModel->create($insertData);
    }

    public function edit($id,$updData){
        return $this->mainModel->where($this->mainId,'=',$id)->update($updData);
    }

    public function delete($ids){
        if(count($ids) > 0){
            $this->mainModel->whereIn($this->mainId,$ids)->delete();
        }
    }
    

    public function showHasCateTagId($prop_tag_id){
        $hasArr =[];
        $productPropertyHasTags = $this->productPropertyHasTagModel
        ->where('prop_tag_id','=',$prop_tag_id)
        ->get()->toArray();
        foreach ($productPropertyHasTags as $key => $value) {
            array_push($hasArr, (int)$value['cate_tag_id']);
        }
        return $hasArr;
    }
    

    public function editHasCategoryTags($id ,$updateDate){
        $this->productPropertyHasTagModel->where('prop_tag_id','=',$id)->delete();
        $this->productPropertyHasTagModel->insert($updateDate);
    }
    

    public function setStatus($ids,$updData){
        if(count($ids) > 0){
            $this->mainModel->whereIn($this->mainId,$ids)->update($updData);
        }
    }

}