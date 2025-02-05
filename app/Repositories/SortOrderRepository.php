<?php

namespace APP\Repositories;

use \App\Models\CategoryTagModel;
use \App\Models\CategoryProOrderModel;
use \App\Models\ProductModel;
use \App\Models\PropertyTagModel;
use \App\Models\ProductImgModel;
use \App\Models\ProdLabelTagModel;
use \App\Models\ProdSeoTagModel;
use \App\Models\ProdTabsTagModel;
use APP\Repositories\ProductRepository;

use \App\Models\ContentTagModel;
use \App\Models\ContentModel;

use \DB;

class SortOrderRepository{

    // 更新cms內容排序
    public function cmsContSort($CmsModel, $updateData ,$infor){
        $modelId = 'cms_id';
        $order = $updateData['order_id'];
        $orderName ='order_id';        
        $databaseModel = $CmsModel;
        $whereDataSame = [[$orderName,'=',$order],['child_template_id','=',$infor->child_template_id],['cms_type_id','=',$infor->cms_type_id]];
        $hasId = $this->getAllSameOrder($databaseModel ,$whereDataSame ,$modelId );

        if( isset($updateData['cmsId']) ){
            $editTarget = $this->getEditTarget($CmsModel, $modelId, $updateData['cmsId']);
            
            if($editTarget){
                // 如果編輯目標的排序與原本相同，就略過處理排序
                if($editTarget[0][$orderName]==$order){
                    return ['status' => '200'];
                }
            }
        }

        if( count($hasId) >0 ){
            $whereData = [[$orderName,'>=',$order],['child_template_id','=',$infor->child_template_id],['cms_type_id','=',$infor->cms_type_id]];            
            $getAllSameOrderArr = $this->getAllSameOrder($databaseModel ,$whereData ,$modelId);
           
            if( count($getAllSameOrderArr) !=0 ){
                $whereInIds =$getAllSameOrderArr;
                DB::beginTransaction();
                $msgCount = $this->setCmsGreaterOrEqualOrder($databaseModel ,$whereInIds,$modelId,$orderName);
                if ( count($whereInIds) != $msgCount) {
                    DB::rollback();
                } else {
                    DB::commit();
                }
            }
        }
    }
    public function setCmsGreaterOrEqualOrder($databaseModel,$whereInIds ,$idName,$orderName){
        $msg = 0;
        foreach($whereInIds as $key => $id){
            $msg+=1;
            $getContByCmsIdData = $databaseModel->where('cms_id','=',$id)->first();
            $updateData = [
                'order_id' =>strval($getContByCmsIdData->order_id+=1),
            ];
            $databaseModel->where($idName,'=', $id )->update($updateData);
        }
        return $msg;
    }

    // gallery Sort   ###has lang_id
    public function gallerySort($GalleryModel , $item){
        $galleryTypeId = $item['gallery_type_id'];
        $langId = $item['lang_id'];
        $sliderOrder = $item['slider_order'];

        // $SortOrderRepository = new SortOrderRepository();
        $whereDataSame = [['gallery_type_id','=',$galleryTypeId],['slider_order','=',$sliderOrder],['lang_id','=',$langId]];
        if(isset($item['member_id'])){
            array_push($whereDataSame, ['member_id','=',$item['member_id']]);
        }
        // return $whereDataSame;
        $hasId = $this->getAllSameOrder($GalleryModel ,$whereDataSame ,'gallery_id');
        // dump($hasId);

        if( isset($item['gallery_id']) ){
            $editTarget = $this->getEditTarget($GalleryModel ,'gallery_id', $item['gallery_id']);
            
            if($editTarget){
                // 如果編輯目標的排序與原本相同，就略過處理排序
                if($editTarget[0]['slider_order']==$sliderOrder){
                    return ['status' => '200'];
                }
            }
        }

        if( count($hasId) >0 ){
            $whereData = [['gallery_type_id','=',$galleryTypeId ],['slider_order','>=',$sliderOrder],['lang_id','=',$langId]];
            if(isset($item['member_id'])){
                array_push($whereData, ['member_id','=',$item['member_id']]);
            }
            $getAllSameOrderArr = $this->getAllSameOrder($GalleryModel ,$whereData ,'gallery_id');
            // return [$hasId , $getAllSameOrderArr];
            if( count($getAllSameOrderArr) !=0 ){
                $whereInIds =$getAllSameOrderArr;
                DB::beginTransaction();
                $msgCount = $this->setGreaterOrEqualOrder($GalleryModel ,$whereInIds,'gallery_id','slider_order');
                if ( count($whereInIds) != $msgCount) {
                    DB::rollback();
                } else {
                    DB::commit();
                }
            }
        }
    }

