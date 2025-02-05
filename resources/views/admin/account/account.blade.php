@extends('layouts.masterAdmin')

<!-- html title -->
@section('htmlTitle') {{$pageTitle}}  @endsection

<!-- 自定義 content -->
@section('content')

<div class="w-100">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">系統管理</li>
			{{-- <li class="breadcrumb-item"><a href="/admin/mailbox">帳號管理</a></li> --}}
			<li class="breadcrumb-item">帳號管理</li>
			<li class="breadcrumb-item active" aria-current="page">列表</li>
		</ol>
	</nav>
</div>

<div class="container-fluid" style="padding: 0px;">
	<div class="row bg-light no-gutters pageHeader">
		<div class="col-12">
			<a href="/admin/account/create" class="addNewBtn btn-use mr-4">
				<span>新增</span>
			</a>
			<span class="d-inline-block" ng-if="contCtrl.accountLimint>0">
				帳號上限：
				<span ng-bind="contCtrl.accountList.length">15</span> / 
				<span ng-bind="contCtrl.accountLimint">30</span>
			</span>
			<span class="d-inline-block">
				搜尋：
				<input type="text" ng-model="contCtrl.searchKey">
				到期日:
				<select ng-model="contCtrl.expiredType">
					<option value="">請選擇</option>
					<option value="1">7日內到期</option>
					<option value="2">已到期</option>
				</select>
				<button ng-click="contCtrl.getAllAccountBySearch()">搜尋</button>				
			</span>
		</div>
	</div>
	<div>
		<table class="table table-bordered admin-table-rwd form">
			<thead>
				<tr class="admin-tr-only-hide">
					<th class="w-50px" scope="col">ID</th>
					<th class="w-50px" scope="col">狀態</th>
					<th scope="col">帳號</th>
					<th scope="col">名字</th>
					<th scope="col">費用</th>
					<th scope="col">到期日期</th>
					<!--  <th scope="col">排序</th> -->
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="item in contCtrl.accountList">
					<th data-th="ID">@{{$index+1}}</th>
					<td data-th="狀態">@{{item.user_status}}</td>
					<td data-th="帳號"><a class="editInfor" href="/admin/account/edit/@{{item.id}}">@{{item.acct}}</a></td>
					<td data-th="名字">@{{item.user_name}}</td>
					<td data-th="費用">@{{item.cost}}</td>
					<td data-th="到期日期">@{{item.end_time}}</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
@endsection

<!-- 自定義 javascript -->
@section('javascript')
	<script type="text/javascript">
		var app = angular.module('app',[]);

		app.controller('ContentController',['$http',function($http){
			var self = this;
			self.accountLimint = 0;
			self.searchKey='';
			self.expiredType='';
			self.getAllAccount = function(){
				$http({
					method : "get",
					url : "/admin/api/account",
					//data: orderPost,
				}).success(function(data){
					// console.log(data);
					var accountList = [];
					for(var i =0;i< data.accountList.length;i++){
						if(data.accountList[i].user_role.indexOf('manager') >= 0){
							accountList.push(data.accountList[i]);
						}
					}
					self.accountList = accountList;
					self.accountLimint = data.accountLimint;
					
				}).error(function(){
						
				})//error
			}//self.login
			self.getAllAccount();

			self.getAllAccountBySearch = function(){
				$http({
					method : "get",
					url : "/admin/api/account?searchKey="+self.searchKey+"&expiredType="+self.expiredType,
					//data: orderPost,
				}).success(function(data){
					// console.log(data);
					var accountList = [];
					for(var i =0;i< data.accountList.length;i++){
						if(data.accountList[i].user_role.indexOf('manager') >= 0){
							accountList.push(data.accountList[i]);
						}
					}
					self.accountList = accountList;
					self.accountLimint = data.accountLimint;
				}).error(function(){
				})//error
			}//self.login
		}]);
	</script>
@endsection
