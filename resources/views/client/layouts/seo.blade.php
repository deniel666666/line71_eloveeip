    
    <meta charset="utf-8" />
    <!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- seo  start -->
        <title>
            @if (!empty($web_title))
                {{$web_title}}
            @else
                {{$seo['web_title']}}
            @endif
        </title>

        @if (!empty($web_keywords))
        <meta name="keywords" content="{{$web_keywords}}">
        @else
        <meta name="keywords" content="{{$seo['web_keyword']}}">
        @endif

        @if (!empty($web_description))
        <meta name="description" content="{{$web_description}}">
        @else
        <meta name="description" content="{{$seo['web_description']}}">
        @endif

        <meta name="rating" content="general" />
        <meta name="robots" content="all" />
        <meta name="revisit-after" content="1 days" />

        <!--favicon-->
        @if (!empty($cmsPublic[0]['template']['pic_1']))
        <link rel="shortcut icon" href="{{$cmsPublic[0]['template']['pic_1']}}" />
        <link rel="bookmark" href="{{$cmsPublic[0]['template']['pic_1']}}" />
        @else
        <link rel="shortcut icon" href="/public/favicon.ico" />
        <link rel="bookmark" href="/public/favicon.ico" />
        @endif

        <!--  告知FB  -->
        @if (!empty($fb_img))
        <meta property="og:image" content="https://{{$seo['host_url']}}{{$fb_img}}">
        @else
        <meta property="og:image" content="https://{{$seo['host_url']}}/public/upload/fb/{{$seo['fb_share_img']}}"> 
        @endif

        @if (!empty($fb_title))
        <meta property="og:title" itemprop="name" content="{{$fb_title}}">
        @else
        <meta property="og:title" itemprop="name" content="{{$seo['fb_title']}}"> 
        <!-- 可替代<meta name="title" content="" /> -->
        @endif

        @if (!empty($fb_description))
        <meta property="og:description" itemprop="description" lang="zh-Hant-TW" content="{{$fb_description}}">
        @else
        <meta property="og:description" itemprop="description" lang="zh-Hant-TW" content="{{$seo['fb_description']}}">
        @endif
        
        <meta property="og:site_name" name="application-name" content="{{$seo['fb_company']}}" />
        <meta property="og:type" content="website"/> <!--可選擇 還有其他的未標示 website blog article-->
        <meta property="fb:app_id" content="" />
        <meta property="og:url" itemprop="url" content="https://{{$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']}}">
        <meta property="og:locale" content="zh_TW"> <!--告知FB為繁體語言-->

        <!--告知twitter-->
        <meta name="twitter:card" content="summary"> <!--縮圖的意思-->
        <meta name="twitter:domain" content="{{$seo['tiwt_company']}}">
        <meta name="twitter:title" content="{{$seo['tiwt_title']}}">
        <meta name="twitter:description" content="{{$seo['tiwt_description']}}">
        <!---其他設定-->

        {!! $seo['google_verify'] !!}
        {!! $seo['google_analysis_code'] !!}
        {!! $seo['google_sales_code'] !!}
        {!! $seo['yahoo_sales_code'] !!}
        <!--{{$seo['hiden_description']}}-->
    <!-- seo  end -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script> 

    <link href="/css/body_block.css" rel="stylesheet" type="text/css">

    <!-- cms模板樣式 -->
    <link href="/frontEndPackage/css/RWD_eidtor_style.css" rel="stylesheet" type="text/css">
    <script src="/frontEndPackage/js/template.js"></script>
