@extends($extends_layouts)

<!-- html title -->
@section('htmlTitle') {{$topTitle}}  @endsection

<!-- 自定義 content -->
@section('content')
	<div class="w-100">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">{{$topTitle}}</li>
				<!-- <li class="breadcrumb-item active" aria-current="page">@{{contCtrl.pageTitle}}</li> -->
				<!-- <li style="margin-left: 64px;">
					數據分析：<a href="https://reurl.cc/k7j2br" target="_blank">https://reurl.cc/k7j2br</a>
				</li> -->
			</ol>
		</nav>
	</div>

	<div class="container-fluid" style="padding: 0px;">
		<div class="row bg-light no-gutters pageHeader">
		    <div class="col-lg-12 clearfix mb-2">
		        <div class="float-left">
		        	報名日期區間：
		        	<input class="use-form-control" style="width: 200px;" type='date' ng-model='contCtrl.searchonline_date_s' id="searchonline_date_s"/>
		        	~
		        	<input class="use-form-control" style="width: 200px;" type='date' ng-model='contCtrl.searchonline_date_e'id="searchonline_date_e"/>
		        	<br>
		        	<input class="use-form-control" style="width: 200px;" type='text' ng-model='contCtrl.searchonline_class' placeholder="請輸入班別"/>
		        	<input class="use-form-control" style="width: 200px;" type='text' ng-model='contCtrl.searchonline_type' placeholder="請輸入梯別"/>
		            <input class="use-form-control" style="width: 200px;" type='text' ng-model='contCtrl.searchonline_text' placeholder="請輸報名介紹內容"/>
		            <!-- <input class="use-form-control" style="width: 200px;" type='text' ng-model='contCtrl.searchText' placeholder="請輸入姓名/電話/信箱"/> -->
		            <span><a href="" ng-click='contCtrl.search()'>搜尋</a></span>
		            <span>|</span>
		            <span><a href="" ng-click='contCtrl.clearSearch()'>清除搜尋</a></span>
		        </div>
		    </div>
			<div class="col-lg-6 clearfix mb-2">
				<div class="float-lg-left admin-receivingMailBox">
					<span ng-repeat="item in contCtrl.status_text_select track by $index" ng-class='{ mailActive: contCtrl.contactStatus== item["n"] }'> 
						<a href="" ng-click='contCtrl.changeContaStatus(item["n"])'><span ng-bind='item["v"]'></span></a>
					</span>
				</div>
			</div>
		    <div class="col-lg-6 clearfix mb-2">
		        <div class="float-lg-right">
		            <span> 共<span ng-bind="contCtrl.contactCount"></span>項</span>
		            <span> <input class="use-form-control pdSpacing" style='width:50px;' type='text' ng-model="contCtrl.currentPage" ng-keydown="$event.keyCode === 13 && contCtrl.goto()" ng-blur="contCtrl.goto()"  ng-focus="contCtrl.textRecording(contCtrl.currentPage)">/@{{contCtrl.pageCount}}</span>
		            <span> <a href="" ng-click='contCtrl.prePage()'>上一頁</a></span>
		            <span> <a href="" ng-click='contCtrl.nextPage()'>下一頁</a></span>
		        </div>
		    </div>
		</div>
		<div>
		    <table class="table table-bordered admin-table-rwd form">
				<thead>
			        <tr class="admin-tr-only-hide">
			            <th class="w-20px"><input type="checkbox" ng-model="contCtrl.selectedAll" ng-click="contCtrl.checkAll()" /></th>
						<th class="w-65px">狀態</th>
			            <th class="w-120px">報名日期</th>
			            <th>班別</th>
			            <th>梯別</th>
			            <th>簡易問答</th>
			            <!-- <th>姓名</th>
			            <th>電話</th>
			            <th>信箱</th> -->
			            <!-- <th>
							<span>詢問項目</span>
							<a href="" data-toggle="modal" data-target="#itemList"><span>(新增/修改)</span></a>
						</th> -->
			            <!-- <th>留言內容</th> -->
			        </tr>
				</thead>
				<tbody>
					<tr ng-repeat="item in contCtrl.contact">
			            <td data-th="項目"><input type="checkbox" ng-model="item.selected" /></td>
			            <td data-th="狀態"><span ng-bind="contCtrl.transStatus(item.contact_status)"></span></td>
			            <td data-th="報名日期">
			            	<a class="editInfor"  ng-href="@{{contCtrl.editPage}}@{{item.conta_id}}" target="_blank" 
			            						  ng-click="contCtrl.go_eidt(item.conta_id, $event)">
			            		<span ng-bind="contCtrl.formatDate(item.conta_datetime)"></span>
			            	</a>
			            </td>
			            <td data-th="班別"><span ng-bind="item.online_class"></span></td>
			            <td data-th="梯別"><span ng-bind="item.online_type"></span></td>
			            <td data-th="簡易問答"><div ng-bind-html="item.qa"></div></td>
			            <!-- <td data-th="姓名">
			            	<a class="editInfor" ng-href="@{{contCtrl.editPage}}@{{item.conta_id}}" target="_blank" 
			            						 ng-click="contCtrl.go_eidt(item.conta_id, $event)">
			            		<span ng-bind="item.conta_name"></span>
			            	</a>
			            </td>
			            <td data-th="電話"> <span ng-bind="item.conta_phone"></span></td>
			            <td data-th="信箱"><span ng-bind="item.conta_email"></span></td> -->
			            <!-- <td data-th="詢問項目"><span ng-bind="item.contact_item.conta_item_name"></span></td> -->
			            <!-- <td data-th="留言內容"><span ng-bind="item.conta_cont"></span></td> -->
					</tr>
				</tbody>
			</table>
			<div class="row pageHeader">
				<div class="col-lg-6 clearfix">
					<div class="float-left clearfix">
						<div class="float-left" ng-if="contCtrl.contactStatus != 3">
							<a class="deleteBtn btn-use" href="" ng-click='contCtrl.remove(false)'><span>丟進垃圾桶</span></a>
						</div>
						<div class="float-left" ng-if="contCtrl.contactStatus == 3">
							<a class="deleteBtn btn-use" href="" ng-click='contCtrl.remove(true)'>刪除</a>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="float-lg-right">
					  <span> 共<span ng-bind="contCtrl.contactCount"></span>項</span>
					  <span> <input class="use-form-control pdSpacing" style='width:50px;' type='text' ng-model="contCtrl.currentPage" ng-keydown="$event.keyCode === 13 && contCtrl.goto()" ng-blur="contCtrl.goto()"  ng-focus="contCtrl.textRecording(contCtrl.currentPage)">/@{{contCtrl.pageCount}}</span>
					  <span> <a href="" ng-click='contCtrl.prePage()'>上一頁</a></span>
					  <span> <a href="" ng-click='contCtrl.nextPage()'>下一頁</a></span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- itemList model start-->
    <div class="modal fade" id="itemList" tabindex="-1" role="dialog" aria-labelledby="describeModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">項目管理</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="use-box">
						<table class="table">
						  <thead>
						    <tr>
							  <th scope="col" class="w-100px">狀態</th>
						      <th scope="col"><input class="form-control" type='text' ng-model="contCtrl.addContaItemNameTxt" placeholder="請填入項目名稱"></th>@{{item}}
						      <th scope="col">
								<select  class="use-form-control maxWidth pdSpacing" ng-model='contCtrl.addLangId' ng-options="option.lang_id as option.lang_word for option in contCtrl.langs"></select>
						      </th>
						      <th scope="col"><button ng-click='contCtrl.addContactItem()'>新增項目</button></th>
						    </tr>
						  </thead>
						  <tbody>
						    <tr ng-repeat="item in contCtrl.contactItem">
								@{{item}}
								<td>
									<div ng-if='item.conta_item_status == 1'>
										<button ng-click='contCtrl.updateContactItem(item.conta_item_id,0)'>啟用</button>
									</div>
									<div ng-if='item.conta_item_status == 0'>
										<button   ng-click='contCtrl.updateContactItem(item.conta_item_id,1)'>停用</button>
									</div>
								</td>
								<td>
									<input class="form-control" type='text' ng-model="item.conta_item_name">
								</td>
								<td ng-bind="item.lang.lang_word"></td>
								<td>
									<div >
										<button   ng-click='contCtrl.updateContactItemName(item.conta_item_id,item.conta_item_name)'>編輯修改</button>
									</div>
								</td>
						    </tr>
						  </tbody>
						</table>
						<span class="herinneren-use">項目修改後需點擊右側對應的「編修確認」按鈕才會儲存</span>
                    </div>
                </div>
                <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" ng-click='contCtrl.getAllContact()'>關閉</button>
                </div>
            </div>
        </div>
    </div>
	<!-- itemList model end-->
