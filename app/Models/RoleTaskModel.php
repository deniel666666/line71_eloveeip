<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleTaskModel extends Model
{
	protected $table 		= 'role_task';
	protected $primaryKey 	= 'id';
	protected $guarded 		= ['created_at', 'updated_at'];
}
