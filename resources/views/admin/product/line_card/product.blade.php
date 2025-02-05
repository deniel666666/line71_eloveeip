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
            <div class="col-lg-6 clearfix mb-2">
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
                </div>
                <div class="d-inline-block">
                    <input class="use-form-control" style="width: 150px;" type='text' ng-model='contCtrl.searchText' placeholder="請填入搜尋主列表" />
                    <div class="d-inline-block">
                        <span> <a href="" ng-click='contCtrl.getItems()'>搜尋</a></span>
                        <span> |</span>
                        <span> <a href="" ng-click='contCtrl.clearSearch()'>清除搜尋</a></span>
                    </div>
                </div>
                <p class="mb-0"><span class="mark-use">各人員有獨立的排序可設定，請使用人員下拉選篩選進行搜尋，並於搜尋結果頁修改排序</span></p>
            </div>
         

            <div class="col-lg-6 clearfix mb-2 d-flex justify-content-end align-items-end">
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
        <div class="mb-2">
            <div class="admin-receivingMailBox mb-2">
                <a href="/admin/product/@{{contCtrl.productNum}}/add" class="addNewBtn btn-use"><span>新增</span></a>
            </div>
        </div>
        <div>
            <div class="admin-receivingMailBox">
                <label for="selected_all" class="m-0 btn btn-primary d-md-none" style="cursor: pointer;">全選</label>
                <a href="###" ng-click="contCtrl.send_line_card()" class="addNewBtn btn-use bg-success mr-2"><span>寄送LINE電子名片</span></a>
                <a href="###" ng-click="contCtrl.copy_card()" class="addNewBtn btn-use bg-warning mr-2"><span>複製名片</span></a>
            </div>
            <table class="table table-bordered admin-table-rwd form">
              <thead>
                    <tr class="admin-tr-only-hide">
                        <th class="" scope="col" style="width:60px">
                            <input id="selected_all" type="checkbox" ng-model="contCtrl.selectedAll" ng-click="contCtrl.checkAll()" />
                            <label for="selected_all" class="m-0" style="cursor: pointer;">全選</label>
                        </th>
                        <!-- <th class="w-50px" scope="col">編碼</th> -->
                        <th class="w-65px" scope="col">狀態</th>
                        <th class="w-140px" scope="col">圖片</th>
                        <th scope="col">編輯</th>
                        <th class="w-180px" scope="col">當前版型</th>
                        <th scope="col">所屬人員</th>
                        <th scope="col">分類</th>
    					<th class="w-80px cleear-fix" ng-show="contCtrl.allClassShow">
                            <span class="float-left">總排序</span>
                        </th>
    					<th class="w-80px cleear-fix" ng-show="contCtrl.singleClassShow">
                            <span class="float-left">人員排序</span>
                        </th>
                    </tr>
              </thead>
              <tbody>
                    <tr ng-repeat="(key ,item) in contCtrl.items">
                        <td data-th="項目">
                            <input type="checkbox" ng-model="item.selected" ng-click="contCtrl.checkWatch()" />
                        <!-- </td>
                        <td data-th="編碼"> -->
                            <span ng-bind="(key+1)+(contCtrl.currentPage -1)*contCtrl.countOfPage" proId="@{{item.prod_id}}"></span>
                        </td>
                        <td data-th="狀態">
                            <span ng-disabled="@{{item.prod_shelf == 1? 'item.itemColor =false': 'item.itemColor=true'}}" ng-class="{true: 'item_enable', false: 'item_disable'}[item.itemColor]" ng-click="contCtrl.changeStatus(item.prod_id,item.prod_shelf,'prod_shelf')">
                                <span class="myMOUSE" ng-bind="contCtrl.status[item.prod_shelf].name"></span>
                            </span>
                        </td>
                        <td data-th="圖片">
                            <!-- 主圖 -->
                            <a href="/admin/product/edit/detail/{{$productNum}}/@{{item.prod_id}}" class="d-block adminImg-responsive-4halfBy3" ng-style="{'background-image': 'url('+item.prod_img+')'}"></a>
                            <!-- 多圖上傳作 -->
                            <!-- <div class="adminImg-responsive-4halfBy3" 
                                 ng-if="item.productImg.length>0"
                                 ng-style="{'background-image': 'url(/upload/product/' + item.prod_id + '/' + item.productImg[0].prod_img_name + ')'}"></div> -->
                        </td>
                        <td data-th="標題(編輯)"><a class="editInfor d-inline-block" href="/admin/product/edit/detail/{{$productNum}}/@{{item.prod_id}}">編輯</a></td>
                        <td data-th="當前版型">
                            
                            <div class="d-flex flex-wrap">

                                <div class="mr-2" ng-if="item.style==1">個人介紹</div>
                                <div class="mr-2" ng-if="item.style==2">官網介紹</div>
                                <div class="mr-2" ng-if="item.style==3">專業版型一</div>
                                <div class="mr-2" ng-if="item.style==4">專業版型二</div>
                                <!-- <div class="mr-2" ng-if="item.style==5">更多聯絡</div> -->
                                <div class="mr-2" ng-if="item.style==6">全版無廣告</div>
                                <div class="mr-2" ng-if="item.style==7">奧斯丁</div>
                                <!-- <div class="mr-2">
                                    <input type="radio" ng-model="item.layout" ng-change="setLayout(item.prod_id,1)" value="1" id="style_one_@{{item.prod_id}}">
                                    <label for="style_one_@{{item.prod_id}}">個人介紹</lable>
                                </div>
                                <div class="mr-2">
                                    <input type="radio" ng-model="item.layout" ng-change="setLayout(item.prod_id,2)" value="2" id="style_two_@{{item.prod_id}}">
                                    <label for="style_two_@{{item.prod_id}}">官網介紹</lable>
                                </div>
                                <div class="mr-2">
                                    <input type="radio" ng-model="item.layout" ng-change="setLayout(item.prod_id,3)" value="3" id="style_three_@{{item.prod_id}}">
                                    <label for="style_three_@{{item.prod_id}}">專業版型一</lable>
                                </div>
                                <div class="mr-2">
                                    <input type="radio" ng-model="item.layout" ng-change="setLayout(item.prod_id,4)" value="4" id="style_four_@{{item.prod_id}}">
                                    <label for="style_four_@{{item.prod_id}}">專業版型二</lable>
                                </div>
                                <div class="mr-2">
                                    <input type="radio" ng-model="item.layout" ng-change="setLayout(item.prod_id,5)" value="5" id="style_five_@{{item.prod_id}}">
                                    <label for="style_five_@{{item.prod_id}}">更多聯絡</lable>
                                </div> -->
                            </div>
                        </td>
                        <td data-th="分類">
                            <p ng-bind="item.user_name"></p>
                        </td>
                        <td data-th="擁有者">
                            <p ng-repeat="tag_name in item.tag_with_layer_name" ng-bind="tag_name"></p>
                        </td>
                        <td data-th="總排序" ng-show="contCtrl.allClassShow">
                            <input class="use-form-control pdSpacing maxWidth" type="text" ng-model="item.prod_order" ng-blur="contCtrl.changOrder(item)"  ng-focus="contCtrl.textRecording(item)">
                        </td>
                        <td data-th="人員排序" ng-show="contCtrl.singleClassShow">
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
         /*計算圖片寬高比*/
        function getAspectRatio(image_url, type="") {
            return new Promise((resolve, reject) => {
                let img = new Image()
                img.onload = () => {
                    const w = img.naturalWidth;
                    const h = img.naturalHeight;
                    let aspectRatio;
                    if (type=='ratio_text') {
                        aspectRatio = '20:' + Math.round(h/w*20);
                    }else{
                        aspectRatio = `${w}:${h}`;
                    }
                    resolve([aspectRatio, w, h]);
                }
                img.onerror = reject
                img.src = image_url;
            })
        };

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
            self.setLayoutUrl = '/admin/api/product/setlayout';
            self.prodImgPath = '/upload/product/';
            self.currentPage = 1;
            self.countOfPage = 999;
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
                // { id: 1, name: '推薦', value: 'promote_prod' },
                // { id: 3, name: '可否購買', value: 'prod_sale' }
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
            self.line_card_categorySel = searchTag !=null?parseInt(searchTag): '';

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
            $scope.setLayout = function(prod_id,style) {
                
                var data = { 'prod_id': prod_id, 'style': style };
                self.actionItem("post", self.setLayoutUrl, data);
                
            };
            
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
                self.line_card_categorySel = '';

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
                self.line_card_categorySel = self.categorySel;
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
                    // console.log(self.items);
                    angular.forEach(self.items, function(item) {
                        //console.info(item.style);
                        item.prod_order = parseInt(item.prod_order);
                        item.prod_img = self.prodImgPath + item.prod_id + '/' + item.prod_img;
                        
                        if(item.style=='1'){
                            item.layout = "1";
                        }else if(item.style=='2'){
                            item.layout = "2";
                        }else if(item.style=='3'){
                            item.layout = "3";
                        }else if(item.style=='4'){
                            item.layout = "4";
                        }else if(item.style=='5'){
                            item.layout = "5";
                        }else if(item.style=='6'){
                            item.layout = "6";
                        }else if(item.style=='7'){
                            item.layout = "7";
                        }
                        
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
                    // console.log(data.categoryTags);
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

            self.send_line_card = function(){
                var ids = self.checkAllItem(ids);
                if(ids.length==0){
                    $.toaster({ message : '請選擇要分享的名片',  priority : 'warning'}); return;
                }
                $('#block_area').show();
              
                var data = {
                    'langId': self.selectLangItem,
                    'shelf': '1',
                    'cate_tag_id': self.line_card_categorySel,
                    'includeIds': JSON.stringify(ids)
                };
                $http({
                    method: "post",
                    url: self.listUrl,
                    data: data
                }).success(async function(data) {
                    id_array = [];
                    card_array = [];
                    card_style = [];
                    var colorRegexp = /#[0-9,A-F,a-f]{6}/gi;
                    // var uriRegexp = /https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()!@:%_\+.~#?&\/\/=]*)/gi;
                    var uriRegexp = /(?:https?:\/\/(?:www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()!@:%_\+.~#?&\/\/=]*)|tel:\+886-(\d{1,2}-\d{6,8}|9\d{8})|mailto:[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})/gi;

                    cards = data.items;
                    // console.log(cards);
                    if(cards.length > 12){
                        $('#block_area').hide();
                        $.toaster({ message : '一次最多寄送12張名片，請重新選擇',  priority : 'warning'}); return;
                    }
                    for (var i = 0; i < cards.length; i++) {
                        // console.log(cards[i]);
                        id_array.push(cards[i].prod_id.toString());

                        // 名片樣式
                        card_layout = cards[i].style.toString();
                        card_style.push(card_layout);

                        // 預設顯示卡頭、卡身、卡尾
                        hero_flag = true;
                        card_body_flag = true;
                        card_footer_flag = true;

                        // 補足屬性欄位，避免什麼都沒填時出錯
                        patch = Array(30 - cards[i].product_property.length).fill({});
                        cards[i].product_property = cards[i].product_property.concat(patch);

                        // 卡頭連結
                        heroUri = cards[i].prod_main_sku ? cards[i].prod_main_sku : "";

                        // 卡身區塊底色
                        mainBackgroundColor = cards[i].prod_subtitle ? cards[i].prod_subtitle : "";
                        mainBackgroundColor = mainBackgroundColor.match(colorRegexp) ? mainBackgroundColor : "#000000";
                        
                        // 公司名
                        companyColor = "#ffffff";
                        if(cards[i].product_property[0]){
                            companyColor = cards[i].product_property[0].prod_prop ? cards[i].product_property[0].prod_prop : "";
                            companyColor = companyColor.match(colorRegexp) ? companyColor : "#ffffff";
                        }
                        companyTextSize = '';
                        if(cards[i].product_property[17] && cards[i].product_property[17].prod_prop){
                            let temp = cards[i].product_property[17].prod_prop.trim();
                            if(temp){ companyTextSize = temp + 'px'; }
                        }
                        
                        // 中文名
                        nameColor = "#ffffff";
                        if(cards[i].product_property[2]){
                            nameColor = cards[i].product_property[2].prod_prop ? cards[i].product_property[2].prod_prop : "";
                            nameColor = nameColor.match(colorRegexp) ? nameColor : "#ffffff";
                        }
                        nameTextSize = '';
                        if(cards[i].product_property[18] && cards[i].product_property[18].prod_prop){
                            let temp = cards[i].product_property[18].prod_prop.trim();
                            if(temp){ nameTextSize = temp + 'px'; }
                        }
                        
                        // 英文名
                        engNameColor = "#ffffff";
                        if(cards[i].product_property[10]){
                            engNameColor = cards[i].product_property[10].prod_prop ? cards[i].product_property[10].prod_prop : "";
                            engNameColor = engNameColor.match(colorRegexp) ? engNameColor : "#ffffff";
                        }
                        engNameTextSize = '';
                        if(cards[i].product_property[19] && cards[i].product_property[19].prod_prop){
                            let temp = cards[i].product_property[19].prod_prop.trim();
                            if(temp){ engNameTextSize = temp + 'px'; }
                        }

                        // 職稱
                        positionColor = "#ffffff";
                        if(cards[i].product_property[6]){
                            positionColor = cards[i].product_property[6].prod_prop ? cards[i].product_property[6].prod_prop : "";
                            positionColor = positionColor.match(colorRegexp) ? positionColor : "#ffffff";
                        }
                        positionTextSize = '';
                        if(cards[i].product_property[20] && cards[i].product_property[20].prod_prop){
                            let temp = cards[i].product_property[20].prod_prop.trim();
                            if(temp){ positionTextSize = temp + 'px'; }
                        }

                        // 介紹文字
                        des1Color = "#ffffff";
                        if(cards[i].product_property[4]){
                            des1Color = cards[i].product_property[4].prod_prop ? cards[i].product_property[4].prod_prop : "";
                            des1Color = des1Color.match(colorRegexp) ? des1Color : "#ffffff";
                        }
                        des1TextSize = '';
                        if(cards[i].product_property[22] && cards[i].product_property[22].prod_prop){
                            let temp = cards[i].product_property[22].prod_prop.trim();
                            if(temp){ des1TextSize = temp + 'px'; }
                        }

                        // 社群文字1
                        socail1Color = "#ffffff";
                        if(cards[i].product_property[14]){
                            socail1Color = cards[i].product_property[14].prod_prop ? cards[i].product_property[14].prod_prop : "";
                            socail1Color = socail1Color.match(colorRegexp) ? socail1Color : "#ffffff";
                        }
                        social1TextSize = '';
                        if(cards[i].product_property[23] && cards[i].product_property[23].prod_prop){
                            let temp = cards[i].product_property[23].prod_prop.trim();
                            if(temp){ social1TextSize = temp + 'px'; }
                        }

                        // 社群文字2
                        socail2Color = "#ffffff";
                        if(cards[i].product_property[16]){
                            socail2Color = cards[i].product_property[16].prod_prop ? cards[i].product_property[16].prod_prop : "";
                            socail2Color = socail2Color.match(colorRegexp) ? socail2Color : "#ffffff";
                        }
                        social2TextSize = '';
                        if(cards[i].product_property[24] && cards[i].product_property[24].prod_prop){
                            let temp = cards[i].product_property[24].prod_prop.trim();
                            if(temp){ social2TextSize = temp + 'px'; }
                        }

                        // 卡尾區塊底色
                        footerBackgroundColor = "#000000";
                        if(cards[i].product_property[7]){
                            footerBackgroundColor = cards[i].product_property[7].prod_prop ? cards[i].product_property[7].prod_prop : "";
                            footerBackgroundColor = footerBackgroundColor.match(colorRegexp) ? footerBackgroundColor : "#000000";
                        }

                        // 標題
                        titleColor = "#ffffff";
                        if(cards[i].product_property[12]){
                            titleColor = cards[i].product_property[12].prod_prop ? cards[i].product_property[12].prod_prop : "";
                            titleColor = titleColor.match(colorRegexp) ? titleColor : "#ffffff";
                        }

                        let ratio_str = '0:0';
                        let img_width = 0;
                        let img_height = 0;
                        try {
                            [ratio_str, img_width, img_height] = await getAspectRatio(`//{{$_SERVER['HTTP_HOST']}}/public/upload/product/${cards[i].prod_id}/${cards[i].prod_img}`, 'ratio_text');
                        } catch (error) {
                            hero_flag = false;
                        }

                        // 卡頭(hero)架構
                        card_hero = {
                            "type": "image",
                            "size": "full",
                            "aspectRatio": ratio_str,
                            "aspectMode": "cover",
                            "url": `https://{{$_SERVER['HTTP_HOST']}}/public/upload/product/${cards[i].prod_id}/${cards[i].prod_img}`,
                        };
                        if (heroUri) {
                            card_hero["action"] = {
                                "type": "uri",
                                "uri": heroUri,
                            }
                        }

                        // 卡身架構
                        card_body = {
                            "type": "box",
                            "layout": "vertical",
                            "backgroundColor": mainBackgroundColor,
                            "contents": []
                        }

                        // 卡尾(按鈕區)架構
                        btn_array = [];
                        product_type = cards[i].product_type;
                        btn_height = 30, cornerRadius = 5;
                        for (var x = 0; x < product_type.length; x++) {
                            if (!product_type[x].prod_type || !product_type[x].prod_sn || !product_type[x].type_price) {
                                continue;
                            } else {
                                let style = product_type[x].prod_type,
                                label = product_type[x].type_price,
                                color = product_type[x].type_sales_price,
                                backgroundColor = product_type[x].type_sales_price_prime,
                                uri = product_type[x].prod_sn;

                                let btnColor, btnUri, action;

                                if (uri.match(uriRegexp)) {
                                    action = {
                                        "type": "uri",
                                        "label": label,
                                        "uri": uri,
                                    }
                                } else {
                                    action = {
                                        "type": "clipboard",
                                        "label": label,
                                        "clipboardText": uri,
                                    }
                                }

                                let box_cont = {
                                    "type": "box",
                                    "layout": "horizontal",
                                    "width": "100%",
                                    "height": btn_height + "px",
                                    "cornerRadius": cornerRadius + "px",
                                    "justifyContent": "center",
                                    "alignItems": "center",
                                    "contents": [
                                        {
                                            "type": "button",
                                            "style": "link",
                                            "height": "sm",
                                            "action": action,
                                        }
                                    ],
                                };

                                switch (style) {
                                    case 'primary':
                                        box_cont["contents"][0]["color"] = "#ffffff";
                                        if (color.match(colorRegexp)) {
                                            box_cont["backgroundColor"] = color;
                                        }
                                        break;
                                    case 'secondary':
                                        box_cont["contents"][0]["color"] = "#000000";
                                        if (color.match(colorRegexp)) {
                                            box_cont["backgroundColor"] = color;
                                        }
                                        break;
                                    // link
                                    default:
                                        if (color.match(colorRegexp)) {
                                            box_cont["contents"][0]["color"] = color;
                                        } else {
                                            box_cont["contents"][0]["color"] = "#ffffff";
                                        }

                                        if (backgroundColor.match(colorRegexp)) {
                                            box_cont["backgroundColor"] = backgroundColor;
                                        }
                                        break;
                                }

                                btn_array.push(box_cont);
                            }
                        }
                        // 有廣告的按鈕
                        let btn_array_has_ad =  btn_array.slice();
                        let ad_btn_area = {
                            "type": "box",
                            "layout": "horizontal",
                            "spacing": "sm",
                            "margin": "md",
                            "justifyContent": "flex-end",
                            "contents": [
                                {
                                    "type": "text",
                                    "text": "網頁設計",
                                    "color": "#ffffff",
                                    "action": {
                                    "type": "uri",
                                    "label": "action",
                                    "uri": "https://71com.tw/5/service"
                                    },
                                    "size": "12px",
                                    "flex": 0,
                                    "align": "end",
                                },
                                { "type": "text", "text": " ", "flex": 0, }, // 用一個空的 text 來製造空白
                                { "type": "text", "text": " ", "flex": 0, }, // 用一個空的 text 來製造空白
                                {
                                    "type": "text",
                                    "text": "商務名片",
                                    "color": "#ffffff",
                                    "action": {
                                    "type": "uri",
                                    "label": "action",
                                    "uri": "https://71com.tw/1/service"
                                    },
                                    "size": "12px",
                                    "flex": 0,
                                    "align": "end",
                                }
                            ],
                        };
                        btn_array_has_ad.push(ad_btn_area);
                        card_footer = {
                            "type": "box",
                            "layout": "vertical",
                            "spacing": "md",
                            "flex": 0,
                            "contents": btn_array_has_ad,
                            "backgroundColor": footerBackgroundColor,
                        };

                        // 客製樣式設定
                        switch (card_layout) {
                            case '1': /*個人介紹*/
                                card_body['backgroundColor'] = mainBackgroundColor;
                                card_body['spacing']="md";
                                card_body['contents'] = [
                                    {
                                        "type": "box",
                                        "layout": "vertical",
                                        "spacing": "sm",
                                        "contents": [
                                            {
                                                "type": "text",
                                                "text": cards[i].prod_name ? cards[i].prod_name : " ",
                                                "color": companyColor,
                                                "weight": "bold",
                                                "size": companyTextSize ? companyTextSize : 'sm',
                                                "wrap": true,
                                            },
                                            {
                                                "type": "box",
                                                "layout": "horizontal",
                                                "contents": [
                                                    {
                                                        "type": "text",
                                                        "wrap": true,
                                                        "contents": [
                                                            {
                                                                "type": "span",
                                                                "text": cards[i].product_property[1].prod_prop ? cards[i].product_property[1].prod_prop : " ",
                                                                "color": nameColor,
                                                                "weight": "bold",
                                                                "size": nameTextSize ? nameTextSize : 'lg',
                                                            },
                                                            { "type": "span", "text": " ",  },// 用一個空的 span 來製造空白
                                                            { "type": "span", "text": " ",  },// 用一個空的 span 來製造空白
                                                            { "type": "span", "text": " ",  },// 用一個空的 span 來製造空白
                                                            {
                                                                "type": "span",
                                                                "text": cards[i].product_property[9].prod_prop ? cards[i].product_property[9].prod_prop : " ",
                                                                "color": engNameColor,
                                                                "weight": "bold",
                                                                "size": engNameTextSize ? engNameTextSize : 'md',
                                                            }
                                                        ]
                                                    },
                                                ],
                                                "justifyContent": "flex-start",
                                                "alignItems": "flex-end",
                                            },
                                        ]
                                    },
                                    {
                                        "type": "box",
                                        "layout": "vertical",
                                        "offsetTop": "sm",
                                        "contents": [
                                            {
                                                "type": "text",
                                                "text": cards[i].product_property[3].prod_prop ? cards[i].product_property[3].prod_prop.replaceAll("\n", "<br>") : " ",
                                                "wrap": true,
                                                "size": des1TextSize ? des1TextSize : 'sm',
                                                "color": des1Color,
                                            },
                                        ],
                                    },
                                ];

                                if (cards[i].product_property[5].prod_prop != ' ') {
                                    card_body['contents'][0]['contents'].push({
                                        "type": "text",
                                        "text": cards[i].product_property[5].prod_prop,
                                        "size": positionTextSize ? positionTextSize : 'sm',
                                        "color": positionColor,
                                    });
                                }

                                let box_obj = {
                                    "type": "box",
                                    "layout": "horizontal",
                                    "offsetTop": "12px",
                                    "justifyContent": "center",
                                    "contents": [],
                                };
                                let img1, resp1, result1, contentType1, img2, resp2, result2, contentType2, blob;

                                if(cards[i].prod_img2 && cards[i].prod_img2.includes('.upload') == false){
                                    img1 = `//{{$_SERVER['HTTP_HOST']}}/public/upload/product/${cards[i].prod_id}/${cards[i].prod_img2}`;
                                    resp1 = await fetch(img1);
                                    result1 = resp1.ok;
                                    contentType1 = resp1.headers.get("Content-Type");
    
                                    if (result1 && contentType1.startsWith("image/")) {
                                        blob = await resp1.blob();
                                        if (blob.size > 17) {
                                            box_obj.contents.push({
                                                "type": "box",
                                                "layout": "vertical",
                                                "contents": [
                                                {
                                                    "type": "image",
                                                    "url": 'https:'+img1,
                                                    "aspectRatio": "20:20",
                                                    "aspectMode": "cover",
                                                    "size": "md"
                                                },
                                                {
                                                    "type": "text",
                                                    "text": cards[i].product_property[13].prod_prop ? cards[i].product_property[13].prod_prop : " ",
                                                    "color": socail1Color,
                                                    "size": social1TextSize ? social1TextSize : 'sm',
                                                }
                                                ],
                                                "alignItems": "center",
                                                "spacing": "sm"
                                            });
                                        }
                                    }
                                }
                                if(cards[i].prod_img3 && cards[i].prod_img3.includes('.upload') == false){
                                    img2 = `//{{$_SERVER['HTTP_HOST']}}/public/upload/product/${cards[i].prod_id}/${cards[i].prod_img3}`;
                                    resp2 = await fetch(img2);
                                    result2 = resp2.ok;
                                    contentType2 = resp2.headers.get("Content-Type");

                                    if (result2  && contentType2.startsWith("image/")) {
                                        blob = await resp2.blob();

                                        if (blob.size > 17) {
                                            box_obj.contents.push({
                                                "type": "box",
                                                "layout": "vertical",
                                                "contents": [
                                                {
                                                    "type": "image",
                                                    "url": 'https:'+img2,
                                                    "aspectRatio": "20:20",
                                                    "aspectMode": "cover",
                                                    "size": "md",
                                                },
                                                {
                                                    "type": "text",
                                                    "text": cards[i].product_property[15].prod_prop ? cards[i].product_property[15].prod_prop : " ",
                                                    "color": socail2Color,
                                                    "size": social2TextSize ? social2TextSize : 'sm',
                                                }
                                                ],
                                                "alignItems": "center",
                                                "spacing": "sm",
                                            });
                                        }
                                    }
                                }
                                if (box_obj.contents.length > 0) {
                                    card_body['contents'].push(box_obj);
                                }
                                break;
                            case '2': /*官網介紹*/
                                hero_flag = false;
                                card_body['paddingBottom']="md";
                                card_body['spacing']="lg";
                                card_body['contents'] =  [
                                    {
                                        "type": "box",
                                        "layout": "vertical",
                                        "cornerRadius": "lg",
                                        "contents": [
                                            {
                                                "type": "image",
                                                "url": `https://{{$_SERVER['HTTP_HOST']}}/public/upload/product/${cards[i].prod_id}/${cards[i].prod_img}`,
                                                "size": "full",
                                                "aspectMode": "cover",
                                                "aspectRatio": ratio_str,
                                            }
                                        ],
                                    },
                                    {
                                        "type": "text",
                                        "text": cards[i].product_property[11].prod_prop ? cards[i].product_property[11].prod_prop : " ",
                                        "weight": "bold",
                                        "size": companyTextSize ? companyTextSize : 'lg',
                                        "color": titleColor,
                                        "wrap": true,
                                    },
                                    {
                                        "type": "text",
                                        "text": cards[i].product_property[3].prod_prop ? cards[i].product_property[3].prod_prop.replaceAll("\n", "<br>") : " ",
                                        "wrap": true,
                                        "color": des1Color,
                                        "size": des1TextSize ? des1TextSize : "md",
                                        "flex": 1,
                                    }
                                ];
                                break;
                            case '3': /*專業版型一*/
                                card_body_flag = false;
                                card_hero = {
                                    "type": "image",
                                    "size": "full",
                                    "aspectRatio": ratio_str,
                                    "aspectMode": "cover",
                                    "url": `https://{{$_SERVER['HTTP_HOST']}}/public/upload/product/${cards[i].prod_id}/${cards[i].prod_img}`,
                                    "flex": 1,
                                };

                                if (('prod_prop' in cards[i].product_property[11] && cards[i].product_property[11].prod_prop != ' ') || ('prod_prop' in cards[i].product_property[3] && cards[i].product_property[3].prod_prop != ' ')) {
                                    card_body_flag = true;
                                    card_body['contents'] =  [
                                        {
                                            "type": "text",
                                            "text": cards[i].product_property[11].prod_prop ? cards[i].product_property[11].prod_prop : " ",
                                            "weight": "bold",
                                            "size": companyTextSize ? companyTextSize : "lg",
                                            "color": titleColor,
                                            "wrap": true,
                                        },
                                        {
                                            "type": "box",
                                            "layout": "vertical",
                                            "position": "relative",
                                            "paddingTop": "md", 
                                            "contents": [
                                                {
                                                    "type": "text",
                                                    "text": cards[i].product_property[3].prod_prop ? cards[i].product_property[3].prod_prop.replaceAll("\n", "<br>") : " ",
                                                    "wrap": true,
                                                    "color": des1Color,
                                                    "size": des1TextSize ? des1TextSize : "md",
                                                    "flex": 1,
                                                }
                                            ],
                                        },
                                        
                                    ];
                                }
                                break;
                            case '4': /*專業版型二*/
                                card_body_flag = false;
                                card_hero = {
                                    "type": "image",
                                    "size": "full",
                                    "aspectRatio": ratio_str,
                                    "aspectMode": "cover",
                                    "url": `https://{{$_SERVER['HTTP_HOST']}}/public/upload/product/${cards[i].prod_id}/${cards[i].prod_img}`,
                                    "flex": 1,
                                };
                                break;

                            case '6': /*全版無廣告*/
                                hero_flag = false;
                                card_footer_flag = false;

                                card_body['paddingAll'] = "0px";
                                card_body['alignItems'] = "center";
                                card_body['justifyContent'] = "center";
                                card_body['contents'] =  [
                                    {
                                        "type": "box",
                                        "layout": "vertical",
                                        "width": "300px",
                                        "position": "relative",
                                        "contents": [
                                            {
                                                "type": "image",
                                                "url": `https://{{$_SERVER['HTTP_HOST']}}/public/upload/product/${cards[i].prod_id}/${cards[i].prod_img}`,
                                                "size": "full",
                                                "aspectMode": "cover",
                                                "gravity": "center",
                                                "aspectRatio": ratio_str,
                                            },
                                        ],
                                    },
                                ];

                                if(product_type.length>0){
                                    let button_area = {
                                        "type": "box",
                                        "layout": "vertical",
                                        "position": "absolute",
                                        "alignItems": "center",
                                        "justifyContent": "flex-end",
                                        "width": "100%",
                                        "maxWidth": "300px",
                                        "height": "100%",
                                        "spacing": "md",
                                        "paddingAll": "10px",
                                        "offsetBottom": "9px",
                                        "contents": [],
                                    }
                                    for (let xx = 0; xx < btn_array.length; xx++) {
                                        button_area.contents.push(btn_array[xx]);
                                    }
                                    card_body['contents'].push(button_area);
                                }
                                break;

                            case '7': /*奧斯丁*/
                                card_body['contents'] =  [
                                    {
                                        "type": "text",
                                        "text": cards[i].product_property[11].prod_prop ? cards[i].product_property[11].prod_prop : " ",
                                        "weight": "bold",
                                        "size": companyTextSize ? companyTextSize : "lg",
                                        "color": titleColor,
                                        // "align": "center",
                                        "wrap": true
                                    },
                                    {
                                        "type": "box",
                                        "layout": "vertical",
                                        "contents": [],
                                        "width": "100%",
                                        "backgroundColor": titleColor,
                                        "height": "1px"
                                    },
                                    {
                                        "type": "box",
                                        "layout": "vertical",
                                        "contents": [],
                                        "width": "100%",
                                        "height": "16px"
                                    },
                                    {
                                        "type": "text",
                                        "text": cards[i].product_property[3].prod_prop ? cards[i].product_property[3].prod_prop.replaceAll("\n", "<br>") : " ",
                                        "wrap": true,
                                        "color": des1Color,
                                        "size": des1TextSize ? des1TextSize : "md",
                                        "offsetTop": "-4px",
                                        "flex": 1,
                                    }
                                ];

                                card_footer = {
                                    "type": "box",
                                    "layout": "vertical",
                                    "spacing": "md",
                                    "flex": 0,
                                    "paddingTop": "0px",
                                    "contents": [],
                                };
                                card_footer['backgroundColor'] = mainBackgroundColor;
                                for (let xx = 0; xx < btn_array.length; xx++) {
                                    card_footer['contents'].push(btn_array[xx]);
                                }
                                card_footer['contents'].push(ad_btn_area);
                                break;

                            default:
                                hero_flag = false;
                                card_body_flag = false;
                                card_footer_flag = false;
                                break;
                        }

                        card_obj = {
                            "type": "bubble",
                        }
                        if (hero_flag) {
                            card_obj['hero'] = card_hero;
                        }
                        if(!card_body_flag){ /*不需要body時不是直接不放body，而是把padding用到0，否則高度不同時，會有「留白」問題*/
                            card_body['paddingAll']= '0px';
                        }
                        card_obj['body'] = card_body;
                        if(card_footer_flag){
                            card_obj['footer'] = card_footer;
                        }
                        if(hero_flag || card_body_flag || card_footer_flag){
                            card_array.push(card_obj);
                        }
                    }
                    // console.log(card_array);
                    if(card_array.length==0){
                        $('#block_area').hide();
                        $.toaster({ message : '無可分享的名片',  priority : 'warning'}); return;
                    }
                    go_select_target(card_array, id_array);
                    $('#block_area').hide();
                }).error(function() {
                    $.toaster({ message : '發生錯誤', priority : 'danger' });
                }) //error
            }
            self.copy_card = async function() {
                var ids = self.checkAllItem(ids);
                if(ids.length==0){
                    $.toaster({ message : '請選擇要複製的名片',  priority : 'warning'}); return;
                }
                $('#block_area').show();
                $http({
                    method: "post",
                    url: '/admin/api/product/copy',
                    data: { 'includeIds': JSON.stringify(ids) },
                }).success(function(resp) {
                    console.log(resp);
                    self.getItems();
                    $('#block_area').hide();
                }).error(function() {
                    $.toaster({ message : '發生錯誤', priority : 'danger' });
                    $('#block_area').hide();
                }) //error
            }
        }]);
    </script>

    <script type="text/javascript">
        function go_select_target(card_array, id_array) {
            // console.log(JSON.stringify(card_array)); return;
            /*建立名片資料*/
            $.ajax({
                method: "post",
                url: "/admin/api/lind_card",
                data: {
                    template : JSON.stringify(card_array),
                    id_array : JSON.stringify(id_array),
                },
                success: function(data) {
                    if(data.status==200){
                        var liff_url = `https://liff.line.me/{{$LIFF_ID_SELECT_SHARE_TARGET}}?rand=${data.msg}&type=webshare`;

                        var u = navigator.userAgent;
                        var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
                        if(isiOS){
                            $('body').append(`
                                <a id="liff_url" class="d-none" target="_blank" href="`+ liff_url +`">liff_url</a>
                            `);
                            $("#liff_url")[0].click();
                            $("#liff_url").remove();

                            location.href = liff_url;
                        }else{
                            window.open(liff_url, "選擇分享對象", config='height=500,width=500');
                        }
                    }
                    else{
                        $.toaster({ message : data.msg, priority : 'danger' });
                    }

                },
                error: function() {
                    $.toaster({ message : '發生錯誤', priority : 'danger' });
                }
            });
        }

        const mapping = {
            'bubble': {
                'width': 300
            },
            'box': {
                'spacing_top': {
                    'default': 19,
                    'md': 10,
                    'lg': 20,
                },
                'spacing': {
                    'sm': 4,
                    'md': 8,
                    'lg': 12
                },
                'padding': {
                    'default': 10,
                    'md': 8,
                }
            },
            'button': {
                'height': {
                    'sm': 40,
                    'md': 52,
                }
            },
            'text': {
                'size': {
                    'sm': 19.6,
                    'md': 22.4,
                    'lg': 26.6,
                },
                'ratio': 1.4
            },
            'image': {
                'size': {
                    'md': 100,
                }
            }
        };
    </script>
@endsection