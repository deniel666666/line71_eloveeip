<!DOCTYPE html>

<!-- <html lang="zh-TW"> -->
<html lang="zh-Hans-CN">
  <head>
    <meta charset="UTF-8">
    @include('client.layouts.seo')
    @include('client.layouts.head')

    @include('client.line.line_select_share_target_head')
  </head>
  <body>
    <div id="app" ng-app="app" ng-controller="ContentController as contCtrl">
      <div id="body_block" class="body_block position-fixed w-100 h-100 bg-dark">
        <div class="loader">
          <span></span>
        </div>
      </div>
      <div class="d-flex align-items-center" style="height:100vh">
        <div class="all-wrap content_block container">
          <h1 class="text-center">分享商務名片</h1>
          <div class="row mt-3">
          </div>
          <div class="row mt-3">
            <div class="col-12 mb-3">
              請點以下按鈕進行操作：
            </div>
            <div class="col-12 mb-3">
              <button class="w-100 btn btn-success" onclick="select_target()">選擇好友</button>
            </div>
            <div class="col-12 mb-3">
              <button class="w-100 btn btn-primary" onclick="copy_url()">複製分享網址</button>
            </div>
          </div>
        </div>
      </div>
      <div class="container-fluid d-none" style="background-color:#849ebf">
        <h3 class="p-4">畫面預覽</h3>
        <div class="w-100" style="overflow-x: scroll;">
          <div class="chatbox">
            <div id="flex2html"></div>
          </div>
        </div>
      </div>
      <input id="copy" type="text" class="position-absolute" value='https://{{$_SERVER["HTTP_HOST"]}}/line_card/select_share_target.html?rand={{$rand}}' style="z-index: -1; top: 0;">
      <div class="bg-white position-absolute w-100" style="z-index: -1; top: 0; height: 50px;"></div>
    </div>

    @include('client.layouts.js')
    @include('client.line.line_select_share_target_js')
  </body>
</html>