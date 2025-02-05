<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemIntroModel extends Model
{
    protected $table = 'system_intro';
    protected $primaryKey = 'system_id';
    protected $guarded = ['created_at', 'updated_at'];

    // public function lang()
    // {
    //     return $this->belongsTo('App\Models\LangModel', 'lang_id', 'lang_id');
    // }
}