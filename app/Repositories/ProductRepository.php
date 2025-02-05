<?php
namespace APP\Repositories;
use \App\Models\CategoryTagModel;
use \App\Models\ProductModel;
use \App\Models\ProductPropertyModel;
use \App\Models\PropertyTagModel;
use \App\Models\ProductImgModel;
use \App\Models\ProductDescribeModel;
use \App\Models\ProductTypeModel;
use \App\Models\ProdSpecificationModel;
use \App\Models\ProductCategoryModel;
use \App\Models\ProductPropertyTagModel;
use \App\Models\FareModel;

use \App\Models\ProdSeoPropertyModel;
use \App\Models\ProdSeoTagModel;
use \App\Models\ProductPropertyHasTagModel;
use \App\Models\CategoryProOrderModel;
use App\Repositories\Cms\Template\CmsTypeTemplateRepository;
use App\Repositories\AccountRepository;
use \App\Models\Contact\ContactTypeModel;

class ProductRepository extends CmsTypeTemplateRepository{
	protected $mainId = 'prod_id';
	protected $mainModel;
	protected $modelArray;
	protected $propertyTagModel;
	protected $productImgModel;
	protected $productDescribeModel;
	protected $productTypeModel;
	protected $prodSpecificationModel;
	protected $prodContentModel;
	protected $productCategoryModel;
	protected $productPropertyModel;
	protected $ProductPropertyTagModel;
	protected $prodSeoPropertyModel;
	protected $prodSeoTagModel;
	protected $categoryProOrderModel;
	
	public function __construct(
		ProductModel $mainModel,
		propertyTagModel $propertyTagModel,
		ProductImgModel $productImgModel,
		ProductDescribeModel $productDescribeModel,
		ProductTypeModel $productTypeModel,
		ProdSpecificationModel $prodSpecificationModel,
		ProductCategoryModel $productCategoryModel,
		ProductPropertyModel $ProductPropertyModel,
		ProductPropertyTagModel $ProductPropertyTagModel,
		ProdSeoPropertyModel $prodSeoPropertyModel,
		ProdSeoTagModel $prodSeoTagModel,
		CategoryProOrderModel $categoryProOrderModel
	){
		parent::__construct(
			$mainModel,
			$primaryKey   = "prod_id",
			$order_column = "prod_order"
		);

		$this->mainModel 				= $mainModel;
		$this->propertyTagModel 		= $propertyTagModel;
		$this->productImgModel 			= $productImgModel;
		$this->productDescribeModel 	= $productDescribeModel;
		$this->productTypeModel 		= $productTypeModel;
		$this->prodSpecificationModel 	= $prodSpecificationModel;
		$this->productCategoryModel 	= $productCategoryModel;
		$this->productPropertyModel 	= $ProductPropertyModel;
		$this->ProductPropertyTagModel 	= $ProductPropertyTagModel;

		$this->prodSeoPropertyModel 	= $prodSeoPropertyModel;
		$this->prodSeoTagModel 			= $prodSeoTagModel;
		$this->categoryProOrderModel 	= $categoryProOrderModel;
		
		$this->modelArray = array(
			'Product'			=>$this->mainModel,
			'PropertyTag'		=>$this->propertyTagModel,
			'ProductImg'		=>$this->productImgModel,
			'ProductDescribe'	=>$this->productDescribeModel,
			'ProductType'		=>$this->productTypeModel,
			'ProdSpecification'	=>$this->prodSpecificationModel,
			'ProductCategory'	=>$this->productCategoryModel,
			'ProductProperty'	=>$this->productPropertyModel,
			'productPropertyTag'	=>$this->ProductPropertyTagModel,
			'ProdSeoPropertyModel'	=>$this->prodSeoPropertyModel,
			'ProdSeoTagModel'		=>$this->prodSeoTagModel
		);

	}

