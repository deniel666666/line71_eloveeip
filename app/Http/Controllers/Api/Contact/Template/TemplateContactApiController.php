<?php
namespace App\Http\Controllers\Api\Contact\Template;

use Illuminate\Http\Request;
use App\Helpers\AppHelper;
use Mail;
use App\Services\FileService as FileService;

use App\Http\Controllers\Controller;

abstract class TemplateContactApiController extends Controller
{
	protected $contactRepository;
	private $public_file_path;

	public function __construct(
		$contactRepository
		){
		$this->contactRepository = $contactRepository;
		$this->public_file_path = '/public/upload/contact/';
	}

	public function showItem(Request $request,$contactTypeId,$langId){
		$contactTypeItem = $this->contactRepository->getContactItem($contactTypeId,$langId, $contaItemId=false, $request);
		$data = [
			'contactTypeItem' => $contactTypeItem
		];
		return response()->json($data);
	} 

	// 取得回函資料
	public function show(Request $request){
		$contactTypeId	= $request->get('contactTypeId');
		$langId			= $request->get('langId');
		$contactItem 	= $this->contactRepository->getContactItem($contactTypeId, $langId);
		$contactType 	= $this->contactRepository->getContactTypeByTypeId($contactTypeId);
		
		$request_obj 	= $request->all();
		$currentPage	= $request->get('currentPage') ? $request->get('currentPage') : '1';
		$currentPage 	= $currentPage<1 ? 1 : $currentPage;
		$countOfPage	= $request->get('countOfPage');
		$request_obj['startIndex'] 	= ($currentPage-1) * $countOfPage;
		$contact 		= $this->contactRepository->getContact($request_obj);
		$contactCount 	= $this->contactRepository->count($request_obj);

		if($countOfPage){
			$pageCount 	= (int)($contactCount/$countOfPage);
			if($contactCount%$countOfPage != 0){
				$pageCount +=1;
			}
		}else{
			$pageCount = 1;
		}
		$langs = AppHelper::instance()->getAllLangsByOrder();

		$data = [
			'status' => '200',
			'langs' => $langs ,
			'contact' => $contact,
			'contactItem' => $contactItem,
			'contactCount' => $contactCount,
			'pageCount' => $pageCount,
			'pageTitle' => $contactType['conta_type_name']
		];

		return response()->json($data);
	}
	// 前台調用回函資料
	public function showList(Request $request, $contactTypeId, $langId){
		// $countOfPage = 5; /*一次載入5個*/
		// $currentPage = $request->get('currentPage') ? $request->get('currentPage') : '1';
		$request_array = [
				'contactStatus' => "5",
				'memberId'	=> $request->get('memberId'), // 會員專屬功能
				'contactTypeId' 	=> $contactTypeId,
				'searchByContaItemId' => $request->get('searchByContaItemId'),
				'langId' 	  	=> $langId,
				'currentPage'	=> $request->get('currentPage'),
				'countOfPage'	=> $request->get('countOfPage'),
				'searchByText'	=> "",
		];
		$request_obj = new Request($request_array);
		$getData = $this->show($request_obj)->getData();

		$contact = $getData->contact;
		$contact_count = $getData->contactCount;

			foreach ($contact as $key => $value) {
				$contact[$key]->conta_datetime = date('M d,Y', strtotime($value->conta_datetime));
				$contact[$key]->conta_cont = str_replace("\n", "<br>", $contact[$key]->conta_cont);
				$contact[$key]->conta_resp = str_replace("\n", "<br>", $contact[$key]->conta_resp);
				unset($contact[$key]->conta_phone);
				unset($contact[$key]->conta_email);
				// if($value->contaWhisper==1){
				// 	$contact[$key]->conta_cont = "悄悄話";
				// }
			}

		return $contact;
	}

	public function remove(Request $request){
		$res = $this->contactRepository->updateNomalToTrash($request->input('ids'));
		$data = [
			'status'=> 200
		];
		return response()->json($data);
	}

	public function destroy(Request $request){
		$res = $this->contactRepository->delete($request->input('ids'));
		$data = [
			'status'=> 200
		];

		return response()->json($data);
	}

	public function getOneContact(Request $request, $contactId){
		$contact = $this->contactRepository->getOneContact($contactId)->toArray();
		$data = [
			'status'=> 200,
			'pageTitle' => $contact['contact_type']['conta_type_name'],
			'contact_type_id' => $contact['contact_type']['conta_type_id'],
			'contact' => $contact
		];
		return response()->json($data);
	}

