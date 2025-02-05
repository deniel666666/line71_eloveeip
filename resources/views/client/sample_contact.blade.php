<!DOCTYPE html>
<!-- <html lang="zh-TW"> -->
<html lang="zh-Hans-CN">

<head>
    <meta charset="UTF-8">
    @include('client.layouts.seo')

    <link rel="stylesheet" href="/css/verify.css">
    @include('client.layouts.head')
</head>
    <body>
        @include('client.layouts.body_top')

        @include('client.layouts.nav')

        <div id="app" ng-app="app" ng-controller="ContentController as contCtrl">
            <h3>回函表範例</h3>

            <section class="page-content contact-box">
                <div class="container w1400">
                    <div class="contact form row">
                        <div class="form-group col-md-6">
                            <label>聯絡人：<span class="mark">必填</span></label>
                            <input class="form-control " type="text" ng-model="contCtrl.model.contact.contaName">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">信箱：<span class="mark">必填</span></label>
                            <input type="email" class="form-control" aria-describedby="emailHelp" ng-model="contCtrl.model.contact.contaEmail" >
                        </div>

                        <div class="form-group col-md-6">
                            <label class="cont-title">詢問項目<span class="mark">必填</span></label>
                            <select class="form-control downSelect ieSelect"
                                ng-model="contCtrl.model.contact.contaItemId" ng-options="item.id as item.label for item in contCtrl.contactItem" name="select" ng-change="contCtrl.changeSelect()">
                                <option value="">-- 請選擇詢問項目 --</option>
                            </select>
                        </div>

                        <div class="form-group col-md-12 use-form-row">
                            <label for="">洽詢內容：</label>
                            <textarea rows="5" class="form-control" type="text" name="data-message" ng-model="contCtrl.model.contact.contaContent"></textarea>
                        </div>
                    
                        <div class="form-group verificationBox col-md-12">
                            <label class="verificationCode cont-title">
                                <span>驗證碼</span>
                                <span class="remindLabel"><span class="mark">*</span></span>
                            </label>
                            <div id="formVerification"></div>
                        </div>
                        <div class="submitBox">
                            <button id="check_contact_btn" class="btn btn-success" ng-click="contCtrl.submitContact()">確認送出</button>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        @include('client.layouts.footer')
        
        @include('client.layouts.js')
        
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script><!-- 跳出訊息 -->
        
        <script type="text/javascript" src="/js/verify.js"></script><!-- 驗證碼 -->
        <script type="text/javascript">
            var contactVerifyCheck = true;
            $('#formVerification').codeVerify({
                type: 1,
                width: '100%',
                height: '38px',
                fontSize: '30px',
                codeLength: 4,
                btnId: 'check_contact_btn',
                ready: function () { },
                success: function () {
                    contactVerifyCheck = true;
                },
                error: function () {
                    contactVerifyCheck = false;
                }
            });
            $('.varify-input-code').addClass('form-control');
            $('.verify-change-code').html("換一張");
            $('.varify-input-code').attr('placeholder', '請輸入右側文字');
        </script>

        <script src="/js/vendor/angular/angular-1.4.4/angular.js" type="text/javascript"></script>
        <script>
            var app = angular.module('app',[]);
            app.controller('ContentController',['$http',function($http){
                var self = this;
                self.model = {};
                self.model.contact = {};
                self.model.contact.contactTypeId = 1;  
                self.model.contact.langId = "1"; //語言版

                self.contactItem = [];
                self.getContactItem = function () {
                    $http({
                        method: "get",
                        url: "/api/contact/item/" + self.model.contact.contactTypeId + "/" + self.model.contact.langId // api/contact/item/{contactTypeId}/{langId}
                    }).success(function (data) {
                        // console.log(data)
                        self.contactTypeItem = data.contactTypeItem;
                        for (var prop in data.contactTypeItem) {
                            if (self.contactTypeItem[prop]['conta_item_status'] == 1) {
                                self.contactItem.push({
                                    label: self.contactTypeItem[prop]['conta_item_name'],
                                    id: self.contactTypeItem[prop]['conta_item_id']
                                })
                            }
                        }
                    }).error(function () {}) //error
                } //self.login
                self.getContactItem();

                self.submitContact = function () {
                    var foolproof = true;
                    if(self.model.contact.contaName == "" || self.model.contact.contaName == undefined) {
                        Swal.fire('請填寫聯絡人姓名','','warning');
                        return false;
                    }
                    else if (self.model.contact.contaEmail == "" || self.model.contact.contaEmail == undefined) {
                        Swal.fire('請檢查email格式是否正確','','warning');
                        return false;
                    }
                    else if (self.model.contact.contaItemId == "" || self.model.contact.contaItemId == undefined) {
                        Swal.fire('請選擇詢問項目','','warning');
                        return false;
                    }
                    else if (!contactVerifyCheck) {
                        Swal.fire('驗證碼失敗','','warning');
                        foolproof = false;
                    }
                    else {
                        $('#body_block').show();
                        // console.log(self.model.contact);
                        // return;
                        $http({
                            method: "post",
                            url: "/api/contact",
                            data: self.model.contact
                        }).success(function(data) {
                            console.log(data)
                            if (data.status == 200) {
                                Swal.fire(data.message,'','success');
                                setTimeout(function(){ location.reload(); }, 500);
                            } else {
                                Swal.fire('資料庫無回應','','error');
                            }
                        }).error(function() {
                            Swal.fire('執行有誤，請稍後再試','','error');
                            $('#body_block').hide();
                        }) //error
                    }
                }
            }])//app.controller()
            // angular.bootstrap(document.getElementById("app"), ['app']); // html內有多個app時需使用
        </script>
    </body>

</html>