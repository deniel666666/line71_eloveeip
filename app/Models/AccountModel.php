<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountModel extends Model
{
	protected $table 		= 'account';
	protected $primaryKey 	= 'id';
	protected $guarded 		= ['created_at', 'updated_at'];

}
