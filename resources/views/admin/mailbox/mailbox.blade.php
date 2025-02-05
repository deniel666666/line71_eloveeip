@extends('layouts.masterAdmin')

<!-- html title -->
@section('htmlTitle') {{$pageTitle}}  @endsection

<!-- 自定義 content -->
@section('content')
<div class="w-100">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">系統管理</li>
			<li class="breadcrumb-item"><a href="/admin/mailbox">通知設定</a></li>
			<li class="breadcrumb-item active" aria-current="page">表列</li>
		</ol>
	</nav>
</div>
<div class="container-fluid" style="padding: 0px;">
	<div class="row bg-light no-gutters pageHeader">
		<div class="col-12">
			<a href="/admin/mailbox/create" class="addNewBtn btn-use">
				<span>新增</span>
			</a>
			<span class="text-danger ml-3">當收到新回函時，以下設定對象將收到通知。</span>
			@if( env('LINE_MESSAGE_TOKEN') )
				<span class="text-danger ml-3">
					若要透過「LINE Message ID」收到通知，請先加入LINE@好友：
					<a href="{{$LINE_BUSINESS_ADD_LINK}}" target="_blank">{{$LINE_BUSINESS_ADD_LINK}}</a>
				</span>
			@endif
		</div>
	</div>
	<div>
		<table class="table table-bordered admin-table-rwd form">
			<thead>
				<tr class="admin-tr-only-hide">
					<th class="w-50px" scope="col">ID</th>
					<th class="w-50px" scope="col">狀態</th>
					<th scope="col">通知信箱</th>
					@if( env('LINE_NOTIFY_ID') )
					<th scope="col">LINE Notify ID</th>
					@endif
					@if( env('LINE_MESSAGE_TOKEN') )
					<th scope="col">LINE Message ID</th>
					@endif
					<th scope="col">通知人名字</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="item in contCtrl.mailboxList">
					<td data-th="ID"><a class="editInfor" href="/admin/mailbox/edit/@{{item.mb_id}}">@{{$index+1}}</a></td>
					<td data-th="狀態">@{{item.mb_status}}</td>
					<td data-th="通知信箱"><a class="editInfor" href="/admin/mailbox/edit/@{{item.mb_id}}">@{{item.rx_mail}}</a></td>
					@if( env('LINE_NOTIFY_ID') )
					<td data-th="LINE Notify ID">
						<button class="btn btn-success" ng-click="contCtrl.line_auth(item.mb_id)">進行綁定</button>
						<span ng-if="item.line_id">@{{item.line_id}}</span>
					</td>
					@endif
					@if( env('LINE_MESSAGE_TOKEN') )
					<td data-th="LINE Message ID">
						<button class="btn btn-success" ng-click="contCtrl.line_auth_message(item.mb_id)">進行綁定</button>
						<span ng-if="item.line_id_message">@{{item.line_id_message}}</span>
					</td>
					@endif
					<td data-th="通知人名字">@{{item.rx_name}}</td>
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
			self.getAllMailbox = function(){
				$http({
					method : "get",
					url :  "/admin/api/mailbox",
					//data: orderPost,
				}).success(function(data){
					self.mailboxList = data.mailboxList;
				}).error(function(){
				})//error
			}//self.login
			self.getAllMailbox();

			self.line_auth = function(mb_id){
				location.href='/admin/go_line_page?mb_id='+mb_id;
			}
			self.line_auth_message = function(mb_id){
				location.href='/admin/go_line_page_message?mb_id='+mb_id;
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
