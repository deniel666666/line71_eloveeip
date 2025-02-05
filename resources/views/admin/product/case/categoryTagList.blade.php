@extends('layouts.masterAdmin')

<!-- html title -->
@section('htmlTitle') {{$pageTitle}}  @endsection

@section('external_plugin')
  <link href="/js/select-mania/select-mania.css" rel="stylesheet" type="text/css">
  <link href="/js/select-mania/themes/select-mania-theme-orange.css" rel="stylesheet" type="text/css">
  <script src="/js/select-mania/js/select-mania.js"></script>
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
    <div class="col-12 clearfix mb-2">
      <!-- <select  id="lang_select" class="use-form-control maxWidth pdSpacing form-control b-radius-0 " ng-model='contCtrl.selectLangItem' ng-change="contCtrl.changedListLang()" ng-options="option.lang_id as option.lang_word for option in contCtrl.langs">
        <option ng-selected="true" value="">全部</option>
      </select> -->
      <div class="d-inline-block">
        <input class="use-form-control" style="width: 180px;" type='text' ng-model='contCtrl.searchText' />
        <span> <a href="" ng-click='contCtrl.getItems(0)'>搜尋</a></span>
        <span> |</span>
        <span> <a href="" ng-click='contCtrl.clearSearch()'>清除搜尋</a></span>
      </div>
    </div>
    <div class="col-lg-6 clearfix mb-2">
      <div class="admin-receivingMailBox">
        <a href="" data-toggle="modal" ng-click='contCtrl.add()' data-target="#itemData" class="btn-use addNewBtn"><span>新增</span></a>
      </div>
    </div>
    <div class="col-lg-6 clearfix mb-2">
      <div class="float-lg-right">
        <span> 共@{{contCtrl.count}}項</span>
        <span> <input class="use-form-control pdSpacing" type='text' ng-model="contCtrl.currentPage" style='width:50px;' readonly>/@{{contCtrl.pageCount}}</span>
        <span> <a href="" ng-click='contCtrl.prePage()'>上一頁</a></span>
        <span> <a href="" ng-click='contCtrl.nextPage()'>下一頁</a></span>
      </div>
    </div>
  </div>

  <!-- tag class start-->
  <div ng-show="contCtrl.tagNavList">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#" ng-click='contCtrl.firstTags()'>全顯示列表</a></li>
      <li class="breadcrumb-item" ng-repeat="item in contCtrl.breadcrumbList">
        <a href="" class="tagColor" ng-click='contCtrl.searchClassTags(item)'><span ng-bind="item.hierarchy_count"></span>階層 : </a>
        <a href="#" ng-bind="item.cate_name" data-toggle="modal" data-target="#itemData" ng-click='contCtrl.edit(item)'></a>
      </li>
      </ol>
    </nav>
  </div>
  <!-- tag class end-->

  <div>
    <table class="table table-bordered admin-table-rwd form">
      <thead>
        <tr class="admin-tr-only-hide">
          <th class="w-20px"><input type="checkbox" ng-model="contCtrl.selectedAll" ng-click="contCtrl.checkAll()" /></th>
          <th class="w-50px">編碼</th>
          <th class="w-65px">狀態</th>
          <!-- <th class="w-50px">階層</th> -->
          <th>分類名稱(編輯)</th>
          <!-- <th class="w-80px">總數量</th>
          <th class="w-80px">上架數量</th>
          <th class="w-50px">語系</th>
          <th class="w-100px">查詢按鈕</th> -->
          <th class="w-120px clear-fix">
            <span class="float-left">排序</span>
            <span class="float-right reloadBtn " ng-click="contCtrl.reload()">更新排序</span>
          </th>
        </tr>
      </thead>
      <tbody>
      <tr ng-repeat="(key,item) in contCtrl.items">
        {{-- @{{item}} --}}
        <td data-th="項目"><input type="checkbox" ng-model="item.selected" ng-click="contCtrl.checkWatch()" /></td>
        <td data-th="編碼">
          <span ng-bind="(key+1)*contCtrl.currentPage" tagId="@{{item.cate_tag_id}}"></span>
        </td>
        <td data-th="狀態"  ng-disabled="@{{item.cate_status == 1? 'item.itemColor =false': 'item.itemColor=true'}}" ng-class="{true: 'item_enable', false: 'item_disable'}[item.itemColor]">
          <span ng-bind="contCtrl.status[item.cate_status].name"></span>
        </td>
        <!-- <td data-th="階層" ng-bind="item.hierarchy_count"></td> -->
        <td data-th="分類名稱(編輯)"><a class="editInfor w-100 d-inline-block" href="" data-toggle="modal" data-target="#itemData" ng-click='contCtrl.edit(item)'><span ng-bind="item.cate_name"></span></a></td>
        <!-- <td data-th="總數量"><span ng-bind="item.pro.showProAll"></span></td>
        <td data-th="上架數量"><span ng-bind="item.pro.showProShelves"></span></td>
        <td data-th="語系"><span ng-bind="item.lang.lang_word"></span></td>
        <td data-th="查詢按鈕" ><a href="" ng-click='contCtrl.searchLowerTags(item)'>下階查詢</a></td> -->
        <td data-th="排序"><input type="text" class="use-form-control maxWidth" ng-model="item.cate_order" ng-blur="contCtrl.changeOrder(item)" onkeyup="value=value.replace(/[^\d]/g,'')"></td>
      </tr>
      </tbody>
    </table>
    <div class="row pageHeader">
        <div class="col-lg-6 clearfix ">
          <div class="admin-receivingMailBox">
            <a class="disableBtn btn-use" href="javascript:void(0);" ng-click='contCtrl.setStatus(1)'>啟用</a>
            <a class="enablewBtn btn-use" href="javascript:void(0);" ng-click='contCtrl.setStatus(0)'>停用</a>
            <a href="javascript:void(0);" class="deleteBtn btn-use" ng-click="contCtrl.remove()">刪除</a>
          </div>
        </div>
        <div class="col-lg-6" ng-hide="contCtrl.tagNavList">
          <div class="float-lg-right">
            <span> 共@{{contCtrl.count}}項</span>
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
            <h4 class="modal-title" ng-if='contCtrl.actionType == "add"'>新增分類</h4>
            <h4 class="modal-title" ng-if='contCtrl.actionType == "edit"'>修改分類</h4>
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
               <!-- <div class="col-12 use-box-btm">
                <span class="use-sp-title">副標題</span>
                <input class="form-control" type='text' ng-model="contCtrl.itemData.cate_subtitle" placeholder="請填入副標題">
              </div> -->
              <div class="col-12 use-box-btm" style="z-index: 600;">
                <!-- <span class="use-sp-title">父級分類</span>  -->
                <!-- ************************************************************************* -->
                <!-- <div id="selectBox">
                  <select id="select" class="downSelect ieSelect" ng-model="contCtrl.itemData.treesSelect" ng-options="m.cate_tag_id as m.cate_name for m in contCtrl.trees"> 
                    <option value="">-- 請選擇詢問項目 --</option>
                  </select>
                </div> -->
                <!-- m.cate_tag_id as m.cate_name for m in contCtrl.trees-->
                <!-- ************************************************************************* -->
              </div>

              <!-- //////////////////////////////////// -->
              <!-- <div class="col-12 use-box-btm">
                <span class="use-sp-title">上傳圖片(窄)</span>
                <div> -->
                  <!-- <input type="file" ng-file-select="onFileSelect($files)"  ng-model="contCtrl.itemData.tag_img" > -->
                  <!-- <div class="input-group">
                    <div class="custom-file">
                      <input type="file" ng-file-select="onFileSelect($files)" ng-model="contCtrl.itemData.tag_img" class="custom-file-input form-control-use line-style" id="file-@{{item.layoutId}}" value="sadsad">
                      <label class="custom-file-label" for="file-@{{item.layoutId}}">選擇檔案</label>
                    </div>
                  </div>
                  <div ng-if='contCtrl.itemData.tag_img != ""'>
                    <img width=220 ng-src="@{{contCtrl.itemData.tag_img}}" />
                    <button type="button" class="btn btn-danger" ng-click="contCtrl.clear_tag_img()">刪除</button>
                  </div>
                </div>
              </div>   -->

              <!-- <div class="col-12 use-box-btm">
                <span class="use-sp-title">上傳圖片(寬)</span>
                <div> -->
                  <!-- <input type="file" ng-file-select="onFileSelect($files)"  ng-model="contCtrl.itemData.tag_img_wide" > -->
                  <!-- <div class="input-group">
                    <div class="custom-file">
                      <input type="file" ng-file-select="onFileSelect($files)" ng-model="contCtrl.itemData.tag_img_wide" class="custom-file-input form-control-use line-style" id="file-@{{item.layoutId}}" value="sadsad">
                      <label class="custom-file-label" for="file-@{{item.layoutId}}">選擇檔案</label>
                    </div>
                  </div>
                  
                  <div ng-if='contCtrl.itemData.tag_img_wide != ""'>
                    <img width=220 ng-src="@{{contCtrl.itemData.tag_img_wide}}" />
                    <button type="button" class="btn btn-danger" ng-click="contCtrl.clear_tag_img_wide()">刪除</button>
                  </div>
                </div>
              </div>   -->
              <!-- //////////////////////////////////// -->

              <!-- <div class="col-12 use-box-btm">
                <span class="use-sp-title">圖片網址</span>
                <input class="form-control" type='text' ng-model="contCtrl.itemData.cate_tag_img" placeholder="請填入網址">
              </div> -->
              <!-- <div class="col-12 use-box-btm">
                <span class="use-sp-title">分類說明</span> -->
                <!-- <textarea style="margin: 0px; height: 253px; width: 280px;" ng-model="contCtrl.itemData.cate_tag_desc"></textarea> -->
                <!-- <div summernote ng-model="contCtrl.itemData.cate_tag_desc" config="noteOptions"></div>
              </div> -->
              <!-- <div class="col-12 use-box-btm">
                <span class="use-sp-title">語系</span>
                <div ng-if='contCtrl.actionType == "add"'>
                  <select id="lang_select" class="form-control" ng-model='contCtrl.itemData.lang_id' ng-change="contCtrl.selectTagLandId()" ng-options="option.lang_id as option.lang_word for option in contCtrl.editLangs"></select>
                </div>
                <div ng-if='contCtrl.actionType == "edit"'>
                  @{{contCtrl.itemData.lang.lang_word}}
                </div>
              </div> -->
              <div class="col-4 use-box-btm">
                <span class="use-sp-title">狀態</span>
                <select class="form-control" ng-model='contCtrl.selectItemStatus' ng-options='option.name for option in contCtrl.status' ng-change="contCtrl.itemSatausChange()"></select>
              </div>
              <div class="col-4 use-box-btm">
                <span class="use-sp-title">順序</span>
                <input class="form-control" type='text' ng-model="contCtrl.itemData.cate_order" placeholder="請填入順序" onkeyup="value=value.replace(/[^\d]/g,'')">
              </div>
              <div class="col-4 use-box-btm">
                <span class="use-sp-title mr-3">推薦</span>
                <span class="btnBox-use"> 
                  <button type="button" class="btn btn-lg btn-toggle promoteBtn" data-toggle="button" aria-pressed="false" autocomplete="off" ng-model='contCtrl.itemData.promote' ng-click="contCtrl.recommendToggle()">
                    <div class="switch"></div>
                  </button>
                </span>
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



