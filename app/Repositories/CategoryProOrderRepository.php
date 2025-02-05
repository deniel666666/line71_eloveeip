<?php



namespace APP\Repositories;



use \App\Models\CategoryTagModel;
use \App\Models\ProductModel;
use \App\Models\CategoryProOrderModel;
use \DB;
class CategoryProOrderRepository{
	public function __construct(
        CategoryTagModel            $categoryTagModel,
        ProductModel 	            $productModel,
        CategoryProOrderModel		$categoryProOrderModel
    ){
        $this->categoryTagModel                 = $categoryTagModel;
        $this->productModel 	        = $productModel;
        $this->categoryProOrderModel 	= $categoryProOrderModel;
	}

    public function addOne($cate_tag_id,$productId){
        $insertData=[
            'category_id' => $cate_tag_id,
            'product_id' => $productId
        ];
        $res = $this->categoryProOrderModel->create($insertData);
    }

    public function deleteOne($cate_tag_id,$productId){
        $res = $this->categoryProOrderModel->where('category_id','=',$cate_tag_id)->where('product_id','=',$productId)->delete();
    }


    public function updateOne($updData){
        // dump($updData);

        $data = ['category_order'=>$updData['category_order'] ];
        // dump($data);
        $this->categoryProOrderModel->where('category_id','=',$updData['category_id'])->where('product_id','=',$updData['prod_id'])->update($data);

    }

}