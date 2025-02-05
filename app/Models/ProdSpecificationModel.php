<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdSpecificationModel extends Model
{
    protected $table = 'prod_specification';
    protected $primaryKey = 'prod_spec_id';
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