	/* PRODUCT */
	/* 取得新增中未完成的商品 */
	public function getLastAddNotFinishItem($product_num){
		$res =  $this->mainModel->with(['lang'])
								->select('prod_id','lang_id','prod_name','prod_order','prod_subtitle','prod_main_sku','prod_show_s_datetime','prod_show_e_datetime','prod_s_datetime','prod_e_datetime','prod_img','prod_img2','prod_img3','prod_status')
								->where('prod_status','>',0)
								->where('product_num','=',$product_num)
								->latest()->first();
		return $res;
	}
	/* 取得最新建完成的商品 */
	public function getLastAddFinishItemHasMemory($product_num){
		$count =  $this->mainModel
									->select('prod_id')
									->where('prod_status','=',0)  //新建完成
									->where('product_num','=',$product_num)
									->where('deleted_at','=', null)
									// ->where('memory','=', '1') //0子階層建立 & 1新增
									->count();
		if($count != 0){
			$res =  $this->mainModel
									->select('prod_id')
									->where('prod_status','=',0)  //新建完成
									->where('product_num','=',$product_num)
									->where('deleted_at','=', null)
									// ->where('memory','=', '1') //0子階層建立 & 1新增
									->latest()->first()->prod_id;
		}else{
			$res= 0;
		}
		return $res;
	}
	/* 取得單一商品資料 */
	public function getOneProduct_sql($productId){
		$res = $this->mainModel->with(['lang'])
				->select('prod_id','lang_id','prod_name','prod_order','product.prod_subtitle','product.prod_main_sku','product.prod_show_s_datetime','product.prod_show_e_datetime','prod_s_datetime','prod_e_datetime','prod_img','prod_img2','prod_img3','prod_status','prod_shelf','prod_sale','promote_prod','admin_url_attached','product_num', 'created_at','own_user as selectUser','style')
				->where('prod_id','=',$productId)->latest()->first();
		return $res;
		// return $this->mainModel->select('prod_id','lang_id','prod_name','prod_order','prod_s_datetime','prod_e_datetime','prod_img','prod_img2','prod_img3','prod_status','prod_shelf','prod_sale','promote_prod','product_num')
		// 	->where('prod_id','=',$productId)->latest()->first();
	}
	/* 搜尋多商品(列表) */
	public function getProducts($cond){
		$mainModel_select = $this->mainModel
														->select('product.prod_id')
														->leftjoin('product_cms','product_cms.cms_id','=','product.'.$this->mainId) // search content
														->leftjoin('product_describe','product_describe.prod_id','=','product.'.$this->mainId) // search product_describe
														->leftjoin('prod_tabs_property','prod_tabs_property.prod_id','=','product.'.$this->mainId) //add search prod_tabs_property
														->join('product_category','product_category.prod_id','=','product.'.$this->mainId)
														->join('category_tag','category_tag.cate_tag_id','=','product_category.cate_tag_id')
														->where('product.prod_status','=','0');

		if(isset($cond['user']) && $cond['user']['id'] > 2){
			$mainModel_select->where(function($query) use ($cond){
				$query->orWhere('own_user', $cond['user']['id'])
							->orWhere('create_user', $cond['user']['id']);
			});
		}
		if(isset($cond['productNum'])){
			if($cond['productNum']!=''){ $mainModel_select->where('product.product_num',$cond['productNum']); }
		}
		if(isset($cond['langId'])){
			if($cond['langId']!=''){ $mainModel_select->where('product.lang_id',$cond['langId']); }
		}
		if(isset($cond['shelf'])){ 
			if($cond['shelf']!==''){ $mainModel_select->where('product.prod_shelf',$cond['shelf']); }
		}
		if(isset($cond['sale'])){ 
			if($cond['sale']!==''){ $mainModel_select->where('product.prod_sale',$cond['sale']); }
		}
		if(isset($cond['promote'])){ 
			if($cond['promote']!==''){ $mainModel_select->where('product.promote_prod',$cond['promote']); }
		}
		if(isset($cond['cate_tag_id'])){ 
			if($cond['cate_tag_id']!='' ){
				$checklist = ProductCategoryModel::select('prod_id')->where('cate_tag_id', '=', $cond['cate_tag_id'])->get()->toArray();
				$mainModel_select->whereIn('product.prod_id', $checklist);
			}
		}
		if(isset($cond['searchByText'])){ 
			if($cond['searchByText']!=''){
				$searchByText = $cond['searchByText'];
				$mainModel_select->where(function($query) use ($searchByText){
					$cont_searchTitle = '%<body>%'.$searchByText.'%/body>%';
					$cont_searchCont = '%{"text":"%'.$searchByText.'%","show":%';
					$query
					->where('product.prod_name', 'like', '%'.$searchByText.'%')
					->orwhere('product.prod_subtitle', 'like', '%'.$searchByText.'%')
					->orwhere('product.prod_main_sku', 'like', '%'.$searchByText.'%')
					->orwhere('product_cms.content', 'like',  $cont_searchTitle ) // search content title
					->orwhere('product_cms.content', 'like',  $cont_searchCont )  // search content content
					->orwhere('product_describe.prod_describe', 'like',  '%'.$searchByText.'%' ) // search product_describe
					->orwhere('prod_tabs_property.prod_prop', 'like',  '%'.$searchByText.'%' ); // search prod_tabs_property
				});
			}
		}
		if(isset($cond['excludeIds'])){
			if($cond['excludeIds']!=''){$mainModel_select->whereNotIn('product.prod_id', json_decode($cond['excludeIds']));}
		}
		if(isset($cond['includeIds'])){
			if($cond['includeIds']!=''){$mainModel_select->whereIn('product.prod_id', json_decode($cond['includeIds']));}
		}

		// 時間區間 0.當前+預告, 1.當前, 2.預告 3.過往
		if(isset($cond['time_zone'])){
			if($cond['time_zone']=='0'){
				$mainModel_select->where('product.prod_show_e_datetime', '>=', date('Y-m-d H:i:s'));
			}
			else if($cond['time_zone']=='1'){
				$mainModel_select->where('product.prod_show_s_datetime', '<=', date('Y-m-d H:i:s'))
								->where('product.prod_show_e_datetime', '>=', date('Y-m-d H:i:s'));
			}
			else if($cond['time_zone']=='2'){
				$mainModel_select->where('product.prod_show_s_datetime', '>', date('Y-m-d H:i:s'));
			}
			else if($cond['time_zone']=='3'){
				$mainModel_select->where('product.prod_show_e_datetime', '<', date('Y-m-d H:i:s'));
			}
		}

		// 年分(有開始結束)
		if(isset($cond['year'])){
			if($cond['year']!=''){
				$year_start = $cond['year'].'-01-01 00:00:00';
				$year_end = ((int)$cond['year']+1).'-01-01 00:00:00';
				$mainModel_select->where('product.prod_show_s_datetime', '<', $year_end)
								->where('product.prod_show_s_datetime', '>=', $year_start);
			}
		}
		// 年分(只一個時間)
		if(isset($cond['year_one'])){
			if($cond['year_one']!=''){
				$year_start = $cond['year_one'].'-01-01 00:00:00';
				$year_end = ((int)$cond['year_one']+1).'-01-01 00:00:00';
				$mainModel_select->where('product.prod_show_s_datetime', '<', $year_end)
								->where('product.prod_show_s_datetime', '>=', $year_start);
			}
		}

		/* 找出所有符合條件的商品的id */
		$ids = $mainModel_select->distinct('product.prod_id')->get()->toArray();
		$ids_array = [];
		array_walk($ids, function($item)use(&$ids_array){
			array_push($ids_array, $item['prod_id']);
		});
		// dump($ids_array);exit;

		/* 檢查是否有一tag搜尋，有的話要依tag內設定排序 */
		if(isset($cond['cate_tag_id'])){
			if($cond['cate_tag_id']!=''){
				$res =$this->mainModel->with([ 
						'categoryTag',
						'propertyTag',
						'productDescribe',
						'productProperty',
						'productType',
					])
					->rightjoin('category_pro_order','category_pro_order.product_id','=','product.'.$this->mainId)
					->where('category_pro_order.category_id', '=', $cond['cate_tag_id'])
					->whereIn('product.prod_id', $ids_array)
					->orderBy('category_pro_order.category_order', 'asc')->orderBy('product.prod_id','desc')->distinct('product.prod_id')->get();
				return $res;
			}
		}

		$res =$this->mainModel->with([ 
				'categoryTag',
				'propertyTag',
				'productDescribe',
				'productProperty',
				'productType',
			])
			->whereIn('product.prod_id', $ids_array)
			->orderBy('product.prod_order', 'asc')
			->orderBy('product.prod_id','desc')->distinct('product.prod_id')->get();

		return $res;
	}
	/*新增商品*/
	public function addProduct($insertData){
		$insertItem = $this->mainModel->create($insertData);
		return $insertItem->prod_id;
	}
	/*編輯單一商品資料*/
	public function editOne($modelName,$whereData,$updData){

		$msg = 0;
		try {
			$this->modelArray[$modelName]->where($whereData)->update($updData);
		} catch (\Exception $e) {
			$msg = 1;
		}
		return $msg;
	}
	/*批次編輯商品資料*/
	public function editMulti($modelName,$column,$ids,$updData){
		$msg = 0;
		try {
			$this->modelArray[$modelName]->whereIn($column,$ids)->update($updData);
		} catch (\Exception $e) {
			$msg = 1;
		}
		return $msg;
	}
	/*刪除商品資料*/
	public function deleteOne($modelName,$whereData){
		$msg = 0;
		try {
			$this->modelArray[$modelName]->where($whereData)->delete();
		} catch (\Exception $e) {
			$msg = 1;
		}
		return $msg;
		// dump($msg);
	}
	/*批次刪除商品資料*/
	public function deleteMulti($modelName,$whereData){
		$msg = 0;
		try {
			$this->modelArray[$modelName]->whereIn($whereData[0],$whereData[1])->delete();
		} catch (\Exception $e) {
			$msg = 1;
		}
		return $msg;
	}

	
	/* CATEGORY TAG */
	/*依語言版、商品別數值取得tags*/
	public function getCategoryTagsByLangNum($lang_id,$product_num){
		return CategoryTagModel::select('cate_tag_id','cate_id','cate_name','lang_id','hierarchy_id','parent_id','hierarchy_count')->where('lang_id','=',$lang_id)->where('cate_id','=',$product_num)->where ('cate_status', '=', 1)->orderBy('cate_order','asc')->orderBy('cate_tag_id','desc')->get()->toArray();
	}
	/* 取得商品勾選的tag */
	public function getCategoryTagsByProduct($id){
		return ProductCategoryModel::join('category_tag', 'category_tag.cate_tag_id', '=', 'product_category.cate_tag_id')->
		select('*')->where('prod_id','=',$id)->get()->toArray();
	}
	public function searchProdCategoryTag($prodCategoryId,$prodId){
		return ProductCategoryModel::select('prod_cate_id')->where('prod_id','=',$prodId)->where('cate_tag_id','=',$prodCategoryId)->first();
	}
	public function addProdCategoryTag($prodCategoryId,$prodId){
		$msg = 1;
		try{
			$data = array(
				array('prod_id'=>$prodId, 'cate_tag_id'=> $prodCategoryId,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=> date('Y-m-d H:i:s'))
			);
			ProductCategoryModel::insert($data);
		}catch (\Exception $e){
			$msg = 0;
		}
		return $msg;
	}


