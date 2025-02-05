@extends('layouts.masterAdmin')

<!-- html title -->
@section('htmlTitle') {{$pageTitle}}  @endsection

<!-- 自定義 content -->
@section('content')

<link rel="stylesheet" href="{{asset('/css/jqueryui/jquery-ui.min.css')}}">
<script src="{{asset('/js/vendor/jqueryui/jquery-ui.min.js')}}"></script>



<div class="w-100 mb-4">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">系統管理</li>
			<li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
		</ol>
	</nav>
</div>

<div class="container-fluid">
	<!-- <div class="mb-3">
		<select id="lang_select" class="use-form-control maxWidth pdSpacing" ng-model='contCtrl.selectLangItem' ng-change="contCtrl.changedListLang()" ng-options="option.lang_id as option.lang_word for option in contCtrl.langs">
		</select>
	</div> -->

	<!-- 網頁基本設定 -->
	<div class="mb-3">
		<div class=""><span>網頁進階SEO設定</span></div>
	</div>
	<!-- 其他設定 -->

	<div class="form-group">
		<div class="row">
			<div class="col-12" style="margin-bottom: 1.5rem;">
				Google驗證 :  <textarea style="height: 100px; width: 100%;" ng-model="contCtrl.model.google_verify" placeholder="<script>去googel取得</script>"></textarea>
			</div>
			<div class="col-12"  style="margin-bottom: 1.5rem;">
				Google分析追蹤碼 :  <textarea style="height: 100px; width: 100%;" ng-model="contCtrl.model.google_analysis_code" placeholder="<script>去googel取得</script>"></textarea>
			</div>		
			<div class="col-12"  style="margin-bottom: 1.5rem;">
				Google再行銷碼 : <textarea style="height: 100px; width: 100%;" ng-model="contCtrl.model.google_sales_code" placeholder="<script>去googel取得</script>"></textarea>
			</div>	
			<div class="col-12"  style="margin-bottom: 1.5rem;">
				Yahoo再行銷碼 : <textarea style="height: 100px; width: 100%;" ng-model="contCtrl.model.yahoo_sales_code" placeholder="<script>去yahoo取得</script>"></textarea>
			</div>
			<div class="col-12"  style="margin-bottom: 1.5rem;">
				隱藏描述詞 : <textarea style="height: 120px; width: 100%;" ng-model="contCtrl.model.hiden_description" placeholder="提醒您記得來修改喔!!這裡的文字是給搜索引擎看的喔!約二百字佳"></textarea>
			</div>
<!--
			<div class="col-12"  style="margin-bottom: 1.5rem;">
				Robots : <input type="text" ng-model="contCtrl.model.robots"  class="form-control input-sm">
			</div>
			<div class="col-12"  style="margin-bottom: 1.5rem;">
				Map:
				<p>(圖片預覽)            
					<input type="file" ng-file-select="onFileSelect($files)" ng-model="contCtrl.model.map_img">
					<img width=220 ng-src="@{{contCtrl.model.map_img}}" />
				</p>
			</div>	
-->	
		</div>
	</div>
	<div class="row" style="margin-bottom: 3rem;">
		<div class="col-12">
			<button  class="btn btn-success btn-block" ng-click="contCtrl.submitAccount()">確認送出</button>
		</div>
	</div>
</div>

@endsection



<!-- 自定義 javascript -->
@section('javascript')

    <script type="text/javascript">

    </script>

    <script type="text/javascript">

      var app = angular.module('app',[]);

      app.controller('ContentController',['$http',function($http){

				var self = this;
				self.selectLangItem = get_record_lang();
				self.getItem = function(){
					var data = {'langId':self.selectLangItem};
					console.log(data);
					$http({
						method : "post",
						url : "/admin/api/seo",
						data:data
					}).success(function(data){
						console.log(data);
						if (data.status=='200'){
							self.model = data.item;
							self.langs = data.langs;
						}else{
							alert('資料庫無回應');
						}
					}).error(function(){
						alert('網路錯誤');
					})//error
				}

			self.getItem();

			self.changedListLang = function(){
				
              if(self.selectLangItem === null){
                  self.selectLangItem = 0;
              }
              self.getItem();
          }

			self.update = function(){
				//console.log(self.model);
				$http({
					method : "put",
					url : "/admin/api/seo",
					data: self.model,
				}).success(function(data){
					if (data.status=='200'){
						alert('修改成功');
						self.getItem();
					}else{
						// alert('資料庫無回應');
					}
				}).error(function(){

				})//error
			}

			self.submitCheck = function(){
				// console.log(self.model);
				// if ((!self.model.acct)||(self.model.acct=='')){
				// 	self.foolproof = false;
				// 	alert('請填帳號');
				// }

				// if ((!self.model.user_name)||(self.model.user_name=='')){
				// 	self.foolproof = false;
				// 	alert('請填姓名');
				// }

				// if ((self.model.id==1)&&(self.model.user_status=='0')){
				// 	self.foolproof = false;
				// 	alert('管理者無法停用');
				// }
			}
			self.submitAccount = function(){
				self.update();
				// self.foolproof = true;
				// self.submitCheck();
				// if (self.foolproof){
				// 	self.updAccount();
				// }
			}
				
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
        });
    </script>
@endsection



