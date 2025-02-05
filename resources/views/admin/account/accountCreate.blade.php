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
			<li class="breadcrumb-item active" aria-current="page">新增</li>
		</ol>
	</nav>
</div>
<div class="container-fluid">
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
			<button class="btn btn-success btn-block" ng-click="contCtrl.addAccount()">確認送出</button>
		</div>
	</div>
</div>
@endsection

<!-- 自定義 javascript -->
@section('javascript')

<script type="text/javascript">
	
	//$('#datetimepicker1').datetimepicker();
	$('#datetimepicker1').datetimepicker({
            "allowInputToggle": true,
            "showClose": true,
            "showClear": true,
            "showTodayButton": true,
            "format": "YYYY-MM-DD",
        });
		$('#datetimepicker2').datetimepicker({
            "allowInputToggle": true,
            "showClose": true,
            "showClear": true,
            "showTodayButton": true,
            "format": "YYYY-MM-DD",
        });
	var app = angular.module('app',[]);
	app.controller('ContentController',['$http','$scope',function($http,$scope){
		var self = this;
		self.model = {};
		self.model.user_status = '1';
		self.model.cost = '';
		self.model.start_time = '';
		self.model.end_time = '';
		self.start_time = '';
		self.end_time = '';
		self.foolproof = true;
		self.model.backend = true;
		
		self.submitCheck = function(){
			self.foolproof = true;
			if ((!self.model.acct)||(self.model.acct=='')){
				self.foolproof = false;
				alert('請填帳號');
			}

			if ((!self.model.user_name)||(self.model.user_name=='')){
				self.foolproof = false;
				alert('請填姓名');
			}

			if ((!self.model.user_pw)||(self.model.user_pw=='')){
				self.foolproof = false;
				alert('請填密碼');
			}
			if ((!self.model.email)||(self.model.email=='')){
				//self.foolproof = false;
				//alert('Email');
			}
		}

		self.accounSubmit = function(){
			self.model.start_time = $("#datetimepicker1_val").val();
			self.model.end_time = $("#datetimepicker2_val").val();
			
			$http({
				method : "post",
				url : "/admin/api/account",
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
		}//self.addNewMember

		self.addAccount = function(){
			self.submitCheck();
			if (self.foolproof){
				self.accounSubmit();
			}
		}
    }]);
</script>
@endsection



