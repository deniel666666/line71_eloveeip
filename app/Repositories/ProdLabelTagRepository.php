<?php
namespace APP\Repositories;
use \App\Models\ProdLabelTagModel;
class ProdLabelTagRepository{
    protected $mainId = 'label_tag_id';
    protected $mainModel;
	public function __construct(ProdLabelTagModel $mainModel){
		$this->mainModel = $mainModel;
    }
    
    public function getId($selectLangItem,$startIndex,$countOfPage,$searchByText,$productNum){

        if($selectLangItem == 0){
            return $this->mainModel->with(['lang'])
            ->where('label_name','like', '%'.$searchByText.'%')
            ->where('label_prod_num','=',$productNum)
            ->orderBy('label_order','asc')
            ->orderBy('label_tag_id','desc')
            ->offset($startIndex)->limit($countOfPage)->get()->toArray();
        }else{
            return $this->mainModel->with(['lang'])
            ->where('label_name','like', '%'.$searchByText.'%')
            ->where('lang_id','=', $selectLangItem)
            ->where('label_prod_num','=',$productNum)
            ->orderBy('label_order','asc')
            ->orderBy('label_tag_id','desc')
            ->offset($startIndex)->limit($countOfPage)->get()->toArray();
        }
    }


    public function countId($selectLangItem,$searchByText,$productNum){
        if($selectLangItem == 0){
            return $this->mainModel->where('label_name','like', '%'.$searchByText.'%')->where('label_prod_num','=',$productNum)
            ->count();
        }else{
            return $this->mainModel->where('label_name','like', '%'.$searchByText.'%')->where('label_prod_num','=',$productNum)
            ->where('lang_id','=', $selectLangItem)
            ->count();
        }
    }
    // public function getMaxId(){
    //     // 'last_insert_id' => $data->id
    //     return $this->mainModel->max('label_tag_id');

    //     // return $this->mainModel->getPdo()->lastInsertId();
    //     // ->max('label_tag_id');

    // }
    public function add($insertData){
        $labelItem = $this->mainModel->create($insertData);
        return $labelItem->label_tag_id;
    }


    public function editImg($id ,$data){
        $this->mainModel->where('label_tag_id','=', $id)->update($data);
    }

    public function edit($id,$updData){
        $this->mainModel->where($this->mainId,'=',$id)->update($updData);
    }

    public function delete($ids){
        if(count($ids) > 0){
            $this->mainModel->whereIn($this->mainId,$ids)->delete();
        }
	}

    public function getImgOne($id){
        return $this->mainModel
        ->select('label_img')
        ->where('label_tag_id','=',$id)->first()->label_img;
    }

    public function setStatus($ids,$updData){
        if(count($ids) > 0){
            $this->mainModel->whereIn($this->mainId,$ids)->update($updData);
        }
    }
    // PropertyTagRepository / ->get() / ->getAll()
}