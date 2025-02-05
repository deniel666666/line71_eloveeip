<?php

namespace App\Repositories\Contact;

use App\Models\Contact\ContactItemModel;
use App\Models\Contact\ContactModel;
use App\Models\Contact\ContactTypeModel;

use App\Repositories\Contact\Template\TemplateContactRepository;

class ContactRepository extends TemplateContactRepository{
	public function __construct(
		ContactItemModel 	$contactItemModel,
		ContactModel 		$contactModel,
		ContactTypeModel	$contactTypeModel
	){
		parent::__construct(
			$contactItemModel,
			$contactModel,
			$contactTypeModel,
			$memberId = false
		);
	}
}