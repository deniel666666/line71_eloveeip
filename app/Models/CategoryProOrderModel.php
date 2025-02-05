<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryProOrderModel extends Model{

    protected $table = 'category_pro_order';


	protected $fillable = [
		'category_id',
        'product_id',
        'category_order'
    ];
    public $timestamps = false;

}
