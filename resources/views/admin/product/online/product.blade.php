@extends('layouts.masterAdmin')

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
    <div class="container-fluid" style="padding: 0px;">
        <div class="row bg-light no-gutters pageHeader">
            <div class="col-12 clearfix mb-2">
                <!-- <select id="lang_select" class="use-form-control maxWidth pdSpacing form-control b-radius-0" ng-model='contCtrl.selectLangItem' ng-change="contCtrl.changedListLang()" ng-options="option.lang_id as option.lang_word for option in contCtrl.langs">
                    <option ng-selected="true" value="">選擇語系</option>
                </select> -->
                <div class="d-inline-block">
                    <!-- tag下拉選 -->
                    <select class="use-form-control" style="width: 150px;" ng-model='contCtrl.categorySel' ng-options="option.cate_tag_id as option.cate_name for option in contCtrl.categoryList">
                        <option value="">選擇分類</option>
                    </select>

                    <!-- shelf下拉選 -->
                    <select class="use-form-control pdSpacing" style="width: 100px;" ng-model='contCtrl.prodStateSel_shelf' ng-options="option.value as option.name for option in contCtrl.prodOption_shelf">
                        <option ng-selected="true" value="">上下架</option>
                    </select>

                    <!-- promote下拉選 -->
                    <!-- <select class="use-form-control pdSpacing" style="width: 100px;" ng-model='contCtrl.prodStateSel_promote' ng-options="option.value as option.name for option in contCtrl.prodOption_promote">
                        <option ng-selected="true" value="">推薦</option>
                    </select> -->

                    <!-- sale下拉選 -->
                    <!-- <select class="use-form-control pdSpacing" style="width: 120px;" ng-model='contCtrl.prodStateSel_sale' ng-options="option.value as option.name for option in contCtrl.prodOption_sale">
                        <option ng-selected="true" value="">可否購買</option>
                    </select> -->
                </div>
                <div class="d-inline-block">
                    <input class="use-form-control" style="width: 150px;" type='text' ng-model='contCtrl.searchText' placeholder="請填入搜尋主列表" />
                    <div class="d-inline-block">
                        <span> <a href="" ng-click='contCtrl.getItems()'>搜尋</a></span>
                        <span> |</span>
                        <span> <a href="" ng-click='contCtrl.clearSearch()'>清除搜尋</a></span>
                    </div>
                </div>
                <p><span class="mark-use">各分類有獨立的排序可設定，請使用分類下拉選篩選進行搜尋，並於搜尋結果頁修改排序</span></p>
            </div>
            <div class="col-lg-6 col-12 clearfix mb-2">
                <div class="admin-receivingMailBox">
                    <a href="/admin/product/@{{contCtrl.productNum}}/add" class="addNewBtn btn-use"><span>新增</span></a>
                </div>
            </div>

            <div class="col-lg-6 clearfix mb-2">
                <div class="float-lg-right">
                    <span> 共<span ng-bind="contCtrl.count"></span>項</span>
                    <span>
                        <input class="use-form-control pdSpacing" style='width:50px;' type='text' ng-model="contCtrl.currentPage" ng-keydown="$event.keyCode === 13 && contCtrl.goto()" ng-blur="contCtrl.goto()"  ng-focus="contCtrl.textRecording(contCtrl.currentPage)">/@{{contCtrl.pageCount}}
                    </span>
                    <span> <a href="" ng-click='contCtrl.prePage()'>上一頁</a></span>
                    <span> <a href="" ng-click='contCtrl.nextPage()'>下一頁</a></span>
                </div>
            </div>
        </div>

        <div>
            <table class="table table-bordered admin-table-rwd form">
              <thead>
                    <tr class="admin-tr-only-hide">
                        <th scope="col">所屬分類</th>
                        <th class="w-20px" scope="col"><input type="checkbox" ng-model="contCtrl.selectedAll" ng-click="contCtrl.checkAll()" /></th>
                        <th class="w-50px" scope="col">編碼</th>
                        <th scope="col">建立日期</th>
                        <th class="w-65px" scope="col">狀態</th>
                        <th class="w-80px" scope="col">報名狀態</th>
                        <th scope="col">班別</th>
                        <th scope="col">梯別</th>
                        <th scope="col">介紹內容</th>
                        <th scope="col">編輯EDM</th>
                        <th scope="col">報名網址</th>
                        <th class="w-80px cleear-fix" ng-show="contCtrl.allClassShow">
                            <span class="float-left">總排序</span>
                        </th>
                        <th class="w-80px cleear-fix" ng-show="contCtrl.singleClassShow">
                            <span class="float-left">分類排序</span>
                        </th>
                    </tr>
              </thead>
              <tbody>
                    <tr ng-repeat="(key ,item) in contCtrl.items">
                        <td data-th="所屬分類">
                            <p ng-repeat="tag_name in item.tag_with_layer_name" ng-bind="tag_name"></p>
                        </td>
                        <td data-th="項目"><input type="checkbox" ng-model="item.selected" ng-click="contCtrl.checkWatch()" /></td>
                        <td data-th="編碼">
                            <span ng-bind="(key+1)+(contCtrl.currentPage -1)*contCtrl.countOfPage" proId="@{{item.prod_id}}"></span>
                        </td>
                        <td data-th="建立日期" ng-bind="item.created_at.slice(0,10)"></td>
                        <td data-th="狀態">
                            <span ng-disabled="@{{item.prod_shelf == 1? 'item.itemColor =false': 'item.itemColor=true'}}" ng-class="{true: 'item_enable', false: 'item_disable'}[item.itemColor]" ng-click="contCtrl.changeStatus(item.prod_id,item.prod_shelf,'prod_shelf')">
                                <span class="myMOUSE" ng-bind="contCtrl.status[item.prod_shelf].name"></span>
                            </span>
                        </td>
                        <td data-th="報名狀態" ng-bind="item.prod_main_sku"></td>
                        <td data-th="班別"><a class="editInfor w-100 d-inline-block" href="/admin/product/edit/detail/{{$productNum}}/@{{item.prod_id}}" target="_blank"><span ng-bind="item.prod_name"></span></a></td>
                        <td data-th="梯別" ng-bind="item.prod_subtitle"></td>
                        <td data-th="介紹內容" ng-bind="item.product_property[0]['prod_prop']"></td>
                        <td data-th="編輯EDM"><a class="editInfor d-inline-block" href="/admin/product_cms/@{{item.prod_id}}" target="_blank">點我編輯</a></td>
                        <td data-th="報名網址">
                            <a ng-bind="'http://{{$_SERVER['HTTP_HOST']}}/'+item.prod_id+'/online_page.html'" target="_blank"
                               href="http://{{$_SERVER['HTTP_HOST']}}/@{{item.prod_id}}/online_page.html"></a>
                        </td>
                        <td data-th="總排序" ng-show="contCtrl.allClassShow">
                            <input class="use-form-control pdSpacing maxWidth" type="text" ng-model="item.prod_order" ng-blur="contCtrl.changOrder(item)"  ng-focus="contCtrl.textRecording(item)">
                        </td>
                        <td data-th="分類排序" ng-show="contCtrl.singleClassShow">
                            <input class="use-form-control pdSpacing maxWidth" type="text" ng-model="item.category_order" ng-blur="contCtrl.changClassOrder(item)"  ng-focus="contCtrl.textRecording(item)">
                        </td>
                    </tr>
              </tbody>
            </table>
            <div class="row pageHeader">
                <div class="col-lg-6 clearfix">
                    <div class="admin-receivingMailBox">
                        <select class="use-form-control w-120px" ng-model='contCtrl.selectColumItem' ng-options="option.value as option.name for option in contCtrl.columItem"></select>
                        <a href="javascript:void(0);" class="disableBtn btn-use" ng-click='contCtrl.setStatus(1)'><span>啟用/上架</span></a>
                        <a href="javascript:void(0);" class="enablewBtn btn-use" ng-click='contCtrl.setStatus(0)'><span>停用/下架</span></a>
                        <a href="javascript:void(0);" class="deleteBtn btn-use" ng-click='contCtrl.remove()'>刪除</a>
                    </div>
                </div>
                <div class="col-lg-6" >
                    <div class="float-lg-right">
                        <span> 共<span ng-bind="contCtrl.count"></span>項</span>
                        <span>
                            <input class="use-form-control pdSpacing" style='width:50px;' type='text' ng-model="contCtrl.currentPage" ng-keydown="$event.keyCode === 13 && contCtrl.goto()" ng-blur="contCtrl.goto()"  ng-focus="contCtrl.textRecording(contCtrl.currentPage)">/@{{contCtrl.pageCount}}
                        </span>
                        <span> <a href="" ng-click='contCtrl.prePage()'>上一頁</a></span>
                        <span> <a href="" ng-click='contCtrl.nextPage()'>下一頁</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- 自定義 javascript -->
