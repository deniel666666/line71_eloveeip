<?php



namespace APP\Repositories;



use \App\Models\ProductLabelModel;
use \App\Models\ProductLabelTagModel;



class ProductLabelTagRepository{


	const PrimaryKey = "label_tag_id";
	public function __construct(
        ProductLabelModel $productLabelModel,
        ProductLabelTagModel $productLabelTagModel
    ){
		$this->productLabelModel = $productLabelModel;
		$this->productLabelTagModel = $productLabelTagModel;
	}

    public function show($langId,$num ,$proId){
        return $this->productLabelTagModel
        ->leftJoin('prod_label', function ($leftJoin) use ($proId) {
            $leftJoin->on('prod_label.label_tag_id', '=', 'prod_label_tag.label_tag_id')
			->where('prod_label.prod_id','=', $proId );
        })
        ->select('prod_label_tag.label_tag_id','prod_label_tag.label_name','label_img','prod_label.prod_id','prod_label.label_tag_id as has_label')
		->where('prod_label_tag.lang_id','=', $langId )
		->where('prod_label_tag.label_prod_num','=',$num)
        ->where('prod_label_tag.label_status','=',1)
        ->orderBy('prod_label_tag.label_order','asc')->orderBy('prod_label_tag.label_tag_id','asc')
        ->get()->toArray();
    }


    public function edit( $productId ,$items ){
        $this->productLabelModel
        ->where('prod_id','=', $productId)
        ->delete();

        $this->productLabelModel->insert($items);

    }


    public function showHasLabelById($langId,$num ,$proId){
        return $this->productLabelTagModel
        ->leftJoin('prod_label', function ($leftJoin) use ($proId) {
            $leftJoin->on('prod_label.label_tag_id', '=', 'prod_label_tag.label_tag_id')
			->where('prod_label.prod_id','=', $proId );
        })
        ->select('prod_label_tag.label_tag_id','prod_label_tag.label_name','label_img','prod_label_tag.label_img_desc','prod_label_tag.label_tag_cont','prod_label_tag.label_order','prod_label.prod_id','prod_label.label_tag_id as has_label')
		->where('prod_label_tag.lang_id','=', $langId )
		->where('prod_label_tag.label_prod_num','=',$num)
		->where('prod_label_tag.label_status','=',1)
        ->where('prod_label.label_tag_id','!=',null)
        ->orderBy('prod_label_tag.label_order','asc')->orderBy('prod_label_tag.label_tag_id','asc')
        // ->whereNull('')
        ->get()->toArray();
    }


}