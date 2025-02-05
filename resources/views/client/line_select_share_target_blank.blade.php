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