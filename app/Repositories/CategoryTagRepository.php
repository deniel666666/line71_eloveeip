<?php

namespace APP\Repositories;

use \App\Models\CategoryTagModel;
use \App\Models\ProductModel;
use \App\Models\ProductCategoryModel;
use App\Repositories\LangRepository;

class CategoryTagRepository{

    protected $mainId = 'cate_tag_id';
    protected $mainModel;
    private $LangRepository;
	public function __construct(
        CategoryTagModel            $mainModel,
        ProductModel 	            $productModel,
        ProductCategoryModel		$productCategoryModel,
        LangRepository              $LangRepository
    ){
        $this->mainModel                = $mainModel;
        $this->productModel 	        = $productModel;
        $this->productCategoryModel 	= $productCategoryModel;
        $this->LangRepository           = $LangRepository;
	}

    public function get($selectLangItem,$startIndex,$countOfPage,$searchByText){
        if($selectLangItem == 0){
            return $this->mainModel->with(['lang'])
            ->where('cate_name','like', '%'.$searchByText.'%')
			->orderBy('cate_order','asc')
			->orderBy('cate_tag_id','desc')
            ->offset($startIndex)->limit($countOfPage)->get()->toArray();
        }else{
            return $this->mainModel->with(['lang'])
            ->where('cate_name','like', '%'.$searchByText.'%')
            ->where('lang_id','=', $selectLangItem)
			->orderBy('cate_order','asc')
			->orderBy('cate_tag_id','desc')
            ->offset($startIndex)->limit($countOfPage)->get()->toArray();
        }
    }

    public function getId($selectLangItem,$startIndex,$countOfPage,$searchByText,$categoryTagId){
        if($selectLangItem == 0){
            return $this->mainModel->with(['lang'])
            ->where('cate_name','like', '%'.$searchByText.'%')
            ->where('cate_id','=',$categoryTagId)
			->orderBy('cate_order','asc')	
			->orderBy('cate_tag_id','desc')
            ->offset($startIndex)->limit($countOfPage)->get()->toArray();

        }else{
            return $this->mainModel->with(['lang'])
            ->where('cate_name','like', '%'.$searchByText.'%')
            ->where('lang_id','=', $selectLangItem)
            ->where('cate_id','=',$categoryTagId)
			->orderBy('cate_order','asc')	
			->orderBy('cate_tag_id','desc')
            ->offset($startIndex)->limit($countOfPage)->get()->toArray();
        }
    }

    // ---------------------------------------------------------------------------------------------------------------------
    public function thisClassShowAll($cateId,$langId,$searchByText,$hierarchyCount){
        if($langId == 0){
            return $this->mainModel->with(['lang'])
            ->where('cate_name','like', '%'.$searchByText.'%')
            ->where('cate_id','=',$cateId)
            ->where('hierarchy_count','=',$hierarchyCount)
			->orderBy('cate_order','asc')	
			->orderBy('cate_tag_id','desc')
            ->get()->toArray();
        }else{
            return $this->mainModel->with(['lang'])
            ->where('cate_name','like', '%'.$searchByText.'%')
            ->where('lang_id','=', $langId)
            ->where('cate_id','=',$cateId)
            ->where('hierarchy_count','=',$hierarchyCount)
			->orderBy('cate_order','asc')	
			->orderBy('cate_tag_id','desc')
            ->get()->toArray();
        }
    }

    public function downSearchClassShowAll($cateId,$langId,$searchByText,$hierarchyCount,$parentId){
        if($langId == 0){
            return $this->mainModel->with(['lang'])
            ->where('cate_name','like', '%'.$searchByText.'%')
            ->where('cate_id','=',$cateId)
            ->where('hierarchy_count','=',$hierarchyCount)
            ->where('parent_id','=',$parentId)
			->orderBy('cate_order','asc')	
			->orderBy('cate_tag_id','desc')
            ->get()->toArray();
        }else{
            return $this->mainModel->with(['lang'])
            ->where('cate_name','like', '%'.$searchByText.'%')
            ->where('lang_id','=', $langId)
            ->where('cate_id','=',$cateId)
            ->where('hierarchy_count','=',$hierarchyCount)
            ->where('parent_id','=',$parentId)
			->orderBy('cate_order','asc')	
			->orderBy('cate_tag_id','desc')
            ->get()->toArray();
        }
    }
    // ---------------------------------------------------------------------------------------------------------------------


