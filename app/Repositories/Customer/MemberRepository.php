<?php

namespace APP\Repositories\Customer;

use App\Models\Customer\MemberModel;

use App\Repositories\Member\Template\TemplateMemberRepository;

class MemberRepository extends TemplateMemberRepository{

	public function __construct(MemberModel $memberModel){
		parent::__construct(
			$memberModel, 
			$primaryKey = "id"
		);
	}
}
