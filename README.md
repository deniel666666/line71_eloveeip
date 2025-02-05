# 萬用後台(laravel_9)
傳訊萬用後台/形象網站後台/RWD編輯器

以Lravel 5.多版開發的內控系統，請搭配php7.3板使用。<br>
需建立資料庫，放置於 database/sql 內，請按名稱排序<b>由小到大</b>逐個匯入<br>
<br>
另外，使用此程式前還請記得修改以下內容：<br>
<ol>
    <li>
        .env.example：<br />
        請複製一份並改名為.env，然後按以下說明修改參數<br />
        如欲架設正式站，請關閉報錯，修改 APP_DEBUG 成 false<br />
        請修APP_URL網址 multipleproduct.wacocolife.com 成正式網址<br />
        請修改資料庫連線設定 DB_DATABASE、DB_USERNAME、DB_PASSWORD<br />
        請修mail連線參數 MAIL_HOST、MAIL_USERNAME、MAIL_PASSWORD<br />
        如有使用LINE登入，請修改 LINE_CHANNEL_ID、LINE_SECRET，並修改LINE_CALL_BACK_URL中的「web_template.test」改成正式網址 (注意：需另外到LINE Developers創建app，並確認主機有安裝SSL)<br />
        <b>此為LINE名片分享特例化分支，務必設定【獨立】 LIFF_ID_SELECT_SHARE_TARGET 參數，不可與其他網域(或子網域)共用，關乎到是否能正確分享名片。</b><br />
    </li>
    <li>
        .htaccess：<br />
        如欲強制跳轉成HTTPS請刪除RewriteCond、RewriteRule前的井字號，反之則請保留井字號在前<br />
    </li>
    <li>
        public/robots.txt：<br />
        如欲搬至正式站，請修改 Disallow:/ 成 Disallow: (注意：設成「Disallow:」才會允許瀏覽器收錄網站)<br />
    </li>
    <li>
        語言版設定：<br />
        - 請至資料資料庫開啟 `lang` 表依需求修改欄位內容：
        <ul>
            <li>
                新增/關閉語言版：<br />
                每一個語言版需有一筆資料，可透過複製後修改來添加語言版資料，避免內容有誤。如不需多語言版，請將無用之與言版的 `lang_status` 欄位設為0 或 刪除整筆紀錄，<b>但請一定要留下id為1的語言版且保持其 `lang_type` 為空字串</b>。<br>
                另外，每一個語言版也需在 <b>`seo`</b> 表中有對應的紀錄，其中<b>`seo_id` 欄位需與 `lang`.`lang_id` 欄位對應</b>。
            </li>
            <li>
                連結：<br />
                於 `lang_type` 設定語言版<b>連結開頭(預設語言請留空白)</b>，<code>{{$lang_type}}/你的網址</code> 即為語言版內容網址，<br>
                ex：{{$lang_type}}/about.html，<br />
                在繁體版下為：/about.html<br />
                在英語版下為：/en/about.html<br />
                (請務必依照依照格式設定網址)<br />
            </li>
            <li>
                路由：<br />
                根據 `lang_type` 設定之語言版對應 `lang_id` ，在 <b>web.php</b> 中用：「 
                <code>
                    Route::group(['langeId'=>{語言版id}], function () { <br>
                        {你的路由們}<br>
                    });<br>
                </code>
                」包起所有同語言版之路由，如此切換語言版網址時，就會依指定的 langeId 去取得對應語言版的固定文字。
            </li>
        </ul>
        - 請設定語言版文字(lang/1)：<br />
        <ul>
            <li>請<i><b><ins>複製</ins></b></i>一份並去掉檔名的「example.」<br /></li>
            <li>
                用法說明：
                <ul>
                    <li>「lang」資料夾中的「1」是「語言版資料夾」，對應資料庫lang表的id</li>
                    <li>如有多語言版，則須建立多個「語言版資料夾」，而每個資料夾中都必須有屬於自己的 menu.json</li>
                    <li>各menu.json為<b>JSON格式</b>之固定文字資料(key值可為中文)，如此即可於 .blade.php 檔中使用 <code>{{$lang_menu['回首頁']}}</code> 語法取得對應key值的語言版文字 (<b>但須把該.blade.php加入app\Providers\ComposerServiceProvider.php中的ProfileNavComposer的預處理對象</b>)</li>
                </ul>
            </li>
            <li><b>如果客製化時有「修改」到語言版內容(添加key-value對或修改value)時，請務必也修改對應「example」檔內容，以利協同作也者了解更新內容</b></li>
            <li><b>如果客製化時有「新增」語言版(ex:建立lang/2/menu.json、lang/3/menu.json)，則無需再建立對應的「example」檔，直接加入git版本追蹤即可</b></li>
        </ul>
    </li>
    <li>
        隱私權條款：<br />
        此用此模板架設之網站預設都會有「隱私權條款頁面」，相對網址為：/privacy_policy.html
    </il>
    <li>
        各頁SEO設定：<br />
        於後台「各頁SEO設定」(resources/views/admin/cms/customize/seo_cms.blade.php)，添加「對應頁面前綴」之欄位們，即可於前台Controller中透過<code>parent::set_page_seo($request, 「對應頁面前綴」);</code>為該頁設定SEO的標題、關鍵字、介紹。(可參考app/Http/Controllers/Client/CmsController.php)
    </il>
</ol>


<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
