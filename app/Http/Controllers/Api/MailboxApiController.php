<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Repositories\MailboxRepository;
use App\Helpers\AppHelper;
use Illuminate\Support\Facades\Log;
class MailboxApiController extends Controller
{

	protected $mailboxRepository;

	public function __construct(MailboxRepository $mailboxRepository)
	{
		$this->mailboxRepository = $mailboxRepository;
	}

	public function index(Request $request){

		$res = $this->mailboxRepository->getAllMailbox();

		foreach ($res as $rKey => $rValue){
			if ($rValue['mb_status'] == 1){
				$res[$rKey]['mb_status'] = '啟用';
			}else{
				$res[$rKey]['mb_status'] = '停用';
			}
		}
		$data = [
			'mailboxList' => $res
		];

		return response()->json($data);
	}

	public function show(Request $request,$mbId){

		$res = $this->mailboxRepository->show($mbId);

		$res['mb_status'] = (string)$res['mb_status'];

		$data = [
			'status' => '200',
			'mailbox' => $res
		];

		return response()->json($data);
	}

	public function create(Request $request) {
		$insData['rx_mail'] 	= $request->input('rx_mail');
		$insData['line_id'] 	= $request->input('line_id');
		$insData['line_id_message'] 	= $request->input('line_id_message');
		$insData['rx_name'] 	= $request->input('rx_name');
		$insData['mb_status'] 	= $request->input('mb_status');
		// dd($insData);
		$hasMailRec = $this->mailboxRepository->hasRecByMail($insData['rx_mail']);
		if ($hasMailRec){
			$data = [
				'status' 	=> 408
			];
		}else{
			$insertId = $this->mailboxRepository->create($insData);
			$data = [
				'insertId' 	=> $insertId,
				'status' 	=> 200
			];
		}//else

		return response()->json($data);
	}

	public function update(Request $request,$mbId){
		$updData['rx_mail'] 	= $request->input('rx_mail');
		$updData['line_id'] 	= $request->input('line_id');
		$updData['line_id_message'] 	= $request->input('line_id_message');
		$updData['rx_name'] 	= $request->input('rx_name');
		$updData['mb_status'] 	= $request->input('mb_status');

		$res = $this->mailboxRepository->update($mbId,$updData);

		$data = [
			'res'   => $res,
			'status'=> 200
		];
		return response()->json($data);

	}

	public function destroy(Request $request,$mbId){

		$res = $this->mailboxRepository->delete($mbId);

		$data = [
			'res'   => $res,
			'status'=> 200
		];
		return response()->json($data);
	}

	/*跳轉 LINE Notify 畫面*/
	public function goLinePage(Request $request){
		if(!env('LINE_NOTIFY_ID')){ return abort(404, "無此功能"); }
		$mb_id = $request->get('mb_id');
		$auth_url = 'https://notify-bot.line.me/oauth/authorize?response_type=code&';
		$auth_url.= 'client_id=' . env('LINE_NOTIFY_ID') . '&';
		$auth_url.= 'redirect_uri=' . env('LINE_ADMIN_AUTH_CALL_BACK') . '&';
		$auth_url.= 'state=' . $mb_id . '&';
		$auth_url.= 'scope=' . 'notify';
		return redirect($auth_url);
	}
	/*LINE Notify 授權*/
	public function lineAuth(Request $request){
		Log::info('line_000000');
		$line_code = $request->get('code');
		$mb_id = $request->get('state');

		// LINE通知
		if(!env('LINE_NOTIFY_ID')){ return abort(404, "無此功能"); }
		try {
			/*get id_token*/
			$post_data = "
						grant_type=authorization_code&
						code=". $line_code ."&
						client_id=". env('LINE_NOTIFY_ID') ."&
						client_secret=". env('LINE_NOTIFY_CLIENT_SECRET') ."&
						redirect_uri=".urlencode(env('LINE_ADMIN_AUTH_CALL_BACK'));
			$post_data = str_ireplace(array("\t","\n",'\t','\n'),'', $post_data);
			// dump($post_data);
			$post_url = "https://notify-bot.line.me/oauth/token";
			$headers = array(
			   "Content-Type: application/x-www-form-urlencoded",
			);
			$token_resp = AppHelper::instance()->http_request($post_url,$post_data,$headers);
			$token_resp = (array)json_decode($token_resp);
			// dump($token_resp);
			$line_id = $token_resp['access_token'];

			$this->mailboxRepository->update($mb_id, ['line_id'=>$line_id]);
			
			return redirect("/admin/mailbox");

		} catch (\Exception $e) {
			// dump( $e->getMessage() );exit();
			return abort(404, "授權失敗：".$e->getMessage());
		}
	}

	/*跳轉 LINE Message 畫面*/
	public function goLinePage_message(Request $request){
		// 串LINE@
		$mb_id = $request->get('mb_id');
		$auth_url = 'https://access.line.me/oauth2/v2.1/authorize?response_type=code&';
		$auth_url.= 'client_id=' . env('LINE_CHANNEL_ID') . '&';
		$auth_url.= 'redirect_uri=' . env('LINE_ADMIN_AUTH_CALL_BACK_MESSAGE') . '&';
		$auth_url.= 'state=' . $mb_id . '&';
		$auth_url.= 'scope=' . 'openid%20profile%20email' . '&';
		$auth_url.= 'nonce=' . '09876xyz';
		return redirect($auth_url);
	}
	/*LINE Message 授權*/
	public function lineAuth_message(Request $request){
		Log::info('line_000000');
		$line_code = $request->get('code');
		$mb_id = $request->get('state');

		// 串LINE@
		try {
			/*get id_token*/
			$post_data = "
						grant_type=authorization_code&
						code=". $line_code ."&
						client_id=". env('LINE_CHANNEL_ID') ."&
						client_secret=". env('LINE_SECRET') ."&
						redirect_uri=".urlencode(env('LINE_ADMIN_AUTH_CALL_BACK_MESSAGE'));
			$post_data = str_ireplace(array("\t","\n",'\t','\n'),'', $post_data);
			// dump($post_data);
			$post_url = "https://api.line.me/oauth2/v2.1/token";
			$token_resp = AppHelper::instance()->http_request($post_url,$post_data);
			$token_resp = (array)json_decode($token_resp);
			// dump($token_resp);

			/*get line id、name*/
			$post_data = "
						id_token=". $token_resp['id_token'] ."&
						client_id=". env('LINE_CHANNEL_ID');
			$post_data = str_ireplace(array("\t","\n",'\t','\n'),'', $post_data);
			// dump($post_data);
			$post_url = "https://api.line.me/oauth2/v2.1/verify";
			$line_info_resp = AppHelper::instance()->http_request($post_url,$post_data);
			$line_info_resp = (array)json_decode($line_info_resp);
			// dump($line_info_resp);

			$line_id_message = $line_info_resp['sub'];
			$line_name = $line_info_resp['name'];

			$this->mailboxRepository->update($mb_id, ['line_id_message'=>$line_id_message]);
			return redirect("/admin/mailbox");

		} catch (\Exception $e) {
			// dump( $e->getMessage() );exit();
			return abort(404, "授權失敗：".$e->getMessage());
		}
	}
}