	/* PRODUCR PROPERTY */
	/*根據勾選tag取得對應prop_tag_id array*/
	public function get_prop_tag_id_array($ids){
		$ProductPropertyHasTags = ProductPropertyHasTagModel::select('prop_tag_id')->whereIn('cate_tag_id',$ids)->groupBy('prop_tag_id')->get()->toArray();
		$prop_tag_id_arr=[];
		foreach ($ProductPropertyHasTags as $key => $value) {
			array_push($prop_tag_id_arr, $value['prop_tag_id'] );
		}
		return $prop_tag_id_arr;
	}
	/*取得商品所有property_tag*/
	public function getPropertyTagByNumAndIds($langId,$productNum,$whereInTagIds ,$whereNotInIds){  //getPropertyTags
		/*property_tag有設定階層，且此商品有勾選tag，需填寫*/
		$whereInData = PropertyTagModel::select('prop_tag_id','prop_tag_name','prop_type','prop_tag_order')->where('lang_id','=',$langId)
		->whereIn('prop_tag_id',$whereInTagIds)
		->where('property_tag_id','=',$productNum)
		->where('prop_tag_status','=',1)
		// ->orderBy('prop_tag_order', 'asc')->orderBy('.prop_tag_id', 'desc');
		->orderBy('prop_tag_order', 'asc')->orderBy('.prop_tag_id', 'desc')->get()->toArray();

		/*property_tag未設定階層，需填寫*/
		$whereNotInData = PropertyTagModel::select('prop_tag_id','prop_tag_name','prop_type','prop_tag_order')->where('lang_id','=',$langId)
																			->whereNotIn('prop_tag_id',$whereNotInIds)
																			->where('property_tag_id','=',$productNum)
																			->where('prop_tag_status','=',1)
																			// ->orderBy('prop_tag_order', 'asc')->orderBy('.prop_tag_id', 'desc');
																			->orderBy('prop_tag_order', 'asc')->orderBy('.prop_tag_id', 'desc')->get()->toArray();
		
		/*合併*/
		$res = array_merge($whereInData, $whereNotInData);
		return $res;
	}
	/*取得某商品 全部property_tag 填寫的資料*/
	public function getProductPropertyDataByProdId($prodId ,$whereInTagIds ,$whereNotInIds){	//getProductProperty
		$res = ProductPropertyModel::join('property_tag', 'property_tag.prop_tag_id', '=', 'product_property.prop_tag_id')
															->select('product_property.prop_tag_id','product_property.prod_prop','product_property.prod_img_path')
															->where('prod_id','=',$prodId)
															->where('prop_tag_status','=',1)
															// ->orderBy('property_tag.prop_tag_order', 'asc')->orderBy('property_tag.prop_tag_id', 'desc');
															->orderBy('property_tag.prop_tag_order', 'asc')->orderBy('property_tag.prop_tag_id', 'desc')->get()->toArray();
		return $res;
	}
	/*取得某商品 某property_tag 填寫的資料*/
	public function getOneProductProperty($productId,$prop_tag_id){
		return ProductPropertyModel::select('prod_img_path')->where('prod_id','=',$productId)->where('prop_tag_id','=',$prop_tag_id)->first();
	}
	/*修改property_tag 填寫的資料*/
	public function editProductProperty($productId,$propertyTagId,$langId, $column,$property){
		$msg = 1;
		try{
			$getItem = ProductPropertyModel::select('prod_type_id')->where('prod_id','=',$productId)->where('prop_tag_id','=',$propertyTagId)->first();
			if(!empty($property) && strlen($property) > 0){
				if(!$getItem){ /*不存在紀錄則新增*/
					$data = array(
						array('prod_id'=>$productId, 'prop_tag_id'=> $propertyTagId, $column=> $property,'lang_id'=> $langId,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=> date('Y-m-d H:i:s'))
					);
					ProductPropertyModel::insert($data);
				}else{ /*存在紀錄則編輯*/
					ProductPropertyModel::where('prod_type_id','=',$getItem['prod_type_id'])->update([$column => $property]);
				}
			}else{
				ProductPropertyModel::where('prod_type_id','=',$getItem['prod_type_id'])->delete();
			}
		}catch (\Exception $e){
			$msg = 0;
		}
		return $msg;
	}


