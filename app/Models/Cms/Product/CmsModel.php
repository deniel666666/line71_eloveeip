<?php
namespace App\Models\Cms\Product;

use Illuminate\Database\Eloquent\Model;

class CmsModel extends Model
{
    protected $table        = 'product_cms';
    protected $primaryKey   = 'cms_id';
    protected $guarded      = ['created_at', 'updated_at'];

    public function cmsType()
    {
        return $this->belongsTo('App\Models\ProductModel', 'cms_type_id', 'prod_id'); /*cms內容綁定商品*/
    }
}
