@extends('customer.layouts.layoutExtends')

@section('javascript_header')@endsection
@section('css_header')@endsection


@section('content')
    <div class="col-12  memberInforBox">
        <div class="row">
            <!-- 會員資料修改 -->
            <div class="col-12 titleBox">
                <span>會員資料修改</span>
            </div>
            <div class="col-md-6 mb-5">
                <!-- /////////////////////////////////////// -->
                <div class="form-row blockBorder">
                    <!-- 會員帳號 -->
                    <div class="col-12">
                        <label for="number">會員帳號</label>
                        <input type="text" ng-model="contCtrl.model.user.account" readonly="readonly" class="form-control" placeholder="" autocomplete="off">
                    </div>

                    <!-- 您的姓名 -->
                    <div class="col-12">
                        <label for="name">姓名</label>
                        <input type="text" ng-model="contCtrl.model.user.user_name" class="form-control" placeholder="必填" autocomplete="off">
                    </div>
                    <!-- 修改密碼 -->
                    <div class="col-12">
                        <label for="modifyPassword">密碼</label>
                        <input type="password" ng-model="contCtrl.model.user.user_pw" class="form-control" placeholder="若不修改密碼，請勿填寫" autocomplete="new-password">
                    </div>
                    <!-- 再次確認密碼 -->
                    <div class="col-12">
                        <label for="againModifyPassword">再次確認修改密碼</label>
                        <input type="password"  ng-model="contCtrl.model.user.passwordConfirm"
                        	   class="form-control" autocomplete="new-password">
                    </div>
                  
                    <!-- 市話 -->
                    <div class="col-md-6">
                        <label for="orderHomeCall">市話</label>
                        <input type="text" ng-model="contCtrl.model.user.telephone" class="form-control" placeholder="" autocomplete="off">
                    </div>

                </div>

            </div>
            <div class="col-md-6 mb-5">
                <div>
                    <label for="orderHomeCall">信箱</label>
                    <input type="email" ng-model="contCtrl.model.user.email" class="form-control" placeholder="必填" autocomplete="" ria-describedby="emailHelp">
                </div>

                <div>
                    <label for="orderHomeCall">生日</label>
                    <input type="date" ng-model="contCtrl.model.user.birth_day" value="@{{contCtrl.model.user.birth_day}}" class="form-control" placeholder="" autocomplete="off">
                </div>

                <!-- 連絡地址 -->
                <div class="sendAddressBox clearfix">
                    <h4>連絡地址</h4>
                    <div class="">
                		<div id="twzipcode" class="d-flex"></div>
            		</div>
                    <input type="text" ng-model="contCtrl.model.user.road" placeholder="請填路名" class="form-control customQuantitySelect" name="address" placeholder="必填">

                </div>
            </div>

            <div class="justify-content-center col-12" ng-if="contCtrl.model.user.line_id=='' || !contCtrl.model.user.line_id">
                <a id="lineAuth" href="/customer/go_line_page" class="btn btn-block btn-success"></span>綁定LINE帳號/</a>
            </div>

            <!-- 送出 -->       
            <div class="justify-content-center col-12 mt-2">
                <button ng-click="contCtrl.updateUser()" class="btn submitBtn col-12" >確認送出</button>
            </div>

            
        </div>
    </div>
@endsection


@section('content2')@endsection


@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-dateFormat/1.0/jquery.dateFormat.js" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $('#twzipcode').twzipcode({
            'readonly': true
        });
    </script>
    <script type="text/javascript">
        var app = angular.module('app',[]);
        app.controller('ContentController',['$http',function($http){
            var self = this;
            self.model = {};

            self.getRegister = function(){
                $http({
                    method  : "get",
                    url     : "/customer/api/register",
                }).success(function(data){
                    // console.log(data);
                    self.model.user = data;
                    $('#twzipcode').twzipcode('set', {
                        'county'  : data.city,
                        'district': data.district,
                    });
                }).error(function(){

                })//error
            }//self.getRegister
            self.getRegister();

            self.updateUser = function(){
                var foolproof = true;
                var county,district,zipcode;

                $('#twzipcode').twzipcode('get', function (county, district, zipcode) {
                    self.model.user.city        = county;
                    self.model.user.district    = district;
                    self.model.user.zipcode     = zipcode;
                });
                // console.log(self.model.user.county);

                if ((!self.model.user.user_name)||(self.model.user.user_name=='')){
                    foolproof = false;
                    $.toaster({ message : '請填姓名', priority : 'warning' });
                }
                if ((!self.model.user.email)||(self.model.user.email=='')){
                    foolproof = false;
                    $.toaster({ message : '請填信箱', priority : 'warning' });
                }


                if (!self.model.user.city){
                    foolproof = false;
                    $.toaster({ message : '請選縣市鄉鎮', priority : 'warning' });
                }
                if ((!self.model.user.road)||(self.model.user.road=='')){
                    foolproof = false;
                    $.toaster({ message : '請填路名', priority : 'warning' });
                }
                if ((self.model.user.user_pw)&&(self.model.user.user_pw != 0)){
                    if (self.model.user.user_pw != self.model.user.passwordConfirm){
                        $.toaster({ message : '修改密碼 與 確認密碼 不合', priority : 'warning' });
                        foolproof = false;
                    }//if
                }//if
                
                // console.log(self.model.user);
                if (foolproof){
                    $http({
                        method : "put",
                        url : "/customer/api/register",
                        data: self.model.user,
                    }).success(function(data){
                        if (data.status == '200'){
                            $.toaster({ message : '資料已更新'});
                        }else{
                            $.toaster({ message : '網路錯誤', priority : 'danger' });
                        }
                    }).error(function(){

                    })//error
                }
            }//self.updateUser = function()
        }])
    </script>
@endsection