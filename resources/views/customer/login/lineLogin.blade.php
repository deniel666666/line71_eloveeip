<!DOCTYPE html>
<html lang="zh-Hant-TW" ng-app="app">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Line 授權</title>
    <link rel="stylesheet" href="/css/reset.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <!-- bootstrap font-awesome -->
    <link rel="stylesheet" href="/css/bootstrap-social.css" >
    <link rel="stylesheet" href="/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="/css/verify.css">
    <script type="text/javascript" src="/js/verify.js" ></script>
    <!-- //////// -->
    <link rel="stylesheet" href="/css/iconstyle.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/phone.css">
    <link rel="stylesheet" href="/css/registered.css">

    <script src="/js/vendor/twzipcode/jquery.twzipcode.js" type="text/javascript"></script>
</head>

<body ng-controller="ContentController as contCtrl">
    <div class="registeredBox">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="logoBox">
                        <img src="img/logo.png" alt="">
                    </div>
                </div>
            </div>
            <div>
                <h2>Line授權</h2>

                <h3>line 登入中請稍後</h3>
            </div>
        </div>
    </div>
                   
    <footer>
        <div class="container clearfix">
                <p class="float-left">Copyright (c)An-Long Color Printing&amp;Reproduction Inc  Co., Ltd. All Rights Reserved.</p>
                <p class="float-right">
                    <span>
                        <a class="photonic" href="http://www.photonic.com.tw/">網路行銷</a> / <a class="photonic" href="http://bigwell.com.tw/">網頁設計</a> / <a class="photonic" href="https://interseo.net/">SEO</a> / <a class="photonic" href="http://erp2000.com/">CRM</a>
                    </span>
                </p>
        </div>
    </footer>

    <script type="text/javascript">
        /*Line 登入 --------------------------------------------*/
        line_id = "{{ $line_id }}";

        var form = document.createElement("form");
        document.body.appendChild(form);
        form.method = "POST";
        form.action = "/api/customer/social_login";
        
        $('form').html("<input name='line_id' type='hidden' value='"+line_id+"'>");  
        setTimeout(function(){
            $('form').submit();
        }, 500);

    </script>
</body>

</html>
