@extends('layouts.master')

<!-- html title -->
@section('htmlTitle') {{$pageTitle}} @endsection
@section('css_header')
<style>
    *{
        font-family: '微軟正黑體','Noto Sans TC', sans-serif;
    }
  body{
     background-color: #eeee;
     overflow-x: hidden;
     padding-left: 1rem;
     padding-right: 1rem;
  }
  .admin-login-box{
     width: 100%;
     height: 100%;
  }
  .admin-login-box h1.title{
     text-align: center;
     font-size: 1.5rem;
     margin-bottom: 1rem;
     font-weight: 500;
  }
 .admin-login-box .center{
    display: flex;
    align-items: center;
    width: 100%;
    height: 100%;
 }
 .profile-img-card {
     width: auto;
     height: auto;
     margin: 0 auto;
     display: block;
     max-width: 270px;
     margin-bottom: 2rem;
  }
  .admin-login-box .card{
      padding: 4rem;
      /* background: rgba(0, 0, 0, 0.2); */
      background: #fff;
      border-radius: 0px;
  }
  .admin-login-box .container{
   max-width: 500px;
   padding-top: 3rem;
   padding-bottom: 3rem;
   padding-right: 0px;
   padding-left: 0px;
   box-sizing: border-box;
  }
  .admin-login-box p.input-title{
   font-size: 1rem;
   margin-bottom: .5rem;
  }
  .admin-login-box .text-danger{
      color: red !important;
      display: block;
      text-align: center;
      font-size: 14px;
  }
  .admin-login-box .submitBtn{
   border-radius: 0px;
   background-color: #343a40;
    border-color: #343a40;
    margin-bottom: .5rem;
  }
  .admin-login-box input:focus{
     outline:none;
     border-color: #495057;
     box-shadow:none;
   }
  .admin-login-box .submitBtn:hover{
      background-color: #4c91e2;
      border-color: #4c91e2;
  }
  .admin-login-box .form-control{
   border-radius: 0px;
  }
  .admin-login-box .ng-hide{
     display: none;
  }
  .admin-login-box .intro ul li,.admin-login-box .intro ul li a{
   font-size: 1rem;
   color: #333;
   text-decoration: none;
  }
  .admin-login-box .intro ul {
      list-style-type: none;
      margin:0px;
      padding:0px;
  }
  .admin-login-box .intro span.title{
    font-weight: 700;
  }
 </style>
@endsection

<!-- 自定義 content -->
@section('content')
  <div class="admin-login-box">
      <div class="center">
          <div class="container">
              <h1 class="title"><span ng-bind="contCtrl.model.client_title"></span>後台登入</h1>
              <div class="card card-container">
                  <div ng-if="contCtrl.model.client_logo">
                      <img id="profile-img" class="profile-img-card" ng-src="@{{contCtrl.model.client_logo}}"  />
                  </div>
                  <p id="profile-name" class="profile-name-card"></p>
                  <form class="form-signin">
                       <div class="form-group">
                          <p class="input-title">帳號</p>
                          <input ng-model="contCtrl.model.acct" type="text" id="inputEmail" class="form-control" required autofocus>
                       </div>
                       <div class="form-group">
                          <p class="input-title">密碼</p>
                          <input ng-model="contCtrl.model.user_pw" type="password" id="inputPassword" class="form-control" required>
                       </div>
                       <div class="form-group">
                          <button class="btn btn-primary btn-block btn-primary submitBtn" type="submit" ng-click="contCtrl.login()">登入</button>
                          <p class="text-danger ng-hide" ng-show="contCtrl.showError">帳密錯誤</p>
                       </div>
                       <div class="intro">
                          <span class="title">製作公司資訊</span>
                          <ul>
                             <li>公司：<span ng-bind="contCtrl.model.dev_team"></span></li>
                             <li>電話：<span ng-bind="contCtrl.model.com_phone"></span></li>
                             <li>地址：<span ng-bind="contCtrl.model.com_address"></span></li>
                          </ul>
                       </div>
                  </form>
              </div>
              
          </div>
      </div>
  </div>

@endsection
<!-- 自定義 javascript -->

@section('javascript')
  <script type="text/javascript">
    var app = angular.module('app', []);
    app.controller('ContentController', ['$http', function($http) {
        var self = this;
        self.model = {};

        self.foolproof = true;
        self.submitCheck = function() {
            // console.log(self.model);
            if ((!self.model.acct) || (self.model.acct == '')) {
                alert("請填帳號");
                self.foolproof = true;
            }
            if ((!self.model.user_pw) || (self.model.user_pw == '')) {
                alert("請填密碼");
                self.foolproof = true;
            }
        }

        self.login = function() {
            self.showError = false;
            self.foolproof = true;
            self.submitCheck();
            console.log(self.foolproof);
            var user = { account: self.model.acct, password: self.model.user_pw };

            if (self.foolproof) {
                $http({
                    method: "post",
                    url: "/admin/api/login/account",
                    data: { user: user },
                }).success(function(data) {
                    console.log(data)
                    if (data.status == '200') {
                        window.location = "/admin";
                    } else {
                        self.showError = true;
                    }
                }).error(function() {
                }) //error
            }
        }

        self.getItem = function() {
            $http({
                method: "get",
                url: "/api/development/team/show",
            }).success(function(data) {
                self.model = data.item;
                console.log(self.model);
            }).error(function() {
                alert('網路錯誤');
            }) //error
        }
        self.getItem();
    }]) //app.controller()

        
  </script>
@endsection