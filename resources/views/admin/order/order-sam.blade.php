@extends('layouts.masterAdmin')

<!-- html title -->
@section('htmlTitle') {{$pageTitle}}  @endsection

<!-- 自定義 content -->
@section('content')

   

<div class="container-fluid">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item" aria-current="page">訂單管理</li>
			<li class="breadcrumb-item active">{{$pageTitle}}</li>
		</ol>
	</nav>
	<div class="row bg-light">
		<div class="col-4">
			<span>
				<select ng-model='contCtrl.model.orderStatus' ng-change="contCtrl.orderStatusChange()"> 
				    <option  value="all">全部</option>
				    <option  value="new">新訂單</option>
				    <option  value="processing">處理中</option>
				    <option  value="finish">已完成</option>
				    <option  value="trash">垃圾桶</option>
				</select>
         	</span>
         <span><input ng-model="contCtrl.model.keyword" type="text" name=""></span>
         <span>	<a href="" ng-click="contCtrl.orderSearch()">搜尋</a> | <a href="" ng-click="contCtrl.clrSearch()">清除搜尋</a> </span>
		</div>
		<div class="col-8">

		</div>
	</div>
	<div class="row bg-light">
		<div class="col-4">
         	<span>	<a href="" ng-click="contCtrl.trash()">刪除</a> </span>
		</div>
		<div class="col-8">

		</div>
	</div>
	<div>
		<table class="table">
			<thead>
				<tr>
					<th scope="col"><input type="checkbox" ng-model="contCtrl.checkAll" ng-click="contCtrl.selAll()"></th>
					<th scope="col">訂單編號</th>
					<th scope="col">訂購人</th>
					<th scope="col">收件人</th>
					<!-- <th scope="col">付款方式</th> -->
					<th scope="col">付款狀態</th>
					<th scope="col">出貨狀況</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="item in contCtrl.orderList">
					<th><input type="checkbox" ng-model="item.selected"></th>
					<th><a href="/admin/product/@{{contCtrl.prodNum}}/order/@{{item.od_id}}/edit">@{{item.od_sn}}</a></th>
					<td>@{{item.buyer}}</td>
					<td>@{{item.recipient}}</td>
					<!-- <td></td> -->
					<td>@{{item.payStatus}}</td>
					<td>@{{item.shippingStatus}}</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div>
		<p style="float: right;">
			<span>頁數 : 
				<input type="text" ng-model="contCtrl.currentPage" ng-keydown="$event.keyCode === 13 && contCtrl.goto()" size="3"> / @{{contCtrl.totalPage}} 
			</span>
			<span>
				<a href=""><span ng-click="contCtrl.prevPage(contCtrl.prevPageIndex)">上一頁</span></a> / 
				<a href=""><span ng-click="contCtrl.nextPage(contCtrl.nextPageIndex)">下一頁</span></a> </span> 
		</p>	
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
			// console.log(currPathAry);
        	var self = this;
        	
        	self.countOfPage	= 2;
        	self.prodNum 		= currPathAry[3];
        	self.checkAll 		= false;

        	self.model 				= {};
        	self.model.orderStatus 	= 'all';
        	self.model.keyword 		= '';

			
			self.getPageOrder = function(currentPage,countOfPage,orderStatus,keyword){
				$http({
					method : "post",
					url : "/admin/api/getPageOrder",
					data: {	currentPage : currentPage,
							countOfPage : countOfPage,
							orderStatus : orderStatus,
							keyword		: keyword,
							prodNum		: self.prodNum},
				}).success(function(data){
					self.orderList = data.pageData;
					for (var prop in self.orderList){
						self.orderList[prop]['selected'] = false;

						if (self.orderList[prop]['pay_status'] == 1){
							self.orderList[prop]['payStatus'] = "已付款";
						}else{
							self.orderList[prop]['payStatus'] = "未付款";
						}
						if (self.orderList[prop]['shipping_status'] == 1){
							self.orderList[prop]['shippingStatus'] = "已出貨";
						}else{
							self.orderList[prop]['shippingStatus'] = "未出貨";
						}
					}//for

					self.currentPage 	= currentPage;
					self.totalPage 		= data.totalPage;

					var pageNavIndex = proj.getNavPageIndex(currentPage,self.totalPage);

					self.prevPageIndex = pageNavIndex.prevIndex;
					self.nextPageIndex = pageNavIndex.nextIndex;
					
				}).error(function(){

				})//error
			}//self.getOrder

			self.prevPage = function(prevIndex){
				self.getPageOrder(prevIndex,self.countOfPage,self.model.orderStatus,self.model.keyword)
			}

			self.nextPage = function(nextIndex){
				self.getPageOrder(nextIndex,self.countOfPage,self.model.orderStatus,self.model.keyword)
			}

			// self.orderStatusChange = function(){
			// 	// alert('orderStatusChange');
			// 	// console.log(self.model.orderStatus);
			// 	self.getPageOrder(	1,
			// 						self.countOfPage,
			// 						self.model.orderStatus,
			// 						'');
			// }


			self.orderSearch = function(){
				// alert('orderStatusChange');
				// console.log(self.model.orderStatus);
				self.getPageOrder(	1,
									self.countOfPage,
									self.model.orderStatus,
									self.model.keyword);
			}


			self.clrSearch = function(){
				self.model.keyword = '';
				self.getPageOrder(	1,
									self.countOfPage,
									self.model.orderStatus,
									self.model.keyword);
			}

			self.getPageOrder(1,self.countOfPage,self.model.orderStatus,'');


			self.selAll = function(){
				for (var prop in self.orderList){
					self.orderList[prop]['selected'] = self.checkAll;	
				}//for
			}//self.selAll

			self.trash = function(){
				console.log(self.orderList);
				$http({
					method : "post",
					url : "/admin/api/order/trash",
					data: {orderList:self.orderList},
				}).success(function(data){
					if (data.status = '200'){
						alert('資料已刪除')
						location.reload();
					}else{
						alert('網路錯誤')
					}
				}).error(function(){

				})//error
			}//self.trash


			self.goto = function(){
				if (self.currentPage <= 0){
					self.currentPage = 1;
					alert("頁數需大於 0");
				}else if(self.currentPage > self.totalPage){
					alert("頁數需小於於總頁數 : "+self.totalPage);
				}else{
					self.getPageOrder(	self.currentPage,
										self.countOfPage,
										self.model.orderStatus,
										self.model.keyword);
				}
			}//self.goto
	

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