@endsection

<!-- 自定義 javascript -->

@section('javascript')
	<script src="/js/vendor/angular/angular-1.4.4/angular-sanitize.js" type="text/javascript"></script>
    <script type="text/javascript">
	    var app = angular.module('app',['ngSanitize']);
	    app.controller('ContentController',['$http',function($http){
			var currUrl = window.location.pathname ;
			var urlSplit= currUrl.split('/');
			var self = this;			

			self.status_text = ['新郵件','打開','已處理','垃圾桶','全部'];
			self.status_text_select = [{n:'4',v:'全部'},{n:'0',v:'新郵件'},{n:'1',v:'打開'},{n:'2',v:'已處理'},{n:'3',v:'垃圾桶'}];
			self.contactStatus = '4';
			self.currentPage = 1;
			self.countOfPage = 20;
			self.selectSearchItem = -1;
			self.searchonline_class = '';
			self.searchonline_type = '';
			self.searchonline_text = '';
			self.searchText = '';
			self.contactTypeId  = urlSplit[3];
			self.selectedAll = false;
			self.selectLangItem = get_record_lang();

			self.editPage					= "/{{$use_end}}/{{$content_table}}/edit/" + self.contactTypeId + "/";
			self.urlAddContactItem 			= "/{{$use_end}}/api/{{$content_table}}/item/add";
			self.urlUpdateContactItem  		= "/{{$use_end}}/api/{{$content_table}}/item/update";
			self.urlUpdateContactItemName 	= "/{{$use_end}}/api/{{$content_table}}/item/updateItemName";
			self.urlDeleteContactItem 		= "/{{$use_end}}/api/{{$content_table}}/item/delete";
			self.urlGetAllContact  			= "/{{$use_end}}/api/{{$content_table}}/show/get/all";
			self.urlRemoveContact  			= "/{{$use_end}}/api/{{$content_table}}/remove";
			self.urlDeleteContact  			= "/{{$use_end}}/api/{{$content_table}}/delete";

			self.go_eidt = function(item_id, $event){
				// $event.preventDefault();
				// window.open(self.editPage + item_id);
				// location.href = self.editPage + item_id;
			}
			self.formatDate = function(date){
					let getDate = new Date(date);
					return getDate.getFullYear()+'-'+('0' + (getDate.getMonth() + 1)).slice(-2)+'-'+('0' + getDate.getDate()).slice(-2);
			}

			self.changeContaStatus = function(index){
				self.currentPage = 1;
				self.selectedAll = false;
				self.contactStatus = index;
				self.getAllContact();
			}

			self.clearSearch = function(){
				self.currentPage = 1;
				self.selectedAll = false;
				self.searchonline_class = '';
				self.searchonline_type = '';
				self.searchonline_text = '';
				self.searchonline_date_s = '';
				self.searchonline_date_e = '';
				self.searchText = '';
				self.selectSearchItem = -1;
				$('#searchonline_date_s').val("");
				$('#searchonline_date_e').val("");
				self.getAllContact();
			}

			self.checkAll = function () {
				if (self.selectedAll) {
					self.selectedAll = true;
				} else {
					self.selectedAll = false;
				}

				angular.forEach(self.contact, function(contact) {
					contact.selected = self.selectedAll;
				});
			};    

			self.remove = function(type){
				let text = "確定丟進垃圾桶？";
				if(type){
					text = "確定刪除？";
				}
				if (confirm(text)) {
					var removeIds=[];
					self.selectedAll = false;
					angular.forEach(self.contact, function(contact){
						if(contact.selected){
							removeIds.push(contact.conta_id);
						}
					}); 
					self.removeContact(type,removeIds);
				}
			};

			self.prePage = function(){
				if(self.currentPage > 1){
					self.currentPage --;
					self.selectedAll = false;
					self.getAllContact();
				}
			}

			self.nextPage = function(){
				if(self.currentPage < self.pageCount){
					self.currentPage ++;
					self.selectedAll = false;
					self.getAllContact();
				}
			}

			self.changedListLang = function(){
				if(self.selectLangItem === null){
					self.selectLangItem = '';
				}
				self.getAllContact();
			}

			self.transStatus = function(statusIndex){
				return self.status_text[statusIndex];
			}

			self.search = function(){
				self.getAllContact();
			}

			self.addContactItem = function(){
				let data = {'contactTypeId': self.contactTypeId,'contaItemName': self.addContaItemNameTxt,'langId':self.addLangId};
				console.log(data);
				$http({
					method : "post",
					url : self.urlAddContactItem,
					data : data
				}).success(function(data){
					console.log(data);
					if (data.status=='200'){
						self.contactItem = data.contactItem;
						self.addContaItemNameTxt = '';
						$.toaster({ message : '儲存成功'});
					}else{
						$.toaster({ message : '資料庫無回應', priority:'warning'});
					}
				}).error(function(){
					$.toaster({ message : '網路錯誤', priority:'warning'});
				})//error
			}

			self.updateContactItem = function(contaItemId,status){
				let data = {'contactTypeId': self.contactTypeId,'contaItemId':contaItemId ,'contaItemStatus': status};
				$http({
					method : "put",
					url : self.urlUpdateContactItem,
					data : data
				}).success(function(data){
					if (data.status=='200'){
						self.contactItem = data.contactItem;
						$.toaster({ message : '儲存成功'});
					}else{
						$.toaster({ message : '資料庫無回應', priority:'warning'});
					}
				}).error(function(){
					$.toaster({ message : '網路錯誤', priority:'warning'});
				})//error
			}

			self.updateContactItemName = function(contaItemId,itemName){
				let data = {'contactTypeId': self.contactTypeId,'contaItemId':contaItemId ,'contaItemName': itemName};
				$http({
					method : "put",
					url : self.urlUpdateContactItemName,
					data : data
				}).success(function(data){
					if (data.status=='200'){
						self.contactItem = data.contactItem;
						$.toaster({ message : '儲存成功'});
					}else{
						$.toaster({ message : '資料庫無回應', priority:'warning'});
					}
				}).error(function(){
					$.toaster({ message : '網路錯誤', priority:'warning'});
				})//error
			}

			self.deleteContactItem = function(contactItemIds){
				let data = {'contactTypeId': self.contactTypeId,'ids': contactItemIds};
				$http({
					method : "put",
					url : self.urlDeleteContactItem,
					data: data,
				}).success(function(data){
					if (data.status=='200'){
						self.contactItem = data.contactItem;
					}else{
						$.toaster({ message : '資料庫無回應', priority:'warning'});
					}
				}).error(function(){
					$.toaster({ message : '網路錯誤', priority:'warning'});
				})	//error
			}

			self.getAllContact = function(){
				let data = {
					'contactTypeId': self.contactTypeId,
					'searchByContaItemId': self.selectSearchItem,
					'searchonline_class': self.searchonline_class,
					'searchonline_type': self.searchonline_type,
					'searchonline_text': self.searchonline_text,
					'searchonline_date_s': $('#searchonline_date_s').val(),
					'searchonline_date_e': $('#searchonline_date_e').val(),

					'searchByText': self.searchText,
					'contactStatus': self.contactStatus,
					'currentPage': self.currentPage,
					'countOfPage': self.countOfPage,
					'langId': self.selectLangItem,
				};
				$http({
					method : "post",
					url : self.urlGetAllContact,
					data : data
				}).success(function(data){
					console.log(data);
					self.contactCount = data.contactCount;
					if(self.contactCount  == 0){
						self.currentPage =0;
					}
					self.pageCount= data.pageCount;
					self.pageTitle= data.pageTitle;
					self.contact = data.contact;
					self.contactItem = data.contactItem;
					self.langs = data.langs;
					self.addLangId = self.langs[0].lang_id;
				}).error(function(){
					$.toaster({ message : '網路錯誤', priority:'warning'});
				})//error
			}	
			self.getAllContact();

			self.removeContact = function(type,contactIds){
				let data = {'ids': contactIds};
				let urlRemoveContact = 	 self.urlRemoveContact;
				if(type){
					urlRemoveContact = 	 self.urlDeleteContact;
				}
				$http({
					method : "put",
					url : urlRemoveContact,
					data: data,
				}).success(function(data){
					if (data.status=='200'){
						self.getAllContact();
					}else{
						$.toaster({ message : '資料庫無回應', priority:'warning'});
					}
				}).error(function(){
					$.toaster({ message : '網路錯誤', priority:'warning'});
				})	//error
			}

			self.textRecording = function(item) {
				self.contrastContent="";
				self.contrastContent = angular.copy(item, self.contrastContent);            
			}
			self.goto = function() {
                if (self.currentPage <= 0) {
                    self.currentPage = 1;
                    $.toaster({ message : '頁數需大於 0',  priority : 'warning'})
                    self.currentPage = self.contrastContent;
                } else if (self.currentPage > self.pageCount) {
                    $.toaster({ message : '頁數需小於於總頁數 : ' + self.pageCount,  priority : 'warning'})
                    self.currentPage = self.contrastContent;
                } else {
                    self.getAllContact();
                }
            } //self.goto
	    }])
    </script>
@endsection







