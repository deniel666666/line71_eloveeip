<?php

namespace App\Http\Controllers\Api\Member;

use App\Repositories\Member\ContactRepository;
use Illuminate\Support\Facades\Session;
use App\Models\Member\MemberModel;
use Illuminate\Http\Request;

use App\Http\Controllers\Api\Contact\Template\TemplateContactApiController;

class ContactApiController extends TemplateContactApiController
{
	protected $mailboxRepository;
	public function __construct(
		ContactRepository   $contactRepository
    ){
    	parent::__construct(
    		$contactRepository
    	);
	}

	/*取得所有需被提醒人的信箱*/
	public function getAllMailbox($request){
		$memberId = $request->get('memberId');
		$memberData = MemberModel::where('id','=',$memberId)->first()->toArray();

		$mail_box =  [ 
	    	['rx_mail'=>$memberData['email'], 'mb_status'=>1],
	    ];

		return $mail_box;
	}

	public function addContact(Request $request, $insertData=[]){
		// dump($request->all());exit;

		/*額外欄位*/
		if($request->get('memberId')){
			$insertData['member_id'] = $request->get('memberId');
		}
		if($request->get('conta_date')){
			$insertData['conta_date'] = $request->get('conta_date');
		}

		return parent::addContact($request, $insertData);
	}
}

