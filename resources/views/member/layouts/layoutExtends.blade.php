<!DOCTYPE html>
<html ng-app="app">

<head>

    @include('client.layouts.seo')

    <!-- admin head -->
    <!-- ---------- -->
    <link href="/css/admin-style.css" rel="stylesheet" type="text/css" />
    <link href="/css/bootstrap/bootstrap-4.0.0/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="/css/fontawesome/fontawesome-free-5.5.0-web/all.css" rel="stylesheet" type="text/css" />


    <!-- member head -->
    <!-- ---------- -->
    <link href="/css/reset.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="/css/iconstyle.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/phone.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="/js/vendor/twzipcode/jquery.twzipcode.js" type="text/javascript"></script>

    <!-- include summernote css/js -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.css" rel="stylesheet">
    <script src="/summernote/summernote-bs4.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/lang/summernote-zh-TW.min.js"></script>


    <script src="/js/proj_admin.js" type="text/javascript"></script>
    <script src="/js/jquery.toaster.js" type="text/javascript"></script>

    @yield('external_plugin')

    @yield('javascript_header')
    @yield('css_header')

    <style type="text/css">
        @media screen and (max-width: 991px){
            .signOut{
                display: inline-block;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid" style="padding: 0px;">
        <div id="ng_contCtrl" ng-controller="ContentController as contCtrl">
            <header class="header">
                <nav class="container clearfix">
                        <div class="logoImgBox">
                            <img src="/img/logo.png" alt="">
                        </div>
                        <ul class="navBox nav">
                            <li class="nav-item">
                                <span><span id="user_name"></span> 你好！</span>
                            </li>
                            <li class="nav-item">
                                <a class="signOut" href="/member/logout">登出<i class="icon-sign_out"></i></a>
                            </li>
                            <li class="nav-item icon-dialogue askBtn" data-toggle="modal" data-target="#contactUs">
                                <div class="text">
                                    <div>
                                        馬上<br/>詢問
                                    </div>
                                </div>
                            </li>
                        </ul>

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
                                                <img class="lineImg" src="/img/line.jpg" alt="">
                                                <p>LINE</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </nav>
            </header>

            <section class="container purchaseOrderBox selectStyle">
                <div class="row phonePadding">
                    <div class="col-12">
                        @include('member.layouts.member_menu')
                    </div>

                    @yield('content')

                </div>
            </section>

            <section class="container purchaseOrderBox selectStyle">
                @yield('content2')
            </section>
        </div>
    </div>
    

    <footer>
        <div class="container clearfix">
            <p class="float-left">Copyright (c)An-Long Color Printing&amp;Reproduction Inc  Co., Ltd. All Rights Reserved.</p>
            <p class="float-right">
                <span>
                    <a target="_blank" class="photonic" href="http://shop.photonic.com.tw/">購物車系統</a> /
                    <a target="_blank" class="photonic" href="http://erp2000.com/">CRM</a> /
                    <a target="_blank" class="photonic" href="http://www.photonic.com.tw/">網頁設計</a> /
                    <a target="_blank" class="photonic" href="https://sprlight.net/index.php/">SEO關鍵字優化</a>
                </span>
            </p>
        </div>
    </footer>


    <!-- //////////////////////////////////////////////////////////////////// -->
    <a href="#" class="goTop"><i class="icon-arrow_top"></i></a>



    <!-- JS  -->
    <script src="/js/vendor/angular/angular-1.4.4/angular.js" type="text/javascript"></script>
    <script src="/js/vendor/angular/angular-summernote-master\dist\angular-summernote.js" type="text/javascript"></script>
    <script src="/js/vendor/angular/angular-ui-bootstrap\ui-bootstrap-tpls-2.5.0.js" type="text/javascript"></script>


    <!-- member JS  -->
    <script src="/js/goTop.js"></script>         <!-- go top -->
    <script src="/js/dropDownSelect.js"></script><!-- 下拉式選單 -->
    <script src="/js/upDown.js"></script>        <!-- updown -->
    <script src="/js/clickFunction.js"></script> <!-- click lightbox -->

    <script type="text/javascript">
        $('#twzipcode').twzipcode({
            'readonly': true
        });

        /*更新使用者名稱*/
        $.ajax({
            url : "/member/api/register",
            type: "GET",
            success: function(data){
                console.log(data);
                $('#user_name').html(data.user_name);
            }
        })
    </script>

    @yield('javascript')
</body>
</html>