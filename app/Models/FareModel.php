<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FareModel extends Model
{
    protected $table = 'fare';
    protected $primaryKey = 'fare_id';
    protected $guarded = ['created_at', 'updated_at'];
    
    public function lang()
    {
        return $this->belongsTo('App\Models\LangModel', 'lang_id', 'lang_id');
    }
}