	/* PRODUCT TYPE */
	/*新增商品包裝*/
	public function addProductType($addItem){
		ProductTypeModel::create($addItem);
	}
	/*取得某商品包裝資料*/
	public function getProductType($productId){
		return ProductTypeModel::select('prod_type_id','prod_type','type_price','type_sales_price','type_sales_price_prime','type_status','prod_sn', 'order_id')->where('prod_id','=',$productId)
														->orderBy('order_id', 'asc')->orderBy('prod_type_id', 'asc')->get()->toArray();
	}

	/* PRODUCT SPEC(規格) */
	public function addProductSpec($addItem){
		ProdSpecificationModel::create($addItem);
	}
	public function getProductSpec($productId){
		return ProdSpecificationModel::select('prod_spec_id','spec_no','spec_name')->where('prod_id','=',$productId)->orderBy('spec_no','asc')->orderBy('prod_spec_id','asc')->get()->toArray();
	}

	/* IMG(副圖) */
	public function addProductImg($imgData){
		ProductImgModel::create($imgData);
	}
	public function editProductImg($whereData , $updData){	
		$msg = 0;
		try {
			ProductImgModel::where($whereData)->update($updData);
		} catch (\Exception $e) {
			$msg = 1;
		}
		return $msg;
	}
	public function getProductImg($productId, $type, $img_id=''){
		$productImgs = ProductImgModel::select('prod_img_id','prod_id','prod_img_name','prod_img_name2','prod_name','img_desc','prod_order','prod_file_size');
		if($img_id){
			$productImgs = $productImgs->where('prod_img_id','=',$img_id);
		}
		$productImgs = $productImgs->where('prod_id','=',$productId)
															->where('prod_img_type','=',$type)
															->orderBy('prod_order','asc')
															->orderBy('created_at','asc')
															->orderBy('prod_img_id','desc')->get()->toArray();

		return $productImgs;
	}