    /*取得編輯的目標*/
    public function getEditTarget($modelName, $idName, $idValue){
        $res =  $modelName->select('*')->where($idName,'=',$idValue)->get()->toArray();
        return  $res;
    }
    /*取得排序相同的id*/
    public function getAllSameOrder($modelName,$whereData ,$idName){
        $res =  $modelName->select($idName)->where($whereData)->get()->toArray();
        $hasProId=[];
        foreach($res as $resKey => $resValue){
            array_push($hasProId, $resValue[$idName]);
        }
        return  $hasProId;
	}

    public function setGreaterOrEqualOrder($modelName,$whereInIds ,$idName,$orderName){

        $msg = 0;
        foreach($whereInIds as $key => $id){
            $msg+=1;
            $modelName->where($idName,'=', $id )->increment($orderName);
        }

        return $msg;
	}

    // 商品改總排序
    public function productSort($productNum ,$item, $check_edit_target=true){

        $ProductModel =  new ProductModel;
        $whereDataSame = [['product_num','=',$productNum ],['prod_order','=',$item['prod_order']],['deleted_at','=',null],['prod_status','=',0],['lang_id','=',$item['lang_id']] ];
        $hasId = $this->getAllSameOrder($ProductModel ,$whereDataSame ,'prod_id');
        $editTarget = $this->getEditTarget($ProductModel ,'prod_id', $item['prod_id']);

        if( isset($item['prod_id']) && $check_edit_target){
            if($editTarget){
                // 如果編輯目標的排序與原本相同，就略過處理排序
                if($editTarget[0]['prod_order']==$item['prod_order']){
                    return ['status' => '200'];
                }
            }
        }

        if( count($hasId) >0 ){
            $whereData = [['product_num','=',$productNum ],['prod_order','>=',$item['prod_order']],['deleted_at','=',null],['prod_status','=',0],['lang_id','=',$item['lang_id']] ];
            $getAllSameOrderArr = $this->getAllSameOrder($ProductModel ,$whereData ,'prod_id');

            if( count($getAllSameOrderArr) !=0 ){
                $whereInIds =$getAllSameOrderArr;  
                DB::beginTransaction();
                $msgCount = $this->setGreaterOrEqualOrder($ProductModel ,$whereInIds ,'prod_id','prod_order');

                if ( count($whereInIds) != $msgCount) {
                    DB::rollback();
                    $retData = ['status' => '400'];

                } else {
                    // $res = $this->mainRepository->update($prodId,$updData);
                    DB::commit();
                    $retData = ['status' => '200'];
                }
            }

        }else{
            // $res = $this->mainRepository->update($prodId,$updData);            
            $retData = ['status' => '200'];
        }

        return  $retData;
    }
    // 商品改分類排序
    public function productCategorySort($item){

        $modelId='product_id';
        $CategoryProOrderModel =  new CategoryProOrderModel;
        $databaseModel = $CategoryProOrderModel;
        $orderName ='category_order';
        $order =$item['category_order'];
        $whereDataSame = [[$orderName,'=',$order ],['category_id','=',$item['category_id'] ] ];  //,['product_id','=',$item['prod_id'] ]
        $hasId = $this->getAllSameOrder($databaseModel ,$whereDataSame ,$modelId );

        if( count($hasId) >0 ){

            $whereData = [[$orderName,'>=',$order],['category_id','=',$item['category_id'] ]];
            $getAllSameOrderArr = $this->getAllSameOrder($databaseModel ,$whereData ,$modelId);

            if( count($getAllSameOrderArr) !=0 ){
                $whereInIds =$getAllSameOrderArr;
                DB::beginTransaction();
                $msgCount = $this->setGreaterOrEqualOrder($databaseModel ,$whereInIds,$modelId,$orderName);

                if ( count($whereInIds) != $msgCount) {
                    DB::rollback();
                    $retData = ['status' => '400'];
                } else {
                    DB::commit();
                    $retData = ['status' => '200'];
                }
            }
        }else{
            $retData = ['status' => '200'];

        }

        return  $retData;
    }

