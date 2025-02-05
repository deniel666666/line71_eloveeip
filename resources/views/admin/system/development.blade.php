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
    	<div class="row">
    		<div class="col-md-12">
    			<div class="row">
    				<div class="col-md-6">
    					<div class="form-group">
    						<label for="client_title">客戶名稱</label>
    						<input type="text" class="form-control" id="client_title" placeholder="" ng-model="contCtrl.model.client_title">
    					</div>
    				</div>
    				<div class="col-md-6">
    					<span>客戶logo</span>
    					<div>
    						<input type="file" ng-file-select="onFileSelect($files)" ng-model="contCtrl.model.client_logo">
    						<img width='100' ng-src="@{{contCtrl.model.client_logo}}" />
    					</div>
                        <span class="herinneren-use">建議尺寸：480x90px</span>
    				</div>
    			</div>
    		</div>
    	</div>

        @if ($admin_user['id']==1)
    	<hr>
    	<div class="row mb-5">
    		<div class="col-md-12">
    			<div class="row">
    				<div class="col-md-6">
    					<div class="form-group">
    						<label for="dev_team">系統開發</label>
    						<input type="text" class="form-control" id="dev_team" placeholder="" ng-model="contCtrl.model.dev_team">
    					</div>
    				</div>
    				<div class="col-md-6">
    					<div class="form-group">	
    						<span>系統開發logo</span>
    						<div>
    							<input type="file" ng-file-select="onFileSelect($files)" ng-model="contCtrl.model.dev_team_img">
    							<img width='100' ng-src="@{{contCtrl.model.dev_team_img}}" />
    						</div>
    					</div>
    				</div>
    			</div>
    		</div>
    		<div class="col-md-12">
    			<div class="row">
    				<div class="col-md-6">
    					<div class="form-group">
    						<label for="marketing">網路行銷</label>
    						<input type="text" class="form-control" id="marketing" placeholder="" ng-model="contCtrl.model.marketing">
    					</div>
    				</div>
    				<div class="col-md-6">
    					<div class="form-group">
    						<span>網路行銷logo</span>
    						<div>
    							<input type="file" ng-file-select="onFileSelect($files)" ng-model="contCtrl.model.marketing_img">
    							<img width='100' ng-src="@{{contCtrl.model.marketing_img}}" />
    						</div>
    					</div>
    				</div>
    			</div>
    		</div>
    		<div class="col-md-6">
                <div class="form-group">
                    <label for="com_url">網址</label>
                    <input type="text" class="form-control" id="com_url" placeholder="" ng-model="contCtrl.model.com_url">
                </div>
            </div>
    		<div class="col-md-6">
    			<div class="form-group">
    				<label for="com_phone">連絡電話</label>
    				<input type="text" class="form-control" id="com_phone" placeholder="" ng-model="contCtrl.model.com_phone">
    			</div>
    		</div>
    		<div class="col-md-6">
    			<div class="form-group">
    				<label for="com_email">信箱</label>
    				<input type="text" class="form-control" id="com_email" placeholder="" ng-model="contCtrl.model.com_mail">
    			</div>
    		</div>
    		<div class="col-md-6">
    			<div class="form-group">
    				<label for="com_address">地址</label>
    				<input type="text" class="form-control" id="com_address" placeholder="" ng-model="contCtrl.model.com_address">
    			</div>
    		</div>
    	</div>
        @endif

        <div class="col-12 mt-3">
            <button  class="btn btn-success btn-block" ng-click="contCtrl.submitAccount()">確認送出</button>
        </div>
    </div>
@endsection

<!-- 自定義 javascript -->
@section('javascript')
    <script type="text/javascript">
        var app = angular.module('app', []);
        app.controller('ContentController', ['$http', function($http) {
            var self = this;
            self.getItem = function() {
                $http({
                    method: "get",
                    url: "/admin/development/team/show",
                }).success(function(data) {
					// console.log(data)
                    if(data.status == '200'){
                        self.model = data.item;
                    }else {
                        alert('資料庫無回應');
                    }
                }).error(function() {
                    alert('網路錯誤');
                }) //error
            }
            self.getItem();

            self.update = function() {
                $http({
                    method: "post",
                    url: "/admin/development/team/save",
                    data:{
						'item':self.model
					},
                }).success(function(data) {
					// console.log(data)
                    if (data.status == '200') {
                        alert('修改成功');
                        self.getItem();
                    } else {
                        alert(data.msg);
                    }
                }).error(function() {
                }) //error
            }

            self.submitAccount = function() {
                self.update();
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







