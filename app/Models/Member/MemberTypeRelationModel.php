<?php

namespace App\Models\Member;

use Illuminate\Database\Eloquent\Model;

class  MemberTypeRelationModel extends Model
{
	protected $table 		= 'member_type_relation';
	protected $primaryKey 	= 'id';
	protected $fillable 	= ['user_id', 'type', 'start_time', 'end_time', 'contract_number', 'note'];
	protected $guarded 		= ['created_at', 'updated_at'];

	public function member()
    {
        return $this->belongsTo('App\Models\Member\MemberModel', 'user_id', 'id');
    }
}
