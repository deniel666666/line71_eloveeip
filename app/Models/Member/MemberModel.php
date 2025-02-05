<?php

namespace App\Models\Member;

use Illuminate\Database\Eloquent\Model;

class  MemberModel extends Model
{
	protected $table 		= 'member';
	protected $primaryKey 	= 'id';
	protected $guarded 		= ['created_at', 'updated_at'];

	public function memberType()
    {
        return $this->hasMany('App\Models\Member\MemberTypeRelationModel', 'user_id', 'id');
    }
}