	/*DESCRIBE*/
	/*新增商品說明*/
	public function addProductDescribe($insertData){
		ProductDescribeModel::insert($insertData);
	}
	/*取得商品說明*/
	public function getProductDescribe($prodId){
		return ProductDescribeModel::select('prod_describe_id','prod_id','prod_describe_type','prod_describe','lang_id')->where('prod_id','=',$prodId)->get()->toArray();
	}

	/* SEO */
	public function getSeoPropertyTagNumByProdId($langId,$productNum ,$productId){
		return ProdSeoTagModel::
					leftJoin('prod_seo_property', function ($leftJoin) use ($productId) {
							$leftJoin->on('prod_seo_property_tag.seo_tag_id', '=', 'prod_seo_property.prop_tag_id')
					->where('prod_seo_property.prod_id','=', $productId );
						})
					->select('prod_seo_property_tag.seo_tag_id','prod_seo_property_tag.seo_name', 'prod_seo_property_tag.seo_meta_property','prod_seo_property_tag.seo_placeholder','prod_seo_property_tag.seo_type'
					,'prod_seo_property.prod_type_id','prod_seo_property.prod_id','prod_seo_property.prod_prop','prod_seo_property.prod_img_path')
					->where('prod_seo_property_tag.lang_id','=',$langId)->where('prod_seo_property_tag.seo_prod_num','=',$productNum)->where('prod_seo_property_tag.seo_status','=','1')
					->orderBy('prod_seo_property_tag.seo_tag_order', 'asc')->orderBy('prod_seo_property_tag.seo_tag_id', 'desc')
					->get()->toArray();
	}
	public function getSeoPropertyImgName($prod_type_id){
		return ProdSeoPropertyModel::select('prod_img_path')->where('prod_type_id','=',$prod_type_id)->first();
	}
	public function editProductSeoProperty($productId, $value, $langId){
		$msg = 1;
		try{
			$getItem = ProdSeoPropertyModel::select('prod_type_id')->where('prod_id','=',$productId)->where('prop_tag_id','=',$value['seo_tag_id'] )->first();
			if(!$getItem){
				$data = array(
					array('prod_id'=>$productId ,'prop_tag_id'=> $value['seo_tag_id'] ,'prod_prop'=> $value['prod_prop'],'prod_img_path'=> $value['prod_img_path'] ,'lang_id'=> $langId,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=> date('Y-m-d H:i:s'))
				);
				ProdSeoPropertyModel::insert($data);
			}else{
				ProdSeoPropertyModel::where('prod_type_id','=',$getItem['prod_type_id'])->update(['prod_prop' => $value['prod_prop'] ,'prod_img_path' => $value['prod_img_path']]);
			}
		}catch (\Exception $e){
			$msg = 0;
		}
		return $msg;
	}
	public function deleteProductSeoProperty($productId, $value, $langId){
		$msg = 1;
		try{
			$getItem = ProdSeoPropertyModel::select('prod_type_id')->where('prod_id','=',$productId)->where('prop_tag_id','=',$value['seo_tag_id'] )->first();
			if($getItem){
				ProdSeoPropertyModel::where('prod_type_id','=',$value['prod_type_id'])->delete();
			}
		}catch (\Exception $e){
			$msg = 0;
		}
		return $msg;
	}

