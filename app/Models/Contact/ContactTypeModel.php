<?php

namespace App\Models\Contact;

use Illuminate\Database\Eloquent\Model;

class ContactTypeModel extends Model
{
    protected $table = 'contact_type';
	protected $fillable = [
		'conta_type',
		'conta_name',
		'prod_id'
	];

	public function contact()
    {
        return $this->hasMany('App\Models\Contact\ContactModel', 'conta_type_id', 'conta_type_id');
    }
}

