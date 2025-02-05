<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoModel extends Model
{
    protected $table = 'seo';
    protected $primaryKey = 'seo_id';
    protected $guarded = ['created_at', 'updated_at'];

    public function lang()
    {
        return $this->belongsTo('App\Models\LangModel', 'lang_id', 'lang_id');
    }
}