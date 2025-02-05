@extends('layouts.masterAdmin')

<!-- html title -->
@section('htmlTitle') {{$pageTitle}}  @endsection

<!-- 自定義 content -->
@section('content')

<div class="container-fluid">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">語系設定</li>
			<li class="breadcrumb-item active">{{$pageTitle}}</li>
		</ol>
	</nav>
	<div class="bg-light">
		<div class="col-12" style="overflow:auto;">
	        <div style="float:left;">
				<input type='text' ng-model='contCtrl.searchText' />
				<span> <a href="" ng-click='contCtrl.search()'>搜尋</a></span>
				<span> |</span>
				<span> <a href="" ng-click='contCtrl.clearSearch()'>清除搜尋</a></span>
	        </div>
	        <div  id="lang_select" style="float:right;" >
				<a href="" data-toggle="modal" data-target="#itemAdd">新增</a>
				<select 
	                ng-model='contCtrl.selectLangItem'
	                ng-change="contCtrl.changedListLang()" 
	                ng-options="option.lang_id as option.lang_word for option in contCtrl.langs">
	                <option ng-selected="true" value="">全部</option>
	            </select>
				<span> 共@{{contCtrl.contactCount}}項</span>
				<span> <input type='text' ng-model="contCtrl.currentPage"  style='width:30px;' readonly>/@{{contCtrl.pageCount}}</span>
				<span> <a href="" ng-click='contCtrl.prePage()'>上一頁</a></span>
				<span> <a href="" ng-click='contCtrl.nextPage()'>下一頁</a></span>
	        </div>
		</div>
		<div class="col-12" style="overflow:auto;">
        	<div style="float:left;">
				<div style="float:left;" ng-if="contCtrl.contactStatus == 3">
					<span> <a href="" ng-click='contCtrl.remove(true)'>刪除</a></span>
				</div>
        	</div>
		</div>
	</div>
	<div>
		<table class="table">
			<thead>
				<tr>
					<th scope="col">id</th>
					<th scope="col">語系</th>
					<th scope="col">內容</th>
					<th scope="col">對應碼</th>
					<th scope="col">色碼</th>
					<th scope="col">順序</th>
					<th scope="col">動作</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="item in contCtrl.items">
					@{{item}}
					<td>@{{item.menu_lang_id }}</td>
					<td>@{{item.lang.lang_word}}</td>
					<td><a href="" data-toggle="modal" data-target="#itemEdit" ng-click='contCtrl.edit(item)'>@{{item.menu_name}}</a></td>
					<td>@{{item.menu_code}}</td>
					<td>@{{item.menu_color}}</td>
					<td>@{{item.menu_lang_order}}</td>
					<td  ng-if="$index%contCtrl.langCount == 0 && contCtrl.selectLangItem == 0" rowspan="@{{contCtrl.langCount}}"> <button class='btn btn-danger' ng-click='contCtrl.removeItem(item.menu_code)'>刪除</button></td>
					<td  ng-if=" contCtrl.selectLangItem != 0" > <button class='btn btn-danger' ng-click='contCtrl.removeItem(item.menu_code)'>刪除</button></td>
				</tr>
			</tbody>
		</table>
		<div class="col-12" style="overflow:auto;">
        <div style="float:right;">
          <span> 共@{{contCtrl.itemsCount}}項</span>
          <span> <input type='text' ng-model="contCtrl.currentPage"  style='width:30px;' readonly>/@{{contCtrl.pageCount}}</span>
          <span> <a href="" ng-click='contCtrl.prePage()'>上一頁</a></span>
          <span> <a href="" ng-click='contCtrl.nextPage()'>下一頁</a></span>
        </div>
		</div>
		<!--Add Modal -->
		<div id="itemAdd" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">新增項目</h4>
					</div>
					<div class="modal-body">
						<table class="table">
							<tr ng-repeat="item in contCtrl.lang">
				                <td>@{{item.lang_word}}</td>
				                <td><input type='text' ng-model="contCtrl.addMenuLangItem.lang[item.lang_id]" placeholder="請填入語系內容"></td>
              				</tr>
							<tr >
								<td>順序</td>
								<td><input type='text' ng-model="contCtrl.addMenuLangItem.order" placeholder="請填入順序"></td>
							</tr>
              				<tr >
								<td>色碼</td>
								<td><input type='text' ng-model="contCtrl.addMenuLangItem.color" placeholder="請填入色碼"></td>
							</tr>
						</table>
					</div>
					<div class="modal-footer">
            			<button type="button" class="btn btn-default"  data-dismiss="modal" ng-click='contCtrl.addMenuLang()'>新增</button>
						<button type="button" class="btn btn-default" data-dismiss="modal" ng-click='contCtrl.getAllLang()'>關閉</button>
					</div>
				</div>
			</div>
		</div>
		<!--Edir Modal -->
		<div id="itemEdit" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">修改項目</h4>
					</div>
					<div class="modal-body">
						<table class="table">
							<tr >
								<td>語系</td>
								<td>@{{contCtrl.editItem.lang.lang_word}}</td>
							</tr>
							<tr >
							<td>對應碼</td>
								<td>@{{contCtrl.editItem.menu_code}}</td>
							</tr>
             				<tr >
								<td>內容</td>
								<td><input type='text' ng-model="contCtrl.editItem.menu_name" placeholder="請填入語系內容"></td>
							</tr>
							<tr >
								<td>順序</td>
								<td><input type='text' ng-model="contCtrl.editItem.menu_lang_order" placeholder="請填入順序"></td>
							</tr>
              				<tr >
								<td>色碼</td>
								<td><input type='text' ng-model="contCtrl.editItem.menu_color" placeholder="請填入色碼"></td>
							</tr>
						</table>
					</div>
					<div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"  ng-click='contCtrl.saveItem()'>儲存</button>
						<button type="button" class="btn btn-default" data-dismiss="modal" ng-click='contCtrl.getAllLang()'>關閉</button>
					</div>
				</div>
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
			
			self.currentPage = 1;
			self.countLangOfPage = 10;
			self.searchText = '';

			self.selectedAll = false;
			self.addMenuLangItem = {};
			self.editItem = {};
			self.selectLangItem = get_record_lang();

			self.clearSearch = function(){
				self.currentPage = 1;
				self.selectedAll = false;
				self.searchText = '';
				self.selectSearchItem = 0;
				self.getAllLang();
					self.selectLangItem= 0;
			}

			self.changedListLang = function(){
					if(self.selectLangItem === null){
							self.selectLangItem = 0;
					}
					self.getAllLang();
			}
		
			self.prePage = function(){
				if(self.currentPage > 1){
					self.currentPage --;
					self.selectedAll = false;
					self.getAllLang();
				}
			}

			self.nextPage = function(){
				if(self.currentPage < self.pageCount){
					self.currentPage ++;
					self.selectedAll = false;
					self.getAllLang();
				}
			}
			self.search = function(){
				self.getAllLang();
			}
			self.edit = function(item){
				self.editItem = item;
			};
			self.saveItem = function(){
				let url  =  "/admin/api/menu/lang/edit";
				let data = {
					'menu_name': self.editItem.menu_name,
					'menu_color':self.editItem.menu_color,
					'menu_lang_order':self.editItem.menu_lang_order,
					'menu_code' :self.editItem.menu_code,
					'menu_lang_id' :self.editItem.menu_lang_id
				};
				$http({
					method : "put",
					url : url,
					data : data
				}).success(function(data){
						console.log(data);
					if (data.status=='200'){
							self.getAllLang();
					}else{
						alert('資料庫無回應');
					}
				}).error(function(){
				})//error
			};

			self.addMenuLang = function(){
		    	var isEmpty = 1;
				$.each(self.lang, function(index, value) {
					var r = value.lang_id;
					var getString = self.addMenuLangItem.lang[r];
					if(getString === undefined || getString.length === 0 ){
						isEmpty = 0;
					}
		        }); 
		        if(isEmpty === 0){
		            alert('請填入語系對應內容');
		            return false;
		        }
		        if(self.addMenuLangItem.order === undefined || self.addMenuLangItem.order.length === 0 ){
		            alert('請填入順序');
		            return false;
		        }
				let url  =  "/admin/api/menu/lang/add";
				let data = {'menuLang': self.addMenuLangItem.lang,'color':self.addMenuLangItem.color,'order':self.addMenuLangItem.order};
				console.log(data);
				$http({
					method : "post",
					url : url,
					data : data
					}).success(function(data){
							console.log(data);
						if (data.status=='200'){
							self.getAllLang();
						}else{
							alert('資料庫無回應');
						}
					}).error(function(){
				})//error
			}
			self.getAllLang = function(){
				let url  =  "/admin/api/menu/lang/show";
				let data = {
					'selectLangItem': self.selectLangItem,
					'searchByText': self.searchText,
					'currentPage': self.currentPage,
					'countLangOfPage': self.countLangOfPage,
				};
				$http({
					method : "post",
					url : url,
					data:data
				}).success(function(data){
					console.log(data);
					self.items = data.items;
					self.itemCount = data.itemsCount;
					self.pageCount= data.pageCount;
					self.lang = data.lang;
					self.langCount = data.lang.length;
					self.langs = data.langs;
				}).error(function(){
				})//error
			}	
			self.getAllLang();

			self.removeItem = function(code){
				let text = "確定刪除此語系？";
				if (confirm(text)) {
						let data = {'code': code};
						let url  =  "/admin/api/menu/lang/delete";
						$http({
							method : "put",
							url : url,
							data: data,
						}).success(function(data){
							if (data.status=='200'){
								self.getAllLang();
							}else{
								alert('資料庫無回應');
							}
						}).error(function(){
						})	//error
				}
			}
		}])
    </script>
	<style>
		.active1 { 
			border: solid 1px red; 
		}
	</style>
@endsection



