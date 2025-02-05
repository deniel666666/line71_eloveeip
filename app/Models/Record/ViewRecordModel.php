<?php

namespace App\Models\Record;

use Illuminate\Database\Eloquent\Model;

class ViewRecordModel  extends Model
{
	protected $table 		= 'view_record';
	protected $primaryKey 	= 'id';
	protected $guarded 		= ['created_at'];

	public $timestamps  = false;
}
