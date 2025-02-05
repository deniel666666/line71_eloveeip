@extends('layouts.masterAdmin')

<!-- html title -->
@section('htmlTitle') {{$pageTitle}}  @endsection

<!-- 自定義 content -->
@section('content')
<div class="w-100 mb-4">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">系統管理</li>
			<li class="breadcrumb-item"><a href="/admin/account">帳號管理</a></li>
			<li class="breadcrumb-item active" aria-current="page">編輯</li>
		</ol>
	</nav>
</div>
<div class="container-fluid">
	<div>
		<button class="btn btn-danger"  ng-click="contCtrl.delCheck(contCtrl.acctId,contCtrl.model.user_name)">刪除</button>
	</div>
	<br>
	<div class="form-group mb-4">
		<div class="row">
			<div class="col-md-6 mb-2">
				登入帳號 : <input type="text" ng-model="contCtrl.model.acct" name="" class="form-control input-sm">
			</div>
			<div class="col-md-6 mb-2">
				姓名 : <input type="text" ng-model="contCtrl.model.user_name" name="" class="form-control input-sm">
			</div>	
			<div class="col-md-6 mb-2">
				密碼 : <input type="text" ng-model="contCtrl.model.user_pw" name="" class="form-control input-sm">
			</div>
			<div class="col-md-6 mb-2">
				狀態
				<select ng-model="contCtrl.model.user_status" class="form-control input-sm">
					<option value="1">啟用</option>
					<option value="0">停用</option>
				</select> 	
			</div>
			<div class="col-md-6 mb-2">
				E-mail :(可多個請用逗號 , 區隔) <input type="text" ng-model="contCtrl.model.email" name="" class="form-control input-sm">
			</div>
			<div class="col-md-6 mb-2">
				費用 : <input type="text" ng-model="contCtrl.model.cost" name="" class="form-control input-sm">
			</div>
			<div class="col-md-6 mb-2">
				開始時間 :
				<div class="form-group">
					<input type="date" ng-model="contCtrl.start_time" id='datetimepicker1_val' class="form-control input-sm">
				</div>
			</div>
			<div class="col-md-6 mb-2">
				結束時間 :
				<div class="form-group">
					<input type="date" ng-model="contCtrl.end_time" id='datetimepicker2_val' class="form-control input-sm">
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<button class="btn btn-success btn-block" ng-click="contCtrl.submitAccount()">確認送出</button>
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
	var app = angular.module('app',[]);
	app.controller('ContentController',['$http','$scope',function($http,$scope){
		var self = this;
		self.model = {};
		self.model.user_status = '1';
		self.foolproof = true;
		self.model.start_time = '';
		self.model.end_time = '';
		self.start_time = '';
		self.end_time = '';
		var currUrl = window.location.pathname ;
		var urlSplit= currUrl.split('/');
		self.acctId 	= urlSplit[4];
		// console.log(urlSplit);

		self.getAccount = function(){
			$http({
				method : "get",
				url : "/admin/api/account/"+self.acctId,
			}).success(function(data){
				if (data.status=='200'){
					self.model = data.account;
					if (self.model.user_status == ''){
						alert('無此帳號');
						window.location = "/admin/account";
					}
					self.start_time = data.account.start_time ? new Date(data.account.start_time) : '';
					self.end_time = data.account.end_time ? new Date(data.account.end_time) : '';
				}else{
					// alert('資料庫無回應');
				}
			}).error(function(){
				alert('網路錯誤');
			})//error
		}
		self.getAccount();

		self.submitCheck = function(){
			// console.log(self.model);
			if ((!self.model.acct)||(self.model.acct=='')){
				self.foolproof = false;
				alert('請填帳號');
			}
			if ((!self.model.user_name)||(self.model.user_name=='')){
				self.foolproof = false;
				alert('請填姓名');
			}
			if ((self.model.id==1)&&(self.model.user_status=='0')){
				self.foolproof = false;
				alert('管理者無法停用');
			}
		}//self.submitCheck = function()

		self.updAccount = function(){
			self.model.start_time = $("#datetimepicker1_val").val();
			self.model.end_time = $("#datetimepicker2_val").val();
			// console.log(self.model);return;
			$http({
				method : "put",
				url : "/admin/api/account/"+self.acctId,
				data: self.model,
			}).success(function(data){
				if (data.status=='200'){
					window.location = "/admin/account";
				}else if(data.msg){
					alert(data.msg);
				}else{
					// alert('資料庫無回應');
				}
			}).error(function(){

			})//error
		}//self.updAccount

		self.submitAccount = function(){
			self.foolproof = true;
			self.submitCheck();
			if (self.foolproof){
				self.updAccount();
			}
		}

		self.delAccount = function(){
			if (self.model.id==1){
				self.foolproof = false;
				alert('管理者無法刪除');
			}else{
				$http({
					method : "delete",
					url : "/admin/api/account/"+self.acctId,
					data: self.model,
				}).success(function(data){
					// console.log( data );
					if (data.status=='200'){
						window.location = "/admin/account";
					}else{
						// alert('資料庫無回應');
					}
				}).error(function(){
				})//error	
			}			
		}

		self.delCheck = function(antId,acctName){
			var delConfirm = confirm('您確定要刪除 '+acctName+" 嗎?");

			if (delConfirm){
				self.delAccount()
			}
		}
	}]);
</script>
@endsection



