<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\MailboxRepository;

class MailboxEditorController extends Controller
{
	protected $mailboxRepository;

	public function __construct(MailboxRepository $mailboxRepository)
	{
		$this->mailboxRepository = $mailboxRepository;
	}

	public function index (Request $request) {

		$viewData['pageTitle'] = '通知設定';//$gallery['gallery_name'];
		$viewData['sysCollapse'] = "show";
		$viewData['mailboxActive'] = "active";

		return view("admin.mailbox.mailboxEditor",$viewData);
	}
}
