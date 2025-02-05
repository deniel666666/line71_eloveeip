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
                    <th scope="col">項目標籤名稱</th>
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
                    <td data-th="狀態" ng-disabled="@{{item.tabs_status == 1? 'item.itemColor =false': 'item.itemColor=true'}}" ng-class="{true: 'item_enable', false: 'item_disable'}[item.itemColor]">
                        <span ng-bind="item.tabs_status_name" ></span>
                    </td>
                    <td data-th="項目標籤名稱">
                        <a class="editInfor w-100 d-inline-block" href="" data-toggle="modal" data-target="#itemData" ng-click='contCtrl.edit(item)' ng-bind="item.tabs_name"></a>
                    </td>
                    <td data-th="語系" ng-bind="item.lang.lang_word"></td>
                    <td data-th="排序">
                        <input type="text" class="use-form-control maxWidth" ng-model="item.tabs_order" ng-blur="contCtrl.changeOrder(item)" ng-focus="contCtrl.textRecording(item)">
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
                        <h4 class="modal-title" ng-if='contCtrl.actionType == "add"'>新增項目標籤</h4>
                        <h4 class="modal-title" ng-if='contCtrl.actionType == "edit"'>修改項目標籤</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row use-box">
                            <div class="col-12 use-box-btm">
                                <span class="use-sp-title">項目標籤名稱</span>
                                <input class="form-control" type='text' ng-model="contCtrl.itemData.tabs_name" placeholder="請填入項目標籤名稱">
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
                                <input class="form-control" type='number' ng-model="contCtrl.itemData.tabs_order" placeholder="請填入順序">
                            </div>


                            <div class="col-12 use-box-btm">
                                <span class="use-sp-title">狀態</span>
                                <select class="form-control" ng-model='contCtrl.selectItemStatus' ng-options='option.name for option in contCtrl.tabs_status_select' ng-change="contCtrl.itemSatausChange()"></select>
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
    app.controller('ContentController', ['$scope','$http', function($scope,$http) {

        var currentPath = window.location.pathname;
        var currPathAry = currentPath.split("/");
        var self = this;
        self.productNum = currPathAry.pop();
  

        // //======= area start=======
        self.listUrl = '/admin/api/prod_tabs/tabsTag/' + self.productNum;
        self.addUrl = '/admin/api/prod_tabs/tabsTag/add';
        self.saveUrl = '/admin/api/prod_tabs/tabsTag/save';
        self.deleteUrl = '/admin/api/prod_tabs/tabsTag/delete';

        self.currentPage = 1;
        self.countOfPage = 20;
        self.searchText = '';
        self.selectLangItem = get_record_lang();
        self.actionType = 'add';

        self.resetItem = function() {
            self.itemData = {};
            self.itemData.lang_id = self.langs[0]['lang_id'];
            self.itemData.tabs_order= 0;
            self.itemData.tabs_status= 1;
            self.selectItemStatus = self.tabs_status_select[0];
        }

        self.add = function() {
            self.actionType = 'add';
            self.resetItem();
        };

        self.edit = function(item) {
            self.actionType = 'edit';
            self.itemData = item;
            self.itemData.tabs_status ==1 ?  self.selectItemStatus = self.tabs_status_select[0] :self.selectItemStatus = self.tabs_status_select[1];
        };

        // ////////////////////////////////////////////



        self.itemData = {};
        self.itemData.tabs_order= 0;

        self.tabs_status_select = [
            { name: '啟用', value: 1 },
            { name: '停用', value: 0 },
        ]
        self.itemData.tabs_status= 1;
        self.selectItemStatus = self.tabs_status_select[0];
        self.itemSatausChange = function() {
            self.itemData.tabs_status = self.selectItemStatus.value;
        };

        // // ---------------------------------------------
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
                    item.tabs_status ==1 ?item.tabs_status_name = '啟用' :item.tabs_status_name = '停用';
                });

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
            // console.log(self.itemData)
            if(self.itemData.tabs_name =='' || self.itemData.tabs_name ==undefined){
                // $('#seoFile').value('');
                $.toaster({ message : '請填入標籤名稱',  priority : 'warning'});
                return false;
            }
            self.itemData.tabs_prod_num = self.productNum;
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
                    ids.push(item.tabs_tag_id);
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
            if(isNaN(item.tabs_order) ){
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
        
        self.setStatusUrl = '/admin/api/prod_tabs/tabsTag/setStatus';
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
                    ids.push(item.tabs_tag_id);
                }
            });
            return ids;
        };
        self.setStatusItem = function(ids, status) {
            var data = { 'ids': ids, status: status };
            self.actionItem("put", self.setStatusUrl, data);
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
    }).factory("fileReader", function($q, $log) {
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







