<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Repositories\ProductRepository;
use App\Repositories\ProductTypeRepository;
use App\Repositories\OrderRepository;
use App\Repositories\MiscellaneousRepository;
use App\Repositories\MailboxRepository;

use App\Helpers\AppHelper;
use \File;
use \DB;
use Mail;

class CartApiController extends Controller
{
	protected $productNum = 1;

    public function __construct(ProductRepository		$productRepository,
        						ProductTypeRepository	$productTypeRepository,
								OrderRepository			$orderRepository,
								MiscellaneousRepository	$miscellaneousRepository,
								MailboxRepository		$mailboxRepository){

        $this->productRepository        = $productRepository;
        $this->productTypeRepository    = $productTypeRepository;
		$this->orderRepository          = $orderRepository;
		$this->miscellaneousRepository	= $miscellaneousRepository;
		$this->mailboxRepository		= $mailboxRepository;
    }

    public function guestOrder(Request $request){
		$cart 		= $request->get('cart');
		$fare 		= $request->get('fare');
		$langType 	= $request->get('langType');
		$orderInfo 	= $request->get('orderInfo');

		$fareId = $fare['fareId'];

		$calCart = $this->caculateCart($cart,$fareId,$langType);

		$insData['uid'] 			= 0;
		$insData['buyer'] 			= $orderInfo['buyer'];
		$insData['recipient'] 		= $orderInfo['recipient'];
		$insData['od_cont'] 		= json_encode($calCart);
		$insData['od_info'] 		= json_encode($orderInfo);
		$insData['pay_status'] 		= 0;
		$insData['shipping_status'] = 0;
		$insData['product_num'] 	= $this->productNum;
		$insData['lang_id']			= 1;

		$tryCnt = 0;
		do{
			$hasOrderSn = false;
			$orderDay 	= date("Ymd-His");
			$randSn 	= rand(1000,9999);
			try{
				$insData['od_sn'] = $orderDay.'-'.$randSn;
				$this->orderRepository->create($insData);
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
			$mailData['od_cont']	= $calCart;
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
	}

	public function caculateCart($products,$fareId,$langType){

		$newItem = [];
		$i = 0;
		$total = 0;

		foreach ($products as $key => $value) {
			$prodType = $this->productTypeRepository->show($value['prodTypeId']);
			$product = $this->productRepository->getShowOne($prodType->prod_id);
			$getQty = $value['qty'];
			$getProductTypeId = $value['prodTypeId'];
			$getProductType = $this->productRepository->getProductTypeFromCart($getProductTypeId );

			$newItem[$i]['prodName'] 		= $getProductType['prod_name'];
			$newItem[$i]['prodTypeId'] 		= $getProductType['prod_type_id'];
			$newItem[$i]['prodType'] 		= $getProductType['prod_type'];
			$newItem[$i]['qty'] 			= $value['qty'];
			$newItem[$i]['typePrice'] 		= $prodType['type_price'];
			$newItem[$i]['typeSalesPrice'] 	= $prodType['type_sales_price'];
			$newItem[$i]['prodSn'] 			= $prodType['prod_sn'];
			$newItem[$i]['prodImg'] 		= $product->prod_img;
			$newItem[$i]['prodId'] 			= $product->prod_id;

			$getTypeSalesPrice = $getProductType['type_sales_price'];
			$total += $getQty*$getTypeSalesPrice;
			$i++;
		}
		$getFare = $this->productRepository->getFare($fareId);
		$newFare['fareId'] 		= $getFare['fare_id'];
		$newFare['fareName']	= $getFare['fare_name'];
		$newFare['fareCost'] 	= $getFare['fare_cost'];

		$freeFareData = $this->miscellaneousRepository->getFreeFare($langType);
		$freeFare = $freeFareData->misc_value;

		if ($total < $freeFare){
			$total += $getFare['fare_cost'];
		}

		$data = [
			'product'=>$newItem,
			'total'=>$total,
			'fare'=>$newFare,
			'freeFare' => $freeFare
		];
		return $data;

	}

    public function getCart(Request $request,$langType){
        $products = $request->get('product');
        $fare = $request->get('fare');

        $cartList = $this->caculateCart($products,$fare,$langType);

        $data = $cartList;

        $data['status'] = 200;

        return $data;
    }


	public function mailToUser($data){
		Mail::send('emails.order', $data, function ($message) use($data) {
			$mailAddr = env('MAIL_USERNAME');
			$mailArray = explode('@',$mailAddr);
			$message->from($mailAddr, $mailArray[0]);
			$message->subject('商品訂單');
			$message->to($data['od_info']['email']);
		});
	}// public function mailToUser

	public function mailToHost($data,$hostMail){
		Mail::send('emails.order_H', $data, function ($message) use($data,$hostMail) {
			$mailAddr = env('MAIL_USERNAME');
			$mailArray = explode('@',$mailAddr);
			$message->from($mailAddr, $mailArray[0]);
			$message->subject('商品訂單 / 訂購者:'.$data['od_info']['buyer']);
			$message->to($hostMail);
		});
	}// public function mailToHost
}
