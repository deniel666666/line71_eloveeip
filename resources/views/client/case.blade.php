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
  <div id="app" ng-app="app" ng-controller="ContentController as contCtrl">
    <section class="position-relative d-flex justify-content-center">
      <img src="{{$cmsPublic['2']['imageSrc']}}" alt="case-banner" class="case-banner" />
      <!-- <img src="frontEndPackage/images/case-banner.png" alt="case-banner" class="case-banner" /> -->
      <!-- @ include('client.layouts.nav') -->
    </section>
    <section class="bg-lightgray py-4">
      <div class="container faq-area d-flex flex-column">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent p-0">
            <!-- <li class="breadcrumb-item"><a href="/">首頁</a></li> -->
            <li class="breadcrumb-item active" aria-current="page">成功案例</li>
          </ol>
        </nav>
        <h2 class="position-relative d-flex justify-content-center">
          <span class="fs-25 p-3">成功案例</span>
        </h2>
      </div>
    </section>
    <main class="fs-18 bg-lightgray">
      <div class="container d-flex flex-column">
        <ul class="list-unstyled case-list overflow-hidden">
        @foreach($case as $item)
          <li class="item">
            <a class="d-flex align-items-center py-14" href="/case-info/{{$item['prod_id']}}">
              <div class="date">{{date('Y/m/d', strtotime($item['prod_s_datetime']))}}</div>
              <h3 class="title fs-18 mb-0 text-truncate">{{$item['prod_name']}}</h3>
              <h4 class="subtitle fs-18 mb-0 text-truncate">{{$item['prod_subtitle']}}</h4>
              <div class="text mb-0 text-truncate">{!!$item['product_describe']['2']['prod_describe']!!}</div>
            </a>
          </li>
        @endforeach
        </ul>
        <a href="javascript:history.back()" class="back mx-auto mb-4">Back</a>
      </div>
    </main>
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