	public function addContact(Request $request, $insertData=[], $additionalRemind=''){
		$insertData['conta_type_id'] = $request->get('contactTypeId');
		$insertData['lang_id'] = $request->get('langId');
		$insertData['conta_item_id'] = $request->get('contaItemId') ?? "-1";
		$insertData['conta_item_id'] = $insertData['conta_item_id']=="" ? "-1" : $insertData['conta_item_id'];

		$insertData['contact_status'] = 0;
		$insertData['conta_datetime'] = date("Y-m-d H:i:s");

		$insertData['conta_name'] = $request->get('contaName') ?? '';
		$insertData['conta_phone'] = $request->get('contaPhone') ?? '';
		$insertData['conta_email'] = $request->get('contaEmail') ?? '';
		$insertData['conta_company'] = $request->get('contaCompany') ?? '';
		$insertData['conta_cont'] = $request->get('contaContent') ?? '';

		$mailData = $insertData;
		$contactType = $this->contactRepository->getContactTypeByTypeId($insertData['conta_type_id']);
		$contactItem = $this->contactRepository->getContactItem($contactTypeId=false, $langId=false ,$insertData['conta_item_id']);

		$mailData['conta_type_name'] = $contactType['conta_type_name'];
		$mailData['contact_item_name'] = $contactItem ? $contactItem[0]['conta_item_name'] : "";

		/*新增紀錄*/
		$new = $this->contactRepository->addContact($insertData);
		$mailData['conta_id'] = $new['conta_id'];

		//--- To User ---
		if(filter_var($mailData['conta_email'], FILTER_VALIDATE_EMAIL)){
			$this->mailContactToUser($mailData);
		}

		//--- To Host ---
		$additionalRemind = explode(',', $additionalRemind);
		foreach($additionalRemind as $address){
			$address = trim($address);
			if ($address){
				$this->mailContactToAdditionalRemind($mailData,$address);
			}
		}
		$hostMail = $this->getAllMailbox($request);
		foreach($hostMail as $hmKey => $hmValue){
			if ($hmValue['mb_status'] == 1){
				$this->mailContactToHost($mailData,$hmValue['rx_mail']);
				$this->lineContactToHost($mailData,$hmValue['line_id'], $hmValue['line_id_message']);
			}
		}

		$data = [
			'status'=> 200,
			'new' => $new,
			'message' => '您的回函已送出',
		];
		return response()->json($data);
	}

	public function update(Request $request, $contaId, $updData=[]){
		if($request->input('contact_status') < 2){
			if($request->input('conta_datetime'))	$updData['conta_datetime'] = $request->input('conta_datetime');
			if($request->input('conta_name'))		$updData['conta_name'] = $request->input('conta_name');
			if($request->input('conta_phone'))		$updData['conta_phone'] = $request->input('conta_phone');
			if($request->input('conta_email'))		$updData['conta_email'] = $request->input('conta_email');
			if($request->input('conta_company'))	$updData['conta_company'] = $request->input('conta_company');
			if($request->input('conta_cont'))		$updData['conta_cont'] = $request->input('conta_cont');
			if($request->input('conta_resp'))		$updData['conta_resp'] = $request->input('conta_resp');

			/*使用編輯器時*/
			if(isset($updData['conta_resp'])){
				if($updData['conta_resp']){	
					$dom = new \domdocument();
					$dom->loadHtml(mb_convert_encoding($updData['conta_resp'],'HTML-ENTITIES','UTF-8'));
					// $dom->loadHtml(mb_convert_encoding($updData['conta_resp'],'HTML-ENTITIES','UTF-8'),LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
					$images = $dom->getelementsbytagname('img');
					foreach($images as $k => $img){
						$base64file	= $img->getattribute('src');
						$fileName 	= $img->getattribute('data-filename');
						if ($fileName != ''){
							$ext = explode('.', $fileName);
							$ext = end($ext);
							$fileName = sha1(uniqid(time(), true)) . '.' . $ext;
							$file = FileService::base64Store($base64file, 'upload','contact/'.$contaId, $fileName);

							$img->removeattribute('src');
							$img->removeattribute('data-filename');
							$img->setattribute('src', $this->public_file_path.$contaId.'/'.$fileName);
						}//if
					}//foreach
					$updData['conta_resp'] = $dom->savehtml($dom);
					$updData['conta_resp'] = str_replace("\n", "", $updData['conta_resp']);
				}
			}

			if(!empty($request->input('conta_resp'))){
				$updData['contact_status'] = 2;
			}
			$contact = $this->contactRepository->update($contaId,$updData);
		}
		
		$data = [
			'status'=> 200
		];
		return response()->json($data);
	}

	public function addContactItem(Request $request){
		$contactTypeId = $request->get('contactTypeId');
		$contaItemName	= $request->get('contaItemName');
		$langId	= $request->get('langId');
		$contactItem = $this->contactRepository->addContactItem($contactTypeId,$contaItemName,$langId);
		$data = [
			'status'=> 200,
			'contactItem' => $contactItem
		];
		return response()->json($data);
	}

	public function updateContactItem(Request $request){
		$contactTypeId = $request->get('contactTypeId');
		$contaItemId = $request->get('contaItemId');	
		$changeStatus = $request->get('contaItemStatus');
		$updateItem =['conta_item_status' => $changeStatus];
		$contactItem = $this->contactRepository->updateContactItem($contactTypeId, $contaItemId,$updateItem);
		$data = [
			'status'=> 200,
			'contactItem' => $contactItem
		];

		return response()->json($data);
	}

