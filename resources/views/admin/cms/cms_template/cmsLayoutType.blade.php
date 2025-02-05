@extends($extends_layouts)

<!-- html title -->
@section('htmlTitle') {{$pageTitle}}  @endsection

<!-- 自定義 content -->
@section('content')

<div class="w-100">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">{{$topTitle}}</li>
            <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
        </ol>
    </nav>
</div>
<div class="container-fluid">
    <div class="row bg-light no-gutters pageHeader">
      <div class="col-12 clearfix mb-2">
        <div class="float-left">
            <input class="use-form-control" style="width: 180px;" type='text' ng-model='contCtrl.searchText' />
            <span> <a href="" ng-click='contCtrl.getItems(0)'>搜尋</a></span>
            <span> |</span>
            <span> <a href="" ng-click='contCtrl.clearSearch()'>清除搜尋</a></span>
        </div>
    </div>
   
    <div class="col-lg-6 mb-2">
            <div class="admin-receivingMailBox">
            
            <!-- <select id="lang_select" class="use-form-control maxWidth pdSpacing" ng-model='contCtrl.selectLangItem' ng-change="contCtrl.changedListLang()" ng-options="option.lang_id as option.lang_word for option in contCtrl.langs">
                <option ng-selected="true" value="">全部</option>
            </select> -->
            
            <a href="" data-toggle="modal" ng-click='contCtrl.add()' data-target="#itemData" class="addNewBtn btn-use">
                <span>新增</span>
            </a>
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
                    <th class="w-20px"><input type="checkbox" ng-model="contCtrl.selectedAll" ng-click="contCtrl.checkAll()" /></th>
                    <th class="w-50px">編碼</th>
                    <th class="w-65px">狀態</th>
                    <th class="w-200px">母模板名稱(修改)</th>
                    <th class="w-100px">編輯顯示畫面</th>
                    <th class="w-100px">展示顯示畫面</th>
                    <th class="w-150px">版型內容(修改)</th>
                    <!-- <th class="w-50px">語系</th> -->
                    <th class="w-50px">排序</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="(key,item) in contCtrl.items">
                    <!--  @{{item}}  -->
                    <td data-th="項目"><input type="checkbox" ng-model="item.selected" ng-click="contCtrl.checkWatch()" /></td>
                    <td data-th="編碼" ng-bind="(key+1)+(contCtrl.currentPage -1)*contCtrl.countOfPage" templateId="@{{item.id}}"></td>
                    <td data-th="狀態">
                        <a href="" ng-click="contCtrl.changeStatus(item)" ng-style="{ color: item.cate_status == '0' ? '#038c5b' : '#007bff' }">
                            @{{contCtrl.status[item.cate_status].name}}
                        </a>
                    </td>
                    <td data-th="母模板名稱(修改)">
                        <a class="editInfor" href="" data-toggle="modal" data-target="#itemData" ng-click='contCtrl.edit(item)'>@{{item.cms_type_name}}-@{{item.cont_type}}</a>
                    </td>
                    <td data-th="編輯顯示畫面">@{{item.edit_view}}</td>
                    <td data-th="展示顯示畫面">@{{item.view_view}}</td>
                    <th data-th="版型內容(修改)"><a href="" ng-click='contCtrl.go_edit(item.id)'>編輯</a></th>
                    <!-- <td data-th="語系">@{{item.lang.lang_word}}</td> -->
                    <td data-th="排序">@{{item.cate_order}}</td>
                </tr>
            </tbody>
        </table>
        <div class="row mb-5 pageHeader">
            <div class="col-lg-6 clearfix">
                <div class="admin-receivingMailBox">
                    <a class="disableBtn btn-use" href="javascript:void(0);" ng-click='contCtrl.setStatus(1)'><span>啟用</span></a>
                    <a class="enablewBtn btn-use" href="javascript:void(0);" ng-click='contCtrl.setStatus(0)'><span>停用</span></a>
                    <a class="deleteBtn btn-use" href="javascript:void(0);" ng-click='contCtrl.delete()'><span>刪除</span></a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="float-lg-right">
                    <span> 共@{{contCtrl.itemCount}}項</span>
                    <span> <input class="use-form-control pdSpacing" style='width:50px;' type='text' ng-model="contCtrl.currentPage" readonly>/@{{contCtrl.pageCount}}</span>
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
                        <h4 class="modal-title" ng-if='contCtrl.actionType == "add"'>新增母模板</h4>
                        <h4 class="modal-title" ng-if='contCtrl.actionType == "edit"'>修改母模板</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row use-box">
                            <div class="col-12 use-box-btm">
                                <span class="use-sp-title">常用選單</span>
                                <input class="form-control" type='text' ng-model="contCtrl.itemData.cms_type_name" placeholder="請填入名稱">
                            </div>
                            <div class="col-12 use-box-btm">
                                <span class="use-sp-title">版型名稱</span>
                                <input class="form-control" type='text' ng-model="contCtrl.itemData.cont_type" placeholder="請填入型別">
                            </div>
                            <div class="col-12 use-box-btm">
                                <span class="use-sp-title">編輯顯示畫面(.blade.php請省略不輸入，無額外設定請填product_cms_haslayout)</span>
                                <input class="form-control" type='text' ng-model="contCtrl.itemData.edit_view" placeholder="對應admin/cms中的檔案">
                            </div>
                            <div class="col-12 use-box-btm">
                                <span class="use-sp-title">展示顯示畫面(.blade.php請省略不輸入，無額外設定請填cmsViewTemplate)</span>
                                <input class="form-control" type='text' ng-model="contCtrl.itemData.view_view" placeholder="對應admin/cms/view_template中的檔案">
                            </div>

                            <!-- <div class="col-12 use-box-btm">
                                <span class="use-sp-title">類別說明</span>
                                <div summernote ng-model="contCtrl.itemData.cate_tag_desc" config="noteOptions"></div>
                            </div> -->
                            <!-- <div class="col-12 use-box-btm">
                                <span class="use-sp-title">語系</span>
                                <div ng-if='contCtrl.actionType == "add"'>
                                    <select class="form-control" ng-model='contCtrl.itemData.lang_id' ng-options="option.lang_id as option.lang_word for option in contCtrl.langs"></select>
                                </div>
                                <div ng-if='contCtrl.actionType == "edit"'>
                                    @{{contCtrl.itemData.lang.lang_word}}
                                </div>
                            </div> -->
                            <div class="col-12 use-box-btm">
                                <span class="use-sp-title">狀態</span>
                                <select class="form-control" ng-model='contCtrl.selectItemStatus' ng-options='option.name for option in contCtrl.status' ng-change="contCtrl.itemSatausChange()"></select>
                            </div>
                            <div class="col-12 use-box-btm">
                                <span class="use-sp-title">順序</span>
                                <input class="form-control" type='number' ng-model="contCtrl.itemData.cate_order" placeholder="請填入順序">
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
        var app = angular.module('app', ['summernote']);
        app.controller('ContentController', ['$http', '$scope', function($http, $scope) {
            var self = this;
            //======= area start=======
            self.currentPage = 1;
            self.countOfPage = 20;
            self.searchText = '';
            self.actionType = 'add';
            self.selectLangItem = get_record_lang();
            self.status = [
                { name: '停用', value: 0 },
                { name: '啟用', value: 1 }
            ]
            self.itemData = {};
            self.selectItemStatus = self.status[1];
            self.itemData.cate_status = 1;
            self.selectedAll = false;

            self.editPage       = '/{{$use_end}}/{{$content_table}}/'; 
            self.listUrl        = '/{{$use_end}}/api/{{$content_table}}/management/cmsType/show';
            self.addUrl         = '/{{$use_end}}/api/{{$content_table}}/management/cmsType/add';
            self.deleteUrl      = '/{{$use_end}}/api/{{$content_table}}/management/cmsType/delete';
            self.saveUrl        = '/{{$use_end}}/api/{{$content_table}}/management/cmsType/save';
            self.setStatusUrl   = '/{{$use_end}}/api/{{$content_table}}/management/cmsType/setStatus';
            self.langsUrl       = '/api/lang';
            self.go_edit = function(id){
                location.href = self.editPage + id;
            }

            self.getlangs = function(){
                $http({
                    method: "get",
                    url: self.langsUrl,
                }).success(function(data) {
                    // console.log(data)
                    self.langs = data.langs;
                }).error(function() {
                    $.toaster({ message : '錯誤', priority : 'danger' });
                }) //error
            }
            self.getlangs();

            self.changeStatus = function(item){
                status = item.cate_status==0 ? 1 : 0;
                self.setStatusItem([item.id], status);
            }
            self.setStatus = function(status) {
                var ids = self.checkAllItem(ids);
                self.setStatusItem(ids, status);
            };

            self.add = function() {
                self.actionType = 'add';
                self.resetItem();
            };

            self.edit = function(item) {
                console.log(item)
                self.actionType = 'edit';
                self.itemData = item;
                self.selectItemStatus = self.status[item.cate_status];
            };


            self.delete = function() {
                // console.log('delete')
                var ids = [];
                self.selectedAll = false;
                angular.forEach(self.items, function(item) {
                    if (item.selected) {
                        ids.push(item.id);
                    }
                });
                var data = { 'ids': ids};
                self.actionItem("put", self.deleteUrl, data);
            };
            // //======= area  end=======

            self.changedListLang = function() {
                if (self.selectLangItem === null) {
                    self.selectLangItem = 0;
                }
                self.getItems();
            }

            self.checkAllItem = function(ids) {
                var ids = [];
                self.selectedAll = false;
                angular.forEach(self.items, function(item) {
                    if (item.selected) {
                        ids.push(item.id);
                    }
                });
                return ids;
            };

            self.resetItem = function() {
                self.itemData = {};
                self.selectItemStatus = self.status[1];
                self.itemData.cate_status = 1;
                self.itemData.lang_id = self.langs[0]['lang_id'];
            }

            self.clearSearch = function() {
                self.currentPage = 1;
                self.selectedAll = false;
                self.searchText = '';
                self.selectLangItem = 0;
                self.resetItem()
                self.getItems();
            }

            self.closeModal = function() {
                self.actionType = 'add';
                self.resetItem();
            }

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

        ////////////////////////////////////////////////////////////////////////////////////////
            self.itemSatausChange = function() {
                self.itemData.cate_status = self.selectItemStatus.value;
                // console.log(self.itemData.cate_status)
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
            //CRUD ====== start ======


            self.addItem = function() {
                // console.log(self.itemData)
                if (typeof(self.itemData.cms_type_name) == 'undefined' || self.itemData.cms_type_name == '') {
                    $.toaster({message:"母模板名稱為必填", priority:'warning'});
                    return false;
                }
                // if (typeof(self.itemData.cate_tag_desc) == 'undefined' || self.itemData.cate_tag_desc == '\n') {
                //     self.itemData.cate_tag_desc = '';
                // }
                var data = { 'item': self.itemData };
                self.actionItem("post", self.addUrl, data);
            }

            self.saveItem = function() {
                // if (typeof(self.itemData.cate_tag_desc) == 'undefined' || self.itemData.cate_tag_desc == '\n') {
                //     self.itemData.cate_tag_desc = '';
                // }
                var data = { 'item': self.itemData };
                self.actionItem("put", self.saveUrl, data);
            }

            /////////////////////////////////////////////////////////////////

            self.setStatusItem = function(ids, status) {
                var data = { 'ids': ids, status: status };
                // console.log(data)
                self.actionItem("put", self.setStatusUrl, data);
            }
            /////////////////////////////////////////////////////////////////

            self.actionItem = function(method, url, data) {
                $http({
                    method: method,
                    url: url,
                    data: data
                }).success(function(data) {
                  console.log(data)
                    if (data.status == '200') {
                        self.getItems();
                        // window.location.reload();
                        // self.actionType = 'add';
                        // self.resetItem();
                        // self.getItems();
                    } else {
                        alert('資料庫無回應');
                    }
                }).error(function() {
                    alert('錯誤');
                }) //error
            }

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
                    self.count = data.count;
                    self.pageCount = data.pageCount;
                    self.items = data.items;
                    // self.langs = data.langs;
                    // self.editLangs = data.editLangs;
                    // self.itemData.lang_id = data.langs[0]['lang_id'];
                }).error(function() {
                    alert('錯誤');
                }) //error
            }
            self.getItems();
            //CRUD ====== end =======
        }])
    </script>
@endsection