    // 商品分類(tag)改排序
    public function categoryTagSort($item){

        $modelId = 'cate_tag_id';
        $order = $item['cate_order'];
        $orderName ='cate_order';
        $CategoryTagModel =  new CategoryTagModel;
        $databaseModel = $CategoryTagModel;
        $whereDataSame = [[$orderName,'=',$order],['cate_id','=',$item['cate_id']],['lang_id','=',$item['lang_id']],['parent_id','=',$item['parent_id']],['hierarchy_count','=',$item['hierarchy_count']] ];

        $hasId = $this->getAllSameOrder($databaseModel ,$whereDataSame ,$modelId );

        if( isset($item[$modelId]) ){
            $editTarget = $this->getEditTarget($databaseModel ,$modelId, $item[$modelId]);

            if($editTarget){
                // 如果編輯目標的排序與原本相同，就略過處理排序
                if($editTarget[0][$orderName]==$order){
                    return ['status' => '200'];
                }
            }
        }

        if( count($hasId) >0 ){
            $whereData = [[$orderName,'>=',$order],['cate_id','=',$item['cate_id']],['lang_id','=',$item['lang_id']],['parent_id','=',$item['parent_id']],['hierarchy_count','=',$item['hierarchy_count']] ];
            $getAllSameOrderArr = $this->getAllSameOrder($databaseModel ,$whereData ,$modelId);

            if( count($getAllSameOrderArr) !=0 ){
                $whereInIds =$getAllSameOrderArr;
                DB::beginTransaction();
                $msgCount = $this->setGreaterOrEqualOrder($databaseModel ,$whereInIds,$modelId,$orderName);

                if ( count($whereInIds) != $msgCount) {
                    DB::rollback();

                } else {
                    DB::commit();
                }
            }
        }
    }

    // 商品附圖改排序
    public function productImgSort($item, $new_order){
        $modelId = 'prod_img_id';
        $order = $new_order;
        $orderName ='prod_order';
        $ProductImgModel =  new ProductImgModel;
        $databaseModel = $ProductImgModel;
        $whereDataSame = [
            [$orderName,'=', $order],
            ['prod_id', '=', $item['prod_id']],
        ];
        $hasId = $this->getAllSameOrder($databaseModel, $whereDataSame, $modelId);

        if( isset($item[$modelId]) ){
            $editTarget = $this->getEditTarget($databaseModel ,$modelId, $item[$modelId]);

            if($editTarget){
                // 如果編輯目標的排序與原本相同，就略過處理排序
                if($editTarget[0][$orderName]==$order){
                    return ['status' => '200'];
                }
            }
        }

        if( count($hasId) >0 ){
            $whereData = [
                [$orderName,'>=',$order],
                ['prod_id', '=', $item['prod_id']],
            ];
            $getAllSameOrderArr = $this->getAllSameOrder($databaseModel, $whereData, $modelId);

            if( count($getAllSameOrderArr) !=0 ){
                $whereInIds =$getAllSameOrderArr;
                DB::beginTransaction();
                $msgCount = $this->setGreaterOrEqualOrder($databaseModel, $whereInIds, $modelId, $orderName);

                if ( count($whereInIds) != $msgCount) {
                    DB::rollback();

                } else {
                    DB::commit();
                }
            }
        }
    }

    // product PropertyTag Sort   ###has lang_id
    public function productPropertyTagSort($item, $tartgetId=false){
        // dump($item);exit;

        $modelId = 'prop_tag_id';
        $order = $item['prop_tag_order'];
        $orderName ='prop_tag_order';
        $PropertyTagModel =  new PropertyTagModel;
        $databaseModel = $PropertyTagModel;
        $whereDataSame = [[$orderName,'=',$order],['property_tag_id','=',$item['property_tag_id']],['lang_id','=',$item['lang_id']] ];

        $hasId = $this->getAllSameOrder($databaseModel ,$whereDataSame ,$modelId );

        if( $tartgetId ){
            $editTarget = $this->getEditTarget($databaseModel ,$modelId, $tartgetId);
            if($editTarget){
                // 如果編輯目標的排序與原本相同，就略過處理排序
                if($editTarget[0][$orderName]==$order){
                    return ['status' => '200'];
                }
            }
        }

        if( count($hasId) >0 ){
            $whereData = [[$orderName,'>=',$order],['property_tag_id','=',$item['property_tag_id']],['lang_id','=',$item['lang_id']] ];
            $getAllSameOrderArr = $this->getAllSameOrder($databaseModel ,$whereData ,$modelId);

            if( count($getAllSameOrderArr) !=0 ){
                $whereInIds =$getAllSameOrderArr;
                DB::beginTransaction();
                $msgCount = $this->setGreaterOrEqualOrder($databaseModel ,$whereInIds,$modelId,$orderName);

                if ( count($whereInIds) != $msgCount) {
                    DB::rollback();
                } else {
                    DB::commit();
                }
            }
        }
    }
   
