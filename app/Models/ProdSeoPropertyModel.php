<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdSeoPropertyModel extends Model
{
    protected $table = 'prod_seo_property';
    // protected $primaryKey = 'prod_prop_id';
    protected $guarded = ['created_at', 'updated_at'];

    public function product()
    {
        return $this->belongsTo('App\Models\ProductModel', 'prod_id', 'prod_id');
    }

    public function propertyTag()
    {
        return $this->belongsTo('App\Models\PropertyTagModel', 'seo_tag_id', 'prop_tag_id');
    }
    
    public function lang()
    {
        return $this->belongsTo('App\Models\LangModel', 'lang_id', 'lang_id');
    }
}
