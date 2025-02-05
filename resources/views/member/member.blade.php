@extends('member.layouts.layoutExtends')

<!-- html title -->
@section('htmlTitle') 店家專區  @endsection

@section('javascript_header')@endsection
@section('css_header')@endsection


@section('content')
    <div class="col-12  memberInforBox">
        <div class="row">
            <!-- 店家資料修改 -->
            <div class="col-12 titleBox">
                <span>店家資料修改</span>
            </div>
            <!-- /////////////////////////////////////// -->
            <div class="col-12 row form-row blockBorder">
                <!-- 主圖 -->
                <div class="col-3">
                    <label for="pic" class="slider" style="">
                        主圖:
                        <img ng-src="@{{contCtrl.model.user.pic}}" class="preview w-100"  alt="">
                    </label>
                    <input type="file" ng-file-select="onFileSelect($files)"  ng-model="contCtrl.model.user.pic"><!--style="display:none;width:0;"-->
                </div>

                <!-- logo圖 -->
                <div class="col-6">
                    <label for="logo" class="slider" style="">
                        logo圖:
                        <img ng-src="@{{contCtrl.model.user.logo}}" class="preview w-100"  alt="">
                    </label>
                    <input type="file" ng-file-select="onFileSelect($files)"  ng-model="contCtrl.model.user.logo"><!--style="display:none;width:0;"-->
                </div>

                <!-- 店家帳號 -->
                <div class="col-6">
                    <label for="number">店家帳號</label>
                    <input type="text" ng-model="contCtrl.model.user.account" readonly="readonly" class="form-control" placeholder="" autocomplete="off">
                </div>
                <!-- 您的姓名 -->
                <div class="col-6">
                    <label for="name">店家名稱</label>
                    <input type="text" ng-model="contCtrl.model.user.user_name" class="form-control" placeholder="" autocomplete="off">
                </div>
                <!-- 修改密碼 -->
                <div class="col-6">
                    <label for="modifyPassword">修改密碼</label>
                    <input type="password" ng-model="contCtrl.model.user.user_pw" class="form-control" placeholder="若不修改密碼，請勿填寫" autocomplete="off">
                </div>
                <!-- 再次確認密碼 -->
                <div class="col-6">
                    <label for="againModifyPassword">再次確認修改密碼</label>
                    <input type="password"  ng-model="contCtrl.model.user.passwordConfirm"
                    	   class="form-control" autocomplete="off">
                </div>
                <!-- 市話 -->
                <div class="col-6">
                    <label for="orderHomeCall">修改連絡電話</label>
                    <input type="text" ng-model="contCtrl.model.user.telephone" class="form-control" placeholder="" autocomplete="off">
                </div>
                <!-- 手機 -->
                <div class="col-6">
                    <label for="phoneNumber">修改行動電話</label>
                    <input type="text" ng-model="contCtrl.model.user.cellphone" class="form-control" placeholder="" autocomplete="off">
                </div>

                <!-- 連絡地址 -->
                <div class="col-6 sendAddressBox clearfix">
                    <h4>連絡地址</h4>
                    <div class="">
                		<div id="twzipcode" class="d-flex"></div>
            		</div>
                    <input type="text" ng-model="contCtrl.model.user.road" placeholder="請填路名" class="form-control customQuantitySelect" name="address" placeholder="">
                </div>
                
                <!-- 統一編號 -->
                <div class="col-6" ng-if="contCtrl.model.user.user_type == 0">
                    <label for="taxID">統一編號</label>
                    <input type="text" ng-model="contCtrl.model.user.id_code" class="form-control"  placeholder="" autocomplete="off">
                </div>

                <!-- 網址 -->
                <div class="col-6">
                    <label>網址</label>
                    <input type="text" ng-model="contCtrl.model.user.userInfo.web" class="form-control"  placeholder="站外連結請包含 http:// 或 https://，站內連結建議使用相對路徑" autocomplete="off">
                </div>

                <!-- 服務類型 -->
                <div class="col-6">
                    <label for="taxID">服務類型</label>
                    <input type="text" ng-model="contCtrl.model.user.service_type" class="form-control"  placeholder="" autocomplete="off">
                </div>

                <!-- 公休日 -->
                <div class="col-6">
                    <label>公休日</label>
                    <textarea ng-model="contCtrl.model.user.userInfo.resttime" class="form-control"></textarea>
                </div>

                <!-- 營業時間 -->
                <div class="col-6">
                    <label>營業時間</label>
                    <textarea ng-model="contCtrl.model.user.userInfo.wroktime" class="form-control"></textarea>
                </div>
            </div>

            <hr>

            <!-- 環境照 -->       
            <div class="row col-12">
                <label>環境照</label>
                <button ng-click="contCtrl.addSlider()" class="btn submitBtn" >新增環境照</button>

                    <div class="row col-12">
                        <div class="col-lg-3 col-6 mb-5" ng-repeat="item in contCtrl.model.user.sub_pics">
                            <div class="h-100 d-flex justify-content-between align-items-center row">
                                <div class="col-12">
                                    <img ng-src="@{{contCtrl.model.user.sub_pics[$index]}}" class="preview w-100"  alt="">
                                </div>
                                <div class="d-flex">
                                    <input ng-file-select="onFileSelect($files)" ng-model="contCtrl.model.user.sub_pics[$index]" type="file" class="mb-0">
                                    <button type="button" class="btn btn-dark" ng-click="contCtrl.delSlider($index)">刪除</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 送出 -->       
            <div class="row justify-content-center col-12">
                <button ng-click="contCtrl.updateUser()" class="btn btn-success submitBtn" >確認送出</button>
            </div>

            
        </div>
    </div>
