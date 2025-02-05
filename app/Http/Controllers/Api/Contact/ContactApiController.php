<?php
namespace App\Http\Controllers\Api\Contact;

use App\Repositories\Contact\ContactRepository;
use App\Repositories\MailboxRepository;
use App\Http\Controllers\Api\ProductApiController;
use Illuminate\Http\Request;

use App\Http\Controllers\Api\Contact\Template\TemplateContactApiController;

/*上傳圖片功能*/
use App\Helpers\AppHelper;
use File;

class ContactApiController extends TemplateContactApiController
{
	protected $publicFilePath =  '/public/upload/contact/'; /*上傳圖片的路徑*/

	protected $mailboxRepository;
	protected $productApiController;
	public function __construct(
		ContactRepository   $contactRepository,
		MailboxRepository 	$mailboxRepository,
		ProductApiController $productApiController
    ){
    	parent::__construct(
    		$contactRepository
    	);
        $this->mailboxRepository  = $mailboxRepository;
        $this->productApiController  = $productApiController;
	}

	/*取得所有需被提醒人的信箱*/
	public function getAllMailbox($request){
		return $this->mailboxRepository->getAllMailbox();
	}

	public function addContact_post(Request $request){// 同步方式寄送回函
		if($_POST){
			$_POST['contaItemId'] = isset($_POST['contaItemId']) ? (int)$_POST['contaItemId'] : '';
			$request = new Request($_POST);
		}
		$result = $this->addContact($request);
		$resp_data = $result->getData();
		abort($resp_data->status, $resp_data->message);
	}
	public function addContact(Request $request, $insertData=[], $additionalRemind=''){// 異步方式寄送回函
		// dump($request->all());exit;

		/*額外欄位*/
			$productId = '0';
			if(!empty($request->get('productId') )){ $productId = $request->get('productId'); };
	    	$product = $this->productApiController->showProductOne($request, $productId);
            $insertData['admin_url_attached'] = $product['item']['admin_url_attached'];
			if(isset($product['propertyTag'])){
				if(isset($product['propertyTag'][1])){
					$additionalRemind = $product['propertyTag'][1]['prod_prop'];
				}
			}
			// if(!empty($request->get('gender') )){
			// 	$insertData['gender'] = $request->get('gender');
			// };
			// if(!empty($request->get('address') )){
			// 	$insertData['address'] = $request->get('address');
			// };
			if(!empty($request->get('online_class') )){ $insertData['online_class'] = $request->get('online_class'); };
			if(!empty($request->get('online_type') )){ $insertData['online_type'] = $request->get('online_type'); };
			if(!empty($request->get('online_text') )){ $insertData['online_text'] = $request->get('online_text'); };
			if(!empty($request->get('qa') )){ 
				$qa = $request->get('qa');
				$qa = explode(";<br>", $qa);
				foreach ($qa as $key => $value) {
					$file_check = explode("_@_file_@_", $value);
					if(count($file_check)==2){
						$base64 = $file_check[1];

						if($base64){ /*是新上傳檔案*/
							$img = $base64;
							$fileName = AppHelper::instance()->renameFile($img);
							$file_path = $this->publicFilePath.'0/'.$fileName;
			                if (!File::exists(base_path().$this->publicFilePath.'0')) {
			                    File::makeDirectory(base_path().$this->publicFilePath.'0', 0775);
			                }
			                AppHelper::instance()->uploadFile($this->publicFilePath.'0', $fileName, $img);

			                $value = explode(":", $file_check[0]);
			                $value[1] = "<a href='http://".$_SERVER['HTTP_HOST'].$file_path."' target='_blank'>".$value[1]."</a>";
			                $qa[$key] = implode(":", $value);
			                // dump($qa[$key]);exit;
				        }else{
				        	$qa[$key] = $file_check[0];
				        }
					}
				}

				$qa = implode(";<br>", $qa);
				// dump($qa);exit;
				$insertData['qa'] = $qa;
			}

		$result = parent::addContact($request, $insertData, $additionalRemind);
		$new = $result->getData()->new; /*新增的內容*/
		$conta_id = $new->conta_id; /*id 為新增回傳回來的conta_id*/

		/*額外欄位 上傳圖片、檔案*/
			// if(!empty($request->get('pics'))){ /*Base64 方式上傳檔案*/
			// 	$pics = $request->get('pics');
			// 	if(is_array($pics)){
			// 		$updData = [];
			// 		foreach ($pics as $key => $value) {
			// 			if(!empty($value) && strpos($value, $this->publicFilePath) === false && strlen($value) > 100){ /*是新上傳檔案*/
			// 				$img = $value;
			// 				$fileName = AppHelper::instance()->renameFile($img);
			// 				$updData['pics'][$key] = $this->publicFilePath.$conta_id.'/'.$fileName;
			//                 if (!File::exists(base_path().$this->publicFilePath.$conta_id)) {
			//                     File::makeDirectory(base_path().$this->publicFilePath.$conta_id, 0775);
			//                 }
			//                 AppHelper::instance()->uploadFile($this->publicFilePath.$conta_id, $fileName, $img);
			// 	        }
			// 		}
			// 		$updData['pics'] = json_encode($updData['pics']);
			// 		$updData['conta_datetime'] = $new->conta_datetime; /*時間與新增時相同*/

			// 		$this->update($request, $conta_id, $updData); /*更新聯絡我們的資料*/
			// 	}
			// }
			
			// if(isset($_FILES['file1'])){ // POST_FILE 方式上傳檔案
			// 	$fileName = $_SERVER['DOCUMENT_ROOT'].$this->publicFilePath.$conta_id.'/'.$_FILES['file1']['name'];
			// 	if (!File::exists(base_path().$this->publicFilePath.$conta_id)) {
			// 		File::makeDirectory(base_path().$this->publicFilePath.$conta_id, 0775);
			// 	}
			// 	move_uploaded_file($_FILES['file1']['tmp_name'], $fileName);

			// 	$updData['file1'] = $_FILES['file1']['name'];
			// 	$updData['conta_datetime'] = $new->conta_datetime; /*時間與新增時相同*/
			// 	$this->update($request, $conta_id, $updData); /*更新聯絡我們的資料*/
			// }

		return $result;
	}

    public function test_email(Request $request){
		$hostMail = 'louis6110xx@photonic.com.tw';
		$data=[
			'conta_type_name' => '測試',
			'conta_type_id' => 1,
			'conta_id' => 0,
		];
		dump(parent::mailContactToHost($data, $hostMail));
	}
}