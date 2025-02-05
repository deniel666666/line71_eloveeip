@extends('layouts.masterAdmin')

<!-- html title -->
@section('htmlTitle') {{$pageTitle}}  @endsection

<!-- 自定義 content -->
@section('content')
<div class="w-100 mb-4">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">系統管理</li>
			<li class="breadcrumb-item"><a href="/admin/mailbox">通知設定</a></li>
			<li class="breadcrumb-item active" aria-current="page">新增</li>
		</ol>
	</nav>
</div> 
<div class="container-fluid">
	<div>
		<!-- <button class="btn btn-danger">刪除</button> -->
	</div>
	<div class="form-group">
		<span class="use-sp-title">通知信箱 :</span>
		<div>
			<input type="text" ng-model="contCtrl.model.rx_mail" name="" class="form-control input-sm">
		</div>
	</div>
	@if( env('LINE_NOTIFY_ID') )
	<div class="form-group">
		<span class="use-sp-title">LINE Notify ID :</span>
		<div class="">
			<!-- <input type="text" ng-model="contCtrl.model.line_id" name="" class="form-control input-sm"> -->
			<span class="text-danger ml-3">請新增帳號後在列表頁進行授權</span>
		</div>
	</div>
	@endif
	@if( env('LINE_MESSAGE_TOKEN') )
	<div class="form-group">
		<span class="use-sp-title">LINE Message ID :</span>
		<div class="">
			<!-- <input type="text" ng-model="contCtrl.model.line_id_message" name="" class="form-control input-sm"> -->
			<span class="text-danger ml-3">請新增帳號後在列表頁進行授權</span>
		</div>
	</div>
	@endif
	<div class="form-group">
		<span class="use-sp-title">通知人姓名 :</span>
		<div>
			<input type="text" ng-model="contCtrl.model.rx_name" name="" class="form-control input-sm">
		</div>
	</div>
	<div class="form-group">
		<span class="use-sp-title">狀態： :</span>
		<div>
			<select ng-model="contCtrl.model.mb_status" class="form-control input-sm">
				<option value="1">啟用</option>
				<option value="0">停用</option>
			</select>
		</div>
	</div>
	<div class="row">
		<div class="col-12"><span>&nbsp;</span></div>
	</div>
	<div class="row">
		<div class="col-12">
			<button class="btn btn-success btn-block" ng-click="contCtrl.addMailbox()">確認送出</button>
		</div>
	</div>
</div>
@endsection

<!-- 自定義 javascript -->
@section('javascript')
<script type="text/javascript">
	function preview(input,pic) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$(pic).attr('src', e.target.result);
				// var KB = format_float(e.total / 1024, 2);
				// $(pic).text("檔案大小：" + KB + " KB");
			}

			reader.readAsDataURL(input.files[0]);
		}
	}
	$(document).on("change", ".pic", function (){
		preview(this,'.preview');
		$(".slider").removeClass('fas fa-cloud-upload-alt fa-7x')
	})
</script>
<script type="text/javascript">
</script>
<script type="text/javascript">
	var app = angular.module('app',[]);
	app.controller('ContentController',['$http','$scope',function($http,$scope){
		var self = this;
		self.model = {};
		self.model.mb_status = '1';

		self.addMailbox = function(){
			$http({
				method : "post",
				url : "/admin/api/mailbox",
				data: self.model,
			}).success(function(data){
				if (data.status=='200'){
					window.location = "/admin/mailbox";
				}else{
					// alert('資料庫無回應');
				}
			}).error(function(){

			})//error
		}//self.addMailbox

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
