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
          <div class="container articleEditorBox w1920">	
            <div class="row">
              <div class="articleBox w-100 position-relative col-12 mt-4">  
                <p>
                  非常歡迎您光臨「 
                  {{$seo['web_title']}}
                  」（以下簡稱本網站），為了讓您能夠安心的使用本網站的各項服務與資訊，特此向您說明本網站的隱私權保護政策，以保障您的權益，請您詳閱下列內容：
                </p>
              </div>
            </div>
          </div>
          {!! $privacy_policy_content !!}
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