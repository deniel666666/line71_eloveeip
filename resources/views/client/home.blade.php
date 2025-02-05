<!DOCTYPE html>
<!-- <html lang="zh-TW"> -->
<html lang="zh-Hans-CN">

<head>
    <meta charset="UTF-8">
    @include('client.layouts.seo')

    @include('client.layouts.head')
</head>
    <body>
        @include('client.layouts.body_top')

        @include('client.layouts.nav')

        <div id="app" ng-app="app" ng-controller="ContentController as contCtrl">
            <h3>這是首頁</h3>
        </div>


        @include('client.layouts.footer')
        
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