    /* 計算本層以下(含)商品總數 */
    public function showProAllForByTag($langType,$cate_id)
    {	
        $res = $this->productCategoryModel
            ->join('product','product.prod_id','=','product_category.prod_id')
            ->join('category_tag', 'category_tag.cate_tag_id', '=', 'product_category.cate_tag_id')
            ->where('hierarchy_id', 'like', '%:"'.$cate_id.'"%')
            ->where('product.prod_status', '=', 0)
            ->whereNull('product.deleted_at')
            ->get()->count();
        // dump($res);
        return $res;
    }
    /* 計算本層商品數 */
    public function showProAll($langType,$cate_id){	
        return $this->productCategoryModel
                    ->where('cate_tag_id', '=', $cate_id)
                    ->join('product','product.prod_id','=','product_category.prod_id')
                    ->whereNull('product.deleted_at')
                    ->where('product.prod_status', '=', 0)
					->get()->count();
    }
    /* 計算本層且設為上架商品數 */
    public function showProShelves($langType,$cate_id)
    {	
        return $this->productCategoryModel
                    ->where('cate_tag_id', '=', $cate_id)         
                    ->join('product','product.prod_id','=','product_category.prod_id')
                    ->where('product.prod_shelf', '=', 1)
                    ->where('product.prod_status', '=', 0)
                    ->whereNull('product.deleted_at')
					->get()->count();
    }   
  
    public function getAll($langType,$cate_id,$startIndex,$countOfPage,$searchByText)
    {	
        return $this->mainModel->where('lang_id', '=', $langType)
					->where('cate_id', '=', $cate_id)
					 ->where('cate_name','like', '%'.$searchByText.'%')
					->where('cate_status', '=', 1)
					->orderBy('cate_order', 'asc')
					->orderBy('cate_tag_id','desc')
					->offset($startIndex)->limit($countOfPage)->get();
    }


    //-------------------------------------------------------------------------------start

    /* 串接資料用 */
    public function getLayerAll($cond)
    {   
        // dump($cond);

        $mainModel_select = $this->mainModel->with(['lang'])
                                ->select('*');
                                // ->select('cate_tag_id','cate_id','cate_name','cate_subtitle','tag_img','tag_img_wide','cate_tag_img','cate_tag_desc','cate_order','cate_status','lang_id','hierarchy_id','hierarchy_count','parent_id','promote');

        if(isset($cond['langId'])){ /*語言版id*/
            if($cond['langId']!=''){ $mainModel_select->where('lang_id', '=', $cond['langId']); }
        }
        if(isset($cond['langType'])){ /*語言版*/
            $lang_type = $this->LangRepository::show_by_type($cond['langType']);
            $lang_type_id = $lang_type ? $lang_type['lang_id'] : '';
            if($lang_type_id!=''){ $mainModel_select->where('lang_id', '=', $lang_type_id); }
        }

        if(isset($cond['productNum'])){ /*商品別數字*/
            if($cond['productNum']!=''){ $mainModel_select->where('cate_id', '=', $cond['productNum']); }
        }

        if(isset($cond['searchByText'])){ /*tag名稱*/
            if($cond['searchByText']!=''){ $mainModel_select->where('cate_name','like', '%'.$cond['searchByText'].'%'); }
        }

        if(isset($cond['parentsHasId'])){ /*父階層id*/
            if($cond['parentsHasId']!=''){ $mainModel_select->where('hierarchy_id','like', '%:"'.$cond['parentsHasId'].'"%'); }
        }

        if(isset($cond['level'])){ /*所屬階層(1為頂層)*/
            if($cond['level']!=''){ $mainModel_select->where('hierarchy_count', '=', $cond['level']); }
        }

        if(isset($cond['cateStatus'])){ /*啟用停用*/
            if( $cond['cateStatus']!=''){ $mainModel_select->where('cate_status', '=', $cond['cateStatus']); }
        }

        if(isset($cond['promote'])){ /*推薦*/
            if($cond['promote']!=''){ $mainModel_select->where('promote', '=', $cond['promote']); }
        }

        if(isset($cond['idArray'])){ /*要找尋的所有id*/
            if($cond['idArray']!=''){ $mainModel_select->whereIn('cate_tag_id', json_decode($cond['idArray'])); }
        }

        if(isset($cond['countOfPage'])){ /*起始值、限制數量(分頁用)*/
            if($cond['countOfPage']!=0){
                $currentPage = $cond['currentPage'];
                $countOfPage = $cond['countOfPage'];
                $startIndex  = ( $currentPage!='' && $countOfPage !='') ? ($currentPage-1) * $countOfPage : 0; /*計算得起始index值*/
                $mainModel_select->offset($startIndex)->limit($countOfPage);
            }
        }


        return $mainModel_select->orderBy('cate_order', 'asc')->orderBy('cate_tag_id','desc')->get();
    }

