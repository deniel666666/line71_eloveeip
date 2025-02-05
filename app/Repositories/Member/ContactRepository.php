<?php

namespace App\Repositories\Member;

use App\Models\Member\Contact\ContactItemModel;
use App\Models\Member\Contact\ContactModel;
use App\Models\Member\Contact\ContactTypeModel;

use Illuminate\Support\Facades\Session;

use App\Repositories\Contact\Template\TemplateContactRepository;

class ContactRepository extends TemplateContactRepository{
	public function __construct(
		ContactItemModel 	$contactItemModel,
		ContactModel 		$contactModel,
		ContactTypeModel	$contactTypeModel
	){

		$memberInfo = Session::get('member');

		parent::__construct(
			$contactItemModel,
			$contactModel,
			$contactTypeModel,
			$memberId = $memberInfo['id']
		);
	}
}