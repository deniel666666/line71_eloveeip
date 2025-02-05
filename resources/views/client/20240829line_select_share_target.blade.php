<!DOCTYPE html>

<!-- <html lang="zh-TW"> -->
<html lang="zh-Hans-CN">
  <head>
    <meta charset="UTF-8">
    @include('client.layouts.seo')
    @include('client.layouts.head')

    <script src="/js/vendor/twzipcode/jquery.twzipcode.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/PamornT/flex2html@main/css/flex2html.css">
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/gh/PamornT/flex2html@main/js/flex2html.min.js" type="text/javascript"></script>
    <style type="text/css">
      .body_block{
        opacity: 0.8;
        z-index:9999;
        display: none;
      }

      .loader {
        position: relative;
        width: 45px;
        height: 45px;
        left: 50%;
        top: 50%;
        margin-left: -22px;
        margin-top: 2px;
        -webkit-animation: rotate 1s infinite linear;
        -moz-animation: rotate 1s infinite linear;
        -ms-animation: rotate 1s infinite linear;
        -o-animation: rotate 1s infinite linear;
        animation: rotate 1s infinite linear;
        border: 3px solid rgba(0, 0, 0, 1);
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -ms-border-radius: 50%;
        -o-border-radius: 50%;
        border-radius: 50%;
      }
      .loader span {
        position: absolute;
        width: 45px;
        height: 45px;
        top: -3px;
        left: -3px;
        border: 3px solid transparent;
        border-top: 3px solid rgba(255, 255, 255, 1);
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -ms-border-radius: 50%;
        -o-border-radius: 50%;
        border-radius: 50%;
      }
      @-webkit-keyframes rotate {
        0% {
          -webkit-transform: rotate(0deg);
        }
        100% {
          -webkit-transform: rotate(360deg);
        }
      }
      @keyframes rotate {
        0% {
          transform: rotate(0deg);
        }
        100% {
          transform: rotate(360deg);
        }
      }

      .chatbox{
        width: auto;
        min-width: 500px;
      }

      /* .T1 .t1Body > .MdBx {
        padding-top:10px !important;
        padding-bottom:0 !important;
      } */
    </style>
  </head>
  <body>
    <div id="app" ng-app="app" ng-controller="ContentController as contCtrl">
      <div id="body_block" class="body_block position-fixed w-100 h-100 bg-dark">
        <div class="loader">
          <span></span>
        </div>
      </div>
      <div class="all-wrap content_block container">
        <div class="row mt-3">
          <div class="col-12 mb-3">
            <button class="w-100 btn btn-success" onclick="select_target()">選擇好友</button>
          </div>
          <div class="col-12 mb-3">
            <button class="w-100 btn btn-primary" onclick="copy_url()">複製分享網址</button>
          </div>
        </div>
      </div>
      <div class="container-fluid" style="background-color:#849ebf">
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

    <script src="/js/vendor/angular/angular-1.4.4/angular.js" type="text/javascript"></script>
    <script>
      var rand = '{{$rand}}';
      var liffID = '{{$LIFF_ID_SELECT_SHARE_TARGET}}';

      var app = angular.module('app',[]);
      app.controller('ContentController',['$http',function($http){
        var self = this;
        self.card_array = [];
        self.get_line_card = async function(){
          $('#body_block').show();

          /*建立名片資料*/
          $.ajax({
            method: "get",
            url: "/api/lind_card/"+rand,
            async: false,
            success: function(data) {
              if(Object.keys(data).length!=0){
                // console.log(data['template']);
                template = JSON.parse(data['template']);
                console.log(template);
                for (let i = 0; i < template.length; i++) {
                  if (template[i].body) {
                    if (template[i].body.contents) {
                      if (template[i].body.contents[1]) {
                        if (template[i].body.contents[1].contents) {
                          if (template[i].body.contents[1].contents[1]) {
                            if (template[i].body.contents[1].contents[1].contents) {
                              if (template[i].body.contents[1].contents[1].contents[0]) {
                                if (template[i].body.contents[1].contents[1].contents[0].action) {
                                  if (template[i].body.contents[1].contents[1].contents[0].action.uri == 'https://line.me') {
                                    template[i].body.contents[1].contents[1].contents[0].action.uri = `https://liff.line.me/${liffID}?rand=${rand}&type=lineshare`;
                                  }
                                }
                              }
                            }
                          }
                        //   if (template[i].body.contents[1].offsetBottom) {
                        //     let ori = parseInt(template[i].body.contents[1].offsetBottom.split('px')[0]);
                        //     template[i].body.contents[1].offsetBottom = (Math.round(ori * 5 / 9) + 25) + 'px';
                        //   }
                        }
                      }
                    }
                  }
                  if (template[i].footer) {
                    for(let j =0 ;j < template[i].footer.contents.length;j++){
                      if(template[i].footer.contents[j].contents[0].action != undefined){
                        // console.info(template[i].footer.contents[j]);
                        if(template[i].footer.contents[j].contents[0].action.uri=='https://line.me'){
                        template[i].footer.contents[j].contents[0].action.uri=`https://liff.line.me/${liffID}?rand=${rand}&type=lineshare`;
                        // console.info(template[i].footer.contents[j].action.uri);
                        }
                      }
                    }
                  }
                }
                if(template){
                  self.card_array = template;
                  flex2html("flex2html", {
                    "type":"flex","altText":"商務名片",
                    "contents":{
                      "type":"carousel",
                      "contents": template
                    }
                  });
                  $('#body_block').hide();
                }else{
                  $.toaster({ message : '名片內容有誤，無法寄送', priority : 'danger' });
                  $('#body_block').hide();
                }
              }
              else{
                $.toaster({ message : '無此名片', priority : 'danger' });
                setTimeout(function(){
                  window.close();
                }, 1500);
              }
            },
            error: function() {
              $('#body_block').hide();
              // $.toaster({ message : '發生錯誤', priority : 'danger' });
              setTimeout(function(){
                window.close();
              }, 1500);
            }
          });
        }
        self.share_target = async function(){
          try {
            await liff.init({
              liffId: liffID // 請用自己的 liffId
            })
            // 從這裡開始使用 liff 的 API
            if (!liff.isLoggedIn()) {
              liff.login({ redirectUri: location.href })
              return
            }
            const accessToken = liff.getAccessToken()
          } catch (err) {
            // 發生錯誤
            console.log(err.code, err.message);
            // alert(err.message)
          }

          await self.get_line_card();

          const urlParams = new URLSearchParams(window.location.search);
          const param_type = urlParams.get('type');

          if (self.card_array.length > 0 && param_type == 'lineshare') {
            select_target();
          }
        }
        self.share_target();
      }])//app.controller()
      // angular.bootstrap(document.getElementById("app"), ['app']); // html內有多個app時需使用
    </script>
    <script src="/js/jquery.toaster.js" type="text/javascript"></script>
    <script src="https://static.line-scdn.net/liff/edge/versions/2.3.0/sdk.js"></script>
    <!-- <script src="https://static.line-scdn.net/liff/edge/2/sdk.js"></script> -->
    <script type="text/javascript">
      function copy_url() {
        textArea = $('#copy');
        textArea.select();

        try {
          var successful = document.execCommand('copy');
          var msg = successful ? 'successful' : 'unsuccessful';
          $.toaster({ message : '複製成功',  priority : 'success'});
        } catch (err) {
          $.toaster({ message : '複製失敗',  priority : 'danger'});
        }
      }
      /* $(document).ready(function(){
        if(liffID){
          liff.init({
            liffId: liffID
          }).then(function() {
            console.log('LIFF init');
            // 這邊開始寫使用其他功能
          }).catch(function(error) {
            console.log(error);
          });
        }
      }); */
      // console.info(liffID);

      // 已移至angular
      async function main () {
        try {
          await liff.init({
            liffId: liffID // 請用自己的 liffId
          })
          // 從這裡開始使用 liff 的 API
          if (!liff.isLoggedIn()) {
            liff.login({ redirectUri: location.href })
            return
          }
          const accessToken = liff.getAccessToken()
        } catch (err) {
          // 發生錯誤
          console.log(err.code, err.message);
          // alert(err.message)
        }
      }

      function select_target(){
        if(liff.isInClient()){
          //alert('phone open');
          //return;
        }
        
        if (liff.isApiAvailable('shareTargetPicker')) {
          card_array = angular.element('#app').scope().contCtrl.card_array;
          for (let i = 0; i < card_array.length; i++) {
            if (card_array[i].body) {
              if (card_array[i].body.contents) {
                if (card_array[i].body.contents[1]) {
                  if (card_array[i].body.contents[1].contents) {
                    if (card_array[i].body.contents[1].contents[0].text) {
                      card_array[i].body.contents[1].contents[0].text = card_array[i].body.contents[1].contents[0].text.replaceAll('<br>', '\n');
                    }
                  }
                }

                if (card_array[i].body.contents[2]) {
                  if (card_array[i].body.contents[2].text) {
                    card_array[i].body.contents[2].text = card_array[i].body.contents[2].text.replaceAll('<br>', '\n');
                  }
                }
              }
            }
          }
          liff.shareTargetPicker(
            [
              {
                "type":"flex","altText":"商務名片",
                "contents":{
                  "type":"carousel",
                  "contents": card_array
                }
              },
            ],
            {
              isMultiple: true,
            }
          )
          .then(function (res) {
            if (res) {
              // succeeded in sending a message through TargetPicker
              console.log(`[${res.status}] Message sent!`);
              $.toaster({ message : '發送成功',  priority : 'success'});
            } else {
              const [majorVer, minorVer] = (liff.getLineVersion() || "").split(".");
              if (parseInt(majorVer) == 10 && parseInt(minorVer) < 11) {
                // LINE 10.3.0 - 10.10.0
                // Old LINE will access here regardless of user's action
                console.log("TargetPicker was opened at least. Whether succeeded to send message is unclear");
              } else {
                // LINE 10.11.0 -
                // sending message canceled
                console.log("TargetPicker was closed!");
              }
            }
          })
          .catch(function (error) {
            // something went wrong before sending a message
            console.log(error);
            if(error.message == 'failed to send message'){
              $.toaster({ message : '發送內容有誤，請再試一次', priority : 'danger' });
            }else{
              $.toaster({ message : '請再登入一次', priority : 'danger' });
              liff.logout();
            }
          });
        }else{
          alert('can not shareTargetPicker');
        }
      }
    </script>
  </body>
</html>