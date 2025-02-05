@extends('layouts.masterAdmin')

<!-- html title -->
@section('htmlTitle') {{$pageTitle}}  @endsection

<!-- 自定義 content -->
@section('content')
	<div class="w-100">
	    <nav aria-label="breadcrumb">
	        <ol class="breadcrumb">
	            <li class="breadcrumb-item" aria-current="page">{{$pageTitle}}</li>
	            <li class="breadcrumb-item active">消費者列表</li>
	        </ol>
	    </nav>
	</div>
	<div class="container-fluid" style="padding: 0px;">
		<div class="row bg-light no-gutters pageHeader">
			<div class="col-12">
				<div class="d-inline-block mb-2">
					<span>
						<select class="use-form-control pdSpacing" style="width: 100px;" ng-model='contCtrl.selectItem'> 
							<option  value="">搜尋項目</option>
							<!--option  value="id">詢價單號</option-->
							<!--option  value="date">日期</option-->
							<option  value="user_name">姓名</option>
							<option  value="acct">帳號</option>
						</select>
					</span>
					<!--span>@{{contCtrl.seek.selectItem}}</span-->
					<span><input class="use-form-control" style="width: 200px;" ng-model="contCtrl.keyword" type="text" name=""></span>
				</div>
				<div class="d-inline-block mb-2">
					登入狀態：
					<span>
						<select  class="use-form-control" style="width: 100px;"  ng-model='contCtrl.seek.user_status'> 
							<option  value="">全部</option>
							<!--option  value="id">詢價單號</option-->
							<option  value="1">啟用</option>
							<option  value="0">停用</option>
							<option  value="2">黑名單</option>
						</select>
					</span>
				</div>
				<div class="d-inline-block mb-2">
					註冊狀態：
					<span>
						<select class="use-form-control" style="width: 100px;"  ng-model='contCtrl.seek.complete_reg'> 
							<option  value="">全部</option>
							<option  value="1">完成</option>
							<option  value="0">未完成</option>
						</select>
					</span>
					<span><a href="" ng-click="contCtrl.search()">搜尋</a> | <a href="" ng-click="contCtrl.clrSearch()">清除搜尋</a> </span>
				</div>
			</div>
			<div class="float-lg-left admin-receivingMailBox">
                <!-- <span class="ng-scope mailActive"> 
                    <a href="@{{contCtrl.editPage}}0">新增</a>
                </span> -->

                <span class="ng-scope mailActive bg-success"> 
                    <a href="#" ng-click="contCtrl.export()">匯出搜尋結果</a>
                    <form id="form_export" name="form_export" action="@{{contCtrl.exportPageUrl}}" method="post" class="d-none"></form>
                </span>
            </div>		
		</div>
		<!-- ///////////////////////// -->
	    <div>
	   	    <table class="table table-bordered admin-table-rwd form">
				<thead>
			        <tr class="admin-tr-only-hide">
						<th class="w-20px" scope="col"><input id="selectAll" type="checkbox" ng-model="contCtrl.selAll" ng-click="contCtrl.checkAll()" /></th>
						<th class="w-100px" scope="col">登入狀態</th>
						<th scope="col">帳號</th>
						<th scope="col">姓名</th>
						<th scope="col">信箱</th>
						<th scope="col">註冊狀態</th>
						<th scope="col">市話</th>
						<th scope="col">地址</th>
			        </tr>
				</thead>
				<tbody>
					<tr ng-repeat="item in contCtrl.model.member">
						<td data-th="項目"><input type="checkbox" ng-model="item.selected"/></td>
						<td data-th="登入狀態">@{{contCtrl.memberStatus[item.user_status]}}</td>	
						<td data-th="帳號"><a class="editInfor" href="@{{contCtrl.editPage}}@{{item.id}}">@{{item.acct}}</a></td>
						<td data-th="姓名"><a class="editInfor" href="@{{contCtrl.editPage}}@{{item.id}}">@{{item.user_name}}</a></td>
						<td data-th="信箱">@{{item.email}}</td>
						<td data-th="註冊狀態">@{{contCtrl.completeReg[item.complete_reg]}}</td>
						<td data-th="市話">@{{item.telephone}}</td>
						<td data-th="地址">@{{item.zipcode}}@{{item.city}}@{{item.district}}@{{item.road}}</td>
					</tr>
				</tbody>
		    </table>
		</div>
		<div class="row mb-5 pageHeader">
			<div class="col-lg-6" >
				<div>
					<!--span> <a href="" ng-click='contCtrl.remove()'>垃圾桶</a></span-->
					<a class="disableBtn btn-use" href="javascript:void(0);" ng-click='contCtrl.remove(1,"user_status")'><span>啟用</span></a>
					<a class="enablewBtn btn-use" href="javascript:void(0);" ng-click='contCtrl.remove(0,"user_status")'><span>停用</span></a>
					<a class="deleteBtn btn-use" href="javascript:void(0);" ng-click='contCtrl.remove(2,"user_status")'><span>黑名單</span></a>
				</div>
			</div>
			<div class="col-lg-6">
				<p class="float-lg-right">
					<span>頁數: @{{contCtrl.currentPage}}/@{{contCtrl.totalPage}} (共@{{contCtrl.totalItem}}項)</span>
					<span><a href=""><span ng-click="contCtrl.prevPage(contCtrl.prevPageIndex)"> 上一頁</span></a> /
					<a href=""><span ng-click="contCtrl.nextPage(contCtrl.nextPageIndex)">下一頁</span></a> </span>
				</p>
			</div>
		</div>
	</div>
