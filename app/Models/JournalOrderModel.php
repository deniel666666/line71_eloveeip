<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalOrderModel extends Model
{
	protected $table 		= 'journal_order';
	protected $primaryKey 	= 'jn_od_id';
	protected $guarded 		= ['created_at', 'updated_at'];
}