    // product LabelTag Sort   ###has lang_id
    public function productLabelTagSort($item, $tartgetId=false){

        $modelId = 'label_tag_id';
        $order = $item['label_order'];
        $orderName ='label_order';
        $ProdLabelTagModel =  new ProdLabelTagModel;
        $databaseModel = $ProdLabelTagModel;

        $whereDataSame = [[$orderName,'=',$order],['label_prod_num','=',$item['label_prod_num']],['lang_id','=',$item['lang_id']]];
        $hasId = $this->getAllSameOrder($databaseModel ,$whereDataSame ,$modelId );

        if( $tartgetId ){
            $editTarget = $this->getEditTarget($databaseModel ,$modelId, $tartgetId);
            if($editTarget){
                // 如果編輯目標的排序與原本相同，就略過處理排序
                if($editTarget[0][$orderName]==$order){
                    return ['status' => '200'];
                }
            }
        }

        if( count($hasId) >0 ){
            $whereData = [[$orderName,'>=',$order],['label_prod_num','=',$item['label_prod_num']],['lang_id','=',$item['lang_id']]];
            $getAllSameOrderArr = $this->getAllSameOrder($databaseModel ,$whereData ,$modelId);

            if( count($getAllSameOrderArr) !=0 ){
                $whereInIds =$getAllSameOrderArr;
                DB::beginTransaction();
                $msgCount = $this->setGreaterOrEqualOrder($databaseModel ,$whereInIds,$modelId,$orderName);

                if ( count($whereInIds) != $msgCount) {
                    DB::rollback();

                } else {
                    DB::commit();
                }
            }
        }
    }

    // productSeoTagSort start  ###has lang_id
    public function productSeoTagSort($item, $tartgetId=false){

        $modelId = 'seo_tag_id';
        $order = $item['seo_tag_order'];
        $orderName ='seo_tag_order';
        $ProdSeoTagModel =  new ProdSeoTagModel;
        $databaseModel = $ProdSeoTagModel;

        $whereDataSame = [[$orderName,'=',$order],['seo_prod_num','=',$item['seo_prod_num']],['lang_id','=',$item['lang_id']]];
        $hasId = $this->getAllSameOrder($databaseModel ,$whereDataSame ,$modelId );

        if( $tartgetId ){
            $editTarget = $this->getEditTarget($databaseModel ,$modelId, $tartgetId);
            if($editTarget){
                // 如果編輯目標的排序與原本相同，就略過處理排序
                if($editTarget[0][$orderName]==$order){
                    return ['status' => '200'];
                }
            }
        }

        if( count($hasId) >0 ){
            $whereData = [[$orderName,'>=',$order],['seo_prod_num','=',$item['seo_prod_num']],['lang_id','=',$item['lang_id']]];
            $getAllSameOrderArr = $this->getAllSameOrder($databaseModel ,$whereData ,$modelId);
            if( count($getAllSameOrderArr) !=0 ){
                $whereInIds =$getAllSameOrderArr;
                DB::beginTransaction();
                $msgCount = $this->setGreaterOrEqualOrder($databaseModel ,$whereInIds,$modelId,$orderName);

                if ( count($whereInIds) != $msgCount) {
                    DB::rollback();
                } else {
                    DB::commit();
                }
            }
        }
    }

    // productTabsSort start  ###has lang_id
    public function productTabsSort($item, $tartgetId=false){

        $modelId = 'tabs_tag_id';
        $order = $item['tabs_order'];
        $orderName ='tabs_order';
        $ProdTabsTagModel =  new ProdTabsTagModel;
        $databaseModel = $ProdTabsTagModel;

        $whereDataSame = [[$orderName,'=',$order],['tabs_prod_num','=',$item['tabs_prod_num']],['lang_id','=',$item['lang_id']]];
        $hasId = $this->getAllSameOrder($databaseModel ,$whereDataSame ,$modelId );

        if( $tartgetId ){
            $editTarget = $this->getEditTarget($databaseModel ,$modelId, $tartgetId);
            if($editTarget){
                // 如果編輯目標的排序與原本相同，就略過處理排序
                if($editTarget[0][$orderName]==$order){
                    return ['status' => '200'];
                }
            }
        }

        if( count($hasId) >0 ){
            $whereData = [[$orderName,'>=',$order],['tabs_prod_num','=',$item['tabs_prod_num']],['lang_id','=',$item['lang_id']]];
            $getAllSameOrderArr = $this->getAllSameOrder($databaseModel ,$whereData ,$modelId);

            if( count($getAllSameOrderArr) !=0 ){
                $whereInIds =$getAllSameOrderArr;
                DB::beginTransaction();

                $msgCount = $this->setGreaterOrEqualOrder($databaseModel ,$whereInIds,$modelId,$orderName);
                if ( count($whereInIds) != $msgCount) {
                    DB::rollback();
                } else {
                    DB::commit();
                }
            }
        }
    }
}

