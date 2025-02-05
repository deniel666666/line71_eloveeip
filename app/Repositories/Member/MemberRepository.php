<?php

namespace APP\Repositories\Member;

use App\Models\Member\MemberModel;

use App\Repositories\Member\Template\TemplateMemberRepository;

class MemberRepository extends TemplateMemberRepository{

	public function __construct(MemberModel $memberModel){
		parent::__construct(
			$memberModel, 
			$primaryKey = "id"
		);
	}
}