<!-- *************************************************************************start -->

<script type="text/javascript">

  function select(){

    $('.downSelect').selectMania({

      themes: ['orange'],

      search: true

    });

  }

</script>

<!-- ************************************************************************* -->



  <script type="text/javascript">
    var app = angular.module('app', ['summernote']);
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

      self.listUrl        = '/admin/api/categoryTag/layer/find';
      self.hierarchyUrl   = '/admin/api/categoryTag/hierarchy/show';
      self.addUrl         = '/admin/api/categoryTag/add';
      self.saveUrl        = '/admin/api/categoryTag/save';
      self.setStatusUrl   = '/admin/api/categoryTag/setStatus';

      self.currentPage = 1;
      self.countOfPage = 20;

      self.level = 1;
      self.parentsHasId = '';

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

      self.setStatus = function(status) {

        var ids = self.checkAllItem(ids);

        self.setStatusItem(ids, status);

      };



      // *************************************************************************start

      self.add = function() {
        self.actionType = 'add';
        self.resetItem();
        self.addHierarchy(self.selectLangItem);
      };

      self.selectTagLandId= function() {
        // console.log(self.selectLangItem)
        self.addHierarchy(self.selectLangItem);
      }

      self.edit = function(item) {
        if(item.promote == 1){
          $('.promoteBtn').addClass('active');
        }else{
          if($('.promoteBtn').hasClass('active')){
            $('.promoteBtn').removeClass('active');
          }
        }
        self.hierarchyModify(item.cate_tag_id , item.parent_id , item.hierarchy_count ,item.lang_id); //tagId , 父Id , 階層  

        self.actionType = 'edit';
        self.itemData = item;

        if(self.itemData.tag_img == null){
          self.itemData.tag_img = '';
        }

        if(self.itemData.tag_img_wide == null){
          self.itemData.tag_img_wide = '';
        }

        self.selectItemStatus = self.status[item.cate_status];
      };
      // *************************************************************************
      //======= area  end=======

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
            ids.push(item.cate_tag_id);
          }
        });
        return ids;
      };

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
        self.itemData.lang_id = self.langs[0]['lang_id'];
        self.itemData.cate_status = 1;
        self.itemData.promote =1;
        $('.promoteBtn').addClass('active');
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

      self.itemSatausChange = function() {
        self.itemData.cate_status = self.selectItemStatus.value;
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
      // *************************************************************************start
      self.addItem = function() {
        self.itemData.cate_id = self.productNum;
        var data = { 'item': self.itemData };
        if(self.itemData.treesSelect != undefined){
          angular.forEach(self.trees, function(item ,key ) {
            if(self.trees[key].cate_tag_id == self.itemData.treesSelect){
              self.itemData.treesSelect =self.trees[key];
            }
          });
        }
        self.actionItem("post", self.addUrl, data);
      }

      self.saveItem = function() {
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
            self.actionType = 'add';
            self.resetItem();
            self.getItems();
            // *************************************************************************start
            self.addHierarchy(self.selectLangItem);
            // *************************************************************************
          } else {
            $.toaster({ message : '資料庫無回應',  priority : 'warning'})
          }
        }).error(function() {
          $.toaster({ message : '錯誤', priority : 'danger' });
        }) //error
      }

      // Pagination localStorage start -------------------------------------------
      if(localStorage.getItem("{{$_SERVER['REQUEST_URI']}}") !== null && localStorage.getItem("{{$_SERVER['REQUEST_URI']}}") !== 'null' ){
        self.currentPage = localStorage.getItem("{{$_SERVER['REQUEST_URI']}}");
      }else{
        // localStorage.clear();
        localStorage.setItem( "{{$_SERVER['REQUEST_URI']}}" , null);
      }

      self.setPage = function(page) {
        localStorage.setItem( "{{$_SERVER['REQUEST_URI']}}" ,page);
      }
      // -------------------------------------------------------------------------

      self.getItems = function(search) {
        if(search==0){
          self.currentPage = 1;
        }
        var data = {
          'langId': self.selectLangItem,
          'searchByText': self.searchText,
          'currentPage': self.currentPage,
          'countOfPage': self.countOfPage,
          'level': self.level,
          'productNum' :self.productNum,
        };
        console.log(data);
        // Pagination localStorage start -------------------------------------------
        self.setPage(self.currentPage);
        // -------------------------------------------------------------------------
        $http({
          method: "post",
          url: self.listUrl,
          data: data
        }).success(function(data) {

          // console.log(data)
          self.count = data.count;
          self.pageCount = data.pageCount;
          self.items = data.items;

          self.tagNavList = false;
        }).error(function() {
          $.toaster({ message : '錯誤', priority : 'danger' });
        }) //error

      }
      self.getItems();

      self.getlangs = function(){
        $http({
          method: "get",
          url: '/admin/api/lang',
        }).success(function(data) {
          self.langs = data.langs;
          self.editLangs = data.langs;
        }).error(function() {
          $.toaster({ message : '錯誤', priority : 'danger' });
        }) //error
      }
      self.getlangs();
      //CRUD ====== end =======


      // *************************************************************************start
      ////////////////////////////////////////////////
      ///////////////   hierarchy   //////////////////
      ////////////////////////////////////////////////
      self.hierarchy = function(lang_id) {
        var data = {
          'selectLangItem': lang_id,
          'productNum':self.productNum,
        };
        $http({
          method: "post",
          url: self.hierarchyUrl,
          data: data
        }).success(function(data) {
          // console.log(data)
          self.trees =data.items;
          setTimeout(function() {
            select();
          }, 50);
        }).error(function() {
          $.toaster({ message : '錯誤', priority : 'danger' });
        }) //error
      }
      self.hierarchy(self.selectLangItem);

      self.addHierarchy = function(lang_id) {
        var data = {
          'selectLangItem': lang_id,
          'productNum':self.productNum,
        };
        $http({
          method: "post",
          url: self.hierarchyUrl,
          data: data
        }).success(function(data) {
          self.trees =data.items;
          setTimeout(function() {
            $('.downSelect').selectMania('update');
          }, 50);
        }).error(function() {
          $.toaster({ message : '錯誤', priority : 'danger' });
        }) //error
      }

      self.hierarchyModify = function(tagId,parentId,level ,lang_id) {
        var data = {
          'selectLangItem': lang_id ,
          'productNum':self.productNum,
          'tagId':tagId, //目前tag ID
          'pid':tagId,  
          'level':parseInt(level)+1,
        };
        $http({
          method: "post",
          url: self.hierarchyUrl,
          data: data
        }).success(function(data) {
          self.trees =data.items;
          self.itemData.treesSelect=parseInt(parentId);
          setTimeout(function() {
            $('.downSelect').selectMania('update');
          }, 50);
          // console.log(self.trees)
        }).error(function() {
          $.toaster({ message : '錯誤', priority : 'danger' });
        }) //error
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
              angular.forEach(self.trees, function(item ,key ) {
                if(self.trees[key].cate_tag_id == self.itemData.treesSelect){
                  self.saveSelect =self.trees[key];
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
      self.firstTags = function() {
        self.tagNavList = false;
        self.getItems();
      }

      /*下階查看*/
      self.searchLowerTags = function(item) {
        console.log(item);
        self.tagIds = jQuery.parseJSON( item.hierarchy_id );
        self.searchTagsIds(self.tagIds);
        var data = {
          'productNum':self.productNum,
          'langId': self.selectLangItem,
          'searchByText':'',
          'level':parseInt(item.hierarchy_count)+1,
          'parentsHasId':item.cate_tag_id,
          'status':0,
        };

        $http({
          method: "post",
          url: '/admin/api/categoryTag/layer/find',
          data: data
        }).success(function(data) {
          self.tagNavList =true;
          self.items = data.items;
          angular.forEach(self.items, function(item ,key) {
            self.items[key].pro=[];
            self.items[key].pro.showProAll=self.items[key].showProAll;
            self.items[key].pro.showProShelves=self.items[key].showProShelves;
          });
          // promote
        }).error(function() {
          $.toaster({ message : '錯誤', priority : 'danger' });
        }) //error
      };

      self.searchTagsIds = function(item) {
        var breadcrumbSearch=[];
        angular.forEach(item, function(item) {
          breadcrumbSearch.push(item)
        });

        $http({
          method: "post",
          url: self.listUrl,
          data: {'idArray': JSON.stringify(breadcrumbSearch)}
        }).success(function(data) {
          self.breadcrumbList =data.items; 
        }).error(function() {
          $.toaster({ message : '錯誤', priority : 'danger' });
        }) //error
      };

      self.searchClassTags = function(item) {
        self.searchLowerTags(item)
      };


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
            $.toaster({ message : '無法刪除類別有:<br/>'+data.cannotDeletedIds+"<br/>(請檢查類別是否有掛商品或是階層)"});
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
    });
  </script>
@endsection