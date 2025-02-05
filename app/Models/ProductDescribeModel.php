<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDescribeModel extends Model
{
    protected $table = 'product_describe';
    protected $primaryKey = 'prod_describe_id';
    protected $guarded = ['created_at', 'updated_at'];

    public function product()
    {
        return $this->belongsTo('App\Models\ProductModel', 'prod_id', 'prod_id');
    }
    
    public function lang()
    {
        return $this->belongsTo('App\Models\LangModel', 'lang_id', 'lang_id');
    }
}
