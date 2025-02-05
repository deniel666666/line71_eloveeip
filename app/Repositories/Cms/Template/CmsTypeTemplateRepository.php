<?php
namespace App\Repositories\Cms\Template;

class CmsTypeTemplateRepository
{
	protected $this_cmsTypeModel;
	protected $this_primaryKey;
	protected $this_type_order_column;

	public function __construct(
		$this_cmsTypeModel,
		$this_primaryKey,
		$this_type_order_column
	){
		$this->this_cmsTypeModel		= $this_cmsTypeModel;
		$this->this_primaryKey 			= $this_primaryKey;
		$this->this_type_order_column	= $this_type_order_column;
	}
    
    public function get($cond){
    	// dump($cond);
		$res = $this->this_cmsTypeModel::with(['lang']);
		if(isset($cond['primary_key'])){
			if($cond['primary_key']!=''){ $res->where($this->this_primaryKey,'=', $cond['primary_key']); }
		}
		if(isset($cond['primary_keys'])){
			if($cond['primary_keys']!=''){ $res->whereIn($this->this_primaryKey, explode(',', $cond['primary_keys'])); }
		}
		if(isset($cond['selectLangItem'])){
			if($cond['selectLangItem']!=''){ $res->where('lang_id','=', $cond['selectLangItem']); }
		}
		if(isset($cond['searchByText'])){
			if($cond['searchByText']!=''){ $res->where('cms_type_name','like', '%'.$cond['searchByText'].'%'); }
		}
		if(isset($cond['own_user'])){
			if($cond['own_user']!='2'){ $res->where('own_user',$cond['own_user']); }
		}

		$res->orderBy($this->this_type_order_column,'asc')->orderBy($this->this_primaryKey,'desc');

		if(isset($cond['countOfPage'])){
			if($cond['countOfPage']!='' || $cond['countOfPage']!=0){ $res->offset($cond['startIndex'])->limit($cond['countOfPage']); }
		}
		
		return $res->get();
    }
    public function count($cond){
    	$res = $this->this_cmsTypeModel;
		if(isset($cond['selectLangItem'])){
			if($cond['selectLangItem']!=''){ $res->where('lang_id','=', $cond['searchByText']); }
		}
		if(isset($cond['searchByText'])){
			if($cond['searchByText']!=''){ $res->where('cms_type_name','like', '%'.$cond['searchByText'].'%'); }
		}
		if(isset($cond['own_user'])){
			if($cond['own_user']!='2'){ $res->where('own_user',$cond['own_user']); }
		}

        return $res->count();    	
    }

	public function add($insData){
		$res = $this->this_cmsTypeModel->create($insData);
		return $res[$this->this_primaryKey];
	}

    public function edit($id,$updData){
        $this->this_cmsTypeModel->where($this->this_primaryKey,'=',$id)->update($updData);
    }

	public function deleteOneType($ids){
		$this->this_cmsTypeModel->where($this->this_primaryKey,'=',$ids)->delete();
	}
}