<!DOCTYPE html>
<html lang="zh-Hant-TW" ng-app="app">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>registered</title>
    <link rel="stylesheet" href="/css/reset.css">
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
    <link rel="stylesheet" type="text/css" href="/css/verify.css">
    <script type="text/javascript" src="/js/verify.js" ></script>
    <!-- //////// -->
    <link rel="stylesheet" href="/css/iconstyle.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/phone.css">
    <link rel="stylesheet" href="/css/registered.css">

    <script src="/js/vendor/twzipcode/jquery.twzipcode.js" type="text/javascript"></script>
    <style>
        body{
            width: 100%;
            display:flex;
            align-items:center;
            justify-content:center;
        }

        
        .registeredBox{
            margin-top: 3rem;
            margin-bottom: 3rem;
        }


        #memberrule .modal-dialog{
            max-width: 960px;
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
            <div>
                <h2 class="title">會員註冊</h2>
            </div>
            <form>
                <div class="form-group">
                    <label for="number">註冊帳號(請填入手機)</label>
                    <input type="text" ng-model="contCtrl.model.user.account" class="form-control" id="number" placeholder="必填">
                </div>

                <div class="form-group">
                    <label for="name">會員姓名</label>
                    <input type="text" ng-model="contCtrl.model.user.name" class="form-control" id="name" placeholder="必填">
                    <input type="hidden" ng-model="contCtrl.model.user.line_id" class="form-control" id="line_id" placeholder="">
                </div>

                <div class="form-group">
                    <label for="password">設定密碼</label>
                    <input type="password" ng-model="contCtrl.model.user.password" class="form-control" id="password" placeholder="必填" autocomplete="new-password">
                </div>
                <div class="form-group">
                    <label for="confirmPassword">確認密碼</label>
                    <input type="password" ng-model="contCtrl.model.user.password_confirm" class="form-control" id="confirmPassword" placeholder="必填" autocomplete="new-password">
                </div>

                <div class="form-group">
                    <label for="phone">連絡電話</label>
                    <input type="text" ng-model="contCtrl.model.user.contactPhone" class="form-control" id="phone" placeholder="">
                </div>
                <div class="form-group">
                    <label for="email">email</label>
                    <input type="text" ng-model="contCtrl.model.user.email" class="form-control" id="email" placeholder="" autocomplete="new-password">
                </div>

                <label>連絡地址</label>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <div id="twzipcode"></div>
                    </div>
                    <div class="form-group col-md-12">
                        <input type="text" ng-model="contCtrl.model.user.road" class="form-control" id="address">
                    </div>
                </div>

                <div class="form-group">
                    <input type="checkbox" ng-model="contCtrl.model.user.consentCheck" class="checkmark" id="checkmark">
                    我已閱讀並同意
                    <span  data-toggle="modal" data-target="#memberrule" style="color:blue">會員同意書</span>內容
                </div>

                <!-- 驗證碼   -->
                <div class="row">   
                    <div class="col-12">
                        <h4 class="verificationCode">驗證碼</h4>
                        <div id="verification"></div>
                    </div>
                </div>
                <!-- 驗證碼   -->

                <button type="submit" ng-click="contCtrl.register()" class="btn btn-primary signInBtn" id="check-btn">註冊</button>
                <div class="footerLinkBox">
                    <a class="signIn" href="/customer/login">返回登入</a>
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
    <!-- 會員同意書ModalBox -->
    <div class="modal fade" id="memberrule" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">會員同意書</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12" ng-bind-html="contCtrl.consent">
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
    <script type="text/javascript">
    	var codeVerifyCheck = true;
        $('#verification').codeVerify({
            type : 1,
            width : '100%',
            height : '50px',
            fontSize : '30px',
            codeLength : 6,
            btnId : 'check-btn',
            ready : function() {
            },
            success : function() {
                // alert('驗證成功');
                codeVerifyCheck = true;
            },
            error : function() {
                // alert('驗證失敗');
                codeVerifyCheck = false;
            }
        });

    </script>
    <script type="text/javascript">
    	$('#twzipcode').twzipcode({
    		'readonly': true
    	});
    </script>

	<script src="/js/vendor/angular/angular-1.4.4/angular.js" type="text/javascript"></script>
    <script src="/js/vendor/angular/angular-1.4.4/angular-sanitize.js" type="text/javascript"></script>
    <script type="text/javascript">
        var app = angular.module('app',['ngSanitize']);
        app.controller('ContentController',['$http',function($http){

        	var self = this;self.ngTest = "Angular Test OK";
        	
        	self.foolproof = true;
        	self.model = {};
        	self.model.user = {};
			
			self.register = function(){
				// console.log(self.model.user);
				$('#twzipcode').twzipcode('get', function (county, district, zipcode) {
					self.model.user.county = county;
					self.model.user.district = district;
					self.model.user.zipcode = zipcode;
				});
				// console.log(self.model.user.county);
				// console.log(self.model.user.district);
				// console.log(self.model.user.zipcode);

                error_msg = '';
				if ((!self.model.user.account)||(self.model.user.account=='')){
					error_msg += "請填註冊帳號\n";
				}
				if ((!self.model.user.name)||(self.model.user.name=='')){
                    error_msg += "請填會員姓名\n";
				}
				if ((!self.model.user.password)||(self.model.user.password=='')){
                    error_msg += "設定密碼\n";
				}
				if (self.model.user.password != self.model.user.password_confirm){
					error_msg += "設定密碼與確認密碼不同\n";
				}
                if ((!self.model.user.email)||(self.model.user.email=='')){
                    error_msg += "請填信箱\n";
                }
				if (!self.model.user.consentCheck){
                    error_msg += "請勾選 我已閱讀並同意\n";
				}
				if (!codeVerifyCheck){
                    error_msg += "驗證碼錯誤\n";
				}
                if(error_msg!=''){
                    alert(error_msg);
                    return;
                }

				$http({
					method : "post",
					url : "/api/customer/register",
					data: self.model.user,
				}).success(function(data){
                    console.log(data)
					if (data.status == '200'){
						location.href = "/customer/login"
					}else{
						alert(data.message);
					}
				}).error(function(){
				})//error	
			}//self.register = function()

			self.getConsent = function(){
				$http({
					method : "post",
					url : "/api/miscellaneous",
					data: { miscId: 2},
				}).success(function(data){
					if (data.status == '200'){
						self.consent = data.consent.replaceAll('\n','<br>');
					}else{
						aler('網路錯誤');
					}
				}).error(function(){

				})//error
			}//self.getConsent
			self.getConsent();


            /*Line 登入 --------------------------------------------*/
            var line_id =   "{{ $line_id }}";
            var line_name = "{{ $line_name }}";
            if(line_id){
                self.model.user.line_id = line_id;
                self.model.user.name    = line_name;
            }
            
        }])//app.controller()
    </script>
</body>

</html>
