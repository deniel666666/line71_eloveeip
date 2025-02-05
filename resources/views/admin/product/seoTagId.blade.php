@extends('layouts.masterAdmin')
<!-- html title -->
@section('htmlTitle') {{$pageTitle}}  @endsection
<!-- 自定義 content -->
@section('content')
<div class="w-100">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">{{$pageMainTitle}}</li>
            <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
        </ol>
    </nav>
</div>

<div class="container-fluid" style="padding: 0px;">
    <div class="row bg-light no-gutters pageHeader">
        <div class="col-12 clearfix mb-2">

            <select id="lang_select" class="use-form-control maxWidth pdSpacing form-control b-radius-0 " ng-model='contCtrl.selectLangItem' ng-change="contCtrl.changedListLang()" ng-options="option.lang_id as option.lang_word for option in contCtrl.langs">
                <option ng-selected="true" value="">全部</option>
            </select>
            <div class="d-inline-block">
                <input class="use-form-control" style="width: 180px;" type='text' ng-model='contCtrl.searchText' />
                <span> <a href="" ng-click='contCtrl.getItems(0)'>搜尋</a></span>
                <span> |</span>
                <span> <a href="" ng-click='contCtrl.clearSearch()'>清除搜尋</a></span>
            </div>
        </div>
        <div class="col-lg-6 clearfix mb-2">
            <div class="admin-receivingMailBox">
                <a href="" class="addNewBtn btn-use" data-toggle="modal" ng-click='contCtrl.add()' data-target="#itemData"><span>新增</span></a>
            </div>
        </div>
        <div class="col-lg-6 clearfix mb-2">
            <div class="float-lg-right">
                <span> 共@{{contCtrl.itemCount}}項</span>
                <span> <input class="use-form-control pdSpacing" type='text' ng-model="contCtrl.currentPage" style='width:50px;' readonly>/@{{contCtrl.pageCount}}</span>
                <span> <a href="" ng-click='contCtrl.prePage()'>上一頁</a></span>
                <span> <a href="" ng-click='contCtrl.nextPage()'>下一頁</a></span>
            </div>
        </div>
    </div>

    <div>
        <table class="table table-bordered admin-table-rwd form">
            <thead>
                <tr class="admin-tr-only-hide">
                    <th class="w-20px" scope="col"><input type="checkbox" ng-model="contCtrl.selectedAll" ng-click="contCtrl.checkAll()" /></th>
                    <th class="w-50px" scope="col">狀態</th>
                    <th scope="col">名稱</th>
                    <th scope="col">meta屬性</th>
                    <th scope="col">備註</th>
                    <th class="w-50px" scope="col">type</th>
                    <th class="w-50px" scope="col">語系</th>
					<th class="w-80px cleear-fix" >
                        <span class="float-left">排序</span>
                        {{-- <span class="float-right reloadBtn" ng-click="contCtrl.reload()">更新排序</span> --}}
                    </th>

                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="item in contCtrl.items">
                    <td data-th="項目"><input type="checkbox" ng-model="item.selected" ng-click="contCtrl.checkWatch()" /></td>
                    <td data-th="狀態" ng-disabled="@{{item.seo_status == 1? 'item.itemColor =false': 'item.itemColor=true'}}" ng-class="{true: 'item_enable', false: 'item_disable'}[item.itemColor]">
                        <span  ng-bind="item.seo_status_name"></span>
                    </td>
                    <td data-th="名稱">
                        <a class="editInfor w-100 d-inline-block" href="" data-toggle="modal" data-target="#itemData" ng-click='contCtrl.edit(item)' ng-bind="item.seo_name"></a>
                    </td>
                    <td data-th="meta屬性" > <pre ng-bind="item.seo_meta_property"> </pre></td>
                    <td data-th="備註" ng-bind="item.seo_placeholder"></td>
                    <td data-th="type" ng-bind="item.seo_type_name"></td>
                    <td data-th="語系" ng-bind="item.lang.lang_word"></td>
                    <td data-th="排序">
                        <input type="text" class="use-form-control maxWidth" ng-model="item.seo_tag_order" ng-blur="contCtrl.changeOrder(item)" ng-focus="contCtrl.textRecording(item)">
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="row pageHeader">
            <div class="col-lg-6 clearfix mb-2">
                <div class="admin-receivingMailBox">
                    <a class="disableBtn btn-use" href="javascript:void(0);" ng-click='contCtrl.setStatus(1)'>啟用</a>
                    <a class="enablewBtn btn-use" href="javascript:void(0);" ng-click='contCtrl.setStatus(0)'>停用</a>
                    <a href="" class="deleteBtn btn-use" ng-click='contCtrl.remove()'><span>刪除</span></a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="float-lg-right mb-2">
                    <span> 共@{{contCtrl.itemCount}}項</span>
                    <span> <input class="use-form-control pdSpacing" type='text' ng-model="contCtrl.currentPage" style='width:50px;' readonly>/@{{contCtrl.pageCount}}</span>
                    <span> <a href="" ng-click='contCtrl.prePage()'>上一頁</a></span>
                    <span> <a href="" ng-click='contCtrl.nextPage()'>下一頁</a></span>
                </div>
            </div>
        </div>
        <!--Modal -->

        <div class="modal fade" id="itemData" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" ng-if='contCtrl.actionType == "add"'>新增項目</h4>
                        <h4 class="modal-title" ng-if='contCtrl.actionType == "edit"'>修改項目</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row use-box">
                            <div class="col-12 use-box-btm">
                                <span class="use-sp-title">標題名稱</span>
                                <input class="form-control" type='text' ng-model="contCtrl.itemData.seo_name" placeholder="請填入標題名稱">
                            </div>
                            <div class="col-12 use-box-btm">
                                <span class="use-sp-title">meta屬性</span>
                                <input class="form-control" type='text' ng-model="contCtrl.itemData.seo_meta_property" placeholder="請填入meta屬性">
                            </div>
                            <div class="col-12 use-box-btm">
                                <span class="use-sp-title">備註</span>
                                <input class="form-control" type='text' ng-model="contCtrl.itemData.seo_placeholder" placeholder="備註">
                            </div>
                            <div class="col-12 use-box-btm">
                                <label class="use-sp-title" for="type">類型選擇</label>
                                <select class="form-control" ng-model='contCtrl.selectSeoType' ng-options='option.name for option in contCtrl.seo_type_select' ng-change="contCtrl.seoTypeChange()"></select>
                            </div>
                            <div class="col-12 use-box-btm">
                                <span class="use-sp-title">語系</span>
                                <div ng-if='contCtrl.actionType == "add"'>
                                    <select class="form-control" ng-model='contCtrl.itemData.lang_id' ng-options="option.lang_id as option.lang_word for option in contCtrl.editLangs"></select>
                                </div>
                                <div ng-if='contCtrl.actionType == "edit"'>
                                    @{{contCtrl.itemData.lang.lang_word}}
                                </div>
                            </div>
                            <div class="col-12 use-box-btm">
                                <span class="use-sp-title">順序</span>
                                <input class="form-control" type='number' ng-model="contCtrl.itemData.seo_tag_order" placeholder="請填入順序">
                            </div>


                            <div class="col-12 use-box-btm">
                                <span class="use-sp-title">狀態</span>
                                <select class="form-control" ng-model='contCtrl.selectItemStatus' ng-options='option.name for option in contCtrl.seo_status_select' ng-change="contCtrl.itemSatausChange()"></select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" ng-if='contCtrl.actionType == "add"' class="btn btn-default" data-dismiss="modal" ng-click='contCtrl.addItem()'>新增</button>
                        <button type="button" ng-if='contCtrl.actionType == "edit"' class="btn btn-default" data-dismiss="modal" ng-click='contCtrl.saveItem()'>儲存</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal" ng-click='contCtrl.closeModal()'>關閉</button>
                    </div>
                </div>
            </div>
        </div>
        <!--Modal End-->
    </div>
