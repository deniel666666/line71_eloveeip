<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MiscellaneousModel extends Model
{
   	protected $table 		= 'miscellaneous';
	protected $primaryKey 	= 'misc_id';
	protected $guarded 		= ['created_at', 'updated_at'];
}
