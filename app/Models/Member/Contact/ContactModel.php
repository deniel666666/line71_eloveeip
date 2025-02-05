<?php

namespace App\Models\Member\Contact;

use Illuminate\Database\Eloquent\Model;

class ContactModel extends Model
{
	protected $table = 'member_contact';
	protected $guarded = ['created_at', 'updated_at'];
	protected $primaryKey = "conta_id";

	public function contactItem()
	{
		return $this->belongsTo('App\Models\Member\Contact\ContactItemModel', 'conta_item_id', 'conta_item_id');
	}
	public function contactType()
	{
		return $this->belongsTo('App\Models\Member\Contact\ContactTypeModel', 'conta_type_id', 'conta_type_id');
	}
	public function lang()
	{
		return $this->belongsTo('App\Models\LangModel', 'lang_id', 'lang_id');
	}
}