</div>


@endsection





<!-- 自定義 javascript -->

@section('javascript')

<script type="text/javascript">
</script>
<script type="text/javascript">
    var app = angular.module('app', []);
    app.controller('ContentController', ['$scope','$http', function($scope ,$http) {

        var currentPath = window.location.pathname;
        var currPathAry = currentPath.split("/");
        var self = this;
        self.productNum = currPathAry.pop();
  

        //======= area start=======
        self.listUrl = '/admin/api/prod_seo/seoTag/' + self.productNum;
        self.addUrl = '/admin/api/prod_seo/seoTag/add';
        self.saveUrl = '/admin/api/prod_seo/seoTag/save';
        self.deleteUrl = '/admin/api/prod_seo/seoTag/delete';

        self.currentPage = 1;
        self.countOfPage = 20;
        self.searchText = '';
        self.selectLangItem = get_record_lang();
        self.actionType = 'add';

        self.resetItem = function() {
            self.itemData = {};
            self.itemData.lang_id = self.langs[0]['lang_id'];
            self.itemData.seo_tag_order= 0;
            self.selectSeoType = self.seo_type_select[0];
            self.itemData.seo_status= 1;
            self.selectItemStatus = self.seo_status_select[0];
        }

        self.add = function() {
            self.actionType = 'add';
            self.resetItem();
        };

        self.edit = function(item) {
            self.actionType = 'edit';
            self.itemData = item;
            self.itemData.seo_type ==1 ?  self.selectSeoType =self.seo_type_select[0] :self.selectSeoType =self.seo_type_select[1];
            self.itemData.seo_status ==1 ?  self.selectItemStatus = self.seo_status_select[0] :self.selectItemStatus = self.seo_status_select[1];
        };

        ////////////////////////////////////////////



        self.itemData = {};
        self.itemData.seo_tag_order= 0;
        self.seo_type_select = [
            { name: 'text', value: 1 },
            { name: 'img', value: 2 }
        ]
        self.itemData.seo_type= 1;
        self.selectSeoType = self.seo_type_select[0];
        self.seoTypeChange = function () {
            self.itemData.seo_type = self.selectSeoType.value;
        };

        self.seo_status_select = [
            { name: '啟用', value: 1 },
            { name: '停用', value: 0 },
        ]
        self.itemData.seo_status= 1;
        self.selectItemStatus = self.seo_status_select[0];
        self.itemSatausChange = function() {
            self.itemData.seo_status = self.selectItemStatus.value;
        };

        // ---------------------------------------------
        self.getItems = function(search) {
            if (search == 0) {
                self.currentPage = 1;
            }
            var data = {
                'selectLangItem': self.selectLangItem,
                'searchByText': self.searchText,
                'currentPage': self.currentPage,
                'countOfPage': self.countOfPage,
            };

            $http({
                method: "post",
                url: self.listUrl,
                data: data
            }).success(function(data) {
                // console.log(data)
                self.itemCount = data.count;
                if (self.itemCount == 0) {
                    self.currentPage = 0;
                }
                self.pageCount = data.pageCount;
                self.items = data.items;
                self.editLangs = data.editLangs;
                self.langs = data.langs;
                self.itemData.lang_id = data.langs[0]['lang_id'];


                angular.forEach(self.items, function(item) {
                    item.seo_type ==1 ?item.seo_type_name = 'text':item.seo_type_name = 'img';
                    item.seo_status ==1 ?item.seo_status_name = '啟用' :item.seo_status_name = '停用';
                });

                // seo_type_name
                // seo_stuts_name
            }).error(function() {
                $.toaster({ message : '發生錯誤', priority : 'danger' });
            }) //error

        }

        self.getItems();




        self.checkAll = function() {
            if (self.selectedAll) {
                self.selectedAll = true;
            } else {
                self.selectedAll = false;
            }
            angular.forEach(self.items, function(item) {
                item.selected = self.selectedAll;
            });
        };



        self.checkWatch = function() {
            var check = 0;
            angular.forEach(self.items, function(item) {
                if (item.selected && item.selected === true) {
                    check++;
                }
            });
            if (check == self.countOfPage) {
                self.selectedAll = true;
            } else {
                self.selectedAll = false;
            }
        };


        self.prePage = function() {
            if (self.currentPage > 1) {
                self.currentPage--;
                self.selectedAll = false;
                self.getItems();
            }
        }

        self.nextPage = function() {
            if (self.currentPage < self.pageCount) {
                self.currentPage++;
                self.selectedAll = false;
                self.getItems();
            }
        }



        self.addItem = function() {
            if(self.itemData.seo_name == undefined || self.itemData.seo_name == ''){
                $.toaster({ message : '標題名稱為必填',  priority : 'warning'});
                return false;
            }
            if(self.itemData.seo_meta_property == undefined || self.itemData.seo_meta_property == ''){
                $.toaster({ message : 'meta屬性為必填',  priority : 'warning'});
                return false;
            }
            self.itemData.seo_prod_num = self.productNum;
            var data = { 'item': self.itemData };
            self.actionItem("post", self.addUrl, data);
        }
        self.saveItem = function() {
            var data = { 'item': self.itemData };
            self.actionItem("put", self.saveUrl, data);
        }


        self.checkAllItem = function(ids) {
            var ids = [];
            self.selectedAll = false;
            angular.forEach(self.items, function(item) {
                if (item.selected) {
                    ids.push(item.seo_tag_id);
                }
            });
            return ids;
        };

        self.remove = function() {
            var ids = self.checkAllItem(ids);
            if (ids.length > 0) {
                if (confirm("確定刪除？")) {
                    self.deleteItem(ids);
                }
            }else{
                $.toaster({ message : '請選擇項目',  priority : 'warning'});
            }
        };
        self.deleteItem = function(ids) {
            var data = { 'ids': ids };
            self.actionItem("put", self.deleteUrl, data);
        }

        self.actionItem = function(method, url, data) {
            $http({
                method: method,
                url: url,
                data: data
            }).success(function(data) {
                // console.log(data)
                if (data.status == '200') {
                    self.actionType = 'add';
                    self.resetItem();
                    self.getItems();
                    $.toaster({ message : '修改成功'});
                } else {
                    $.toaster({ message : '資料庫無回應',  priority : 'warning'})
                }
            }).error(function() {
                $.toaster({ message : '發生錯誤', priority : 'danger' });
            }) //error
        }

        self.textRecording = function(item) {
            self.contrastContent="";
            self.contrastContent = angular.copy(item, self.contrastContent);            
        }


        self.changeOrder = function(item ){
            if(isNaN(item.seo_tag_order) ){
                self.getItems();
                $.toaster({ message : '排序請填入數字',  priority : 'warning'})
                return false;
            }
            $scope.result = angular.equals(self.contrastContent, item);
            if(!$scope.result){
                var data = { 'item':item };
                $http({
                    method : "put",
                    url : self.saveUrl,
                    data: data,
                }).success(function(data){
                    if(data.status == 200){
                        self.getItems();
                        $.toaster({ message : '修改成功'});
                    }else{
                        $.toaster({ message : '資料庫無回應',  priority : 'warning'})
                    }
                }).error(function(){
                    $.toaster({ message : '發生錯誤', priority : 'danger' });
                })//error
            }
        }
        self.reload = function(){  
            location.reload();
        }


        self.setStatusUrl = '/admin/api/prod_seo/seoTag/setStatus';
        self.setStatus = function(status) {
            var ids = self.checkAllItem(ids);
            if (ids.length > 0) {
                self.setStatusItem(ids, status);
            }else{
                $.toaster({ message : '請選擇項目',  priority : 'warning'});
            }
        };
        self.checkAllItem = function(ids) {
            var ids = [];
            self.selectedAll = false;
            angular.forEach(self.items, function(item) {
                if (item.selected) {
                    ids.push(item.seo_tag_id);
                }
            });
            return ids;
        };
        self.setStatusItem = function(ids, status) {
            var data = { 'ids': ids, status: status };
            self.actionItem("put", self.setStatusUrl, data);
        }

        
    }])
</script>
@endsection







