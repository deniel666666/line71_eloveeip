<?php

namespace App\Models\Record;

use Illuminate\Database\Eloquent\Model;

class LoveRecordModel extends Model
{
	protected $table 		= 'love_record';
	protected $primaryKey 	= 'id';
	protected $guarded 		= ['created_at'];

	public $timestamps  = false;
}
