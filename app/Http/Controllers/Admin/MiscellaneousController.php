<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\MiscellaneousRepository;

class MiscellaneousController extends Controller
{
	private $miscellaneousRepository;
	public function __construct(MiscellaneousRepository $miscellaneousRepository)
	{
		$this->miscellaneousRepository = $miscellaneousRepository;
	}

	public function index (Request $request, $miscId) {

		$res = $this->miscellaneousRepository->show($miscId);
		if($res){ $res=$res->toArray();
			// dump($res);

			$viewData['topTitle']						= '說明設定';
			$viewData['pageTitle']						= $res['misc_note'];
			$viewData['miscellaneousCollapse'] 			= "show";
			$viewData['miscellaneous'.$miscId.'Active']	= "active";
			$viewData['miscId']							= $miscId;

			if($miscId==1){
				
			}else if($miscId==2){
				
			}else if($miscId==3){
				
			}
		}

		return view("admin.miscellaneous.edit",$viewData);
		return view("errors.404");
	}
}

