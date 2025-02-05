<!DOCTYPE html>
<!-- <html lang="zh-TW"> -->
<html lang="zh-Hans-CN">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/frontEndPackage/css/RWD_eidtor_style.css" />
    @include('client.layouts.seo')
    @include('client.layouts.head')
</head>

<body>
    @include('client.layouts.body_top')
    <div id="app" ng-app="app" ng-controller="ContentController as contCtrl">
        <header class="position-relative bg-lightgray">
            <!-- @ include('client.layouts.nav') -->
            <div class="container d-flex justify-content-between pt-100">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0">
                        <!-- <li class="breadcrumb-item"><a href="/">首頁</a></li> -->
                        <!-- <li class="breadcrumb-item"><a href="/case">成功案例</a></li> -->
                        <li class="breadcrumb-item active" aria-current="page">{{ $content['item']['prod_name']}} </li>
                    </ol>
                </nav>
                <span>{{date('Y/m/d', strtotime($content['item']['prod_s_datetime']))}} </span>
            </div>
        </header>

        {!! $content['contents']!!}

        <div class="container d-flex flex-column mt-4">
            <a href="javascript:history.back()" class="back mx-auto mb-4">Back</a>
        </div>
    </div>

    @include('client.layouts.footer')
    <script src="/frontEndPackage/js/template.js"></script>
    @include('client.layouts.js')

    <!-- <script src="/js/vendor/angular/angular-1.4.4/angular.js" type="text/javascript"></script> -->
    <script>
        // var app = angular.module('app',[]);
        // app.controller('ContentController',['$http',function($http){
        // }])//app.controller()
        // angular.bootstrap(document.getElementById("app"), ['app']); // html內有多個app時需使用
    </script>
</body>

</html>