    //-------------------------------------------------------------------------------end

    public function getLangIdByMainId($id)
    {
        return $this->mainModel->select('lang_id')->where($this->mainId, '=', $id)->get();
    }

    public function getAllCategoryTagCountByLangId($LangId)
    {
        return $this->mainModel->where('lang_id', '=', $LangId)->count();
    }

    public function getAllCategoryTagOffStatusCountByLangId($LangId)
    {
        return $this->mainModel->where('lang_id', '=', $LangId)->where('cate_status','=',0)->count();
    }

    public function setStatus($ids,$updData){
        if(count($ids) > 0){
            $this->mainModel->whereIn($this->mainId,$ids)->update($updData);
        }
    }

    public function add($insertData){
        $res = $this->mainModel->create($insertData);
		return $res[$this->mainId];
    }

    public function edit($id,$updData){
        $res = $this->mainModel->where($this->mainId,'=',$id)->update($updData);
        return  $res;
    }

    public function delete($ids){
        if(count($ids) > 0){
            $this->mainModel->whereIn($this->mainId,$ids)->delete();
        }
	}

    //-------------------------------------------------------------------------
    //-------------------------------------------------------------------------
    //-------------------------------------------------------------------------
    //-------------------------------------------------------------------------
    public function hierarchy($selectLangItem , $productNum , $tagId = 0){

        $mainModel_select = $this->mainModel->with(['lang']);

        if($selectLangItem!='' && $selectLangItem!='null'){
            $mainModel_select->where('lang_id','=', $selectLangItem);
        }
        if($productNum!='' && $productNum!='null'){
            $mainModel_select->where('cate_id','=', $productNum);
        }
        if($tagId!='' && $tagId!='null'){
            $mainModel_select->where('cate_tag_id','!=', $tagId);
        }

        return $mainModel_select->orderBy('hierarchy_count','asc')
                ->orderBy('cate_order','asc')
                ->orderBy('cate_tag_id','desc')
                ->get()->toArray();
    }

    public function treeIdArrUp($ids , $selectLangItem, $productNum, $tagId = 0){

        $mainModel_select = $this->mainModel->with(['lang']);

        if(!empty($ids)){
            $mainModel_select->whereNotIn('cate_tag_id' , $ids);
        }
        if($selectLangItem!='' && $selectLangItem!='null'){
            $mainModel_select->where('lang_id','=', $selectLangItem);
        }
        if($productNum!='' && $productNum!='null'){
            $mainModel_select->where('cate_id','=', $productNum);
        }
        if($tagId!='' && $tagId!='null' ){
            $mainModel_select->where('cate_tag_id','!=', $tagId);
        }

        return $mainModel_select->orderBy('hierarchy_count','asc')
                ->orderBy('cate_order','asc')
                ->orderBy('cate_tag_id','desc')
                ->get()->toArray();
    }

