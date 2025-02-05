<?php

namespace APP\Repositories;

use \App\Models\MiscellaneousModel;
use \App\Models\FareModel;

class FareRepository{
    protected $mainId = 'fare_id';
    protected $mainModel;

	public function __construct(FareModel $mainModel){
		$this->mainModel = $mainModel;
	}

    public function get($selectLangItem,$startIndex,$countOfPage,$searchByText){
        if($selectLangItem == 0){
            return $this->mainModel->with(['lang'])
            ->where('fare_name','like', '%'.$searchByText.'%')
            ->offset($startIndex)->limit($countOfPage)->get()->toArray();
        }else{
            return $this->mainModel->with(['lang'])
            ->where('fare_name','like', '%'.$searchByText.'%')
            ->where('lang_id','=', $selectLangItem)
            ->offset($startIndex)->limit($countOfPage)->get()->toArray();
        }     
    }

    public function count($selectLangItem,$searchByText){
        if($selectLangItem == 0){
            return $this->mainModel->where('fare_name','like', '%'.$searchByText.'%')
            ->count();
        }else{
            return $this->mainModel->where('fare_name','like', '%'.$searchByText.'%')
            ->where('lang_id','=', $selectLangItem)
            ->count();
        }
    }
    public function getOne($lang_id)
    {
        return MiscellaneousModel::where('lang_id', '=', $lang_id)->where('misc_type','=', 'freeFare')->first();
    }
    public function updateFreeFare($id, $item)
    {
        $res = MiscellaneousModel::where('misc_id', '=', $id)->update($item);
    }


    public function setMultiStatus($ids,$updData){
        if(count($ids) > 0){
            $this->mainModel->whereIn($this->mainId,$ids)->update($updData);
        }
    }

    public function setStatus($id,$updData){
       $this->mainModel->where($this->mainId, $id)->update($updData);
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
}