<?php

namespace App\Models\Contact;

use Illuminate\Database\Eloquent\Model;

class ContactItemModel extends Model
{
    protected $table = 'contact_item';
	protected $fillable = [
		'conta_type_id',
		'conta_item_name',
		'conta_item_status',
		'lang_id',
	];

	public function contact()
    {
        return $this->hasMany('App\Models\Contact\ContactModel', 'conta_item_id', 'conta_item_id');
	}
	public function lang()
    {
        return $this->belongsTo('App\Models\LangModel', 'lang_id', 'lang_id');
    }
}

