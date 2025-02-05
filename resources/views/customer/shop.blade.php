@extends('customer.layouts.layoutExtends')

@section('javascript_header')@endsection
@section('css_header')@endsection


@section('content')
    <div class="col-12  memberInforBox">
        <div class="row">
            <!-- 追蹤店家 -->
            <div class="col-12 titleBox">
                <span>追蹤店家</span>
            </div>

            <!-- /////////////////////////////////////// -->
            <div class="row blockBorder w-100 m-0">
                <div class="col-md-3 col-6" ng-repeat="item in contCtrl.model.user.trackingShop">
                    <img ng-src="@{{item.pic}}" width="100%">
                    <h3 ng-bind="item.user_name"></h3>
                    <a herf="/">查看詳細內容</a>
                    <a herf="/" ng-click="contCtrl.cancelTracking(item.id)">取消追蹤</a>
                </div>
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

            self.getRegisterUrl     = "/customer/api/register";
            self.trackingShopUrl    = "/customer/api/tracking_shop";

            self.getRegister = function(){
                $http({
                    method  : "get",
                    url     : self.getRegisterUrl,
                }).success(function(data){
                    // console.log(data)
                    data.trackingShop = data.trackingShop.filter(item => typeof(item.id)!=='undefined');
                    self.model.user = data;
                }).error(function(){
                })//error
            }//self.getRegister
            self.getRegister();



            self.cancelTracking = function(item_id){
                $http({
                    method  : "post",
                    url     : self.trackingShopUrl,
                    data    :{
                        method  : 'subtract',
                        shop_id : item_id
                    }
                }).success(function(data){
                    $.toaster({ message : '更新成功'});
                    self.getRegister();
                }).error(function(){
                    $.toaster({ message : '網路錯誤', priority:"danger"});
                })//error
            }
        }])
    </script>
@endsection