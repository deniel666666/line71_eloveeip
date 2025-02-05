<?php

namespace App\Models\Contact;

use Illuminate\Database\Eloquent\Model;

class ContactModel extends Model
{
	protected $table = 'contact';
	protected $guarded = ['conta_id'];
	protected $primaryKey = "conta_id";

	public function contactItem()
	{
		return $this->belongsTo('App\Models\Contact\ContactItemModel', 'conta_item_id', 'conta_item_id');
	}
	public function contactType()
	{
		return $this->belongsTo('App\Models\Contact\ContactTypeModel', 'conta_type_id', 'conta_type_id');
	}
	public function lang()
	{
		return $this->belongsTo('App\Models\LangModel', 'lang_id', 'lang_id');
	}
}

