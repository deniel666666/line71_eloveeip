<!DOCTYPE html>
<!-- <html lang="zh-TW"> -->
<html lang="zh-Hans-CN">

<head>
    <meta charset="UTF-8">
    @include('client.layouts.seo')

    <link rel="stylesheet" href="/frontEndPackage/owlcarousel/owl.carousel.min.css" />
    <link rel="stylesheet" href="/frontEndPackage/owlcarousel/owl.theme.default.min.css" />
    <link rel="stylesheet" href="/frontEndPackage/swiper/swiper-bundle.min.css" />
    @include('client.layouts.head')
</head>

<body>
    @include('client.layouts.body_top')

    <div id="app" ng-app="app" ng-controller="ContentController as contCtrl">
        <section class="position-relative d-flex justify-content-center">
            <img src="{{$cmsPublic['1']['imageSrc']}}" alt="faq-banner" class="faq-banner" />
            @include('client.layouts.nav')
        </section>
        <section class="bg-lightgray py-4">
            <div class="container faq-area d-flex flex-column">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0">
                        <li class="breadcrumb-item"><a href="/">首頁</a></li>
                        <li class="breadcrumb-item active" aria-current="page">FAQ</li>
                    </ol>
                </nav>
                <h2 class="position-relative d-flex justify-content-center">
                    <span class="fs-25 p-3">FAQ</span>
                </h2>
            </div>
        </section>

        <section class="bg-lightgray faqtab">
            <div class="container">
                <div class="faqtab-carousel owl-carousel owl-theme">
                    @foreach($categories as $item)
                    @if($cate_tag_id == $item->cate_tag_id)
                    <a href="/faq/{{$item->cate_tag_id}}" class="item pb-2 px-1 mr-3 active">{{$item->cate_name}}</a>
                    @else
                    <a href="/faq/{{$item->cate_tag_id}}" class="item pb-2 px-1 mr-3">{{$item->cate_name}}</a>
                    @endif
                    @endforeach
                </div>
            </div>
        </section>
        <main class="bg-lightgray pt-60 pb-4">
            <div class="container faq-area">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div id="accordion">
                            @foreach($faq as $q =>$item)
                            <div class="card rounded-0 mb-3">
                                <div class="card-header bg-white" id="Q{{$q+1}}">
                                    <h2 class="mb-0 fs-16">
                                        <a class="question-title w-100" type="button" data-toggle="collapse" href="#A{{$q+1}}" aria-expanded="true" aria-controls="A{{$q+1}}">
                                            Q{{$q+1}}. {{$item['prod_name']}}
                                        </a>
                                    </h2>
                                </div>
                                <div id="A{{$q+1}}" class="collapse" aria-labelledby="Q{{$q+1}}" data-parent="#accordion">
                                    <div class="card-body">
                                        {!!$item['product_describe']['2']['prod_describe']!!}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <ul class="pagination d-flex justify-content-center align-items-center">
                
                    @if($p_prev)
                        <li class="prev"><a href="/faq/{{$current_tag}}/{{$p_prev}}" class="p-2">上一頁</a></li>
                    @endif
                
                    @foreach($pages as $page)
                        <li><a href="/faq/{{$current_tag}}/{{$page}}" class="p-2 @if($currentPage==$page) active @endif">{{$page}}</a></li>
                    @endforeach
                
                    @if($p_next)
                        <li class="next"><a href="/faq/{{$current_tag}}/{{$p_next}}" class="p-2">下一頁</a></li>
                    @endif
                </ul>
        </main>
    </div>

    @include('client.layouts.footer')

    @include('client.layouts.js')

    <script src="/frontEndPackage/owlcarousel/owl.carousel.min.js"></script>
    <script src="/frontEndPackage/swiper/swiper-bundle.min.js"></script>
    <script src="/frontEndPackage/js/swiper-control.js"></script>
    <script src="/frontEndPackage/js/owlcarousel-control.js"></script>
    <!-- <script src="/js/vendor/angular/angular-1.4.4/angular.js" type="text/javascript"></script> -->
    <script>
        // var app = angular.module('app',[]);
        // app.controller('ContentController',['$http',function($http){
        // }])//app.controller()
        // angular.bootstrap(document.getElementById("app"), ['app']); // html內有多個app時需使用
    </script>
</body>

</html>