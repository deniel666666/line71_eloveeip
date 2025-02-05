<!DOCTYPE html>
<html>
    <head>
        <title>成功</title>
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <style>
            html, body {
                height: 100%;
            }
            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato', sans-serif;
            }
            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }
            .content {
                text-align: center;
                display: inline-block;
            }
            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
            a{
                color: inherit;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                @if($exception->getMessage()=="")
                    <div class="title">操作成功</div>
                @else
                    <div class="title">{{ $exception->getMessage() }}</div>
                @endif
                <h3><span id="second"></span>秒後即將<a href="javascript:location.href=document.referrer">跳轉</a></h3>
            </div>
        </div>

        <script type="text/javascript">
            var second = 3; /*等待跳轉秒數*/
            var second_span = document.getElementById('second');
            second_span.innerHTML = second;
            interval = setInterval(function(){
                second -= 1;
                second_span.innerHTML = second;
                if(second <= 0 ){
                    location.href=document.referrer
                    clearInterval(interval);
                }
            }, 1000)
        </script>
    </body>
</html>