	public function updateContactItemName(Request $request){
		$contactTypeId = $request->get('contactTypeId');
		$contaItemId = $request->get('contaItemId');	
		$changeItemName = $request->get('contaItemName');
		$updateItem =['conta_item_name' => $changeItemName];
		$contactItem = $this->contactRepository->updateContactItem($contactTypeId, $contaItemId,$updateItem);
		$data = [
			'status'=> 200,
			'contactItem' => $contactItem
		];
		return response()->json($data);
	}

	public function deleteContactItem(Request $request){
		$contactTypeId = $request->get('contactTypeId');
		$contactItem = $this->contactRepository->deleteContactItem($contactTypeId,$request->input('ids'));
		$data = [
			'status'=> 200,
			'contactItem' => $contactItem
		];
		return response()->json($data);
	}

	public function checkNew(Request $request){
		$contaType = $this->contactRepository->getContactType();
		$newData = [];
		$i = 0;
		foreach ($contaType as $key => $value) {
			$newType = [];
			$checkNewContactByType = $this->contactRepository->getContactStatusCount($value['conta_type_id'],0);
			$newType['id'] = $value['conta_type_id'];
			$newType['name'] = $value['conta_type_name'];
			if($checkNewContactByType > 0){
				$newType['getNew'] = true;
			}else{
				$newType['getNew'] = false;
			}
			$newType['count'] = $checkNewContactByType;
			$newData[$i] = $newType;
			$i++;
		}
		// var_dump($newData);
		// die();
		$data = [
			'status'=> 200,
			'contactType' => $newData,
			'message' => '您的回函已送出',
		];
		return response()->json($data);
	}

		public function mailContactToHost($data,$hostMail){
			try {
				return Mail::send('emails.contact_H', $data, function ($message) use($data,$hostMail) {
					$mailAddr = env('MAIL_USERNAME');
					$mailArray = explode('@',$mailAddr);
					$message->from($mailAddr, $mailArray[0]);
					$message->subject($data['conta_type_name'].'-新回函表提醒');
					$message->to($hostMail);
				});
			} catch (\Exception $e) {
				return $e->getMessage();
			}
		}// public function mailContactToUser
		public function mailContactToAdditionalRemind($data,$hostMail){
			try {
				$result =  Mail::send('emails.contact_A', $data, function ($message) use($data,$hostMail) {
					$mailAddr = env('MAIL_USERNAME');
					$mailArray = explode('@',$mailAddr);
					$message->from($mailAddr, $mailArray[0]);
					$message->subject($data['conta_type_name'].'-新回函表提醒');
					$message->to($hostMail);
				});
			} catch (\Exception $e) {
				return $e->getMessage();
			}
			return $result;
		}// public function mailContactToAdditionalRemind
		public function lineContactToHost($data, $line_id, $line_id_message){
			$message = "親愛的管理員您好，後台收到新的回函，再請您登入查看\nhttp://".$_SERVER['HTTP_HOST']."/admin/contact/edit/".$data['conta_type_id']."/".$data['conta_id'];

			// LINE通知
			if($line_id){
				$post_url = "https://notify-api.line.me/api/notify";
				$headers = array(
					"Authorization: Bearer ".$line_id,
				);
				$post_data = [
					"message"	=> $message,
				];
				$output = AppHelper::instance()->http_request($post_url,$post_data,$headers);
			}

			// 串LINE@
			if($line_id_message){
				$post_url = "https://api.line.me/v2/bot/message/push";
				$headers = array(
					"Content-Type: application/json",
					"Authorization: Bearer ".env('LINE_MESSAGE_TOKEN'),
				);
				$message = strip_tags($message);
				$message = str_replace("\n", "\\n", $message);
				$post_data = '{
						"to": "'.$line_id_message.'",
						"messages":[
								{
										"type":"text",
										"text":"'.$message.'"
								}
						]
				}';
				$output = AppHelper::instance()->http_request($post_url,$post_data,$headers);
				// dd($output);
			}
		}// public function lineContactToHost

		public function mailContactToUser($data){
			try {
				Mail::send('emails.contact', $data, function ($message) use($data) {
					$mailAddr = env('MAIL_USERNAME');
					$mailArray = explode('@',$mailAddr);
					$message->from($mailAddr, $mailArray[0]);
					$message->subject($data['conta_type_name'].'-回函表');
					$message->to($data['conta_email']);
				});
			} catch (\Exception $e) {
				return $e->getMessage();
			}
		}// public function mailContactToUser

		
		/*取得所有需被提醒人的信箱*/
		abstract public function getAllMailbox($request);
		/*整理為此格式
		[ 
			['rx_mail'=>xxx@com.tw],
		]*/
}

