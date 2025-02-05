<?php

namespace App\Models\Member\Contact;

use Illuminate\Database\Eloquent\Model;

class ContactTypeModel extends Model
{
    protected $table = 'member_contact_type';
	protected $fillable = [
		'conta_type',
		'conta_name',
	];

	public function contact()
    {
        return $this->hasMany('App\Models\Member\Contact\ContactModel', 'conta_type_id', 'conta_type_id');
    }
}

