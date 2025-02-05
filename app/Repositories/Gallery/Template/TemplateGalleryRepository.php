<?php

namespace App\Repositories\Gallery\Template;

class TemplateGalleryRepository{
	protected $galleryTypeModel;
	protected $galleryModel;
	public function __construct(
		$galleryTypeModel,
		$galleryModel
	){
		$this->galleryTypeModel 				= $galleryTypeModel;
		$this->galleryModel 					= $galleryModel;
	}

	//-------------------
	// GalleryTypeModel
	//-------------------
	public function getTypes(){
		return $this->galleryTypeModel::all();
	}

	public function getGalleryTypeByTypeId($id){
		$gallery = $this->galleryTypeModel->where('gallery_type_id','=',$id)->first();
		return $gallery->toArray();
	}

	//-------------------
	// GalleryTypeModel
	//-------------------
	public function create($insData){
		return $this->galleryModel->insertGetId($insData);
	}

	public function hasRecByImgName($imgName){
		return $this->galleryModel->where('img_name','=',$imgName)->exists();
	}


	public function getGalleryById($galleryId){
		$res = $this->galleryModel->with(['lang'])->where('gallery_id','=',$galleryId)->first();
		return $res;
	}

	public function getAllGalleryByTypeId($typeId,$langId){
		if($langId == 0){
			$res = $this->galleryModel->with(['lang'])->where('gallery_type_id', '=', $typeId)
												->where('img_status', '=',1)
												->orderBy('slider_order', 'asc')
												->orderBy('gallery_id','desc')
												->get()->toArray();
		}else{
			$res = $this->galleryModel->with(['lang'])->where('lang_id', '=', $langId)
												->where('gallery_type_id', '=', $typeId)
												->where('img_status', '=',1)
												->orderBy('slider_order', 'asc')
												->orderBy('gallery_id','desc')
												->get()->toArray();
		}
		return $res;
	}

	public function update($galleryId,$updData){
        $res = $this->galleryModel->where('gallery_id','=',$galleryId)->update($updData);
        return $res;
	}

    public function delete($galleryId){
        $res = $this->galleryModel->where('gallery_id','=',$galleryId)->delete();
        return $res;
    }


    /* 取得gallery */
	public function get($cond){
		// dump($cond);exit;
		$res = $this->galleryModel::with(['lang'])->select('*');
		$res = $this->deal_where_sql($res, $cond);
		$gallery_table = $this->galleryModel->getTable();
		return $res->orderBy($gallery_table.'.slider_order', 'asc')
					->orderBy($gallery_table.'.gallery_id','desc')
					->get()->toArray();
	}
	/* 計算總個數 */
	public function count($cond){
		$res = $this->galleryModel::with(['lang']);
		unset($cond['countOfPage']);
		$res = $this->deal_where_sql($res, $cond);

		return $res->distinct()->count(['gallery_id']);
	}
	/* 處理條件 */
	public function deal_where_sql($use_model, $cond){
		$gallery_table = $this->galleryModel->getTable();

		if(isset($cond['selectLangItem'])){
			if($cond['selectLangItem'] !=''){ $use_model->where($gallery_table.'.lang_id', '=', $cond['selectLangItem']); }
		}
		if(isset($cond['searchByText'])){
			if($cond['searchByText'] !=''){
				$searchByText = $cond['searchByText'];
				$use_model->where(function($query) use ($gallery_table, $searchByText){
					$cont_searchTitle = '{"title":"%'.$searchByText.'%","link"%';
					$cont_searchNote = '%"note":"%'.$searchByText.'%"}';
					$query
					->where($gallery_table.'.alt', 'like', '%' . $searchByText . '%')		// search alt
					->orwhere($gallery_table.'.gallery_cont', 'like',  $cont_searchTitle )	// search gallery_cont.title
					->orwhere($gallery_table.'.gallery_cont', 'like',  $cont_searchNote );	// search gallery_cont.note
				});
			}
		}
		if(isset($cond['imgStatus'])){
			if($cond['imgStatus'] !=''){ $use_model->where($gallery_table.'.img_status', '=', $cond['imgStatus']); }
		}
		if(isset($cond['galleryTypeId'])){
			if($cond['galleryTypeId'] !=''){ $use_model->where($gallery_table.'.gallery_type_id', '=', $cond['galleryTypeId']); }
		}

		if(isset($cond['galleryId'])){
			if($cond['galleryId'] !=''){ $use_model->where($gallery_table.'.gallery_id', '=', $cond['galleryId']); }
		}

		/*會員特有功能*/
		if(isset($cond['memberId'])){
			if($cond['memberId'] !=''){ $use_model->where($gallery_table.'.member_id', '=', $cond['memberId']); }
		}

		if(isset($cond['countOfPage'])){
			if($cond['countOfPage']!='' && $cond['countOfPage']!=0){
				$use_model->offset($cond['startIndex']);
				$use_model->limit($cond['countOfPage']); 
			}
		}

		return $use_model;
	}

	public function editMulti($ids,$updData){
		$msg = 0;
		try {
			$this->galleryModel->whereIn('gallery_id',$ids)->update($updData);
		}catch (\Exception $e) {
			$msg = 1;
		}
		return $msg;
	}

	public function deleteGallery($whereData){
		$msg = 0;
		try {
			$this->galleryModel->whereIn($whereData[0],$whereData[2])->delete();
		} catch (\Exception $e) {
			$msg = 1;
		}
		return $msg;
	}
}