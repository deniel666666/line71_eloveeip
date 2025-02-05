<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyTagModel extends Model
{
    protected $table = 'property_tag';
    protected $primaryKey = 'prop_tag_id';
    protected $guarded = ['created_at', 'updated_at'];
    
    public function productProperty()
    {
        return $this->hasMany('App\Models\ProductPropertyModel', 'prop_tag_id', 'prop_tag_id');
    }
    

    public function lang()
    {
        return $this->belongsTo('App\Models\LangModel', 'lang_id', 'lang_id');
    }
}