@section('javascript')
    <script>
        var Request = new Object();  
        Request = GetRequest();
        function GetRequest() {      
             var url = location.search; 
             var theRequest = new Object();      
             if (url.indexOf("?") != -1) {       
                var str = url.substr(1);         
                strs = str.split("&");       
                for(var i = 0; i < strs.length; i++) {       
                   theRequest[strs[i].split("=")[0]]=decodeURI(strs[i].split("=")[1]);       
                }        
             }       
             return theRequest;      
        }
    </script>
    <link href="/css/datetimepicker/angular-datetime-picker.css" rel="stylesheet">
    <script src="/js/datetimepicker/moment.2.11.2.min.js" type="text/javascript"></script>
    <script src="/js/datetimepicker/angular-datetime-picker.js" type="text/javascript"></script>
    <script type="text/javascript">
        var app = angular.module('app', ['angular.circular.datetimepicker']);
        app.controller('ContentController', ['$scope','$http', function($scope,$http) {
            var currentPath = window.location.pathname;
            var currPathAry = currentPath.split("/");
            var self = this;
            self.productNum = currPathAry[3];

            //======= area start=======
            if (self.productNum == 'property') {
                self.productNum = currPathAry[4];
                self.listUrl = '/admin/api/product/find/' + self.productNum;
            } else {
                self.listUrl = '/admin/api/product/find/' + self.productNum;
            }
            self.changeStatusUrl = '/admin/api/product/status';
            self.setStatusUrl = '/admin/api/product/status/multiple';
            self.prodImgPath = '/upload/product/';
            self.currentPage = 1;
            self.countOfPage = 20;
            self.searchText = '';
            self.actionType = 'add';
            self.selectLangItem = get_record_lang();
            self.promote = [
                { name: '無', value: 0 },
                { name: '有', value: 1 }
            ]
            self.status = [
                { name: '下架', value: 0 },
                { name: '上架', value: 1 }
            ]
            self.sale = [
                { name: '停用', value: 0 },
                { name: '啟用', value: 1 }
            ]
            
            self.columItem = [
                { id: 2, name: '狀態', value: 'prod_shelf' },
                { id: 1, name: '推薦', value: 'promote_prod' },
                { id: 3, name: '可否購買', value: 'prod_sale' }
            ]
            self.prodOption_shelf = [
                { name: '上架', value: 1 },
                { name: '下架', value: 0 },
            ];
            self.prodOption_promote = [
                { name: '推薦', value: 1},
                { name: '無推薦', value: 0},
            ];
            self.prodOption_sale = [
                { name: '可購買', value: 1},
                { name: '不可購買', value: 0},
            ];

            self.selectColumItem = self.columItem[0].value;
            let searchTag =Request["searchTag"];
            self.categorySel = searchTag !=null?parseInt(searchTag): '';

            self.changeClassSelect =function(){
                // console.log(self.categorySel);
                if(self.categorySel == '' || self.categorySel == null){
                    self.allClassShow =true;
                    self.singleClassShow =false;
                }else{
                    self.allClassShow =false;
                    self.singleClassShow =true;
                }
            }

            self.prodStateSel_shelf = '';
            self.prodStateSel_promote = '';
            self.prodStateSel_sale = '';

            self.categoryTagOptions = [];
            self.itemData = {};
            // self.itemData.cate_status = 0;
            self.selectedAll = false;

            self.setStatus = function(status) {
                var ids = self.checkAllItem(ids);
                if (ids.length > 0) {
                    self.setStatusItem(ids, status);
                } else {
                    $.toaster({ message : '請選擇項目',  priority : 'warning'})
                }
            };

            self.itemLangChange = function() {
                var options = [];
                angular.forEach(self.categoryTags, function(item) {
                    if (item.lang_id == self.itemData.lang_id) {
                        options.push(item);
                    }
                });
                self.categoryTagOptions = options;
                self.itemData.cate_tag_id = options[0].cate_tag_id;
            }

            self.remove = function() {
                var ids = self.checkAllItem(ids);
                if (ids.length > 0) {
                    if (confirm("確定刪除？")) {
                        self.deleteItem(ids);
                    }
                }else{
                    $.toaster({ message : '請選擇項目',  priority : 'warning'})
                }
            };
            //======= area  end=======

            self.changedListLang = function() {
                if (self.selectLangItem === null) {
                    self.selectLangItem = '';
                }
                self.currentPage=1;

                self.getCategory(self.selectLangItem);
                self.getItems();
            }

            self.checkAllItem = function(ids) {
                var ids = [];
                self.selectedAll = false;
                angular.forEach(self.items, function(item) {
                    if (item.selected) {
                        ids.push(item.prod_id);
                    }
                });

                return ids;
            };

            self.resetItem = function() {
                self.itemData = {};
                self.selectItemStatus = self.status[0];
                self.itemData.lang_id = self.langs[0]['lang_id'];
                // self.itemData.cate_status = 0;
                self.prodStateSel_shelf = '';
                self.prodStateSel_promote = '';
                self.prodStateSel_sale = '';
            }

            self.clearSearch = function() {
                self.currentPage = 1;
                self.selectedAll = false;
                self.searchText = '';
                self.selectLangItem = '';
                self.categorySel = ''

                self.resetItem()
                self.getCategory();
                self.getItems();
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

            // self.itemSatausChange = function() {
            //     self.itemData.cate_status = self.selectItemStatus.value;
            // };
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
            self.setStatusItem = function(ids, status) {
                var data = { 'ids': ids, 'status': status, 'type': self.selectColumItem };
                self.actionItem("put", self.setStatusUrl, data);
            }

            self.changeStatus = function(id, status, type) {
                if (status == 0) {
                    status = 1;
                } else if (status == 1) {
                    status = 0;
                }
                var data = { 'productId': id, 'status': status, 'type': type };
                self.actionItem("put", self.changeStatusUrl, data);
            }

            self.textRecording = function(item) {
                self.contrastContent="";
                self.contrastContent = angular.copy(item, self.contrastContent);            
            }

            self.changOrder = function(item) {
                if(isNaN(item.prod_order) ){
                    self.getItems();
                    $.toaster({ message : '排序請填入數字',  priority : 'warning'})
                    return false;
                }
                $scope.result = angular.equals(self.contrastContent, item);
                if(!$scope.result){
                    $http({
                        method: "put",
                        url: "/admin/api/product/" + item.prod_id,
                        data: { 'item': item ,'productNum': self.productNum },
                    }).success(function(data) {
                        if (data.status == '200') {
                            self.getItems();
                            $.toaster({ message : '修改成功'})
                        } else {
                            $.toaster({ message : '網路錯誤', priority : 'danger' });
                        }
                    }).error(function() {
                        $.toaster({ message : '發生錯誤', priority : 'danger' });
                    }) //error
                }
            } //self.changOrder = function()

            self.changClassOrder = function(item) {
                if(isNaN(item.category_order) ){
                    self.getItems();
                    $.toaster({ message : '排序請填入數字',  priority : 'warning'})
                    return false;
                }

                $scope.result = angular.equals(self.contrastContent, item);
                if(!$scope.result){
                    $http({
                        method: "put",
                        url: "/admin/api/product/category/order/" + item.prod_id,
                        data: { 'item': item ,'productNum': self.productNum },
                    }).success(function(data) {
                        // console.log(data)
                        if (data.status == '200') {
                            self.getItems();
                            $.toaster({ message : '修改成功'})
                        } else {
                            $.toaster({ message : '網路錯誤', priority : 'danger' });
                        }
                    }).error(function() {
                        $.toaster({ message : '發生錯誤', priority : 'danger' });
                    }) //error
                }
            } //self.changOrder = function()

            self.reload = function(){  
                location.reload();
            }

            self.actionItem = function(method, url, data) {
                // console.log(data);
                $http({
                    method: method,
                    url: url,
                    data: data
                }).success(function(data) {
                    if (data.status == '200') {
                        // console.log(data);
                        self.resetItem();
                        self.getItems();
                        $.toaster({ message : '修改成功'})
                    } else {
                        $.toaster({ message : '資料庫無回應',  priority : 'warning'})
                    }
                }).error(function() {
                    $.toaster({ message : '發生錯誤', priority : 'danger' });
                }) //error
            }

            // Pagination localStorage start -------------------------------------------
            if(localStorage.getItem("{{$_SERVER['REQUEST_URI']}}") != null ){
                self.currentPage = localStorage.getItem("{{$_SERVER['REQUEST_URI']}}");
            }else{
                // localStorage.clear();
                localStorage.setItem( "{{$_SERVER['REQUEST_URI']}}" , null);
            }

            self.setPage = function(page) {
                localStorage.setItem( "{{$_SERVER['REQUEST_URI']}}" ,page);
            }
            // -------------------------------------------------------------------------

            self.getlangs = function(){
                $http({
                    method: "get",
                    url: '/admin/api/lang',
                }).success(function(data) {
                    // console.log(data)
                    self.langs = data.langs;
                    self.itemData.lang_id = data.langs[0]['lang_id'];
                }).error(function() {
                    $.toaster({ message : '錯誤', priority : 'danger' });
                }) //error
            }
            self.getlangs();

            self.getItems = function() {
                self.changeClassSelect();
                var data = {
                    'langId': self.selectLangItem,
                    'shelf': self.prodStateSel_shelf,
                    'promote': self.prodStateSel_promote,
                    'sale': self.prodStateSel_sale,
                    'cate_tag_id': self.categorySel,
                    'searchByText': self.searchText,
                    'currentPage': self.currentPage,
                    'countOfPage': self.countOfPage,
                };
                // Pagination localStorage start -------------------------------------------
                self.setPage(self.currentPage);
                // -------------------------------------------------------------------------
                // console.log(data);
                $http({
                    method: "post",
                    url: self.listUrl,
                    data: data
                }).success(function(data) {
                    // console.log(data)
                    self.count = data.count;
                    self.pageCount = data.pageCount;
                    self.items = data.items;
                    angular.forEach(self.items, function(item) {
                        item.prod_order = parseInt(item.prod_order);
                        item.prod_img = self.prodImgPath + item.prod_id + '/' + item.prod_img;
                    });
                }).error(function() {
                    $.toaster({ message : '發生錯誤', priority : 'danger' });
                }) //error
            }
            self.getItems();


            self.getCategory = function(lang_id) {
                $http({

                    method: "post",
                    data:{
                        selectLangItem : lang_id,
                        productNum : self.productNum,
                    },
                    url: "/admin/api/categoryTag/hierarchy/show"
                }).success(function(data) {
                    // console.log(data.categoryTags)
                    self.categoryList = data.items;
                }).error(function() {
                }) //error
            }
            self.getCategory(self.selectLangItem);


            self.deleteItem = function(ids) {
                // console.log(ids);
                $http({
                    method: "put",
                    url: "/admin/api/product/delete",
                    data: { productId: ids },
                }).success(function(data) {
                    if (data.status == '200') {
        				$.toaster({ message : '資料已刪除'});
                        location.reload();
                    } else {
                        $.toaster({ message : data.msg , priority : 'danger' });
                    }
                }).error(function() {
                    $.toaster({ message : '發生錯誤', priority : 'danger' });
                }) //error
            }
            //CRUD ====== end =======

            self.goto = function() {
                if (self.currentPage <= 0) {
                    self.currentPage = 1;
                    $.toaster({ message : '頁數需大於 0',  priority : 'warning'})
                    self.currentPage = self.contrastContent;
                } else if (self.currentPage > self.pageCount) {
                    $.toaster({ message : '頁數需小於於總頁數 : ' + self.pageCount,  priority : 'warning'})
                    self.currentPage = self.contrastContent;
                } else {
                    self.getItems();
                }

            } //self.goto
        }]);
    </script>
@endsection