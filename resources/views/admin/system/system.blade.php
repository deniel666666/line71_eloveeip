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
		<div class="col-md-6">
			<div class="form-group">
				<label for="sys_title">系統名稱</label>
				<input type="text" class="form-control" id="sys_title" placeholder="" ng-model="contCtrl.model.system_title">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="sys_version">系統版本</label>
				<input type="text" class="form-control" id="sys_version" placeholder="" ng-model="contCtrl.model.system_version">
			</div>
		</div>

		<div class="col-md-12">
			<div class="form-group">
				<label for="sys_note">系統備註</label>
				<textarea class="form-control" id="sys_note" rows="3" placeholder="" ng-model="contCtrl.model.system_note"></textarea>
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<label for="sys_front_end">前台開發程式</label>
				<textarea class="form-control" id="sys_front_end" rows="3" placeholder="" ng-model="contCtrl.model.front_end"></textarea>
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<label for="sys_back_end">後台開發程式</label>
				<textarea class="form-control" id="sys_back_end" rows="3" placeholder="" ng-model="contCtrl.model.back_end"></textarea>
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<label for="php_v">php版本</label>
				<input type="text" class="form-control" id="php_v" placeholder="" ng-model="contCtrl.model.php_version">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="sql_v">sql版本</label>
				<input type="text" class="form-control" id="sql_v" placeholder="" ng-model="contCtrl.model.sql_version">
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label for="time">結案時間</label>
				<input type="text" class="form-control" id="time" placeholder="" ng-model="contCtrl.model.closing_date">
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label for="s_note">備註</label>
				<textarea class="form-control" id="s_note" rows="3" placeholder="" ng-model="contCtrl.model.note"></textarea>
			</div>
		</div>
		
		<div class="col-12 mt-3">
			<button  class="btn btn-success btn-block" ng-click="contCtrl.submitAccount()">確認送出</button>
		</div>
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
                    url: "/admin/system/intro/show",
                }).success(function(data) {
                    console.log(data);
                    if (data.status == '200') {
                        self.model = data.item;
                    } else {
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
                    url: "/admin/system/intro/save",
                    data:{
						'item':self.model
					},
                }).success(function(data) {
					console.log(data)
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



