<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
	protected $use_end 			= "member";
	protected $content_table	= "member_contact";
	protected $extends_layouts	= "member.layouts.layoutExtends";

    public function index (Request $request,$contactTypeId) {
    	$viewData['use_end'] 		= $this->use_end;
		$viewData['content_table'] 	= $this->content_table;
		$viewData['extends_layouts']= $this->extends_layouts;
		$viewData['webTitle']		= '回函表';

		if ($contactTypeId == 1){
			$viewData['topTitle'] 	= '會員專區';
		}elseif ($contactTypeId == 2){
			$viewData['topTitle'] 	= '會員專區';
		}else{
			$viewData['topTitle'] 	= '會員專區';
		}

    	$viewData['contaCollapse'] 						= "show";
		$viewData['contact'.$contactTypeId.'Active']  	= "active";

		return view("admin.contact.template.contact",$viewData);
    }

    public function edit (Request $request, $contactTypeId, $contactId) {
     	$viewData['use_end'] 		= $this->use_end;
		$viewData['content_table'] 	= $this->content_table;
		$viewData['extends_layouts']= $this->extends_layouts;
		$viewData['webTitle']		= '回函表';

		if ($contactTypeId == 1){
			$viewData['topTitle'] 	= '會員專區';
		}elseif ($contactTypeId == 2){
			$viewData['topTitle'] 	= '會員專區';
		}else{
			$viewData['topTitle'] 	= '會員專區';
		}

		$viewData['contaCollapse'] 					= "show";
		$viewData['contact'.$contactId.'Active']  	= "active";

		return view("admin.contact.template.contactEditor",$viewData);
    }
}

