@extends('layouts.masterAdmin')

<!-- html title -->

@section('htmlTitle') {{$pageTitle}}  @endsection

@section('external_plugin')
    <link href="/js/select-mania/select-mania.css" rel="stylesheet" type="text/css">
    <link href="/js/select-mania/themes/select-mania-theme-orange.css" rel="stylesheet" type="text/css">
    <script src="/js/select-mania/js/select-mania.js"></script>
    <style>
    </style>
@endsection

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
            <div class="admin-receivingMailBox">
                <a href="" data-toggle="modal" ng-click='contCtrl.add()' data-target="#itemData" class="btn-use addNewBtn"><span>新增</span></a>
            </div>
        </div>
        <div class="col-lg-6 clearfix mb-2">
          <div class="float-lg-right">
              <span> 共@{{contCtrl.count}}項</span>
          </div>
        </div>       
    </div>
    <div class="multipleTagsRow-use">
        <div class="multipleTagsBox-use">
            <div class="scroll-box">
                <tree show-id="contCtrl.showItemId" light-box-item="contCtrl.itemData" product-num="contCtrl.productNum" lang-id="contCtrl.selectLangItem"  select-item-status="contCtrl.selectItemStatus"></tree>
            </div>
        </div>
    </div>
    <div>
        <!--Modal -->
        <div class="modal fade" id="itemData" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" ng-if='contCtrl.itemData.actionType == "add"'>新增項目</h4>
                        <h4 class="modal-title" ng-if='contCtrl.itemData.actionType == "edit"'>修改項目</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row use-box">
                            <div class="col-12 use-box-btm">
                                <span class="use-sp-title">分類名稱</span>
                                <input class="form-control" type='text' ng-model="contCtrl.itemData.cate_name" placeholder="請填入名稱">
                            </div>
                            
                            <div class="col-12 use-box-btm">
                                <span class="use-sp-title">狀態</span>
                                <select class="form-control" ng-model='contCtrl.selectItemStatus' ng-options='option.name for option in contCtrl.status' ng-change="contCtrl.itemSatausChange()"></select>
                            </div>
                            <div class="col-12 use-box-btm">
                                <span class="use-sp-title">順序</span>
                                <input class="form-control" type='text' ng-model="contCtrl.itemData.cate_order" placeholder="請填入順序" onkeyup="value=value.replace(/[^\d]/g,'')">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" ng-if='contCtrl.itemData.actionType == "add"' class="btn btn-default" data-dismiss="modal" ng-click='contCtrl.addItem()'>新增</button>
                        <button type="button" ng-if='contCtrl.itemData.actionType == "edit"' class="btn btn-default" data-dismiss="modal" ng-click='contCtrl.saveItem()'>儲存</button>
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
        function select(){
            $('.downSelect').selectMania({
                themes: ['orange'],
                search: true
            });
        }
    </script>

    <script>
        function hierarchyModifyFn($http,tagId,parentId,level ,lang_id ,productNum){
            var resData;
            var data = {
                'selectLangItem': lang_id ,
                'productNum':productNum,
                'tagId':tagId, //目前tag ID
                'pid':tagId,  
                'level':parseInt(level)+1,
            };
            $.ajax({
                url : '/admin/api/categoryTag/hierarchy/show',
                type : "post",
                data : data,
                async : false,
                success : function(data) {
                    resData = data;
                }
            });
            return resData;
        }
    </script>

    <script>
        /* 
         * An Angular service which helps with creating recursive directives.
         * @author Mark Lagendijk
         * @license MIT
         */
        angular.module('RecursionHelper', []).factory('RecursionHelper', ['$compile', function($compile){
            return {
                /**
                 * Manually compiles the element, fixing the recursion loop.
                 * @param element
                 * @param [link] A post-link function, or an object with function(s) registered via pre and post properties.
                 * @returns An object containing the linking functions.
                 */
                compile: function(element, link){
                    // Normalize the link parameter
                    if(angular.isFunction(link)){
                        link = { post: link };
                    }

                    // Break the recursion loop by removing the contents
                    var contents = element.contents().remove();
                    var compiledContents;
                    return {
                        pre: (link && link.pre) ? link.pre : null,
                        /**
                         * Compiles and re-adds the contents
                         */
                        post: function(scope, element){
                            // Compile the contents
                            if(!compiledContents){
                                compiledContents = $compile(contents);
                            }
                            // Re-add the compiled contents to the element
                            compiledContents(scope, function(clone){
                                element.append(clone);
                            });

                            // Call the post-linking function, if any
                            if(link && link.post){
                                link.post.apply(null, arguments);
                            }
                        }
                    };
                }
            };
        }]);
    </script>

    <script type="text/javascript">
        var app = angular.module('app', ['summernote','RecursionHelper']);
        app.controller('ContentController', ['$http', '$scope', function($http, $scope) {
            $scope.noteOptions = {
                popover: {
                    image: [
                        ['custom', ['imageAttributes']],
                        ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
                        ['float', ['floatLeft', 'floatRight', 'floatNone']],
                        ['remove', ['removeMedia']]
                    ],
                },
                lang: 'zh-TW',
                imageAttributes:{
                    icon:'<i class="note-icon-pencil"/>',
                    removeEmpty:false, // true = remove attributes | false = leave empty if present
                    disableUpload: false // true = don't display Upload Options | Display Upload Options
                },

                height: 200,
                focus: false,
                airMode: false,
                toolbar: [
                    ['edit', ['undo', 'redo']],
                    ['headline', ['style']],
                    ['style', ['bold', 'italic', 'underline', 'superscript', 'subscript', 'strikethrough', 'clear']],
                    ['fontface', ['fontname']],
                    ['textsize', ['fontsize']],
                    ['fontclr', ['color']],
                    ['alignment', ['ul', 'ol', 'paragraph', 'lineheight']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video', 'hr']],
                    ['view', ['fullscreen', 'codeview']],
                    // ['help', ['help']]
                ],
                fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '24', '28', '36'],
                lineHeights: ['0.5','0.7','0.9','1.0','1.1', '1.2','1.3', '1.4', '1.5', '1.6', '1.8', '2.0', '3.0'],
                maximumImageFileSize: 1920 * 1920,
                callbacks: { onImageUploadError: function(msg) { alert(msg + ' (圖片尺寸超過1920px*1920px-3.52 MB)'); } }
            };

            var currentPath = window.location.pathname;
            var currPathAry = currentPath.split("/");
            var self = this;
            self.productNum = currPathAry[3];

            //======= area start=======
            self.listUrl = '/api/categoryTag/layer/find';
            self.addUrl = '/admin/api/categoryTag/add';
            self.saveUrl = '/admin/api/categoryTag/save';
            self.setStatusUrl = '/admin/api/categoryTag/setStatus';

            self.searchText = '';
            self.selectLangItem = get_record_lang();
            self.status = [
                { name: '停用', value: 0 },
                { name: '啟用', value: 1 }
            ]
            
            self.itemData = {};
            self.itemData.actionType= 'add';
            self.selectItemStatus = self.status[1];
            self.itemData.cate_status = 1;
            self.selectedAll = false;

            self.add = function() {
                self.resetItem();

                // self.actionType = 'add';
                self.itemData.actionType= 'add';
                self.addHierarchy(self.itemData.lang_id);
            };

            /* 更換語言 */
            self.changedListLang = function() {
                if (self.selectLangItem === null) {
                    self.selectLangItem = 0;
                }
                self.getItems();
                self.getItemsAll(0);
            }

            /* 重置新增model */
            self.resetItem = function() {
                self.itemData = {};
                self.itemData.cate_order = 0;
                if(self.itemData.tag_img == null){
                    self.itemData.tag_img = '';
                }

                if(self.itemData.tag_img_wide == null){
                    self.itemData.tag_img_wide = '';
                }

                self.selectItemStatus = self.status[1];
                self.itemData.lang_id = self.selectLangItem ? self.selectLangItem : 1;
                self.itemData.cate_status = 1;
                self.itemData.promote =1;
                $('.promoteBtn').addClass('active');
            }

            // *************************************************************************start
            self.addItem = function() {
                self.itemData.cate_id = self.productNum;
                var data = { 'item': self.itemData };
                if(self.itemData.treesSelect != undefined){
                    angular.forEach(self.itemData.trees, function(item ,key ) {
                        if(self.itemData.trees[key].cate_tag_id == self.itemData.treesSelect){
                            self.itemData.treesSelect =self.itemData.trees[key];
                        }
                    });
                }
                self.actionItem("post", self.addUrl, data);
            }

            self.saveItem = function() {
                delete self.itemData["childTreesArr"];
                
                if(self.itemData.parent_id == self.itemData.treesSelect){
                    self.itemData.modify=false;
                    var data = { 'item': self.itemData };
                    self.actionItem("put", self.saveUrl, data);
                }else{
                    self.judgeHasChild( self.itemData.cate_tag_id, self.itemData.parent_id , self.itemData.hierarchy_count , self.itemData);  //tagId , 父Id , 階層  
                }                
            }
            // *************************************************************************

            self.setStatusItem = function(ids, status) {
                var data = { 'ids': ids, status: status };
                self.actionItem("put", self.setStatusUrl, data);
            }

            self.actionItem = function(method, url, data) {
                $http({
                    method: method,
                    url: url,
                    data: data
                }).success(function(data) {
                    if (data.status == '200') {
                        self.resetItem();
                        // self.actionType = 'add';
                        self.itemData.actionType= 'add';
                        self.getItems();

                        // *************************************************************************start
                        self.addHierarchy(self.selectLangItem);
                        // *************************************************************************

                        self.getItemsAll(self.showItemId);
                    } else {
                        $.toaster({ message : '資料庫無回應',  priority : 'warning'})
                    }
                }).error(function() {
                    $.toaster({ message : '錯誤', priority : 'danger' });
                }) //error
            }

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

            self.getItems = function(search) {
                var data = {
                    'langId': self.selectLangItem,
                    'productNum' :self.productNum,
                };
                $http({
                    method: "post",
                    url: self.listUrl,
                    data: data
                }).success(function(data) {
                    // console.log(data)
                    self.count = data.items.length;
                }).error(function() {
                    $.toaster({ message : '錯誤', priority : 'danger' });
                }) //error
            }
            self.getItems();

            //CRUD ====== end =======

            // *************************************************************************start

            ////////////////////////////////////////////////
            ///////////////   hierarchy   //////////////////
            ////////////////////////////////////////////////
            self.hierarchy = function(lang_id) {
                var data = {
                    'selectLangItem': lang_id ,
                    'productNum':self.productNum,
                    'tagId':'', //目前tag ID
                    'pid':'',  
                    'level':'',
                };
                $http({
                    method: "post",
                    url : '/admin/api/categoryTag/hierarchy/show',
                    data: data
                }).success(function(data) {
                    self.itemData.trees=data.items;
                    setTimeout(function() {
                        select();
                    }, 50);
                }).error(function() {
                    $.toaster({ message : '錯誤', priority : 'danger' });
                }) //error
            }
            self.hierarchy(self.selectLangItem);

            self.addHierarchy = function(lang_id){
                var data = {
                    'selectLangItem': lang_id ,
                    'productNum':self.productNum,
                    'tagId':'', //目前tag ID
                    'pid':'',  
                    'level':'',
                };
                $http({
                    method: "post",
                    url : '/admin/api/categoryTag/hierarchy/show',
                    data: data
                }).success(function(data) {
                    self.itemData.trees=data.items;

                    setTimeout(function() {
                        $('.downSelect').selectMania('update');
                    }, 50);
                }).error(function() {
                    $.toaster({ message : '錯誤', priority : 'danger' });
                }) //error
            }

            self.hierarchyModify = function(tagId,parentId,level ,lang_id) {
                self.innerFn =hierarchyModifyFn;
                let data = self.innerFn($http,tagId,parentId,level ,lang_id ,self.productNum);

                self.itemData.trees =data.items;
                self.itemData.treesSelect=parseInt(parentId);
                setTimeout(function() {
                    $('.downSelect').selectMania('update');
                }, 50);
            }

            self.judgeHasChild = function(tagId , parentId , level ,tagData) {
                var data = {
                    'selectLangItem': self.selectLangItem ,
                    'productNum':self.productNum,
                    'tagId':tagId, //目前tag ID
                    'pid':tagId,  
                    'level':parseInt(level)+1,
                };

                $http({
                    method: "post",
                    url: '/admin/api/categoryTag/hierarchy/judgeHasChild',
                    data: data
                }).success(function(data) {
                    // if(data.length == 0){
                        if(self.itemData.treesSelect != null || self.itemData.treesSelect != undefined){
                            angular.forEach(self.itemData.trees, function(item ,key ) {
                                if(self.itemData.trees[key].cate_tag_id == self.itemData.treesSelect){
                                    self.saveSelect =self.itemData.trees[key];
                                }
                            });
                            self.saveSelect.hierarchyArray[(parseInt(self.saveSelect.hierarchy) +1) ]=tagData.cate_tag_id; 
                            tagData['treesSelect']=self.saveSelect; 
                            tagData['modify']    =true;

                        }else{
                            tagData['hierarchy_count']='';
                            tagData['hierarchy_id']   ='';
                            tagData['parent_id']      ='';
                            tagData['treesSelect']    =0;
                            tagData['modify']    =true;
                        }

                        var sendData = { 'item': tagData , 'arrId':data };
                        self.actionItem("put", self.saveUrl, sendData );
                    // }else{
                    //     self.getItems();
                    //     alert('分類含有子分類無法變更，請先移除子分類')
                    // }
                }).error(function() {
                    $.toaster({ message : '錯誤', priority : 'danger' });
                }) //error
            }
            // *************************************************************************

            // 推薦 --------------------------------------------
            self.recommendToggle = function(){
                if($('.promoteBtn').hasClass('active')){
                  self.itemData.promote=0;                  
                }else{
                  self.itemData.promote=1;
                }
            }

            self.changeOrder = function(item){  
                $http({
                    method : "put",
                    url : "/admin/api/categoryTag/save/order",
                    data: { 'item': item },
                }).success(function(data){
                }).error(function(){
                })//error
            }

            self.reload = function(){  
                location.reload();
            }

            self.clear_tag_img =function(){
                self.itemData.tag_img= '';
            }

            self.clear_tag_img_wide =function(){
                self.itemData.tag_img_wide= '';
            }

            // delete cate_tag_id start
            self.deleteCheck  = function(ids){
                var data = {
                    'productNum':self.productNum,
                    'langId': self.selectLangItem,
                    'ids':ids,
                };
                $http({
                    method: "post",
                    url: '/admin/api/categoryTag/delete/check',
                    data: data
                }).success(function(data) {
                    // console.log(data.completeDeletionIds)
                    // console.log(data.cannotDeletedIds)
                    if(data.completeDeletionIds != 0){
                        $.toaster({ message : '已經刪除類別有:<br/>'+data.completeDeletionIds});
                        self.getItems();
                    }
                    if(data.cannotDeletedIds!= 0){
                        $.toaster({ message : '無法刪除類別有:<br/>'+data.cannotDeletedIds+"<br/>(請檢查類別是否有掛商品或是階層)" ,  priority : 'warning'});
                    }
                }).error(function() {
                }) //error
            }

            self.remove = function() {
                var ids = self.checkAllItem(ids);
                if (ids.length > 0) {
                    if (confirm("確定刪除？")) {
                        self.deleteCheck(ids);
                    }
                }
            };
            // delete cate_tag_id end

            self.hierarchy_count_all = 1;
            self.getItemsAll = function(showItemId) {
                var data = {
                    'selectLangItem': self.selectLangItem,
                    'searchByText': self.searchText,
                    'hierarchy_count' : self.hierarchy_count_all,
                };

                $http({
                    method: "post",
                    url: '/admin/api/categoryTag/tree/json/' + self.productNum,
                    data: data
                }).success(function(data) {
                    self.itemData.treeFamily=data;
                    if(self.itemData.treeFamily.items.length != 0){
                        if(showItemId == 0){
                            self.showItemId = self.itemData.treeFamily.items[0].cate_tag_id;
                        }
                    }
                    // console.log(self.itemData)
                }).error(function() {
                    $.toaster({ message : '錯誤', priority : 'danger' });
                }) //error
            }
            self.getItemsAll(0);

            $('#itemData').on('hidden.bs.modal', function () {
                self.getItemsAll(self.showItemId);
            });

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
        })
        .factory("fileReader", function($q, $log) {
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
        })

        .directive("tree", function($http,RecursionHelper) {
            return {
                restrict: "E",
                scope: {
                    // family: '=',
                    showId: '=',
                    lightBoxItem: '=',  //contCtrl.itemData
                    productNum : '=',
                    langId: '=',
                    selectItemStatus: '=',
                    // trees: '=',
                    // actionType: '=',
                },
                template: 
                    '<div class="f-box main-box ng-class:setStyle(value.cate_tag_id); " ng-repeat="(key, value) in lightBoxItem.treeFamily.items" ng-click="editBox()">'+
                        '<div class="tree-card-use">'+
                            '<div class="w-100 h-100 cursorBox" ng-click="toggleExpandStatus(value.cate_tag_id)">'+
                                '<div class="tree-body">'+
                                    '<div class="header">'+
                                        '<h6 class="tagName" ng-bind="value.cate_name"></h6><div class="status"><a ng-class="status[value.cate_status].color" href="javascript:void(0)" ng-click="editStatus(value)" ng-bind="status[value.cate_status].name"></a></div>'+
                                    '</div>'+
                                    '<div>'+
                                        '<span>含本階層以下總數:<span ng-bind="value.pro.all"></span></span><span>&nbsp;</span>'+
                                        '<span>本層數:'+
                                        '<span ng-bind="value.pro.showProAll"></span><span class="cutLine">/</span><span ng-bind="value.pro.showProShelves"></span>'+
                                        '</span>'+
                                    '</div>'+
                                    '<div class="orderBox">'+
                                        '<span>排序:</span><input type="text" class="use-form-control w-100" ng-model="value.cate_order" ng-blur="changeOrder(value)" ng-focus="textRecording(value)">'+
                                    '</div>'+
                                    '<div class="operationalBox">'+
                                        '<span ng-if="status[value.cate_status].value == 1"><a target="_blank" href="/admin/product/@{{productNum}}?searchTag=@{{value.cate_tag_id}}">查看</a></span>'+
                                        '<span ng-if="status[value.cate_status].value == 0">查看</span>'+
                                        '<span class="cutLine">|</span>'+
                                        '<a href="javascript:void(0)" data-toggle="modal" data-target="#itemData" ng-click="edit(value)">編輯</a><span class="cutLine">|</span>' + 
                                        '<a href="javascript:void(0)" ng-click="remove(value)">刪除</a><span class="cutLine">|</span>' + 
                                        // '<a href="javascript:void(0)" ng-click="addLowerClass(value);$event.stopPropagation();">+子階層</a><span class="cutLine">|</span>'+
                                        '<a href="javascript:void(0)" ng-click="addPro(value , productNum)">+項目</a>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+                            
                        '</div>'+
                        '<div class="subclassBox">'+
                            '<div class="tree-card-use-box">'+
                                '<span ng-repeat="item in value.childTreesArr" ng-if="value.childTreesArr.length > 0  && value.cate_tag_id == item.parent_id" ng-show="showId == item.parent_id">'+
                                    '<tree-view parent-data="value.childTreesArr" tree-data="item" id="item.cate_tag_id" show-id="showId" light-box-item="lightBoxItem" parent-id="value.cate_tag_id" product-num="productNum" lang-id="langId" select-item-status="selectItemStatus"></tree-view>'+
                                '</span>'+
                            '</div>'+
                        '</div>'+
                    '</div>'
                ,
                compile: function(element) {
                    return RecursionHelper.compile(element, function(scope, iElement, iAttrs, controller, transcludeFn){                       
                        scope.status =[
                            { name: '停用', value: 0 ,color:'deactivateText' },
                            { name: '啟用', value: 1 ,color:'enableText'}
                        ];
                        // scope.expression="boxActive";
                        scope.setStyle = function(cate_tag_id) {
                            if(cate_tag_id != scope.showId ){
                                return "boxNoActive";
                            }
                        }
                        console.log(scope.lightBoxItem);
                        // console.log(scope.lightBoxItem.treeFamily);
                    });
                },
                controller: function($scope){
                    $scope.toggleExpandStatus = function(id){
                        if(id !=$scope.showId){
                            $scope.showId=id;
                        }
                    };
                    $scope.editBox = function(item){
                        // $scope.actionType = 'edit';
                    };
                    $scope.edit = function(item){   //edit
                        // console.log( item )
                        // console.log( $scope.lightBoxItem)
                        $scope.lightBoxItem.actionType= 'edit'; //需修改
                        // -----------------------------------------------------

                        if(item.promote == 1){
                            $('.promoteBtn').addClass('active');
                        }else{
                            if($('.promoteBtn').hasClass('active')){
                                $('.promoteBtn').removeClass('active');
                            }
                        }
                        let treeArrData =$scope.hierarchyModify(item.cate_tag_id , item.parent_id , item.hierarchy_count ,item.lang_id); //tagId , 父Id , 階層  

                        // $scope.trees =treeArrData.items;   //需修改
                        $scope.lightBoxItem.trees=treeArrData.items;
                        $scope.lightBoxItem.treesSelect=parseInt(item.parent_id);
                        setTimeout(function() {
                            $('.downSelect').selectMania('update');
                        }, 50);

                        // -----------------------------------------------------------
                        // -----------------------------------------------------------
                        // -----------------------------------------------------------
                        $scope.lightBoxItem.cate_id =item.cate_id;
                        $scope.lightBoxItem.cate_name =item.cate_name;
                        $scope.lightBoxItem.cate_order =item.cate_order;
                        $scope.lightBoxItem.cate_status =item.cate_status;
                        $scope.lightBoxItem.cate_subtitle =item.cate_subtitle;
                        $scope.lightBoxItem.cate_tag_desc =item.cate_tag_desc;
                        $scope.lightBoxItem.cate_tag_img =item.cate_tag_img;
                        $scope.lightBoxItem.lang_id =item.lang_id;
                        $scope.lightBoxItem.promote =item.promote;
                        $scope.lightBoxItem.tag_img =item.tag_img;
                        $scope.lightBoxItem.tag_img_wide =item.tag_img_wide;
                        $scope.lightBoxItem.cate_tag_id =item.cate_tag_id;
                        // $scope.lightBoxItem.updated_at =item.updated_at;
                        // $scope.lightBoxItem.created_at =item.created_at;
                        // $scope.lightBoxItem.lang =item.lang;
                        $scope.lightBoxItem.hierarchy_count =item.hierarchy_count;
                        $scope.lightBoxItem.hierarchy_id =item.hierarchy_id;
                        $scope.lightBoxItem.parent_id =item.parent_id;

                        if($scope.lightBoxItem.tag_img == null){
                            $scope.lightBoxItem.tag_img = '';
                        }
                        if($scope.lightBoxItem.tag_img_wide == null){
                            $scope.lightBoxItem.tag_img_wide = '';
                        }
                        $scope.selectItemStatus.name = $scope.status[$scope.lightBoxItem.cate_status].name;
                        $scope.selectItemStatus.value = $scope.status[$scope.lightBoxItem.cate_status].value;
                        // -----------------------------------------------------------
                        // -----------------------------------------------------------
                        // -----------------------------------------------------------
                    };
                    $scope.hierarchyModify = function(tagId,parentId,level ,lang_id) {
                        $scope.innerFn =hierarchyModifyFn;
                        let data = $scope.innerFn($http,tagId,parentId,level ,lang_id ,$scope.productNum);
                        return data;
                        // $scope.trees =data.items;
                        // $scope.lightBoxItem.treesSelect=parseInt(parentId);
                        // setTimeout(function() {
                        //     $('.downSelect').selectMania('update');
                        // }, 50);
                    };

                    $scope.$watch("lightBoxItem", function () {
                        // console.log('更換')
                    });
                    // --------------------------------------------------------------------------------

                    $scope.editStatus = function(item){
                        if(item.cate_status == 0){
                            item.cate_status = 1;
                        }else{
                            item.cate_status = 0;
                        }
                        var ids =[];
                        ids.push(item.cate_tag_id);
                        $scope.setStatusItem(ids , item.cate_status)
                    };

                    $scope.setStatusItem = function(ids, status){
                        var data = { 'ids': ids, status: status };
                        var setStatusUrl = '/admin/api/categoryTag/setStatus';
                        $scope.actionItem("put", setStatusUrl, data);
                    };

                    $scope.actionItem = function(method, url, data){
                        $http({
                            method: method,
                            url: url,
                            data: data
                        }).success(function(data) {
                        }).error(function() {
                        }) //error
                    }

                    $scope.remove = function(item){
                        var ids =[];
                        ids.push(item.cate_tag_id);
                        $scope.deleteCheck(ids);
                    }

                    $scope.deleteCheck = function(ids){
                        var data = {
                            'productNum':$scope.productNum,
                            'langId': $scope.langId, //$scope.selectLangItem
                            'ids':ids,
                        };

                        $http({
                            method: "post",
                            url: '/admin/api/categoryTag/delete/check',
                            data: data
                        }).success(function(data) {
                            // console.log($scope.lightBoxItem.treeFamily)
                            if(data.completeDeletionIds != 0){
                                $.toaster({ message : '已經刪除:<br/>'+data.completeDeletionIds});
                            }
                            if(data.cannotDeletedIds!= 0){
                                $.toaster({ message : '無法刪除:<br/>'+data.cannotDeletedIds+"<br/>(請檢查類別是否有掛商品或是階層)" ,  priority : 'warning'});
                            }
                            $scope.getItemsAll($scope.showId);
                        }).error(function() {
                        }) //error
                    }

                    $scope.getItemsAll = function(showItemId) {
                        var data = {
                            'selectLangItem': $scope.langId,
                            'searchByText': "",
                            'hierarchy_count' : 1,
                        };
                        $http({
                            method: "post",
                            url: '/admin/api/categoryTag/tree/json/' + $scope.productNum,
                            data: data
                        }).success(function(data) {
                            $scope.lightBoxItem.treeFamily=data;
                            if($scope.lightBoxItem.treeFamily.items.length != 0){
                                if(showItemId == 0){
                                    $scope.showId = $scope.lightBoxItem.treeFamily.items[0].cate_tag_id;
                                }
                            }
                        }).error(function() {
                            $.toaster({ message : '錯誤', priority : 'danger' });
                        }) //error
                    }

                    $scope.addLowerClass = function(item){
                        // $scope.actionType = 'add';
                        $scope.lightBoxItem.actionType= 'add';
                        $scope.reset();
                        $('#itemData').modal('show');

                        var data = {
                            'selectLangItem': $scope.langId,
                            'productNum':$scope.productNum,
                            'tagId':'', //目前tag ID
                            'pid':'',  
                            'level':'',
                        };
                        $http({
                            method: "post",
                            url : '/admin/api/categoryTag/hierarchy/show',
                            data: data
                        }).success(function(data) {
                            // $scope.trees =data.items; //需修改
                            $scope.lightBoxItem.trees=data.items;
                            $scope.lightBoxItem.treesSelect=parseInt(item.cate_tag_id);
                            setTimeout(function() {
                                $('.downSelect').selectMania('update');
                            }, 50);
                        }).error(function() {
                            $.toaster({ message : '錯誤', priority : 'danger' });
                        }) //error
                    }

                    $scope.reset = function() {
                        $scope.lightBoxItem.cate_order =0;
                        $scope.lightBoxItem.cate_status =1;
                        $scope.lightBoxItem.lang_id =$scope.langId;
                        $scope.lightBoxItem.promote =1;
                        $scope.lightBoxItem.tag_img ="";
                        $scope.lightBoxItem.tag_img_wide ="";

                        if($scope.lightBoxItem.promote == 1){
                            $('.promoteBtn').addClass('active');
                        }else{
                            if($('.promoteBtn').hasClass('active')){
                                $('.promoteBtn').removeClass('active');
                            }
                        }

                        $scope.lightBoxItem.cate_name ="";
                        $scope.lightBoxItem.cate_subtitle ="";
                        $scope.lightBoxItem.cate_tag_desc ="";
                        // $scope.lightBoxItem.cate_id ="";
                        // $scope.lightBoxItem.cate_tag_img ="";
                        // $scope.lightBoxItem.cate_tag_id =item.cate_tag_id;

                        delete $scope.lightBoxItem["cate_tag_id"];
                        delete $scope.lightBoxItem["hierarchy_count"];
                        delete $scope.lightBoxItem["hierarchy_id"];
                        delete $scope.lightBoxItem["parent_id"];

                        $scope.selectItemStatus.name = $scope.status[$scope.lightBoxItem.cate_status].name;
                        $scope.selectItemStatus.value = $scope.status[$scope.lightBoxItem.cate_status].value;
                        $scope.addHierarchy($scope.langId);
                    }

                    $scope.addHierarchy = function(lang_id) {
                        var data = {
                            'selectLangItem': lang_id,
                            'productNum':$scope.productNum,
                            'tagId':'', //目前tag ID
                            'pid':'',  
                            'level':'',
                        };
                        $http({
                            method: "post",
                            url: '/admin/api/categoryTag/hierarchy/show',
                            data: data
                        }).success(function(data) {
                            $scope.trees =data.items;
                            setTimeout(function() {
                                $('.downSelect').selectMania('update');
                            }, 50);
                        }).error(function() {
                            $.toaster({ message : '錯誤', priority : 'danger' });
                        }) //error
                    }

                    $scope.changeOrder= function(item) {                
                        if(isNaN(item.cate_order)){
                            item.cate_order = $scope.contrastContent.cate_order;
                            $.toaster({ message : '排序請填入數字',  priority : 'warning'})
                            return false;
                        }
                        $scope.result = angular.equals($scope.contrastContent, item);

                        if(!$scope.result){
                            if(item.cate_order != null){
                                item.cate_order = parseInt(item.cate_order);
                                $http({
                                    method : "put",
                                    url : "/admin/api/categoryTag/save/order",
                                    data: { 'item': item },
                                }).success(function(data){
                                    $.toaster({ message : '修改成功'});
                                    $scope.getItemsAll($scope.showId);
                                }).error(function(){
                                })//error
                            }else{
                                $.toaster({ message : '修改失敗'});
                                $scope.getItemsAll($scope.showId);
                            }
                        }
                    }

                    $scope.textRecording= function(item) {
                        console.log(9999)
                        $scope.contrastContent="";
                        $scope.contrastContent = angular.copy(item, $scope.contrastContent); 
                    }

                    $scope.addPro= function(item,productNum) {
                        $http({
                            method : "post",
                            url : '/admin/api/tag/buliding/product',
                            data: { 'productNum': productNum ,'tag':item },
                        }).success(function(data){
                            if(data.status == 400){
                                if (confirm( "有商品在建置中，是否要刪除商品")) {
                                    $scope.deletePro(item,productNum);
                                }else{
                                    $.toaster({ message : '請先去商品列表新增完成', priority : 'warning' });
                                }
                            }else if(data.status == 200){
                                location.href = '/admin/product/'+productNum+'/add';
                            }
                        }).error(function(){
                        })//error
                    }

                    $scope.deletePro= function(item,productNum) {
                        console.log(productNum)
                        $http({
                            method : "post",
                            url : "/admin/api/tag/delete/buliding/product",
                            data: { 'productNum': productNum ,'tag':item },
                        }).success(function(data){
                            if(data.status == 200){
                                location.href = '/admin/product/'+productNum+'/add';
                            }else if(data.status == 400){
                                $.toaster({ message : '發生錯誤', priority : 'danger' });
                            }
                        }).error(function(){
                        })//error
                    }
                },
            };

        }).directive("treeView", function($http,RecursionHelper) {
            return {
                restrict: "E",
                scope: {
                    // family: '=',
                    treeData: "=" ,
                    id: "=" ,
                    showId: '=',
                    lightBoxItem: '=lightBoxItem',  //=> treeData
                    parentId: "=" ,
                    productNum : '=',
                    langId: '=',
                    parentData: '=',
                    selectItemStatus: '=',
                    // trees: '=',
                    // actionType: '=',
                },
                template: 
                    '<div class="f-box" >'+
                        '<div class="tree-card-use">'+
                            '<div class="w-100 h-100 cursorBox">'+
                                '<div class="tree-body">'+
                                    '<div class="header">'+
                                        '<h6 class="tagName" ng-bind="treeData.cate_name"></h6><div class="status"><a <a ng-class="status[treeData.cate_status].color" href="javascript:void(0)" ng-click="editStatus(treeData)" ng-bind="status[treeData.cate_status].name"></a></div>'+
                                    '</div>'+
                                    '<div>'+
                                        '<span>含本階層以下總數:<span ng-bind="treeData.pro.all"></span></span><span>&nbsp;</span>'+
                                        '<span>本層數:'+
                                            '<span ng-bind="treeData.pro.showProAll"></span><span class="cutLine">/</span><span ng-bind="treeData.pro.showProShelves"></span>'+
                                        '</span>'+                               
                                    '</div>'+
                                    '<div class="orderBox">'+
                                        '<span>排序:</span><input type="text" class="use-form-control w-100" ng-model="treeData.cate_order" ng-blur="changeOrder(treeData)" ng-focus="textRecording(treeData)">'+
                                    '</div>'+
                                    '<div class="operationalBox">'+
                                        '<span ng-if="status[treeData.cate_status].value == 1"><a target="_blank" href="/admin/product/@{{productNum}}?searchTag=@{{treeData.cate_tag_id}}">查看</a></span>'+
                                        '<span ng-if="status[treeData.cate_status].value == 0">查看</span>'+
                                        '<span class="cutLine">|</span>'+
                                        '<a href="" data-toggle="modal" data-target="#itemData" ng-click="edit(treeData)">編輯</a><span class="cutLine">|</span>' +
                                        '<a href="javascript:void(0)" ng-click="remove(treeData)">刪除</a><span class="cutLine">|</span>' +
                                        '<a href="javascript:void(0)" ng-click="addLowerClass(treeData);$event.stopPropagation();">+子階層</a><span class="cutLine">|</span>'+
                                        '<a href="javascript:void(0)" ng-click="addPro(treeData ,productNum)">+商品</a>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '<div class="tree-card-use-box" ng-if="treeData.childTreesArr.length > 0  " >'+
                            '<tree-view parent-data="treeData.childTreesArr" tree-data="item" id="item.cate_tag_id" show-id="showId" light-box-item="lightBoxItem" parent-id="value.cate_tag_id" product-num="productNum" lang-id="langId" select-item-status="selectItemStatus" ng-repeat="item in treeData.childTreesArr"></tree-view>'+
                        '</div>'+
                    '</div>'
                ,
                compile: function(element) {
                    return RecursionHelper.compile(element, function(scope, iElement, iAttrs, controller, transcludeFn){
                        scope.status =[
                            { name: '停用', value: 0 ,color:'deactivateText' },
                            { name: '啟用', value: 1 ,color:'enableText'}
                        ];
                    });
                },
                controller: function($scope){
                    $scope.edit = function(item){   //edit
                        // $scope.actionType = 'edit';
                        $scope.lightBoxItem.actionType= 'edit';
                        // -----------------------------------------------------
                        if(item.promote == 1){
                            $('.promoteBtn').addClass('active');
                        }else{
                            if($('.promoteBtn').hasClass('active')){
                                $('.promoteBtn').removeClass('active');
                            }
                        }
                        let treeArrData =$scope.hierarchyModify(item.cate_tag_id , item.parent_id , item.hierarchy_count ,item.lang_id); //tagId , 父Id , 階層     
                        // $scope.trees =treeArrData.items; //需修改
                        $scope.lightBoxItem.trees=treeArrData.items;
                        $scope.lightBoxItem.treesSelect=parseInt(item.parent_id);
                        setTimeout(function() {
                            $('.downSelect').selectMania('update');
                        }, 500);

                        // -----------------------------------------------------------
                        // -----------------------------------------------------------
                        // -----------------------------------------------------------
                        $scope.lightBoxItem.cate_id =item.cate_id;
                        $scope.lightBoxItem.cate_name =item.cate_name;
                        $scope.lightBoxItem.cate_order =item.cate_order;
                        $scope.lightBoxItem.cate_status =item.cate_status;
                        $scope.lightBoxItem.cate_subtitle =item.cate_subtitle;
                        $scope.lightBoxItem.cate_tag_desc =item.cate_tag_desc;
                        $scope.lightBoxItem.cate_tag_img =item.cate_tag_img;
                        $scope.lightBoxItem.lang_id =item.lang_id;
                        $scope.lightBoxItem.promote =item.promote;
                        $scope.lightBoxItem.tag_img =item.tag_img;
                        $scope.lightBoxItem.tag_img_wide =item.tag_img_wide;
                        $scope.lightBoxItem.cate_tag_id =item.cate_tag_id;
                        // $scope.lightBoxItem.updated_at =item.updated_at;
                        // $scope.lightBoxItem.created_at =item.created_at;
                        // $scope.lightBoxItem.lang =item.lang;
                        $scope.lightBoxItem.hierarchy_count =item.hierarchy_count;
                        $scope.lightBoxItem.hierarchy_id =item.hierarchy_id;
                        $scope.lightBoxItem.parent_id =item.parent_id;
                        if($scope.lightBoxItem.tag_img == null){
                            $scope.lightBoxItem.tag_img = '';
                        }
                        if($scope.lightBoxItem.tag_img_wide == null){
                            $scope.lightBoxItem.tag_img_wide = '';
                        }
                        $scope.selectItemStatus.name = $scope.status[$scope.lightBoxItem.cate_status].name;
                        $scope.selectItemStatus.value = $scope.status[$scope.lightBoxItem.cate_status].value;
                        // -----------------------------------------------------------
                        // -----------------------------------------------------------
                        // -----------------------------------------------------------
                    };
                    $scope.hierarchyModify = function(tagId,parentId,level ,lang_id) {
                        $scope.innerFn =hierarchyModifyFn;
                        let data = $scope.innerFn($http,tagId,parentId,level ,lang_id ,$scope.productNum);
                        return data;
                    };
                    // --------------------------------------------------------------------------------

                    $scope.editStatus = function(item){
                        if(item.cate_status == 0){
                            item.cate_status = 1;
                        }else{
                            item.cate_status = 0;
                        }
                        var ids =[];
                        ids.push(item.cate_tag_id);
                        $scope.setStatusItem(ids , item.cate_status)
                    };

                    $scope.setStatusItem = function(ids, status){
                        var data = { 'ids': ids, status: status };
                        var setStatusUrl = '/admin/api/categoryTag/setStatus';
                        $scope.actionItem("put", setStatusUrl, data);
                    };

                    $scope.actionItem = function(method, url, data){
                        $http({
                            method: method,
                            url: url,
                            data: data
                        }).success(function(data) {
                        }).error(function() {
                        }) //error
                    }

                    $scope.remove = function(item){
                        var ids =[];
                        ids.push(item.cate_tag_id);
                        var data = {
                            'productNum':$scope.productNum,
                            'langId': $scope.langId, //$scope.selectLangItem
                            'ids':ids,
                        };
                        $http({
                            method: "post",
                            url: '/admin/api/categoryTag/delete/check',
                            data: data
                        }).success(function(data){
                            if(data.completeDeletionIds != 0){
                                angular.forEach($scope.parentData, function(value, key) {
                                    if(value.cate_tag_id == item.cate_tag_id){
                                        $scope.parentData.splice(key, 1);
                                    }
                                });
                                $.toaster({ message : '已經刪除:<br/>'+data.completeDeletionIds});
                            }
                            if(data.cannotDeletedIds!= 0){
                                $.toaster({ message : '無法刪除:<br/>'+data.cannotDeletedIds+"<br/>(請檢查類別是否有掛商品或是階層)" ,  priority : 'warning'});
                            }
                        }).error(function() {
                        }) //error
                    }

                    $scope.getItemsAll = function(showItemId) {
                        var data = {
                            'selectLangItem': $scope.langId,
                            'searchByText': "",
                            'hierarchy_count' : 1,
                        };
                        $http({
                            method: "post",
                            url: '/admin/api/categoryTag/tree/json/' + $scope.productNum,
                            data: data
                        }).success(function(data) {
                            $scope.lightBoxItem.treeFamily=data;
                            if($scope.lightBoxItem.treeFamily.items.length != 0){
                                if(showItemId == 0){
                                    $scope.showId = $scope.lightBoxItem.treeFamily.items[0].cate_tag_id;
                                }
                            }
                        }).error(function() {
                            $.toaster({ message : '錯誤', priority : 'danger' });
                        }) //error
                    }

                    $scope.addLowerClass = function(item){
                        // $scope.actionType = 'add';
                        $scope.reset();
                        $scope.lightBoxItem.actionType= 'add';
                        // console.log($scope.lightBoxItem);
                        var data = {
                            'selectLangItem': $scope.langId,
                            'productNum':$scope.productNum,
                            'tagId':'', //目前tag ID
                            'pid':'',  
                            'level':'',
                        };
                        $http({
                            method: "post",
                            url: '/admin/api/categoryTag/hierarchy/show',
                            data: data
                        }).success(function(data) {
                            // $scope.trees =data.items; //需修改
                            $scope.lightBoxItem.trees=data.items;
                            $scope.lightBoxItem.treesSelect=parseInt(item.cate_tag_id);

                            setTimeout(function() {
                                $('.downSelect').selectMania('update');
                            }, 50);
                        }).error(function() {
                            $.toaster({ message : '錯誤', priority : 'danger' });
                        }) //error

                        $('#itemData').modal('show');
                    }

                    $scope.reset = function() {
                        // reset start ---------------------------------
                        $scope.lightBoxItem.cate_order =0;
                        $scope.lightBoxItem.cate_status =1;
                        $scope.lightBoxItem.lang_id =$scope.langId;
                        $scope.lightBoxItem.promote =1;
                        $scope.lightBoxItem.tag_img ="";
                        $scope.lightBoxItem.tag_img_wide ="";
                        if($scope.lightBoxItem.promote == 1){
                            $('.promoteBtn').addClass('active');
                        }else{
                            if($('.promoteBtn').hasClass('active')){
                                $('.promoteBtn').removeClass('active');
                            }
                        }

                        $scope.lightBoxItem.cate_id ="";
                        $scope.lightBoxItem.cate_name ="";
                        $scope.lightBoxItem.cate_subtitle ="";
                        $scope.lightBoxItem.cate_tag_desc ="";
                        $scope.lightBoxItem.cate_tag_img ="";
                        $scope.lightBoxItem.cate_name ="";
                        $scope.lightBoxItem.cate_subtitle ="";
                        $scope.lightBoxItem.cate_tag_desc ="";
                        // reset end ---------------------------------

                        delete $scope.lightBoxItem["cate_tag_id"];
                        delete $scope.lightBoxItem["hierarchy_count"];
                        delete $scope.lightBoxItem["hierarchy_id"];
                        delete $scope.lightBoxItem["parent_id"];
                    }

                    $scope.changeOrder= function(item) {
                        console.log(item)
                        if(isNaN(item.cate_order)){
                            item.cate_order = $scope.contrastContent.cate_order;
                            $.toaster({ message : '排序請填入數字',  priority : 'warning'})
                            return false;
                        }

                        $scope.result = angular.equals($scope.contrastContent, item);
                        if(!$scope.result){
                            if(item.cate_order != null){
                                item.cate_order = parseInt(item.cate_order);
                                $http({
                                    method : "put",
                                    url : "/admin/api/categoryTag/save/order",
                                    data: { 'item': item },
                                }).success(function(data){
                                    $.toaster({ message : '修改成功'});
                                    $scope.getItemsAll($scope.showId);
                                }).error(function(){
                                })//error
                            }else{
                                $.toaster({ message : '修改失敗'});
                                $scope.getItemsAll($scope.showId);
                            }
                        }
                    }

                    $scope.textRecording= function(item) {
                        $scope.contrastContent="";
                        $scope.contrastContent = angular.copy(item, $scope.contrastContent); 
                    }

                    $scope.addPro= function(item,productNum) {
                        $http({
                            method : "post",
                            url : '/admin/api/tag/buliding/product',
                            data: { 'productNum': productNum ,'tag':item },
                        }).success(function(data){
                            if(data.status == 400){
                                if (confirm( "有商品在建置中，是否要刪除商品")) {
                                    $scope.deletePro(item,productNum);
                                }else{
                                    $.toaster({ message : '請先去商品列表新增完成', priority : 'warning' });
                                }
                            }else if(data.status == 200){
                                location.href = '/admin/product/'+productNum+'/add';
                            }
                        }).error(function(){
                        })//error
                    }

                    $scope.deletePro= function(item,productNum) {
                        console.log(productNum)
                        $http({
                            method : "post",
                            url : "/admin/api/tag/delete/buliding/product",
                            data: { 'productNum': productNum ,'tag':item },
                        }).success(function(data){
                            if(data.status == 200){
                                location.href = '/admin/product/'+productNum+'/add';
                            }else if(data.status == 400){
                                $.toaster({ message : '發生錯誤', priority : 'danger' });
                            }
                        }).error(function(){
                        })//error
                    }
                },
            };
        });
    </script>
@endsection