	/*-----------------------------------------------------*/
	/* 購物相關(暫無用途) */
	public function getProductTypeFromCart($prodTypeId){
		return ProductTypeModel::select('product_type.prod_type_id','product_type.type_sales_price','product_type.prod_type','product.prod_name')
			->join('product', 'product.prod_id', '=', 'product_type.prod_id')
			->where('product_type.prod_type_id', '=', $prodTypeId)
			->first();
	}
	public function getFare($fareId){
		return FareModel::select('fare_id','fare_name','fare_cost')
			->where('fare_id', '=', $fareId)
			->first();
	}

	public function setStylelayout($prod_id,$style){

		ProductModel::where('prod_id',$prod_id)->update(['style'=>$style]);

	}

	public function setOwner($prod_id,$owner){

		ProductModel::where('prod_id',$prod_id)->update(['own_user'=>$owner]);

	}

	/*取得某行銷活動回函ID*/
	public function getProductContactId($prodId){	
		
		$count = ContactTypeModel::select('product_id')
		->where('product_id',$prodId)
		->count();

		if($count==0){
			$last=ContactTypeModel::select('conta_type_id')->orderby('conta_type_id','desc')->first();
			$new_id = $last->conta_type_id + 1;
			
			ContactTypeModel::insert(['conta_type_id'=>$new_id,'conta_type'=>'conta'.$new_id,'product_id'=>$prodId]);
		}
		return true;
	}

}