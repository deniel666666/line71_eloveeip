@extends('layouts.masterAdmin')

<!-- html title -->
@section('htmlTitle') {{$pageTitle}}  @endsection

<!-- 自定義 content -->
@section('content')
    <div class="w-100">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">運費管理</li>
                <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
            </ol>
        </nav>
    </div>
    <div class="container-fluid" style="padding: 0px;">
        <div class="row bg-light no-gutters pageHeader">
            <div class="col-12 mb-2">
                <div class="float-left">
                    <input class="use-form-control w-200px" type='text' ng-model='contCtrl.searchText' />
                    <span> <a href="" ng-click='contCtrl.getItems(0)'>搜尋</a></span>
                    <span> |</span>
                    <span> <a href="" ng-click='contCtrl.clearSearch()'>清除搜尋</a></span>
                </div>
            </div>
            <div class="col-lg-6 mb-2">
                <div class="admin-receivingMailBox">
                    <select id="lang_select" class="use-form-control maxWidth pdSpacing" ng-model='contCtrl.selectLangItem' ng-change="contCtrl.changedListLang()" ng-options="option.lang_id as option.lang_word for option in contCtrl.langs">
                        <option ng-selected="true" value="">全部</option>
                    </select>
                    <a href="" data-toggle="modal" ng-click='contCtrl.add()' data-target="#itemData" class="addNewBtn btn-use"><span>新增</span></a>
                </div>
            </div>
            <div class="col-lg-6 mb-2 clearfix">
                <div class="float-lg-right">
                    <span> 共@{{contCtrl.itemCount}}項</span>
                    <span> <input class="use-form-control pdSpacing" type='text' ng-model="contCtrl.currentPage" style='width:50px;' readonly>/@{{contCtrl.pageCount}}</span>
                    <span> <a href="" ng-click='contCtrl.prePage()'>上一頁</a></span>
                    <span> <a href="" ng-click='contCtrl.nextPage()'>下一頁</a></span>
                </div>
            </div>
        </div>
        <div>
            <!-- /////////////// -->
            <table class="table table-bordered admin-table-rwd form">
              <thead>
                    <tr class="admin-tr-only-hide">
                        <th class="w-20px" scope="col"><input type="checkbox" ng-model="contCtrl.selectedAll" ng-click="contCtrl.checkAll()" /></th>
                        <th class="w-65px" scope="col">狀態</th>
                        <th scope="col">運費名稱</th>
                        <th scope="col">運費金額</th>
                        <th scope="col">滿額免運</th>
                        <th class="w-50px" scope="col">語系</th>
                    </tr>
              </thead>
              <tbody>
                    <tr ng-repeat="item in contCtrl.items">
                        @{{item}}
                        <td data-th="項目"><input type="checkbox" ng-model="item.selected" ng-click="contCtrl.checkWatch()" /></td>
                        <td data-th="狀態">
                            <span class="myMOUSE" ng-disabled="@{{item.fare_status == 1? 'item.itemColor =false': 'item.itemColor=true'}}" ng-class="{true: 'item_enable', false: 'item_disable'}[item.itemColor]" ng-click="contCtrl.changeStatus(item.fare_id,item.fare_status,'fare_status')" ng-bind="contCtrl.fairStatus[item.fare_status].label"></span>

                        </td>
                        <td data-th="運費名稱"><a class="editInfor w-100 d-inline-block"  href="" data-toggle="modal" data-target="#itemData" ng-click='contCtrl.edit(item)' ng-bind="item.fare_name"></a></td>
                        <td data-th="運費金額" ng-bind="item.fare_cost"></td>
                        <td data-th="滿額免運" ng-bind="item.free_rule"></td>
                        <td data-th="語系" ng-bind="item.lang.lang_word"></td>
                    </tr>
              </tbody>
            </table>
            <div class="row pageHeader">
                    <div class="col-lg-6">
                        <div class="admin-receivingMailBox">
                            <a class="disableBtn btn-use" href="javascript:void(0);" ng-click='contCtrl.setStatus(1)'><span>啟用</span></a>
                            <a class="enablewBtn btn-use" href="javascript:void(0);" ng-click='contCtrl.setStatus(0)'><span>停用</span></a>
                            <a class="deleteBtn btn-use" href="javascript:void(0);" ng-click='contCtrl.remove()'><span>刪除</span></a>
                        </div>
                    </div>
                    <div class="col-lg-6 clearfix">
                        <div class="float-lg-right">
                            <span> 共@{{contCtrl.itemCount}}項</span>
                            <span> <input class="use-form-control pdSpacing" type='text' ng-model="contCtrl.currentPage" style='width:50px;' readonly>/@{{contCtrl.pageCount}}</span>
                            <span> <a href="" ng-click='contCtrl.prePage()'>上一頁</a></span>
                            <span> <a href="" ng-click='contCtrl.nextPage()'>下一頁</a></span>
                        </div>
                    </div>
            </div>
            <hr>

            <!-- Modal -->
            <div class="modal fade" id="itemData" tabindex="-1" role="dialog" aria-labelledby="itemDataTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" ng-if='contCtrl.actionType == "add"'>新增項目</h4>
                            <h4 class="modal-title" ng-if='contCtrl.actionType == "edit"'>修改項目</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- ////////// -->
                            <div class="row">
                              <div class="col-12">
                                <span class="use-sp-title">運費名稱</span>
                                <input class="form-control" type='text' ng-model="contCtrl.itemData.fare_name" placeholder="請填入名稱">
                              </div>
                              <div class="col-12">
                                <span class="use-sp-title">運費金額</span>
                                <input class="form-control" type='text' ng-model="contCtrl.itemData.fare_cost" placeholder="請填入金額">
                              </div>
                              <div class="col-12">
                                <span class="use-sp-title">滿額免運</span>
                                <input class="form-control" type='text' ng-model="contCtrl.itemData.free_rule" placeholder="請填入金額">
                              </div>
                              <div class="col-12">
                                <span class="use-sp-title">語系</span>
                                <div ng-if='contCtrl.actionType == "add"'>
                                  <select class="form-control" ng-model='contCtrl.itemData.lang_id' ng-options="option.lang_id as option.lang_word for option in contCtrl.langs"></select>
                                </div>
                                <div ng-if='contCtrl.actionType == "edit"'>
                                  @{{contCtrl.itemData.lang.lang_word}}
                                </div>
                              </div>
                              <div class="col-12">
                                <span class="use-sp-title">狀態</span>
                                <select class="form-control" ng-model='contCtrl.itemData.fare_status' ng-options='s.id as s.label for s in contCtrl.fairStatus' ng-change=""></select>
                              </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" ng-if='contCtrl.actionType == "add"' class="btn btn-default" ng-click='contCtrl.addItem()' data-dismiss="modal">新增</button>
                            <button type="button" ng-if='contCtrl.actionType == "edit"' class="btn btn-default" ng-click='contCtrl.saveItem()' data-dismiss="modal">儲存</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal" ng-click='contCtrl.closeModal()'>關閉</button>
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
      var app = angular.module('app',[]);
      app.controller('ContentController',['$http',function($http){
          var self = this;

          //======= area start=======
          self.listUrl = '/admin/api/fare';
          self.addUrl = '/admin/api/fare/add';
          self.saveUrl = '/admin/api/fare/save';
          self.deleteUrl = '/admin/api/fare/delete';
          self.changeStatusUrl = '/admin/api/fare/status/'; 
          self.setStatusUrl = '/admin/api/fare/status/multiple';
          self.currentPage = 1;
          self.countOfPage = 10;
          self.searchText = '';
          self.actionType = 'add';
          self.fairStatus = [
          	{label: '停用',id: 0},
          	{label: '啟用',id: 1}
          ];
          self.selectItemStatus = 0;//self.status[0];
          self.selectedAll = false;
          self.selectLangItem = get_record_lang();

          self.setStatus = function(status){
              var ids = self.checkAllItem(ids);
              self.setStatusItem(ids,status);
          };

          self.add = function(){
                self.actionType = 'add';
                self.resetItem();
          };

          self.edit = function(item){
              console.log(item);
              self.actionType = 'edit';
              self.itemData = item;
              self.selectItemStatus = parseInt(item.fare_status);
          };
       
          self.remove = function(){
              if (confirm( "確定刪除？")) {
                  var ids = self.checkAllItem(ids);
                  if(ids.length > 0){
                       self.deleteItem(ids);
                  }                
              }
          };
          //======= area  end=======

          self.itemSatausChange = function () {
              self.itemData.fare_status = self.selectItemStatus.value;
          };

          self.changedListLang = function(){
              if(self.selectLangItem === null){
                  self.selectLangItem = 0;
              }
              self.getItems();
          }        

          self.checkAllItem = function(ids){
              var ids = [];
              self.selectedAll = false;
              angular.forEach(self.items, function(item){
                  if(item.selected){
                    ids.push(item.fare_id);
                  }
              });

              return ids;
          };

          self.resetItem = function(){
            self.itemData = {
                fare_name:'',
                fare_cost:0,
                fare_status:0,
                lang_id: self.langs[0]['lang_id']
            }
          }

          self.clearSearch = function(){
            self.currentPage = 1;
            self.selectedAll = false;
            self.searchText = '';
            self.selectLangItem = 0;
            self.resetItem()
            self.getItems();
          }

          self.closeModal = function(){
            self.actionType = 'add';
            self.resetItem();
          }

          self.checkAll = function () {
            if (self.selectedAll) {
                self.selectedAll = true;
            } else {
                self.selectedAll = false;
            }
            angular.forEach(self.items, function(item) {
                item.selected = self.selectedAll;
            });
          };          

          self.checkWatch = function () {
              var check = 0;
              angular.forEach(self.items, function(item) {
                  if(item.selected && item.selected === true){
                    check++;
                  }
              });
              if(check == self.countOfPage ){
                  self.selectedAll = true;
              }else{
                   self.selectedAll = false;
              }
          };

          self.prePage = function(){
              if(self.currentPage > 1){
                self.currentPage --;
                self.selectedAll = false;
                self.getItems();
              }
          }

          self.nextPage = function(){
              if(self.currentPage < self.pageCount){
                self.currentPage ++;
                self.selectedAll = false;
                self.getItems();
              }
          }
          //CRUD ====== start ======

          self.addItem = function(){
            if(self.itemData.fare_name.length == 0 || self.itemData.fare_cost.length == 0 ){
                $.toaster({ message : '請填入運費名稱與金額', priority : 'warning' });
                return false;
            }

            var exp = /^(([1-9]\d*)|\d)(\.\d{1,2})?$/;

            if(!exp.test(self.itemData.fare_cost)){
                $.toaster({ message : '金額格式不對', priority : 'warning' });
                return false;
            }

            var data = {'item': self.itemData};
            self.actionItem(0, "post",self.addUrl,data);
          }

          self.saveItem = function(){
    				if(self.itemData.fare_name.length == 0 || self.itemData.fare_cost.length == 0 ){
                $.toaster({ message : '請填入運費名稱與金額', priority : 'warning' });
    				    return false;
    				}

    				var exp = /^(([1-9]\d*)|\d)(\.\d{1,2})?$/;
    				if(!exp.test(self.itemData.fare_cost)){
    				    $.toaster({ message : '金額格式不對', priority : 'warning' });
    				    return false;
    				}
    	            var data = {'item': self.itemData};
    	            // self.actionItem( 0,"put",self.saveUrl,data);
    				$http({
    					method 	: 'put',
    					url 	: self.saveUrl,
    					data 	: data
    				}).success(function(data){
    					if (data.status == '200'){
                $.toaster({ message : '資料已更新'})
    						$('#itemData').modal('hide')
    					}else{
                $.toaster({ message : '資料庫無回應', priority : 'danger' });
    					}
         		})

    			}//self.saveItem

          self.deleteItem = function(ids){
              var data = {'ids': ids};
              self.actionItem( 1,"put",self.deleteUrl,data);
          }

          self.setStatusItem = function(ids,status){
              var data = {'ids': ids, status: status};
              self.actionItem( 2,"put",self.setStatusUrl,data);
          }

          self.changeStatus = function(id,status,type){
              if(status == 0){
                  status =1;
              }else if(status == 1){
                  status = 0;
              }

              var data = {'fareId': id, 'status': status, 'type':type};
              self.actionItem(2,"put", self.changeStatusUrl, data);
           }

          self.actionItem = function(number,method,url,data){
              $http({
                method : method,
                url : url,
                data : data
              }).success(function(data){
                if (data.status=='200'){
                    if(number == 0){
                        $.toaster({ message : '成功'});
                    }
                    if(number == 4){
                        self.getMiscItems();
                    }else{
                        self.actionType = 'add';
                        self.resetItem();
                        self.getItems();
                    }                
                }else{
                    $.toaster({ message : '資料庫無回應', priority : 'danger' });
                }
              }).error(function(){
                $.toaster({ message : '錯誤', priority : 'danger' });
              })//error
          }

          self.getItems = function(search){
              if(search==0){
                self.currentPage = 1;
              }
              var data = {
                'selectLangItem': self.selectLangItem,
                'searchByText': self.searchText,
                'currentPage': self.currentPage,
                'countOfPage': self.countOfPage,
              };
              $http({
                method : "post",
                url : self.listUrl,
                data : data
              }).success(function(data){
                self.count = data.count;
                self.pageCount= data.pageCount;
                self.items = data.items;
                self.langs = data.langs;
                //self.itemData.lang_id = data.langs[0]['lang_id'];
              }).error(function(){
                $.toaster({ message : '錯誤', priority : 'danger' });
              })//error
          }	
          self.getItems();
          //CRUD ====== end =======
      }])
    </script>
@endsection







