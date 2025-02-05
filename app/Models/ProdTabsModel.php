<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdTabsModel extends Model
{
    protected $table = 'prod_tabs_property';
    protected $primaryKey = 'prod_type_id';
    protected $guarded = ['created_at', 'updated_at'];
    

    public function product(){
        return $this->belongsTo('App\Models\ProductModel', 'prod_id', 'prod_id');
    }
    
}
