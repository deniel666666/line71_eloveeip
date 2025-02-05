@extends('layouts.masterAdmin')

<!-- html title -->
@section('htmlTitle') {{$pageTitle}}  @endsection

<!-- 自定義 content -->
@section('content')

<div>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">語系設定</li>
			<li class="breadcrumb-item active">{{$pageTitle}}</li>
		</ol>
	</nav>
	<div class="container-fluid no-gutters">
		<div class="form-group">
			<div class="row">
					<label class="col" ng-repeat="r in contCtrl.selectedItems.lang">
						<input type="checkbox" ng-model="r.lang_status" ng-true-value="1" ng-false-value="0" ng-click="contCtrl.clickCheck(r)" >@{{r.lang_word}}<br />
					</label>
			</div>
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
				self.selectedItems ={};
				self.clickCheck = function(item){
				  $http({
				    method : "put",
				    url : "/admin/api/lang",
				    data: item,
				  }).success(function(data){
				    if (data.status=='200'){
				      // window.location = "/admin/lang";
				    }else{
				       alert('更新狀態失敗');
				    }
				  }).error(function(){

				  })//error
				};

				self.getLang = function(){
					$http({
						method : "get",
						url : "/admin/api/lang",
					}).success(function(data){
						if (data.status=='200'){
							angular.forEach(data.langs, function(item){
									item.lang_status  = Number(item.lang_status);
							});
              self.selectedItems['lang'] =  data.langs;
							 
						}else{
							alert('資料庫無回應');
						}
					}).error(function(){
						alert('網路錯誤');
					})//error
				}

			self.getLang();
			}]);
    </script>
@endsection



