
    <script src="/js/vendor/angular/angular-1.4.4/angular.js" type="text/javascript"></script>
    <script>
      var rand = '{{$rand}}';
      var liffID = '{{$LIFF_ID_SELECT_SHARE_TARGET}}';

      var app = angular.module('app',[]);
      app.controller('ContentController',['$http',function($http){
        var self = this;
        self.card_array = [];

        self.replaceValue_uri = function(obj, targetUri, replacement) {
          for (const key in obj) {
            if (typeof obj[key] === 'object' && obj[key] !== null) {
              // 檢查是否為 action 對象
              if (key === 'action' && obj[key].uri === targetUri) {
                obj[key].uri = replacement; // 替換 uri
              } else {
                self.replaceValue_uri(obj[key], targetUri, replacement); // 递归调用
              }
            }
          }
        }
        self.replaceValue_br = function(obj, targetKey, replacement) {
          for (const key in obj) {
            if (typeof obj[key] === 'object' && obj[key] !== null) {
              // 檢查是否為 action 對象
              if (obj[key].type === 'text') {
                if(obj[key].text = obj[key].text){
                  obj[key].text = obj[key].text.replaceAll(targetKey, replacement); // 替換 uri
                }
              } else {
                self.replaceValue_br(obj[key], targetKey, replacement); // 递归调用
              }
            }
          }
        }

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

                let line_share_uri = `https://liff.line.me/${liffID}?rand=${rand}&type=lineshare`;
                for (let i = 0; i < template.length; i++) {
                  self.replaceValue_uri(template[i], 'https://line.me', line_share_uri);
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
                $.toaster({ message : '無此名片或名片已過期', priority : 'danger' });
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
          let contCtrl = angular.element('#app').scope().contCtrl;
          card_array = contCtrl.card_array;
          for (let i = 0; i < template.length; i++) {
            contCtrl.replaceValue_br(template[i], '<br>', '\n');
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
              $.toaster({ message : '請重新整理畫面', priority : 'danger' });
              liff.logout();
            }
          });
        }else{
          alert('can not shareTargetPicker');
        }
      }
    </script>