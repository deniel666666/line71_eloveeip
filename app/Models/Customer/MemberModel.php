<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

class  MemberModel extends Model
{
	protected $table 		= 'customer';
	protected $primaryKey 	= 'id';
	protected $guarded 		= ['created_at', 'updated_at'];

}
