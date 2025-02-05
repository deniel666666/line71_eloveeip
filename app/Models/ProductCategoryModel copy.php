<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategoryModel extends Model
{
    protected $table = 'product_category';
    protected $primaryKey = 'prod_cate_id';
    protected $guarded = ['created_at', 'updated_at'];

    public function product()
    {
        return $this->belongsTo('App\Models\ProductModel', 'prod_id', 'prod_id');
    }
    
    public function categoryTag()
    {
        return $this->belongsTo('App\Models\CategoryTagModel', 'cate_tag_id', 'cate_tag_id');
    }
}
