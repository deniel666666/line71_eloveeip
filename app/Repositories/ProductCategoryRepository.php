<?php



namespace APP\Repositories;



use \App\Models\ProductCategoryModel;



class ProductCategoryRepository{



	protected $model;

	const PrimaryKey = "prod_cate_id";



	public function __construct(ProductCategoryModel $productCategoryModel){

		$this->model = $productCategoryModel;

	}



	//-------------------

	// SampleModel

	//-------------------

	//CURD

	public function index(){



	}



	public function show($id){

		$res = $this->model->where(self::PrimaryKey,'=',$id)->first();

		return $res;

	}



	public function store($insData){

		$res = $this->model->create($insData);

		return $res[self::PrimaryKey];

	}



	public function update($id,$updData){

		$res = $this->model->where(self::PrimaryKey,'=',$id)->update($updData);

		return $res;

	}



	public function destroy($id){

		$res = $this->model->where(self::PrimaryKey,'=',$id)->delete();

		return $res;

	}







	//-------------------------

	// Relation

	//-------------------------

	public function getCategoryTag($cond){// $cond['prodId'];$cond['cateStatus']



		if (isset($cond['cateStatus'])){

			$cateStatus = $cond['cateStatus'];

			$res = ProductCategoryModel::with(

				['categoryTag'=>function($query)use($cateStatus){

					$query->where('cate_status',$cateStatus)->orderBy('cate_order','asc');

				}]

			);

		}else{

			$res = ProductCategoryModel::with('categoryTag')->orderBy('cate_order','asc');

		}



		if (isset($cond['prodId'])){

			$res = $res->where('prod_id',$cond['prodId']);

		}

		if (isset($cond['lang_id'])){
			$lang_id = $cond['lang_id'];
			$res = ProductCategoryModel::with(

				['categoryTag'=>function($query)use($lang_id){

					$query->where('lang_id',$lang_id)->orderBy('cate_order','asc');

				}]

			);

		}
		
		if (isset($cond['cate_id'])){
			$cate_id = $cond['cate_id'];
			$res = ProductCategoryModel::with(

				['categoryTag'=>function($query)use($cate_id){

					$query->where('cate_id',$cate_id)->orderBy('cate_order','asc');

				}]

			);

		}


		$res->orderBy('cate_tag_id','desc');



		$res = $res->get();



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

//		echo $res->toSql();



		$res = $res->get();



		return $res;

	}



	public function itemCount($pageParam){



		$res = $this->model->where('cont_id','!=',0);



		return $res->count();

	}



}