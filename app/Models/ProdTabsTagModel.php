<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdTabsTagModel extends Model
{
    protected $table = 'prod_tabs_property_tag';
    protected $primaryKey = 'tabs_tag_id';
    protected $guarded = ['created_at', 'updated_at'];

    public function lang(){
        return $this->belongsTo('App\Models\LangModel', 'lang_id', 'lang_id');
    }
}
