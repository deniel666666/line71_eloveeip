<?php

namespace APP\Repositories;

use \App\Models\GalleryTypeModel;

class GalleryTypeRepository{

	protected $model;
	const PrimaryKey = "gallery_type_id";
	public function __construct(GalleryTypeModel $galleryTypeModel){
		$this->model = $galleryTypeModel;
	}

	public function index(){
		return GalleryTypeModel::all();
	}

	public function store($insData){
		$res = GalleryTypeModel::create($insData);
		return $res[self::PrimaryKey];
	}

	public function show($id){
		$res = GalleryTypeModel::where(self::PrimaryKey,'=',$id)->first();
		return $res;
	}

	public function update($id,$updData){
		$res = GalleryTypeModel::where(self::PrimaryKey,'=',$id)->update($updData);
		return $res;
	}

	public function destroy($id){
		$res = GalleryTypeModel::where(self::PrimaryKey,'=',$id)->delete();
		return $res;
	}
	
	//--------------------
	// Dedicated function
	//--------------------
	public function page($pageParam){
		$offset = ($pageParam['currentPage']-1)*$pageParam['countOfPage'];
		$limit 	= $pageParam['countOfPage'];
		$res = $this->model->offset($offset)->limit($limit);
		$res->orderBy('created_at', 'desc');
		// echo $res->toSql();

		$res = $res->get();
		return $res;
	}
	public function itemCount($pageParam){
		$res = $this->model->where('cont_id','!=',0);
		return $res->count();
	}
}