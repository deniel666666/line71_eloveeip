<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
	protected $table = 'order_form';
	protected $primaryKey = 'od_id';
	protected $guarded = ['created_at', 'updated_at'];
}
