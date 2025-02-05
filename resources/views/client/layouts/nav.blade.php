<!-- 當前語言版id：{{$langId}} -->
<!-- 語言版網址範例：<a href="{{$lang_type}}/你的網址"> -->
<!-- 語言版對應內容：{{$lang_menu['回首頁']??''}} -->
<!-- LOGO：{{$cmsPublic[0]['imageSrc']}} -->
<nav class="side-menu">
    <a class="burger-menu position-fixed" type="button" data-toggle="offcanvas">
        <span class="burger"></span>
    </a>

    <div class="navbar-collapse offcanvas-collapse d-flex flex-column">
        <a type="button" data-toggle="offcanvas" class="ml-auto mt-3"><span class="material-icons"> clear </span></a>
        <ul class="list-unstyled text-center">
            <li>
                <a id="" class="nav-link position-relative" href="/">首頁</a>
            </li>
            <li>
                <a id="nav-case" class="nav-link position-relative" href="/case">成功案例</a>
            </li>
            <li>
                <a id="nav-faq" class="nav-link position-relative" href="/faq">FAQ</a>
            </li>
        </ul>
    </div>
</nav>
