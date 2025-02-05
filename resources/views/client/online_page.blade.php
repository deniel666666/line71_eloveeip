<!DOCTYPE html>
<html lang="zh-TW">
  <head>
    <meta charset="UTF-8">
    @include('client.layouts.seo')
    @include('client.layouts.head')

    <link rel="stylesheet" href="/frontEndPackage/particles/style.css">
    <link rel="stylesheet" href="/frontEndPackage/css/verify.css">

    <style>
      .detect-box .title {
        font-size: 1.1rem;
      }
      .detect-box ul {
        display: flex;
        flex-wrap: wrap;
        border-bottom: 1px solid #cccccc;
      }
      .detect-box ul li .form-group {
        margin-bottom: 2rem;
      }
      .detect-box ul li {
        flex: 0 0 100%;
      }
      @media (min-width: 992px){
        .detect-box ul li {
          flex: 0 0 50%;
          padding-right: 15px;
        }
      }

      @media (min-width: 1024px){
        .modal-dialog {
          max-width: 1000px;
        }
      }
    </style>
  </head>
  <body>
    @include('client.layouts.body_top')
    <div class="all-wrap content_block ">
      <!-- @ include('client.layouts.nav') -->
      <nav class="side-menu">
        <a class="burger-menu position-fixed" type="button" data-toggle="offcanvas">
          <span class="burger"></span>
        </a>
        <div class="navbar-collapse offcanvas-collapse d-flex flex-column">
          <a type="button" data-toggle="offcanvas" class="ml-auto mt-3"><span class="material-icons"> clear </span></a>
          <ul class="list-unstyled text-center">
            <li>
              <a id="" class="nav-link position-relative page-top-btn m-0" href="###" style="right: auto; bottom: auto;">最頂端</a>
            </li>
            @if(count($case)>0)
              <li>
                <a id="nav-case" class="nav-link position-relative" href="#block_case">成功案例</a>
              </li>
            @endif
            @if(count($faq)>0)
              <li>
                <a id="nav-faq" class="nav-link position-relative" href="#block_faq">FAQ</a>
              </li>
            @endif
          </ul>
        </div>
      </nav>

      <div id="app" ng-app="app" ng-controller="ContentController as contCtrl">
        {{-- 
          <section class="page">
            <div class="banner-content">
              <!-- 大圖 -->
              <div class="about page-banner" style="background-image: url(/frontEndPackage/images/page.png);">
                <div class="txt">
                  <h2 class="title">線上報名</h2>
                </div>
              </div>
            </div>
          </section>
        --}}

        <!-- 輪播 -->
        <div class="slider mt-0 d-lg-block d-none">
          @foreach($productImg as $img)
              <div class="item d-flex justify-content-center">
                <a href="{{$img['img_desc']}}" target="_blank">
                  <img src="/upload/product/{{$img['prod_id']}}/{{$img['prod_img_name']}}" alt="{{$img['prod_name']}}" class="w-100">
                </a>
              </div>
            @endforeach
        </div>
        <div class="slider mt-0 d-lg-none d-block">
          @foreach($productImg as $img)
            <div class="item d-flex justify-content-center">
              <a href="{{$img['img_desc']}}" target="_blank">
                <img src="/upload/product/{{$img['prod_id']}}/{{$img['prod_img_name2']}}" alt="{{$img['prod_name']}}" class="w-100">
              </a>
            </div>
          @endforeach
        </div>

        <div class="container w1400">
          @if($product['productDescribe'][0]['prod_describe']=="否")
          @else
            @if($product['productDescribe'][1]['prod_describe']=="是")
              {!! $productDescribe !!}
              @include('client.online_page_form')
            @endif
          @endif
        </div>
      
        <div class="">
          {!! $contents !!}
        </div>
        @if(count($case)>0)
          <section class="bg-darkgray py-60" id="block_case">
            <div class="container case-area d-flex flex-column">
              <h2 class="position-relative d-flex justify-content-center">
                <span class="text-white fs-25 p-3">成功案例</span>
              </h2>
              <div class="case-carousel mb-4 fs-18 ">
                @foreach($case as $item)
                  <a class="swiper-slide" href="/case-info/{{$item['prod_id']}}">
                    <div class="item d-flex align-items-center pb-1">
                        <span class="date text-white">{{date('Y/m/d', strtotime($item['prod_s_datetime']))}}</span>
                        <h3 class="title fs-18 mb-0 text-truncate">{{$item['prod_name']}}</h3>
                        <h4 class="subtitle text-white fs-18 mb-0 text-truncate">
                          {{$item['prod_subtitle']}}
                        </h4>
                        <div class="text text-white mb-0 text-truncate">{!!$item['product_describe']['2']['prod_describe']!!}</div>
                    </div>
                  </a>
                @endforeach
              </div>
            </div>
          </section>
        @endif
        @if(count($faq)>0)
          <section class="bg-lightgray py-60" id="block_faq">
            <div class="container faq-area d-flex flex-column">
              <h2 class="position-relative d-flex justify-content-center">
                <span class="fs-25 p-3">FAQ</span>
              </h2>
              <div id="accordion" class="mb-4">
                @foreach($faq as $q =>$item)
                  <div class="card rounded-0 mb-3">
                    <div class="card-header bg-white" id="Q{{$q+1}}">
                      <h2 class="mb-0 fs-16">
                        <a
                          class="question-title w-100"
                          type="button"
                          data-toggle="collapse"
                          href="#A{{$q+1}}"
                          aria-expanded="true"
                          aria-controls="A{{$q+1}}"
                          >
                          Q{{$q+1}}. {{$item['prod_name']}}
                        </a>
                      </h2>
                    </div>
                    <div id="A{{$q+1}}" class="collapse" aria-labelledby="Q{{$q+1}}" data-parent="#accordion">
                      <div class="card-body">
                        {!!$item['product_describe'][2]['prod_describe']!!}
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
              <!-- <a href="/faq" class="faq-know-more px-4 py-2 mx-auto position-relative">了解更多</a> -->
            </div>
          </section>
        @endif

        <div class="container w1400">
          @if($product['productDescribe'][0]['prod_describe']=="否")
          @else
            @if($product['productDescribe'][1]['prod_describe']!="是")
              {!! $productDescribe !!}
              @include('client.online_page_form')
            @endif
          @endif
        </div>
      </div>

      @include('client.layouts.footer')
    </div>

    <!-- 跳出視窗：問卷結果 -->
    <span id="qaBtn" class="d-none" data-toggle="modal" data-target="#qa">問卷結果按鈕</span>
    <div class="modal fade smallMOdel" id="qa" tabindex="-1" role="dialog" aria-labelledby="qaTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; right: 1rem; top: 1rem;">
            <span aria-hidden="true">&times;</span>
          </button>
          <div class="modal-header">
            <h5 class="modal-title" id="qaTitle">問卷結果</h5>
          </div>
          <div class="modal-body">
            <div class="container">
              <div class="row">
                <div class="col-12">
                  <p>感謝您使用線上報名功能，我們將會有專人與您聯繫，您填寫的結果如下：</p>
                </div>
              </div>
              <div class="row resault">
              </div>
              <div class="row">
                <div class="offset-3 col-6">
                  <button class="btn btn-success w-100" onclick="print();">列印結果</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    @include('client.layouts.js')

    <script src="/js/vendor/angular/angular-1.4.4/angular.js" type="text/javascript"></script>
    <script>
      var app = angular.module('app',[]);
      app.controller('ContentController',['$http',function($http){
        var self = this;
        self.productId = "{{$productId}}";
          self.model = {};
          self.reset_form = function (){
            self.model.contact = {};
            self.model.contact = {
              online_class: '{{$online_class}}',
              online_type: '{{$online_type}}',
              online_text: '{{$online_text}}',
            };
            self.model.contact.contactTypeId = 2;  
            self.model.contact.langId = "1"; //語言版
          }
          self.reset_form();

          self.qa = [];
          self.get_qa = function () {
            $http({
                method: "get",
                url: "/api/product/getOne/"+self.productId,
            }).success(function (data) {
                self.qa = data.item ? data.productType : [];
                for (var i = 0; i < self.qa.length; i++) {
                  self.qa[i]['prod_sn'] = self.qa[i]['prod_sn'] ? self.qa[i]['prod_sn'].split(',') : [];
                }
              // console.log(self.qa);
            }).error(function () {}) //error
          }
          self.get_qa();

          self.submitContact = function () {
            /*處理問題*/
            var qa = [];
            var result_html = "";
            var questions = $('.question');
            for (var i = 0; i < questions.length; i++) {
              title = $(questions[i]).find('.title span').html();
              question_type = $(questions[i]).attr('question_type');
              input_require = $(questions[i]).find('.input_require');
              
              if(question_type==0){ /*單選*/
                  ans = $('input[name="question_'+i+'"]:checked').val();
                  if(typeof(ans)=='undefined'){
                      ans="";
                  }
              }
              else if(question_type==1){ /*多選*/
                ans = [];
                  ans_checked = $('input[name="question_'+i+'"]:checked');
                  for (var x = 0; x < ans_checked.length; x++) {
                    ans.push( $(ans_checked[x]).val() );
                  }
                  ans = ans.join(',');
              }
              else if(question_type==2){ /*文字*/
                ans = $('input[name="question_'+i+'"]').val();
              }
              else if(question_type==3){ /*檔案*/
                fileName = $('#question_'+i+'_fileName').val();
                fileData = $('#question_'+i+'_fileData').val();
                ans = fileName + "_@_file_@_" + fileData;
              }

              if(input_require.length){/*為必填*/
                if(question_type==3 && ans=="_@_file_@_"){
                  alert("請選擇「" + title + "」");return;
                }else if(ans==""){
                  alert("請填寫「" + title + "」");return;
                }
              }
              qa.push(title+":"+ans);
            }
            // console.log(qa);
            self.model.contact.qa = qa.join(';<br>');

            if(self.model.contact.online_class == "" || self.model.contact.online_class == undefined) {
                alert("未輸入班別");
              }
              else if(self.model.contact.online_type == "" || self.model.contact.online_type == undefined) {
                alert("未輸入梯別");
              }
              // else if(self.model.contact.contaName == "" || self.model.contact.contaName == undefined) {
              //   alert("請填寫姓名");
              // }
              // else if (self.model.contact.contaPhone == "" || self.model.contact.contaPhone == undefined) {
              //   alert("請填寫電話");
              // }
              else if (!contactVerifyCheck) {
                alert('驗證碼失敗');
              }
              else {
                $('#body_block').show();
                // console.log(self.model.contact); return;
                var post_data = JSON.parse(JSON.stringify(self.model.contact));
                post_data.productId = self.productId;
                $http({
                  method: "post",
                  url: "/api/contact",
                  data: post_data,
                }).success(function(data) {
                  console.log(data)
                  if (data.status == 200) {
                    $('#body_block').hide();

                    if(result_html!=""){
                      $('#qaBtn').click();
                      $('#qa .resault').html(result_html);
                    }else{
                      alert("感謝您使用線上報名功能，您的報名已送出，我們將會有專人與您聯繫");
                      location.reload();
                    }
                    self.reset_form();
                  } else {
                    alert("資料庫無回應");
                    $('#body_block').hide();
                  }
                }).error(function() {
                  $('#body_block').hide();
                }) //error
              }
          }
      }])//app.controller()
      // angular.bootstrap(document.getElementById("app"), ['app']); // html內有多個app時需使用

      function print(){
        win = window.open('', '', config='height=800,width=500');
        var resault_html = $('#qa .resault').html()
        // console.log(resault_html);
        win.document.write("<title>問卷結果-列印</title></<h3>問卷結果：</h3>");  //在新視窗中輸出提示資訊
        win.document.write(resault_html);  //在新視窗中輸出提示資訊
        win.print();
      }
    </script>

    <script src="/frontEndPackage/js/verify.js"></script>
    <script>
      var contactVerifyCheck = true
      $('#formVerification').codeVerify({
        type: 1,
        width: '100%',
        height: '38px',
        fontSize: '30px',
        codeLength: 5,
        btnId: 'check-contact-btn',
        ready: function () {},
        success: function () {
          // alert('驗證成功');
          contactVerifyCheck = true;
        },
        error: function () {
          // alert('驗證失敗');
          contactVerifyCheck = false;
        }
      });

      $('.varify-input-code').addClass('form-control');
      $('.varify-input-code').attr('placeholder', '請輸入右側文字');

      $('.question_file').on('change', function(e){
        var id = $(this).attr('id')
        var file = $(this)[0].files[0];
        if(file){
          var reader = new FileReader();
          reader.onload = (function(theFile){
        var fileName = theFile.name;
        return function(e){
          // console.log(fileName);
          // console.log(e.target.result);
          $('#'+id+'_fileName').val(fileName);
          $('#'+id+'_fileData').val(e.target.result);
        };
      })(file);
      reader.readAsDataURL(file);
        }else{
          $('#'+id+'_fileName').val("");
          $('#'+id+'_fileData').val("");
        }
      });
    </script>
  </body>
</html>