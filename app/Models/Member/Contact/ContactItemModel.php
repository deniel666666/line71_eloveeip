<?php

namespace App\Models\Member\Contact;

use Illuminate\Database\Eloquent\Model;

class ContactItemModel extends Model
{
    protected $table = 'member_contact_item';
	protected $fillable = [
		'conta_type_id',
		'member_id',
		'conta_item_name',
		'conta_item_status',
		'lang_id',
	];

	public function contact()
    {
        return $this->hasMany('App\Models\Member\Contact\ContactModel', 'conta_item_id', 'conta_item_id');
	}
	public function lang()
    {
        return $this->belongsTo('App\Models\LangModel', 'lang_id', 'lang_id');
    }
}

