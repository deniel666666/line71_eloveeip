@extends('layouts.masterAdmin')

<!-- html title -->
@section('htmlTitle') {{$pageTitle}}  @endsection

<!-- 自定義 content -->
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <p class="h3 text-muted d-lg-block d-none">@{{contCtrl.adminCont}}</p>
                <p class="h3 text-muted d-lg-none d-block mt-5"><br>請點右上選單進入各功能</p>
            </div>
        </div>
    </div>
@endsection

<!-- 自定義 javascript -->
@section('javascript')
    <script type="text/javascript">
    </script>
    <script type="text/javascript">
        var app = angular.module('app',[]);
        app.controller('ContentController',['$http',function($http){
        	var self = this;
        	self.adminCont = "請點選左方選項";
        }])//app.controller()
    </script>
@endsection