@endsection

<!-- 自定義 javascript -->
@section('javascript')
    <script type="text/javascript">
        var app = angular.module('app',[]);
        app.controller('ContentController',['$http',function($http){
        	var self = this;self.ngTest = "Angular Test OK"
        	self.currentPage = 1;
        	self.countOfPage = 20;
        	self.memberStatus = ['停用','啟用','黑名單'];
			self.completeReg  = ['未完成','完成'];

			self.seek = {};

			self.selectItem = '';
			self.keyword = '';

        	self.model = {}
			/////////////////////////////////////////////////////////////////////////////////////////////
			/////////////////////////////////////////////////////////////////////////////////////////////
			self.editPage	 		= "/admin/customer/";
			self.getPageUrl 		= "/admin/api/customer/page/get";
			self.exportPageUrl      = "/admin/api/customer/page/export";
			self.sendActiveCodeUrl 	= "/admin/api/customer/sendActiveCode";
			self.updateStatusUrl 	= "/admin/api/customer/updateUserStatus";

			self.export = function(){
                $('#form_export').html("");

                var input = document.createElement("input");
                input.name = 'file_name';
                input.value = '消費者資料';
                form_export.appendChild(input);

                var input = document.createElement("input");
                input.name = self.selectItem;
                input.value = self.keyword;
                form_export.appendChild(input);

                keys = Object.keys(self.seek);
                for (var i = 0; i < keys.length; i++) {
                    var input = document.createElement("input");
                    input.name = keys[i];
                    input.value = self.seek[ keys[i] ];
                    form_export.appendChild(input);
                }
                form_export.submit();
            }

        	self.getPage = function(){
        		post_data = {
        			currentPage 	: self.currentPage,
					countOfPage 	: self.countOfPage,
        		} 
        		post_data[self.selectItem] = self.keyword;
        		keys = Object.keys(self.seek);
        		for (var i = 0; i < keys.length; i++) {
        			post_data[keys[i]] = self.seek[ keys[i] ];
        		}
        		// console.log(post_data);

				$http({
					method 	: "post",
					url 	: self.getPageUrl,
					data 	: post_data
				}).success(function(data){
					// console.log(data)
					self.model.member = data.res;
					// console.log(data.res);
					for(var prop in self.model.member){
						self.model.member[prop]['selected'] = false;
					}//for

					self.totalItem 		= data.totalItem;
					self.totalPage 		= data.totalPage;
					self.totalPage 		= data.totalPage;

					self.pageNavIndex = proj.getNavPageIndex(self.currentPage,self.totalPage);
					
					$('#selectAll').prop('checked', false);

				}).error(function(){
				})//error
			}//self.getPageOrder
			self.getPage();

			self.prevPage = function(){
				self.currentPage = self.pageNavIndex.prevIndex;
				self.getPage()
			}
			self.nextPage = function(){
				self.currentPage = self.pageNavIndex.nextIndex;
				self.getPage()
			}

			self.checkAll = function(){
				for(var prop in self.model.member){
					self.model.member[prop]['selected'] = self.selAll;
				}
			}//self.checkAll

			self.clrSearch = function(){
				self.seek = {};
				self.selectItem = '';
				self.keyword = '';
				self.currentPage = 1;
				self.getPage();
			}

			self.ShowSatausChange = function(item,status_column){
				change_status = item.show_status== 1 ? 0 : 1

				$http({
					method : "post",
					url : self.updateStatusUrl,  //
					data 	: {	
								member_array 	: [item.id],
								status_column 	: status_column,
								status_value 	: change_status
							  }
				}).success(function(data){
					if (data.status == '200'){
						$.toaster({ message : '已更新'});
						setTimeout(function(){
							window.location.reload();
						},1000)
					}else{
						$.toaster({ message : '網路錯誤', priority : 'danger'});
					}
				}).error(function(){
				})//error
			}

			self.search = function(){
				self.currentPage = 1;
				self.getPage();
			}

			self.remove = function(x,status){
				var member_array=[];
				for(var prop in self.model.member){
						if(self.model.member[prop]['selected'] == true ){
							member_array.push(self.model.member[prop].id);
						}
				}

				$http({
					method : "post",
					url : self.updateStatusUrl,  //
					data 	: {	
								member_array 	: member_array,
								status_column 	: status,
								status_value : x
							  }
				}).success(function(data){
					if (data.status == '200'){
						$.toaster({ message : '已更新'});
						self.getPage();
					}else{
						$.toaster({ message : '網路錯誤', priority : 'danger'});
					}
				}).error(function(){
				})//error

				console.log(status);
			}
        }])//app.controller()
    </script>
@endsection