<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuLangModel extends Model
{
    protected $table = 'menu_lang';
    protected $primaryKey = 'menu_lang_id';
    protected $guarded = ['created_at', 'updated_at'];

    public function lang()
    {
        return $this->belongsTo('App\Models\LangModel', 'lang_id', 'lang_id');
    }
}
