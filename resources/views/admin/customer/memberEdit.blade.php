@extends('layouts.masterAdmin')

<!-- html title -->
@section('htmlTitle') {{$pageTitle}}  @endsection

<!-- 自定義 content -->
@section('content')
<div class="w-100 mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">{{$pageTitle}}</li>
            <li class="breadcrumb-item active">詳細內容</li>
        </ol>
    </nav>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <p>狀態 ：<select ng-model="contCtrl.model.user.user_status" ng-options="item.id as item.label for item in contCtrl.userStatus" class="form-control"></select></p>
        </div>
        <div class="col-md-6">
            <p>開通顯示 ：<select ng-model="contCtrl.model.user.show_status" ng-options="item.id as item.label for item in contCtrl.showStatus" class="form-control"></select></p>
        </div>

        <!-- 店家帳號 -->
        <div class="col-6">
            <label for="number">店家帳號</label>
            <input type="text" ng-model="contCtrl.model.user.account" readonly="readonly" class="form-control" placeholder="" autocomplete="off">
        </div>
        <!-- 您的姓名 -->
        <div class="col-6">
            <label for="name">店家名稱</label>
            <input type="text" ng-model="contCtrl.model.user.user_name" class="form-control" placeholder="" autocomplete="off">
        </div>
        <!-- 修改密碼 -->
        <div class="col-6">
            <label for="modifyPassword">修改密碼</label>
            <input type="password" id="password" class="form-control" placeholder="若不修改密碼，請勿填寫" autocomplete="off">
        </div>
    </div>

    <hr>

    <div class="row">

    		<div class="col-12 row form-row blockBorder">
    			<div class="row col-12 d-flex align-items-center">
	                <!-- 主圖 -->
	                <div class="col-6">
	                    <label for="pic" class="slider d-inline-flex align-items-center" style="">
	                        <span style="width: 200px;">主圖:</span>
	                        <img ng-src="@{{contCtrl.model.user.pic}}" class="preview w-100 col-4">
	                    </label>
	                    <input type="file" ng-file-select="onFileSelect($files)"  ng-model="contCtrl.model.user.pic"><!--style="display:none;width:0;"-->
	                </div>

	                <!-- logo圖 -->
	                <div class="col-6">
	                    <label for="logo" class="slider d-inline-flex align-items-center" style="">
	                        <span style="width: 200px;">logo圖:</span>
	                        <img ng-src="@{{contCtrl.model.user.logo}}" class="preview w-100">
	                    </label>
	                    <input type="file" ng-file-select="onFileSelect($files)"  ng-model="contCtrl.model.user.logo"><!--style="display:none;width:0;"-->
	                </div>
	            </div>

	            <hr class="col-12">

                <!-- 市話 -->
                <div class="col-6">
                    <label for="orderHomeCall">修改連絡電話</label>
                    <input type="text" ng-model="contCtrl.model.user.telephone" class="form-control" placeholder="" autocomplete="off">
                </div>
                <!-- 手機 -->
                <div class="col-6">
                    <label for="phoneNumber">修改行動電話</label>
                    <input type="text" ng-model="contCtrl.model.user.cellphone" class="form-control" placeholder="" autocomplete="off">
                </div>

                <!-- 連絡地址 -->
                <div class="col-6 sendAddressBox clearfix">
                    <label>連絡地址</label>
                    <div class="">
                		<div id="twzipcode" class="d-flex"></div>
            		</div>
                    <input type="text" ng-model="contCtrl.model.user.road" placeholder="請填路名" class="form-control customQuantitySelect" name="address" placeholder="">
                </div>
                
                <!-- 統一編號 -->
                <div class="col-6" ng-if="contCtrl.model.user.user_type == 0">
                    <label for="taxID">統一編號</label>
                    <input type="text" ng-model="contCtrl.model.user.id_code" class="form-control"  placeholder="" autocomplete="off">
                </div>

                <!-- 網址 -->
                <div class="col-6">
                    <label>網址</label>
                    <input type="text" ng-model="contCtrl.model.user.userInfo.web" class="form-control"  placeholder="站外連結請包含 http:// 或 https://，站內連結建議使用相對路徑" autocomplete="off">
                </div>

                <!-- 服務類型 -->
                <div class="col-6">
                    <label for="taxID">服務類型</label>
                    <input type="text" ng-model="contCtrl.model.user.service_type" class="form-control"  placeholder="" autocomplete="off">
                </div>

                <!-- 公休日 -->
                <div class="col-6">
                    <label>公休日</label>
                    <textarea ng-model="contCtrl.model.user.userInfo.resttime" class="form-control"></textarea>
                </div>

                <!-- 營業時間 -->
                <div class="col-6">
                    <label>營業時間</label>
                    <textarea ng-model="contCtrl.model.user.userInfo.wroktime" class="form-control"></textarea>
                </div>
            </div>

            <hr>

            <!-- 環境照 -->       
            <div class="row col-12">
                <label>環境照</label>
                    <div class="row col-12">
                        <div class="col-2" ng-repeat="item in contCtrl.model.user.sub_pics">
                            <div class="h-100 d-flex justify-content-between align-items-center row">
                                <div class="col-12">
                                    <img ng-src="@{{contCtrl.model.user.sub_pics[$index]}}" class="preview w-100"  alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

	</div>
    <br>
    <div class="row">
        <div class="col-12">
            <button type="button" class="col-12 btn btn-primary" ng-click="contCtrl.updateMemberInfo()">更新資料</button>
        </div>
    </div>
    <br>
</div><!-- <div class="container-fluid"> -->

@endsection



<!-- 自定義 javascript -->
@section('javascript')

    <script type="text/javascript">

    </script>

    <script type="text/javascript">
    	$('#twzipcode').twzipcode({
    		'readonly': true
    	});
    </script>

    <script type="text/javascript">
        var app = angular.module('app',[]);

        app.controller('ContentController',['$http',function($http){

        	var currentPath = window.location.pathname;
			var currPathAry = currentPath.split("/");
			// console.log(currPathAry);

        	var self = this;self.ngTest = "Angular Test OK";

        	self.memberId = currPathAry[3];

			self.showStatus = [
				{id:0, label:'隱藏'},
				{id:1, label:'顯示'}
			];

			self.userStatus = [
				{id:0, label:'停用'},
				{id:1, label:'啟用'},
				{id:2, label:'黑名單'}	
			];

			self.model = {};

			self.userInfoUrl = "/admin/api/customer/Info/";

        	////////////
        	self.getMemberInfo = function(){
				$http({
					method : "get",
					url : self.userInfoUrl +self.memberId,
					//data: orderPost,
				}).success(function(data){
					// console.log(data)
					self.model.user 	= data;
                    $('#twzipcode').twzipcode('set', {
                        'county'  : data.city,
                        'district': data.district,
                    });

				}).error(function(){
				})//error
			}//self.getProductInquiry = function()

			self.getMemberInfo()

			self.updateMemberInfo = function(){

				if($('#password').val()){
					self.model.user.user_pw = $('#password').val();
				}

				$http({
					method : "put",
					url : self.userInfoUrl + self.memberId ,
					data: self.model.user,
				}).success(function(data){
					console.log(data) //acct
					if (data.status == '200'){
						$.toaster({ message : '資料已更新'})
					}
				}).error(function(){
				})//error
			}
        }])
    </script>

@endsection