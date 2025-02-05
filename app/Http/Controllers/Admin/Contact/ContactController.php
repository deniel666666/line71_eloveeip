<?php

namespace App\Http\Controllers\Admin\Contact;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
	protected $use_end 			= "admin";
	protected $content_table	= "contact";
	protected $extends_layouts	= "layouts.masterAdmin";

    public function index (Request $request,$contactTypeId) {
    	$viewData['use_end'] 		= $this->use_end;
		$viewData['content_table'] 	= $this->content_table;
		$viewData['extends_layouts']= $this->extends_layouts;
		$viewData['contaCollapse'] 						= "show";
		$viewData['contact'.$contactTypeId.'Active']  	= "active";

		if ($contactTypeId == 1){
			$viewData['topTitle'] = '聯絡我們';
			return view("admin.contact.customize.about_contact",$viewData);
		}
		elseif ($contactTypeId == 2){
			$viewData['topTitle'] = '線上報名';
			// $viewData['onlineCollapse'] = "show";
			return view("admin.contact.customize.online_contact",$viewData);
		}

		$viewData['topTitle'] 							= '聯絡我們';
		// return view("admin.contact.template.contact",$viewData);
    }

    public function edit (Request $request, $contactTypeId, $contactId) {
     	$viewData['use_end'] 		= $this->use_end;
		$viewData['content_table'] 	= $this->content_table;
		$viewData['extends_layouts']= $this->extends_layouts;
		$viewData['contaCollapse'] 					= "show";
		$viewData['contact'.$contactTypeId.'Active']  	= "active";

		if ($contactTypeId == 1){
			$viewData['topTitle'] = '聯絡我們';
			return view("admin.contact.customize.about_contactEditor",$viewData);
		}
		elseif ($contactTypeId == 2){
			$viewData['topTitle'] = '線上報名';
			// $viewData['onlineCollapse'] = "show";
			return view("admin.contact.customize.online_contactEditor",$viewData);
		}

		$viewData['topTitle'] 						= '聯絡我們';
		// return view("admin.contact.template.contactEditor",$viewData);
    }
}

