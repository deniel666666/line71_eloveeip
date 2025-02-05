<!DOCTYPE html>
<html lang="zh-Hant-TW" ng-app="app">
	<head>
	    <meta charset="UTF-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	    <title>會員登入</title>
	    <link rel="stylesheet" href="css/reset.css">
	    <!-- Latest compiled and minified CSS -->
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	    <!-- jQuery library -->
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	    <!-- Popper JS -->
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	    <!-- Latest compiled JavaScript -->
	    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	    <!-- bootstrap font-awesome -->
	    <link rel="stylesheet" href="/css/bootstrap-social.css" >
	    <link rel="stylesheet" href="/css/font-awesome.css">
	    <!-- //////// -->
	    <link rel="stylesheet" href="/css/iconstyle.css">
	    <link rel="stylesheet" href="/css/style.css">
	    <link rel="stylesheet" href="/css/phone.css">
	    <link rel="stylesheet" href="/css/registered.css">

	    <script src="/js/vendor/twzipcode/jquery.twzipcode.js" type="text/javascript"></script>
	    <style>
	        body{
	            height: 100vh;
	            min-height: 500px;
	            width: 100%;
	            display:flex;
	            align-items:center;
	            justify-content:center;
	        }
	    </style>
	</head>
	<body ng-controller="ContentController as contCtrl">
	    <div class="registeredBox">
	        <div class="container">
	            <div class="row">
	                <div class="col-12">
	                    <div class="logoBox">
	                        <img src="img/logo.png" alt="">
	                    </div>
	                </div>
	            </div>
	            <form>
	                <div class="form-group">
	                    <label for="number">店家帳號</label>
	                    <!-- <input type="text" ng-model="contCtrl.model.user.account" class="form-control" id="number" placeholder="請輸入帳號"> -->
	                    <input type="email" ng-model="contCtrl.model.user.account" class="form-control" id="number" aria-describedby="emailHelp" placeholder="請輸入信箱">
	                </div>
	                <div class="form-group">
	                    <label for="Password">店家密碼</label>
	                    <input type="password" ng-model="contCtrl.model.user.password" class="form-control" id="Password" placeholder="請輸入密碼">
	                </div>
	                <button type="submit" ng-click="contCtrl.login()" class="btn btn-primary signInBtn">登入</button>
	                <a class="btn btn-block memberRegisteredBtn" href="/member/register">新會員註冊</a>
	                <!-- <a id="fbLogin" class="btn btn-block btn-social btn-facebook"><span class="fa fa-facebook"></span>Facebook登入</a> -->
	                <div class="footerLinkBox">
	                    <a class="forgetPasswordBtn" href="/member/forgetPassword">忘記密碼</a>
	                    <span  data-toggle="modal" data-target="#contactUs">馬上詢問</span>
	                </div>

	            </form>
	        </div>
	    </div>
	                    
	    <!-- 馬上詢問ModalBox -->
	    <div class="modal fade" id="contactUs" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	        <div class="modal-dialog modal-dialog-centered" role="document">
	            <div class="modal-content">
	                <div class="modal-header">
	                    <h5 class="modal-title" id="exampleModalCenterTitle">馬上詢問</h5>
	                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                        <span aria-hidden="true">&times;</span>
	                    </button>
	                </div>
	                <div class="modal-body">
	                    <div class="row">
	                        <div class="col-6 text-center">
	                            <div class="iconBox">
	                                <i class="icon-phone"></i>
	                            </div>
	                            <a class="phone" href="tel:0222264888">(02)2226-4888</a>
	                        </div>
	                        <div class="col-6 text-center">
	                            <img class="lineImg" src="img/line.jpg" alt="">
	                            <p>LINE</p>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	    <footer>
	        <div class="container clearfix">
	                <p class="float-left">Copyright (c)An-Long Color Printing&amp;Reproduction Inc  Co., Ltd. All Rights Reserved.</p>
	                <p class="float-right">
	                    <span>
	                        <a class="photonic" href="http://www.photonic.com.tw/">網路行銷</a> / <a class="photonic" href="http://bigwell.com.tw/">網頁設計</a> / <a class="photonic" href="https://interseo.net/">SEO</a> / <a class="photonic" href="http://erp2000.com/">CRM</a>
	                    </span>
	                </p>
	        </div>
	    </footer>

	    <script src="/js/vendor/angular/angular-1.4.4/angular.js" type="text/javascript"></script>

	    <script type="text/javascript">

	        var app = angular.module('app',[]);

	        app.controller('ContentController',['$http',function($http){

	        	var self = this;

	        	self.login = function(){
	        		self.model.user['login_type'] = 'member';
					$http({
						method : "post",
						url : "/api/member/login",
						data: self.model.user,
					}).success(function(data){
						if (data.status == '200'){
							// location.href = "/";
							// window.history.back()
							location.href = "/member";
						}else{
							alert(data.message)
						}
					}).error(function(){

					})//error
				}//self.login
	        }])//app.controller()
	    </script>
	</body>
</html>