@endsection


@section('content2')@endsection


@section('javascript')
    <script type="text/javascript">
        $('#twzipcode').twzipcode({
            'readonly': true
        });
    </script>
    <script type="text/javascript">
        var app = angular.module('app',[]);
        app.controller('ContentController',['$http',function($http){
            var self = this;
            self.model = {};

            self.getRegister = function(){
                $http({
                    method  : "get",
                    url     : "/member/api/register",
                }).success(function(data){
                    self.model.user = data;
                    console.log(data);
                    $('#twzipcode').twzipcode('set', {
                        'county'  : data.city,
                        'district': data.district,
                    });
                    self.unique_sub_img_id = self.model.user.sub_pics.length;
                }).error(function(){

                })//error
            }//self.getRegister
            self.getRegister();

            self.addSlider = function(){
                self.unique_sub_img_id = self.unique_sub_img_id+1;
                self.model.user.sub_pics.push(self.unique_sub_img_id);
            }

            self.delSlider = function(index){
                self.model.user.sub_pics.splice(index, 1);
            }
            self.updateUser = function(){
                var foolproof = true;
                var county,district,zipcode;

                $('#twzipcode').twzipcode('get', function (county, district, zipcode) {
                    self.model.user.city        = county;
                    self.model.user.district    = district;
                    self.model.user.zipcode     = zipcode;
                });
                // console.log(self.model.user.county);

                if (!self.model.user.city){
                    foolproof = false;
                    $.toaster({ message : '請選縣市鄉鎮', priority : 'warning' });
                }

                if ((!self.model.user.road)||(self.model.user.road=='')){
                    foolproof = false;
                    $.toaster({ message : '請填路名', priority : 'warning' });
                }

                if ((self.model.user.user_pw)&&(self.model.user.user_pw != 0)){
                    if (self.model.user.user_pw != self.model.user.passwordConfirm){
                        $.toaster({ message : '修改密碼 與 確認密碼 不合', priority : 'warning' });
                        foolproof = false;
                    }//if
                }//if
                
                console.log(self.model.user);
                if (foolproof){
                    $http({
                        method : "put",
                        url : "/member/api/register",
                        data: self.model.user,
                    }).success(function(data){
                        if (data.status == '200'){
                            $.toaster({ message : '資料已更新'});
                        }else{
                            $.toaster({ message : '網路錯誤', priority : 'danger' });
                        }
                    }).error(function(){

                    })//error
                }
            }//self.updateUser = function()

        

            @include('member.layouts.ng_js')

        }]).directive("ngFileSelect", function(fileReader, $timeout) {
            return {
                scope: {
                    ngModel: '='
                },
                link: function($scope, el) {
                    function getFile(file) {
                        fileReader.readAsDataUrl(file, $scope)
                        .then(function(result) {
                            $timeout(function() {
                                $scope.ngModel = result;
                            });
                        });
                    }
                    el.bind("change", function(e) {
                        var file = (e.srcElement || e.target).files[0];
                        getFile(file);
                    });
                }
            };
        })
        .factory("fileReader", function($q, $log) {
            var onLoad = function(reader, deferred, scope) {
                return function() {
                scope.$apply(function() {
                    deferred.resolve(reader.result);
                });
                };
            };

            var onError = function(reader, deferred, scope) {
                return function() {
                scope.$apply(function() {
                    deferred.reject(reader.result);
                });
                };
            };

            var onProgress = function(reader, scope) {
                return function(event) {
                scope.$broadcast("fileProgress", {
                    total: event.total,
                    loaded: event.loaded
                });
                };
            };

            var getReader = function(deferred, scope) {
                var reader = new FileReader();
                reader.onload = onLoad(reader, deferred, scope);
                reader.onerror = onError(reader, deferred, scope);
                reader.onprogress = onProgress(reader, scope);
                return reader;
            };

            var readAsDataURL = function(file, scope) {
                var deferred = $q.defer();
                var reader = getReader(deferred, scope);
                reader.readAsDataURL(file);
                return deferred.promise;
            };

            return {
                readAsDataUrl: readAsDataURL
            };
        });//app.controller()
    </script>
@endsection