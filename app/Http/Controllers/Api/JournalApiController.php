<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Repositories\JournalOrderRepository;
use App\Repositories\MailboxRepository;
use Mail;

class JournalApiController extends Controller
{
	public function __construct(
								JournalOrderRepository		$journalOrderRepository,
								MailboxRepository			$mailboxRepository){

		$this->journalOrderRepository	= $journalOrderRepository;
		$this->mailboxRepository		= $mailboxRepository;
	}
	public function guestOrder(Request $request){
//		echo "guestOrder";
		$subscribe 	= $request->get('subscribe');
		$fare 		= $request->get('fare');
		$langType 	= $request->get('langType');
		$orderInfo 	= $request->get('orderInfo');
		$totalPrice	= $request->get('totalPrice');

		$subscribeCont = [
			'subscribe' 	=> $subscribe,
			'totalPrice'	=> $totalPrice,
			'fare'			=> $fare,
		];

		$insData['uid'] 			= 0;
		$insData['buyer'] 			= $orderInfo['buyer'];
		$insData['recipient'] 		= $orderInfo['recipient'];
		$insData['od_cont']			= json_encode($subscribeCont);
		$insData['od_info'] 		= json_encode($orderInfo);
		$insData['pay_status'] 		= 0;
		$insData['shipping_status'] = 0;
		$insData['lang_id']			= 1;

		$tryCnt = 0;
		do{
			$hasOrderSn = false;
			$orderDay 	= date("Ymd-His");
			$randSn 	= rand(1000,9999);
			try{
				$insData['od_sn'] = 'j'.$orderDay.'-'.$randSn;
				$this->journalOrderRepository->create($insData);
			}catch(\Illuminate\Database\QueryException $ex){
				//dd($ex->getMessage());
				$tryCnt = $tryCnt+1;
				if ($tryCnt >= 100){
					$hasOrderSn = false;
				}else{
					$hasOrderSn = true;
				}

			}
		}while($hasOrderSn);

		if ($tryCnt >=100){
			$retData = ['status' => 'tryCnt > 100'];
		}else{
			//---Mail To User ---
			$mailData = $insData;
			$mailData['od_cont']	= $subscribeCont;
			$mailData['od_info']	= $orderInfo;

			$this->mailToUser($mailData);

			//---Mail To Host ---
			$hostMail = $this->mailboxRepository->getAllMailbox();
			foreach($hostMail as $hmKey => $hmValue){
				if ($hmValue['mb_status'] == 1){
					$this->mailToHost($mailData,$hmValue['rx_mail']);
				}
			}
			//--- Return data ---
			$retData = ['status' => '200'];
		}

		return $retData;
	}//public function guestOrder

	public function mailToUser($data){
		Mail::send('emails.journal', $data, function ($message) use($data) {
			$mailAddr = env('MAIL_USERNAME');
			$mailArray = explode('@',$mailAddr);
			$message->from($mailAddr, $mailArray[0]);
			$message->subject('訂閱期刊');
			$message->to($data['od_info']['email']);
		});
	}// public function mailToUser

	public function mailToHost($data,$hostMail){
		Mail::send('emails.journal_H', $data, function ($message) use($data,$hostMail) {
			$mailAddr = env('MAIL_USERNAME');
			$mailArray = explode('@',$mailAddr);
			$message->from($mailAddr, $mailArray[0]);
			$message->subject('訂閱期刊 / 訂購者:'.$data['od_info']['buyer']);
			$message->to($hostMail);
		});
	}// public function mailToHost
}
