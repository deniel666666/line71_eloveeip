@extends('layouts.masterAdmin')

<!-- html title -->
@section('htmlTitle') {{$pageTitle}}  @endsection

<!-- 自定義 content -->
@section('content')

<style type="text/css">
	thead {
    	background-color: Teal;
    	color: white;
	} 
</style>

<div class="container-fluid">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">{{$pageTitle}}</li>
			<li class="breadcrumb-item active" aria-current="page">訂單編輯</li>
		</ol>
	</nav>
	<div class="row bg-light">
		<div class="col-8">

		</div>
	</div>
	<div>
		<table class="table">
			<thead>
				<tr>
					<th scope="col">訂單編號</th>
					<th scope="col">訂購人</th>
					<th scope="col">收件人</th>
					<!-- <th scope="col">付款方式</th> -->
					<th scope="col">付款狀態</th>
					<th scope="col">出貨狀況</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th>@{{contCtrl.orderSn}}</th>
					<td>@{{contCtrl.orderInfo.buyer}}</td>
					<td>@{{contCtrl.orderInfo.recipient}}</td>
					<!-- <td></td> -->
					<td>
						<select ng-model='contCtrl.model.payStatus' ng-change="contCtrl.payStatusChange()"> 
							<option  value="0">未付款</option>
							<option  value="1">已付款</option>
						</select>
					</td>
					<td>
						<select ng-model='contCtrl.model.shippingStatus' ng-change="contCtrl.shippingStatusChange()"> 
							<option  value="0">未出貨</option>
							<option  value="1">已出貨</option>
						</select>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	
	<div>
		<table class="table">
			<thead>
				<tr>
					<th scope="col">產品名稱</th>
					<th scope="col">產品主圖</th>
					<th scope="col">產品規格</th>
					<th scope="col">單價</th>
					<th scope="col">數量</th>
					<th scope="col">總價</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="item in contCtrl.orderCont.product">
					<th>@{{item.prodName}}</th>
					<td><img src="/upload/product@{{contCtrl.productNum}}/@{{item.prodId}}/@{{item.prodImg}}" width="100"></td>
					<td>@{{item.prodType}}</td>
					<td>@{{item.typeSalesPrice}}</td>
					<td>@{{item.qty}}</td>
					<td>@{{item.qty*item.typeSalesPrice}}</td>
				</tr>
			</tbody>
		</table>
	</div>

	<hr style="border-top: dotted 1px;" />

	<div class="row">
		<div class="col-6">
			訂購人 : @{{contCtrl.orderInfo.buyer}}
		</div>
		<div class="col-6">
			信箱 :  @{{contCtrl.orderInfo.email}}
		</div>
		
	</div>
	<div class="row">
		<div class="col-6">
			聯絡電話 : @{{contCtrl.orderInfo.contactPhone}}
		</div>
		<div class="col-6">
			行動電話 :  @{{contCtrl.orderInfo.mobilePhone}}
		</div>
		
	</div>
	
	<div class="row">
		<div class="col-12">
			地址 :  @{{contCtrl.orderInfo.address}}
		</div>
	</div>
	
	<hr style="border-top: dotted 1px;" />

	<div class="row">
		<div class="col-12">
			收件人 :  @{{contCtrl.orderInfo.recipient}}
		</div>
	</div>
	<div class="row">
		<div class="col-6">
			聯絡電話 :  @{{contCtrl.orderInfo.rxContactPhone}}
		</div>
		<div class="col-6">
			行動電話 :  @{{contCtrl.orderInfo.rxMobilePhone}}
		</div>
		
	</div>

	<div class="row">
		<div class="col-12">
			地址 :  @{{contCtrl.orderInfo.rxAddress}}
		</div>
	</div>

	<hr style="border-top: dotted 1px;" />

	<div class="row">
		<div class="col-6">
			統一編號 :  @{{contCtrl.orderInfo.taxId}}
		</div>
		<div class="col-6">
			公司抬頭 :  @{{contCtrl.orderInfo.companyTitle}}
		</div>
	</div>


	<div class="row">
		<div class="col-12">
			發票寄送對象 :  @{{contCtrl.orderInfo.taxRx}}
		</div>
	</div>

	<hr style="border-top: dotted 1px;" />

	<div class="row">
		<div class="col-6">
			運送方式 :  @{{contCtrl.orderCont.fare.fareName}}(@{{contCtrl.orderCont.fare.fareCost}}元)
		</div>
		<div class="col-6">
			免運金額 :  @{{contCtrl.orderCont.freeFare}}
		</div>
	</div>

	<hr style="border-top: dotted 1px;" />

	<div class="row">
		<div class="col-12">
			總金額 :   @{{contCtrl.orderCont.total}}元
		</div>
	</div>

</div>


@endsection



<!-- 自定義 javascript -->
@section('javascript')

    <script type="text/javascript">

    </script>

    <script type="text/javascript">
        var app = angular.module('app',[]);

        app.controller('ContentController',['$http',function($http){

        	var currentPath = window.location.pathname;
			var currPathAry = currentPath.split("/");
			//console.log(currPathAry);

        	var self = this;
        	self.countOfPage 		= 4;
        	self.orderId 			= currPathAry[5];

        	self.model 				= {};
        	self.model.orderStatus 	= 'all';
			
			self.getOrder = function(){
				$http({
					method : "get",
					url : "/admin/api/order/"+self.orderId,
				}).success(function(data){
					// console.log(data);
					self.orderSn 	= data.od_sn;
					self.orderCont 	= data.od_cont; 
					self.orderInfo 	= data.od_info;
					if (data.product_num == 1){
                        self.productNum = '';
                    }
					else{
                        self.productNum = data.product_num;
					};
					self.model.payStatus 		= data.pay_status;
					self.model.shippingStatus 	= data.shipping_status;
				}).error(function(){

				})//error
			}//self.getOrder

			self.getOrder();

			

			self.payStatusChange = function(){
				// alert("payStatusChang");
				$http({
					method : "put",
					url : "/admin/api/order/"+self.orderId+"/payStatus",
					data: {payStatus:self.model.payStatus},
				}).success(function(data){
					self.getOrder();
					alert("資料已更新")
				}).error(function(){

				})//error
			}

			self.shippingStatusChange = function(){
				// alert("shippingStatusChange");
				$http({
					method : "put",
					url : "/admin/api/order/"+self.orderId+"/shippingStatus/",
					data: {shippingStatus:self.model.shippingStatus},
				}).success(function(data){
					self.getOrder();
					alert("資料已更新")
				}).error(function(){

				})//error
			}

			// self.login = function(){
			// 	$http({
			// 		method : "post",
			// 		url : "/webapi/getOrder",
			// 		//data: orderPost,
			// 	}).success(function(data){

			// 	}).error(function(){

			// 	})//error
			// }//self.login

        }])//app.controller()
    </script>

@endsection



