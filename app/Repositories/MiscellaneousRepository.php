<?php

namespace APP\Repositories;

use Illuminate\Support\Facades\DB;

use \App\Models\MiscellaneousModel;

class MiscellaneousRepository{

	protected $model;
	const PrimaryKey = "misc_id";

	public function __construct(MiscellaneousModel $miscellaneousModel){
		$this->model = $miscellaneousModel;
	}

	//-------------------
	// AccountModel
	//-------------------
	//CURD
	public function index(){
		return MiscellaneousModel::all();
	}

	public function store($insData){
		$res = MiscellaneousModel::create($insData);
		return $res[self::PrimaryKey];
	}

	public function show($id){
		$res = MiscellaneousModel::where(self::PrimaryKey,'=',$id)->first();
//		$res = MiscellaneousModel::findOrFaila($id);
		return $res;
	}

	public function update($id,$updData){
//		$res = SampleModel::where(self::PrimaryKey,'=',$id)->update($updData);
		$res = MiscellaneousModel::findOrFail($id);
		$res = $res->update($updData);
		return $res;

	}

	public function destroy($id){
//		$res = SampleModel::where(self::PrimaryKey,'=',$id)->delete();
		$res = MiscellaneousModel::fincOrFail($id);
		$res = $res->delete();
		return $res;
	}

	public function find($cond){//equal or like
//		$cond = [['a','=',1],.....]
		$res = MiscellaneousModel::where($cond)->get();
		return $res;
	}



	public function getFreeFare($lang_type){
		$res = DB::table($this->table)->join($this->langTable,$this->table.'.lang_id','=',$this->langTable.'.lang_id')
					->where($this->table.'.misc_type','freeFare')
					->where($this->langTable.'.lang_type',$lang_type)
					->first();
		return $res;
	}








}