<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryTagModel extends Model
{
    protected $table = 'category_tag';
    protected $primaryKey = 'cate_tag_id';
    protected $guarded = ['created_at', 'updated_at'];
    
    public function lang()
    {
        return $this->belongsTo('App\Models\LangModel', 'lang_id', 'lang_id');
    }

    public function propduct()
    {
        return $this->hasMany('App\Models\ProductModel', 'category_tag', 'category_tag');
    }
}