    /* 修改名稱成階層格式 */
    public function tree($arr, $pid, $level){  //$pid = 0 第一階 $level=1  第一階
        // return $arr;
        static $tree = array();
        foreach($arr as $v){
            if($v['parent_id'] == $pid){

                if($v['hierarchy_count'] == $level){
                    $v['level'] = $level;
                    $v['name'] =$v['cate_name'];

                    // $v['cate_name'] =str_repeat('|___',$level).$level.'階 : '.$v['cate_name']; // /* 加入階層前綴+階層數 */
                    // $v['cate_name'] =$level.'階 : '.$v['cate_name']; /* 只加入階層數 */

                    /* 加入到此之前的選單 開始------------ */
                    $tag_path = [$v['cate_name']];
                    $parent_id = $v['parent_id'];
                    while ($parent_id!=0) { 
                        $parent_tag =  $this->mainModel->where('cate_tag_id','=', $parent_id)->get()->toArray();
                        if($parent_tag){
                            array_push($tag_path, $parent_tag[0]['cate_name']);
                        }
                        $parent_id =  $parent_tag ? $parent_tag[0]['parent_id'] : 0;
                    }
                    $tag_path = array_reverse($tag_path);
                    $v['cate_name'] = implode('>', $tag_path);
                    /* 加入到此之前的選單 結束------------ */

                    $tree[] = $v;

                    $this->tree($arr, $v['cate_tag_id'], $level + 1);
                }
            }
        }
        return $tree;

    }
    public function treeIdArr($arr, $pid, $level){  //$pid = 0 第一階 $level=1  第一階
        static $tree = array();
        foreach($arr as $v){
            if($v['parent_id'] == $pid){
                if($v['hierarchy_count'] == $level){
                    $tree[] = $v['cate_tag_id'];
                    $this->treeIdArr($arr, $v['cate_tag_id'], $level + 1);
                }
            }
        }
        return $tree;
    }
    //-------------------------------------------------------------------------
    //-------------------------------------------------------------------------
    //-------------------------------------------------------------------------

    public function show_tag_with_layer_name($tags){
        $tag_with_layer_name = [];
        foreach ($tags as $t_k => $t_v) {
            $path=[];
            if($t_v['cate_status']==1){
                array_push($path, $t_v['cate_name']);
                $parent_id = $t_v['parent_id'];

                // 往上找父tag
                while ( $parent_id!= 0) {
                    $prev_tag = $this->mainModel->select('*')->where('cate_tag_id', '=', $parent_id)->get()->toArray()[0];
                    array_push($path, $prev_tag['cate_name']);
                    $parent_id = $prev_tag['parent_id'];
                }

                $path = array_reverse($path);
                $path_name = implode('>', $path);
                array_push($tag_with_layer_name, $path_name);
            }
        }
        return $tag_with_layer_name;
    }

    // delete cate_tag_id start
    public function getOneByTagTd($cate_id ,$tagId){	
        return $this->mainModel->select('*')
					->where('cate_id', '=', $cate_id)
                    ->where('cate_tag_id', '=', $tagId)
                    ->first();
    }

    public function searchSingleLowerclass($hierarchy_count , $parent_id){  
        $hierarchy_count+=1;
        return $this->mainModel
            ->where('hierarchy_count' ,'=', $hierarchy_count)
            ->where('parent_id' ,'=',  $parent_id)
            ->count();
    }

    public function deleteCateTagIdAndProCateTagId($cate_tag_id){	

		$msg = 0;
		try {
            $this->mainModel
            ->where('cate_tag_id', '=', $cate_tag_id)
            ->delete();
            $this->productCategoryModel
            ->where('cate_tag_id', '=', $cate_tag_id)
            ->delete();
		} catch (\Exception $e) {
			$msg = 1;
		}

		return $msg;
    }
    // delete cate_tag_id end
}