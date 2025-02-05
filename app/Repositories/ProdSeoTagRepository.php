<?php
namespace APP\Repositories;
use \App\Models\ProdSeoTagModel;
class ProdSeoTagRepository{
    protected $mainId = 'seo_tag_id';
    protected $mainModel;
	public function __construct(ProdSeoTagModel $mainModel){
		$this->mainModel = $mainModel;
    }
    
    public function getId($selectLangItem,$startIndex,$countOfPage,$searchByText,$productNum){

        if($selectLangItem == 0){
            return $this->mainModel->with(['lang'])
            ->where('seo_name','like', '%'.$searchByText.'%')
            ->where('seo_prod_num','=',$productNum)
            ->orderBy('seo_tag_order','asc')
            ->orderBy('seo_tag_id','desc')
            ->offset($startIndex)->limit($countOfPage)->get()->toArray();
        }else{
            return $this->mainModel->with(['lang'])
            ->where('seo_name','like', '%'.$searchByText.'%')
            ->where('lang_id','=', $selectLangItem)
            ->where('seo_prod_num','=',$productNum)
            ->orderBy('seo_tag_order','asc')
            ->orderBy('seo_tag_id','desc')
            ->offset($startIndex)->limit($countOfPage)->get()->toArray();
        }
    }


    public function countId($selectLangItem,$searchByText,$productNum){
        if($selectLangItem == 0){
            return $this->mainModel->where('seo_name','like', '%'.$searchByText.'%')->where('seo_prod_num','=',$productNum)
            ->count();
        }else{
            return $this->mainModel->where('seo_name','like', '%'.$searchByText.'%')->where('seo_prod_num','=',$productNum)
            ->where('lang_id','=', $selectLangItem)
            ->count();
        }

    }

    public function add($insertData){
        $this->mainModel->create($insertData);

    }

    public function edit($id,$updData){
        $this->mainModel->where($this->mainId,'=',$id)->update($updData);
    }

    public function delete($ids){
        if(count($ids) > 0){
            $this->mainModel->whereIn($this->mainId,$ids)->delete();
        }
	}


    public function setStatus($ids,$updData){
        if(count($ids) > 0){
            $this->mainModel->whereIn($this->mainId,$ids)->update($updData);
        }
    }

    // PropertyTagRepository / ->get() / ->getAll()
}