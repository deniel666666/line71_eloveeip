@extends('layouts.masterAdmin')

<!-- html title -->
@section('htmlTitle') {{$pageTitle}}  @endsection

@section('external_plugin')
    <!-- DateTime -->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/css/tempusdominus-bootstrap-4.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/js/tempusdominus-bootstrap-4.min.js"></script>
  
    <!-- select -->
    <link href="/js/select-mania/select-mania.css" rel="stylesheet" type="text/css">
    <link href="/js/select-mania/themes/select-mania-theme-orange.css" rel="stylesheet" type="text/css">
    <script src="/js/select-mania/select-mania.js"></script>

    <!-- tagify -->
    <!-- <link href="/js/tagify-master/tagify.css" rel="stylesheet" type="text/css">
    <script src="/js/tagify-master/tagify.js"></script> -->

    <!-- tabs -->
    <link href="/js/multipurpose_tabcontent-master/css/style.css" rel="stylesheet" type="text/css">
    <script src="/js/multipurpose_tabcontent-master/js/jquery.multipurpose_tabcontent.js"></script>

    <!-- upload-more-image -->
    <link href="/ng-template/upload-more-image/upload-more-image.css" rel="stylesheet" type="text/css">

    <style type="text/css">
        hr.area_break{
            margin-top: 20px 0px;
        }

        #tabs_box .controller{
            display: none;
        }
    </style>
@endsection

<!-- 自定義 content -->
@section('content')
    <div class="w-100 mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">{{$topTitle}}</li>
                <li class="breadcrumb-item">{{$pageTitle}}</li>
                @section('act_name')
                    <li class="breadcrumb-item active" aria-current="page">新增</li>
                @show
            </ol>
        </nav>
    </div>
    <div class="container-fluid">
        <div class="form-group">
            <div id="adminMainIntro">
                <!-- <div class="leftBox">
                    <div class="main-img-box admin mb-2">
                        <div class="box">
                            <div ng-if="contCtrl.item.prod_img" class="adminImg-responsive-1By1" ng-style="{'background-image': 'url('+contCtrl.item.prod_img+')'}"></div>
                        </div>
                    </div>
                    <div><span>主圖(必須上傳)：</span></div>
                    <div class="custom-file">
                        <input class="inputFile w-100" type="file" mo-block="0" ng-file-select="onFileSelect($files)" ng-model="contCtrl.item.prod_img" class="custom-file-input form-control-use line-style" id="file-main-img" pro-num='contCtrl.productNum' content-item='contCtrl.item' pro-id="contCtrl.productId" value="">
                        <label class="custom-file-label" for="file-main-img">選擇檔案</label>
                    </div>
                    <span class="herinneren-use">建議尺寸：220x75px</span>
                </div> -->
                <div class="rightBox">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <span class="use-sp-title">歸屬對象 :</span>
                            <select class="use-form-control" style="width: 150px;" ng-options='option.value as option.name for option in contCtrl.memberOptions' ng-model='contCtrl.item.selectUser' ng-blur="contCtrl.modifyItemOnwer(contCtrl.item)" >
                    
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <span class="use-sp-title">總排序：</span>
                            <input type='text' ng-model="contCtrl.item.prod_order" placeholder="請填入順序" class="form-control input-sm" ng-blur="contCtrl.modifyItem(contCtrl.item)" ng-focus="contCtrl.textRecording(contCtrl.item)">
                            <span class="herinneren-use">數字小的在前面</span>
                        </div>
                        <div class="col-md-6 mb-2 d-flex justify-content-between">
                            @section('select_lang')
                                <div></div>
                            @show
                            <h4 class="use-h4-title d-flex align-items-center"><a href="" data-toggle="modal" data-target="#seoPropertyModal" data-backdrop="static" data-keyboard="false"><span>編輯<br>SEO</span></a></h4>
                        </div>

                        <div class="col-12 mb-2">
                            <span class="use-sp-title">報名狀態：</span>
                            <select class="form-control"  ng-model="contCtrl.item.prod_main_sku" ng-blur="contCtrl.modifyItem(contCtrl.item)" ng-focus="contCtrl.textRecording(contCtrl.item)">
                                <option value="可報名">可報名</option>
                                <option value="即將額滿">即將額滿</option>
                                <option value="已額滿">已額滿</option>
                            </select>
                        </div>
                        <div class="col-12 mb-2">
                            <span class="use-sp-title">行銷主題：</span>
                            <input type='text' ng-model="contCtrl.item.prod_name" placeholder="" class="form-control input-sm" ng-blur="contCtrl.modifyItemName(contCtrl.item)" ng-focus="contCtrl.textRecording(contCtrl.item)">
                            <span class="mark-use">必填</span>
                        </div>
                        <div class="col-12 mb-2">
                            <span class="use-sp-title">年度波次：</span>
                            <input type='text'  placeholder="" class="form-control input-sm" ng-model="contCtrl.item.prod_subtitle" ng-blur="contCtrl.modifyItem(contCtrl.item)" ng-focus="contCtrl.textRecording(contCtrl.item)">
                        </div>
                        <div class="col-12 mb-2" ng-repeat="(key , t) in contCtrl.propertyTag">
                            <span class="use-sp-title" ng-bind="t.prop_tag_name"></span>
                            <span class="herinneren-use" ng-if="t.prop_tag_name=='額外提醒信箱：'">
                                收到回函時會提醒「系統管理」>「通知設定」所設定之對象外，也會提醒此處設定之信箱。可以<b>英文逗號(,)</b>分隔，額外提醒多個信箱。
                            </span>
                            <div ng-if="t.prop_type == 1">
                                <input class="form-control" type="text" ng-model="t.prod_prop" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)">
                            </div>
                            <div ng-if="t.prop_type == 2">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="custom-file w-100">
                                            <input class="inputFile w-100" type="file" mo-block="1" ng-file-select="onFileSelect($files)" ng-model="t.prod_img_path" class="custom-file-input form-control-use line-style" id="fileImg-@{{key}}" pro-num='contCtrl.productNum' content-item='contCtrl.propertyTag' pro-id="[t.prop_tag_id ,contCtrl.productId]" value="contCtrl.productId">
                                            <label class="custom-file-label" for="fileImg-@{{key}}">選擇檔案</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2" ng-if="t.prod_img_path != ''">
                                        <div class="adminImg-responsive-4halfBy3" ng-style="{'background-image': 'url('+t.prod_img_path+')'}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 分類 start -->
                        <div class="col-md-12 mb-3">
                            <div class="w-100 categoryTagsBox d-none">
                                <label class="" ng-repeat="r in contCtrl.categoryTags">
                                    <input type="checkbox" ng-model="r.status" ng-true-value="1" ng-false-value="0" ng-click="contCtrl.clickCheck(r)" ><span ng-bind="r.cate_name"></span><br />
                                </label>
                            </div>
                            <div>
                                <div>
                                    <h4 class="use-h4-title">分類選取 :</h4>
                                    <span class="mark-use">(至少選取一個分類)</span>
                                </div>
                                <div>
                                    <span class="badge badge-dark tagsLabel" ng-if="r.status" ng-repeat="r in contCtrl.categoryTags" ><span ng-bind="r.cate_name"></span></span>
                                </div>
                            </div>
                            <div id="selectBox" class="mb-2">
                                <select id="select" class="downSelect ieSelect" 
                                        ng-model="contCtrl.treesSelect" 
                                        ng-change="contCtrl.selectChange()" 
                                        ng-options="m.cate_tag_id as m.cate_name disable when (m.hierarchy_count==0) for m in contCtrl.categoryTags" multiple></select>
                            </div>
                            <div class="d-none">
                                <button ng-click="contCtrl.selectSend()" type="button" class="btn btn-secondary w-100" id="tagsEnter">確認送出修改</button>
                            </div>
                        </div>

                        <!-- 副圖上傳 start -->
                        <div class="col-lg-12 mb-3">
                            <h4 class="use-h4-title">大圖輪播</h4>
                            <div class="row">
                                <div class="col-12">
                                    <div class="uploadMoreImgs">
                                        <div more-img-upload method="POST" url="/admin/api/product/img" key="contCtrl.productId" data="contCtrl.productImg"></div>
                                    </div>
                                    <span class="herinneren-use">建議上傳尺寸：圖1(電腦)：1920x320px，圖2(手機)：640x700px。越晚新增的排越後面。</span>
                                </div>
                            </div>
                            <table class="table table-bordered admin-table-rwd form">
                                <thead>
                                    <tr class="admin-tr-only-hide">
                                        <th style="width: 300px;">圖片預覽</th>
                                        <th>圖片名稱</th>
                                        <th>連結網址<span class="herinneren-use">請輸入含https:// 或 http:// 的網址</span></th>
                                        <th class="w-200px">順序<span class="herinneren-use">數字小的在前面</span></th>
                                        <th class="w-65px">刪除</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="t in contCtrl.productImg">
                                        <td data-th="圖片預覽">
                                            <div class="row">
                                                <div class="col-lg-6 col-12">
                                                    <div class="adminImg-responsive-4halfBy3"
                                                         ng-style="{'background-image': 'url('+t.prod_img_name+')', 'max-width':'100px', 'padding-bottom':'100px'}"></div>
                                                    <input type="file" ng-file-product-img-select="onFileProductImgSelect($files)" 
                                                                       ng-model="t" product-img-column="'prod_img_name'" style="width: 85px;">
                                                    <button type="button" class="btn btn-danger" ng-click='contCtrl.delColumnImg(t, "prod_img_name")'>x</button>
                                                </div>
                                                <div class="col-lg-6 col-12">
                                                    <div class="adminImg-responsive-4halfBy3"
                                                         ng-style="{'background-image': 'url('+t.prod_img_name2+')', 'max-width':'100px', 'padding-bottom':'100px'}"></div>
                                                    <input type="file" ng-file-product-img-select="onFileProductImgSelect($files)" 
                                                                       ng-model="t" product-img-column="'prod_img_name2'" style="width: 85px;">
                                                    <button type="button" class="btn btn-danger" ng-click='contCtrl.delColumnImg(t, "prod_img_name2")'>x</button>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-th="圖片名稱">
                                            <input class="use-form-control pdSpacing w-100" type="text" ng-model="t.prod_name" ng-blur="contCtrl.editSubImg(t)" ng-focus="contCtrl.textRecording(contCtrl.productImg)">
                                        </td>
                                        <td data-th="連結網址">
                                            <input class="use-form-control pdSpacing w-100" type="text" ng-model="t.img_desc" ng-blur="contCtrl.editSubImg(t)" ng-focus="contCtrl.textRecording(contCtrl.productImg)">
                                        </td>
                                        <td data-th="順序">
                                            <input class="use-form-control pdSpacing w-100" type="text" ng-model="t.prod_order" ng-blur="contCtrl.editSubImg(t)" ng-focus="contCtrl.textRecording(contCtrl.productImg)">
                                        </td>
                                        <td data-th="刪除" ng-click='contCtrl.delImg(t)'><button type="button" class="btn btn-danger">x</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- 主體內容 start -->
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <h4 class="use-h4-title">回函表介紹</h4>
                                <!-- <button type="button" class="btn btn-warning" ng-click='contCtrl.saveDescribeModal()' data-dismiss="modal">儲存</button> -->
                            </div>
                            <div class="row use-box">
                                <div class="col-12 use-box-btm" ng-repeat="r in contCtrl.productDescribe">
                                    <div ng-if="r.prod_describe_type == 'ProdNo'">
                                        <span class="use-sp-title">是否使用回函表：</span>
                                        <sapn class="form-group">
                                            <input id="use_contact" type="checkbox" ng-model="r.prod_describe" 
                                                   ng-checked="r.prod_describe"
                                                   ng-change="contCtrl.modifyDescribe(contCtrl.productDescribe)" ng-true-value="'否'">
                                            <label for="use_contact" style="cursor: pointer;">否 (若勾選，則回函表介紹、簡易問答等資訊都將不顯示)</label>
                                        </sapn>
                                    </div>
                                    <div ng-if="r.prod_describe_type == 'ProdKey'">
                                        <span class="use-sp-title">回函表置上：</span>
                                        <sapn class="form-group">
                                            <input id="top_contact" type="checkbox" ng-model="r.prod_describe" 
                                                   ng-checked="r.prod_describe"
                                                   ng-change="contCtrl.modifyDescribe(contCtrl.productDescribe)" ng-true-value="'是'">
                                            <label for="top_contact" style="cursor: pointer;">是 (若勾選，則回函表顯示於大圖輪播之下；若不勾選擇顯示於介紹之下)</label>
                                        </sapn>
                                    </div>
                                    <div ng-if="r.prod_describe_type == 'ProdSimpleIntro'">
                                        <!-- <span class="use-sp-title">主體介紹</span> -->
                                        <!-- <textarea class="form-control" style="height: 100px;" ng-model="r.prod_describe"></textarea> -->
                                        <div summernote ng-model="r.prod_describe" config="noteOptions" id="prodDescribeBox"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 主體包裝 type start -->
                        <div class="col-12 mb-3">
                            <div class="tableBoxUse">
                                <h4 class="use-h4-title">
                                    簡易問答
                                    <!-- <span class="herinneren-use">請都輸入是非問答</span> -->
                                    <span class="herinneren-use">問答皆為單選題，請以<b>英文逗號(,)</b>分隔選項</span>
                                </h4>
                                <a class="link" href="javascript:void(0)" ng-click="contCtrl.addProductTypeModal()"><span>+</span></a>
                            </div>
                            <table class="table table-bordered admin-table-rwd form">
                            <thead>
                                <tr class="admin-tr-only-hide">
                                    <th scope="col">問題</th>
                                    <th scope="col">類型</th>
                                    <th scope="col">必填</th>
                                    <th scope="col">選項(僅當類型為「單選」、「多選」才有用)</th>
                                    <th class="w-65px" scope="col">狀態</th>
                                    <th class="w-65px" scope="col">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="item in contCtrl.productType">
                                    <td data-th="問題">
                                        <input class="use-form-control pdSpacing w-100" type="text" ng-model="item.prod_type" ng-blur="contCtrl.saveProductTypeModal(item)" ng-focus="contCtrl.textRecording(item)">                              
                                    </td>
                                    <td data-th="類型">
                                        <!-- 價格 -->
                                        <select class="use-form-control pdSpacing w-100" ng-model="item.type_price" ng-change="contCtrl.saveProductTypeModal(item)">
                                            <option value="0">單選</option>
                                            <option value="1">多選</option>
                                            <option value="2">文字</option>
                                            <option value="3">檔案</option>
                                        </select>
                                        <!-- <input class="use-form-control pdSpacing w-100" type="text" ng-model="item.type_price" ng-blur="contCtrl.saveProductTypeModal(item)" ng-focus="contCtrl.textRecording(item)"> -->                       
                                    </td>
                                    <td data-th="必填">
                                        <!-- 售價 -->
                                        <select class="use-form-control pdSpacing w-100" ng-model="item.type_sales_price" ng-change="contCtrl.saveProductTypeModal(item)">
                                            <option value="0">否</option>
                                            <option value="1">是</option>
                                        </select>
                                        <!-- <input class="use-form-control pdSpacing w-100" type="text" ng-model="item.type_sales_price" ng-blur="contCtrl.saveProductTypeModal(item)" ng-focus="contCtrl.textRecording(item)"> -->
                                    </td>
                                    <td data-th="選項">
                                        <input class="use-form-control pdSpacing w-100" type="text" ng-model="item.prod_sn" ng-blur="contCtrl.saveProductTypeModal(item)" ng-focus="contCtrl.textRecording(item)">                                
                                    </td>
                                    <td data-th="狀態">
                                        <a href="javascipt:void(0)" ng-bind="contCtrl.productTypeStatus[item.type_status].name" ng-click="contCtrl.changeProductTypeStatus(item)"></a>
                                    </td>
                                    <td data-th="操作">
                                        <button ng-click='contCtrl.delProductType(item.prod_type_id)' type="button" class="btn btn-danger">x</button>
                                    </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 
        </div>

        <div class="form-group">
            @section('bottom_btn')
            <div class="row mb-2">
                <div class="col-6 use-box-btm">
                    <button class="btn btn-danger btn-block" ng-click="contCtrl.deleteItem()">刪除</button>
                </div>
                <div class="col-6 use-box-btm">
                    <button class="btn btn-success btn-block" ng-click="contCtrl.addItem()">下一步</button>
                </div>
            </div>
            @show
        </div>

        <br>
        <br>
        <br>
        <br>
    </div>

    <!--seoPpropertyModal start -->
    <div class="modal fade" id="seoPropertyModal" tabindex="-1" role="dialog" aria-labelledby="seoPropertyModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">編輯SEO</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row use-box">
                        <div class="col-12 use-box-btm" ng-repeat="t in contCtrl.getSeoProperty">
                            <span class="use-sp-title"><span ng-bind="t.seo_name"></span></span>
                            <!-- text -->
                            <div ng-if='t.seo_type ==1'>
                                <input class="form-control" type="text" ng-model="t.prod_prop" placeholder="請填入@{{t.seo_placeholder}}">
                            </div>
                            <!-- img -->
                            <div ng-if='t.seo_type ==2'>
                                <div class="row">
                                    <div class="col-5">
                                        <div class="form-group">
                                            <input type="file" class="form-control-file" id="seoFile" ng-file-select-seo="onFileSelect($files)" ng-model="t.prod_img_path">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <img id="prodImgAdd" style="width: 100%;" ng-src="@{{t.prod_img_path}}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" ng-click="contCtrl.saveSeoPropertyModal()" data-dismiss="modal">儲存</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" ng-click='contCtrl.close()'>關閉</button>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- 自定義 javascript -->
@section('javascript')
    <script>
        function selectClick(e){
            let btn = document.getElementById("tagsEnter");
            setTimeout(function(){ 
                btn.click();
            }, 100);
        }
    </script>
    <script>
        function tabsAnimation(className ,activeNum){
            $(className).champ({
                plugin_type: "tab",
                side: "",
                active_tab: activeNum,
                controllers: "true",
                ajax: "false",
            });
        }
    </script>

    <script type="text/javascript">
        //   var app = angular.module('app', ['angular.circular.datetimepicker']);
        var app = angular.module('app', ['summernote']);
            app.controller('ContentController', ['$scope', '$http','$sce', function($scope, $http,$sce) {
            var currentPath = window.location.pathname;
            var currPathAry = currentPath.split("/");

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

                height: 400,
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
                callbacks: { 
                    onImageUploadError: function(msg) { alert(msg + ' (圖片尺寸超過1920px*1920px-3.52 MB)'); },
                    onPaste: function (e) {
                        var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                        e.preventDefault();
                        document.execCommand('insertText', false, bufferText);
                    },
                    onFocus: function(item) {
                        // console.log( $(this).summernote('code') )
                        self.textRecording($(this).summernote('code'));
                        // console.log(self.contrastContent)
                    },
                    onBlur: function() {
                        // console.log(this)
                        $scope.check_and_update_summernote(this);
                    },
                    onBlurCodeview: function(ori_code, e) {
                        target_summernote = $(e.target).parent().parent().prev()[0]
                        // console.log(target_summernote)
                        int = target_summernote['id'];
                        if(int != 'prodDescribeBox'){
                            angular.forEach(self.getTabsTags, function(item ,key) {
                                if(item.prop_tag_id == int ){
                                    self.getTabsTags[key].prod_prop = ori_code;
                                }
                            });
                        }
                        $scope.check_and_update_summernote(target_summernote);
                    },
                    onChange: function(item) {
                        // console.log('onChange')
                    },
                },
            };
            $scope.check_and_update_summernote = function(target){
                $scope.result = angular.equals(self.contrastContent, $(target).summernote('code') );                  
                if(!$scope.result){
                    if($(target)[0]['id'] == 'prodDescribeBox'){
                        self.saveDescribeModal();
                    }else{
                        let int = $(target)[0]['id'];
                        int = parseInt(int);
                        angular.forEach(self.getTabsTags, function(item ,key ) {
                            if(item.prop_tag_id == int){
                                let data = { 'item':item, 'productId': self.tabsProductId , 'lang':self.lang.lang_id };
                                $http({
                                    method: "put",
                                    data: data,
                                    url: '/admin/api/prod_tabs/edit',
                                }).success(function(data) {
                                    if(data.status == 200){
                                        self.getTabsTags =data.getTabsTag;
                                        $.toaster({ message : '修改成功'});
                                    }else{
                                        $.toaster({ message : '資料庫無回應',  priority : 'warning'})
                                    }
                                }).error(function() {
                                    $.toaster({ message : '網路錯誤', priority : 'danger' });
                                }) //err
                            }
                        });
                    }
                }
                if($(target).next().hasClass('codeview')){
                    $(target).summernote('codeview.toggle');
                }
            }

            var self = this;
            
            self.memberOptions={};
            
            @foreach($member_list as $member)
                var member = {
                    value: {{$member['id']}},
                    name: "{{$member['user_name']}}",
                }
                self.memberOptions[{{$member['id']}}]=member;
            @endforeach
            

            self.productId = "{{$productId}}";
            self.listUrl = '/admin/api/product/detail/edit'; /*取得商品完整內容api*/
            self.staticFilePath = '/upload/product/';           /*靜態檔案讀取位置*/
            self.need_content = true; /*需編輯詳細內容*/
            // self.need_content = false; /*無需編輯詳細內容*/

            @section('angular_js')
            {
                /*新增特有method-----------------開始*/
                self.auto_click_tag = true; /*需自動勾選tag*/
                // self.auto_click_tag = false; /*無需自動勾選tag*/

                self.mainEditUrl = '/admin/api/product/main/edit';
                self.changeStatusUrl = '/admin/api/product/status';
                self.deleteUrl = '/admin/api/product/delete';
                self.getLangUrl = "/api/lang";

                self.getLang = function(){
                    $http({
                        method : "get",
                        url : self.getLangUrl,
                    }).success(function(data){
                        if (data.status=='200'){
                            self.langs=  data.langs;
                        }else{
                            alert('資料庫無回應');
                        }
                    }).error(function(){
                        alert('網路錯誤');
                    })//error
                }
                self.getLang();

                self.langSelect = function(item) {
                    if(item.prod_order == null){
                        item.prod_order = 0;
                    }
                    item['prod_id'] = self.productId;

                    let data = { 'item': item, 'productId': self.productId };
                    $http({
                        method: 'put',
                        url: self.mainEditUrl,
                        data: data
                    }).success(function(data) {
                        console.log(data)
                        if (data.status == '200') {
                            location.reload();
                        } else {
                            $.toaster({ message : '資料庫無回應',  priority : 'warning'})
                        }
                    }).error(function() {
                        $.toaster({ message : '發生錯誤', priority : 'danger' });
                    }) //error
                }

                self.addItem = function(){
                    
                    if(self.item.selectUser == undefined){
                        $.toaster({ message : '請選擇對象',  priority : 'warning'})
                        return false;
                    }
                    if( self.item.prod_name == "" || self.item.prod_name ==null ){
                        alert('請填寫名稱');
                        return false;
                    }

                    if(self.endDateStatus == 0){
                        if(self.item.prod_e_datetime <=  self.item.prod_s_datetime){
                            alert('結束日期不能小於等於開始時間');
                            return false;
                        }
                    }else{
                        self.item.prod_e_datetime = '2222-01-01 00:00:00';  //2018-01-01 08:00:00
                    }

                    if( self.item.prod_img == "" || self.item.prod_img ==null){
                        alert('請上傳主圖片');
                        return false;
                    }

                    var checkCategoryTag = 0;
                    angular.forEach(self.categoryTags, function(item) {
                        if (item.status == 1) {
                            checkCategoryTag = 1;
                        }
                    });

                    if (checkCategoryTag == 0) {
                        alert('請至少選擇一個分類');
                        return false;
                    }

                    var data = {'productId': self.item.prod_id, 'type':'prod_status', 'status':0,'owner':self.item.selectUser};
                    self.actionItem('add','put', self.changeStatusUrl, data); // 下一步驟
                }

                self.deleteItem = function(){
                    if(self.item.prod_id){
                        if (confirm( "確定刪除此此次新增？")) {
                            var data = {'productId': self.item.prod_id};
                            self.actionItem('del','put', self.deleteUrl, data);
                        }
                    }
                }

                self.getItems = function() {
                    let data = { 'productId': self.productId };
                    $http({
                        method: "post",
                        data: data,
                        url: self.listUrl,
                    }).success(function(data) {
                        self.categoryTags = data.categoryTags;
                        
                        var downSelectVal=[];
                        angular.forEach(self.categoryTags, function(item ,key ) {
                            if(self.categoryTags[key].status == 1){
                                downSelectVal.push('number:'+self.categoryTags[key].cate_tag_id)
                            }
                        });

                        if(self.auto_click_tag && self.categoryTags.length!=0){ /*需自動勾選tag 且 有tag可勾選*/
                            self.categoryTags[0].status = 1; /*修改勾選狀態*/
                            self.clickCheck();               /*送出資料*/
                            self.auto_click_tag = false;     /*停止重複處理*/
                        }else{
                            setTimeout(function() {
                                self.select();
                                $('.downSelect').val(downSelectVal);
                                $('.downSelect').selectMania('update');
                            }, 50);
                        }

                        self.lang = data.lang;
                        self.item = data.item;
                        @if($role=='member')
                        self.item.selectUser = '{{$user_id}}';
                        @endif
                        //console.log(self.item);
                        // self.item.prod_s_datetime =Date.parse(new Date(self.item.prod_s_datetime));

                        //----------------------------------------------------------------
                        //----------------------------------------------------------------
                        //----------------------------------------------------------------
                        //----------------------------------------------------------------
                        $('#proShowStartTime').datetimepicker({
                            defaultDate: self.item.prod_show_s_datetime ,
                            locale: 'zh-tw',
                            format: 'YYYY-MM-D',
                            ignoreReadonly: true,
                            icons: {
                                time: "fa fa-clock-o",
                                date: "fa fa-calendar",
                                up: "fa fa-arrow-up",
                                down: "fa fa-arrow-down"
                            }
                        });

                        $('#proShowEndTime').datetimepicker({
                            defaultDate: self.item.prod_show_e_datetime ,
                            locale: 'zh-tw',
                            format: 'YYYY-MM-D',
                            ignoreReadonly: true,
                            icons: {
                                time: "fa fa-clock-o",
                                date: "fa fa-calendar",
                                up: "fa fa-arrow-up",
                                down: "fa fa-arrow-down"
                            }
                        });

                        $("#proShowStartTime").on("change.datetimepicker", function (e) {
                            $('#proShowEndTime').datetimepicker('minDate', e.date);
                        });

                        $("#proShowEndTime").on("change.datetimepicker", function (e) {
                            $('#proShowStartTime').datetimepicker('maxDate', e.date);
                        });

                        // ----------------------------------------------------------------------------

                        $('#proStartTime').datetimepicker({
                            defaultDate: self.item.prod_s_datetime ,
                            locale: 'zh-tw',
                            format: 'YYYY-MM-D HH:mm:ss',
                            ignoreReadonly: true,
                            icons: {
                                time: "fa fa-clock-o",
                                date: "fa fa-calendar",
                                up: "fa fa-arrow-up",
                                down: "fa fa-arrow-down"
                            }
                        });

                        $('#proEndTime').datetimepicker({
                            defaultDate: self.item.prod_e_datetime,
                            locale: 'zh-tw',
                            format: 'YYYY-MM-D HH:mm:ss',
                            ignoreReadonly: true,
                            icons: {
                                time: "fa fa-clock-o",
                                date: "fa fa-calendar",
                                up: "fa fa-arrow-up",
                                down: "fa fa-arrow-down"
                            }
                        });

                        $("#proStartTime").on("change.datetimepicker", function (e) {
                            $('#proEndTime').datetimepicker('minDate', e.date);
                        });

                        $("#proEndTime").on("change.datetimepicker", function (e) {
                            $('#proStartTime').datetimepicker('maxDate', e.date);
                        });
                        //----------------------------------------------------------------
                        //----------------------------------------------------------------
                        //----------------------------------------------------------------
                        //----------------------------------------------------------------

                        self.productNum = data.item.product_num;
                        self.item.prod_img = self.staticFilePath + self.productId + '/' + data.item.prod_img;
                        self.item.prod_img2 = self.staticFilePath + self.productId + '/' + data.item.prod_img2;
                        self.productDescribe = data.productDescribe;

                        self.showProd_describe = $sce.trustAsHtml(self.productDescribe[2].prod_describe);
                        self.propertyTag = data.propertyTag;
                        self.productType = data.productType;
                        self.productSpec = data.productSpec;
                        self.productImg = data.productImg;
                        angular.forEach(self.productImg, function(item) {
                            item.prod_img_name = self.staticFilePath + item.prod_id + '/' + item.prod_img_name;
                            item.prod_img_name2 = self.staticFilePath + item.prod_id + '/' + item.prod_img_name2;
                        });
                        console.log(self.productImg);

                        self.productFile = data.productFile;
                        angular.forEach(self.productFile, function(item) {
                            item.prod_img_path = self.staticFilePath + item.prod_id + '/' + item.prod_img_name;
                        });
                        // console.log( Date.parse(self.item.prod_e_datetime) )

                        if (Date.parse(self.item.prod_e_datetime) == Date.parse( '2222-01-01 00:00:00')) {
                            self.endDateStatus = 1;
                            $("#proEndTime").hide();
                        }
                    }).error(function() {
                        $.toaster({ message : '發生錯誤', priority : 'danger' });
                    }) //error
                }
                self.getItems();
                /*新增特有method-----------------結束*/
            }
            @show

            //======= area start=======
            self.editMainUrl = '/admin/api/product/main/edit';
            self.catagoryTagEditUrl = '/admin/api/product/category/tag';
            self.prodDescribeEditUrl = '/admin/api/product_describe';
            self.prodPropertyEditUrl = '/admin/api/product_property';
            self.productTypeUrl = '/admin/api/product_type';
            self.productTypeDelUrl = '/admin/api/product_type/remove';
            self.productSpecUrl = '/admin/api/product_specification';
            self.productSpecDelUrl = '/admin/api/product_specification/remove';
            self.productImgUrl = '/admin/api/product/img';
            self.productImgUrl_modify  = '/admin/api/product/img/modify'; /*編輯*/
            self.productImgUrl_put = '/admin/api/product_img';            /*刪除*/
            self.productFileUrl = '/admin/api/product/file';
            self.modifyProductFileUrl = '/admin/api/product/file/modify';   /*編輯*/
            self.productFileUrl_put = '/admin/api/product_file';            /*刪除*/

            self.productTypeStatus = [
                { name: '下架', value: 0 },
                { name: '上架', value: 1 }
            ]

            self.selectProductTypeStatus = self.productTypeStatus[0];
            self.actionProductType = 1; //add:1,edit:2
            self.goToEditPage = function(){
                location.href = '/admin/product_cms/' + self.productId;
            }
            self.backToProduct = function() {
                location.href = '/admin/product/' + self.productNum;
            }
            self.endDateStatus = 0;

            self.noEndTime = function() {
                if( self.endDateStatus == 0){
                    $("#proEndTime").show();
                    self.item.prod_e_datetime =self.item.prod_s_datetime ;
                }else{
                    $("#proEndTime").hide();
                    self.item.prod_e_datetime = '2222-01-01 00:00:00';
                    self.modifyItem(self.item);
                }
            }

            self.productTypeItem ={
                prod_type: '',
                type_price: 0,
                type_sales_price: 0,
                prod_sn: '',
                type_status: 0
            }

            self.actionProductSpec = 1; //add:1,edit:2

            self.productSpecItem ={
                spec_name: '',
                spec_no: 0
            }

            self.transStatus = function(statusIndex) {
                return self.status_text[statusIndex];
            }

            self.productTypeSatausChange = function() {
                self.productTypeItem.type_status = self.selectProductTypeStatus.value;
            };

            self.addProductType = function() {
                self.actionProductType = 1;
                self.productTypeItem ={
                    prod_type: '',
                    type_price: 0,
                    type_sales_price: 0,
                    prod_sn: '',
                    type_status: 0
                }
                self.selectProductTypeStatus = self.productTypeStatus[0];
            }

            self.editProductType = function(item) {
                self.actionProductType = 2;
                self.productTypeItem = item;
                self.selectProductTypeStatus = self.productTypeStatus[item.type_status];
            }

            self.addProductSpec = function() {
                self.actionProductSpec = 1;
                self.productSpecItem ={
                    spec_name: '',
                    spec_no: 0
                }
            }

            self.editProductSpec = function(item) {
                self.actionProductSpec = 2;
                self.productSpecItem = item;
            }

            // self.changeMainDateTime = function(datetime) {
            //     return new Date(datetime).Format("yyyy-MM-dd hh:mm:ss");
            // }

            self.closeMainModal = function() {
                self.getItems();
                angular.element("input[type='file']").val(null);
            }
            //CRUD ====== start ======

            // Main start
            self.saveMainModal = function() { 
                if(self.item.prod_order == null){
                    self.item.prod_order = 0;
                }
                var data = { 'item': self.item, 'productId': self.productId };
                self.actionItem(0, "put", self.editMainUrl, data);
            };

            self.textRecording = function(item) {
                self.contrastContent="";
                self.contrastContent = angular.copy(item, self.contrastContent);            
            }

            self.modifyItem = function(item) {
                if( isNaN(item.prod_order) ){
                    self.item = self.contrastContent;
                    $.toaster({ message : '排序請填入數字',  priority : 'warning'})
                    return false;
                }

                if (self.item.prod_img.length === 0) {
                    $.toaster({ message : '請上傳主體主圖片',  priority : 'warning'})
                    return false;
                }

                $scope.result = angular.equals(self.contrastContent, item);

                if(!$scope.result){
                    self.saveMainModal(item);
                }
            }

            self.modifyItemName = function(item) {
                if (self.item.prod_name.length === 0) {
                    $.toaster({ message : '請填寫主體名稱',  priority : 'warning'})
                    return false;
                }

                $scope.result = angular.equals(self.contrastContent, item);

                if(!$scope.result){
                    self.saveMainModal(item);
                }
            }

            self.modifyItemTime = function(item) {
                if (self.endDateStatus == 0) {
                    if (self.item.prod_e_datetime <= self.item.prod_s_datetime) {
                        $.toaster({ message : '結束日期不能小於等於開始時間',  priority : 'warning'})
                        return false;
                    }
                } else {
                    self.item.prod_e_datetime = '2222-01-01 00:00:00';
                }

                $scope.result = angular.equals(self.contrastContent, item);
                if(!$scope.result){
                    self.saveMainModal(item);
                }
            }
            // Main end

            self.modifyDescribe = function(item) {
                $scope.result = angular.equals(self.contrastContent, item);
                if(!$scope.result){
                    self.saveDescribeModal();
                }
            }

            self.modifyPropertyTag = function(item) {
                $scope.result = angular.equals(self.contrastContent, item);
                if(!$scope.result){
                    self.savePropertyTagModal();
                }
            }

            self.clickCheck = function(item) {
                var checkCategoryTag = 0;
                angular.forEach(self.categoryTags, function(item) {
                    if (item.status == 1) {
                        checkCategoryTag = 1;
                    }
                });

                if (checkCategoryTag == 0) {
                    $.toaster({ message : '請至少選擇一個分類',  priority : 'warning'})
                    self.getItems();
                    return false;
                }

                var data = { 'item': self.categoryTags, 'productId': self.productId };
                self.actionItem(1, "put", self.catagoryTagEditUrl, data);
            };

            self.selectChange = function() {
            };

            self.selectSend = function() {
                angular.forEach(self.categoryTags, function(item ,key ) {
                    if(self.treesSelect.includes(item.cate_tag_id)){
                        item.status = 1 ;
                    }else{
                        item.status = 0 ;
                    }
                });
                self.clickCheck();
            };

            self.saveDescribeModal = function() {
                var data = { 'item': self.productDescribe ,'productId': self.productId };
                self.timeoutAct = setTimeout(function(){ 
                    self.actionItem(2, "put", self.prodDescribeEditUrl, data);
                }, 100);
            };

            self.savePropertyTagModal = function() {
                var data = { 'item': self.propertyTag, 'productId': self.productId, 'productNum': self.productNum };
                self.actionItem(3, "put", self.prodPropertyEditUrl, data);
            };

            self.addProductTypeModal = function() {
                var data = { 'item': self.productTypeItem, 'productId': self.productId };
                self.actionItem(6, "post", self.productTypeUrl, data);
            };

            self.changeProductTypeStatus= function(item){
                if(item.type_status == 0){
                    item.type_status = 1;
                }else{
                    item.type_status = 0;
                }
                self.saveProductTypeModal(item);
            }

            self.saveProductTypeModal = function(item) {
                $scope.result = angular.equals(self.contrastContent, item);
                if(!$scope.result){
                    var data = { 'item': item, 'productId': self.productId };
                    self.actionItem(6, "put", self.productTypeUrl, data);
                }
            }

            self.delProductType = function(id) {
                var data = { 'id': id, 'productId': self.productId, 'productNum': self.productNum };
                self.actionItem(6, "put", self.productTypeDelUrl, data);
            }

            self.addProductSpecModal = function() {
                var data = { 'item': self.productSpecItem, 'productId': self.productId, 'productNum': self.productNum };
                self.actionItem(7, "post", self.productSpecUrl, data);
            };

            self.saveProductSpecModal = function(item) {
                if( isNaN(item.spec_no) ){
                    item.spec_no = self.contrastContent.spec_no;
                    $.toaster({ message : '分組請填入數字',  priority : 'warning'})
                    return false;
                }

                $scope.result = angular.equals(self.contrastContent, item);
                if(!$scope.result){
                    var data = { 'item': item, 'productId': self.productId, 'productNum': self.productNum };
                    self.actionItem(7, "put", self.productSpecUrl, data);
                }
            }

            self.delProductSpec = function(id) {
                var data = { 'id': id, 'productId': self.productId, 'productNum': self.productNum };
                self.actionItem(7, "put", self.productSpecDelUrl, data);
            }

            self.bannerArrayReset = function() {
                self.banner_array=[];
                self.banner_array.name='';
                self.banner_array.order=0;
                self.addProdImg ='';
            }
            self.bannerArrayReset();

            self.bannerSwitchBtn =true;
            self.bannerBtnSwitch =function( res ,value=undefined){
                self.bannerSwitchBtn =res;
                if(res){
                    self.bannerArrayReset();
                }else{
                    self.banner_array.name=value.prod_name;
                    self.banner_array.order=value.prod_order;
                    self.banner_array.id=value.prod_img_id;
                }
            }

            self.editSubImg = function(item) {
                if(item.prod_order == null){
                    item.prod_order = 0;
                }
                if(isNaN(item.prod_order) ){
                    self.productImg = self.contrastContent;
                    $.toaster({ message : '排序請填入數字',  priority : 'warning'})
                    return false;
                }

                $scope.result = angular.equals(self.contrastContent, self.productImg);
                if(!$scope.result){
                    let data={
                        'prod_img_id': item.prod_img_id,
                        'fileName': item.prod_name,
                        'imgDesc': item.img_desc,
                        'fileOrder': item.prod_order,
                    }
                    $scope.subPicturModify(data);
                }
            }
            self.delColumnImg = function(item, product_img_column) {
                let data={
                    'prod_img_id': item.prod_img_id,
                    'fileName': item.prod_name,
                    'imgDesc': item.img_desc,
                    'fileOrder': item.prod_order,
                }
                data[product_img_column] = "delete";
                $scope.subPicturModify(data);
            }
            $scope.subPicturModify =function(modifyData){
                $http({
                    method: 'put',
                    url: self.productImgUrl_modify + "/" + self.productId ,
                    data: modifyData
                }).success(function(data) {
                    if(data.status == 200){
                        self.productImg = data.getProductImg;
                        angular.forEach(self.productImg, function(item) {
                            item.prod_img_name = self.staticFilePath + item.prod_id + '/' + item.prod_img_name;
                            item.prod_img_name2 = self.staticFilePath + item.prod_id + '/' + item.prod_img_name2;
                        });
                        self.bannerArrayReset();
                        $.toaster({ message : '修改成功'})
                    }
                }).error(function() {
                    $.toaster({ message : '發生錯誤', priority : 'danger' });
                }) //error
            }
            self.delImg = function(item) {
                var data = { 'item': item, 'productId': self.productId };
                self.actionItem(10, "put", self.productImgUrl_put, data);
            }

            $scope.getFileDetails = function(e) {
                self.files = [];
                $scope.$apply(function() {
                    for (var i = 0; i < e.files.length; i++) {
                        self.files.push(e.files[i])
                    }
                });
            };

            self.fileSwitchBtn =true;
            self.fileBtnSwitch =function( res ,value=undefined){
                self.fileSwitchBtn =res;
                if(res){
                    self.attachFileReset();
                }else{
                    self.attachFile.name=value.prod_name;
                    self.attachFile.order=value.prod_order;
                    self.attachFile.id=value.prod_img_id;
                }
            }

            self.attachFileReset = function() {
                self.attachFile=[];
                self.attachFile.name='';
                self.attachFile.order=0;
            }
            self.attachFileReset();

            self.addFile = function() {
                if(self.attachFile.name == undefined || self.attachFile.name == ''){
                    $.toaster({ message : '請填入檔案名稱',  priority : 'warning'})
                    return false;
                }
                if(self.files == undefined || self.files == ''){
                    $.toaster({ message : '請選擇檔案',  priority : 'warning'})
                    return false;
                }

                var formData = new FormData();
                formData.append('uploadedFile', self.files[0]);
                formData.append('productNum', self.productNum);
                formData.append('fileName', self.attachFile.name);
                formData.append('fileOrder', self.attachFile.order);

                var request = {
                    method: 'POST',
                    url: self.productFileUrl + "/" + self.productId,
                    data: formData,
                    headers: {
                        'Content-Type': undefined
                    }
                };

                $http(request).then(function success(e) {
                    if(e.data.status == 200){
                        self.productFile = e.data.productFile;
                        // console.log(self.productFile );
                        angular.element("input[type='file']").val(null);
                        angular.forEach(self.productFile, function(item) {
                            item.prod_img_path = self.staticFilePath + item.prod_id + '/' + item.prod_img_name;
                        });
                        self.attachFileReset();
                        self.files=[];
                        $.toaster({ message : '新增成功'})
                    }
                }, function error(e) {
                    $scope.errors = e.data.errors;
                });
            }
            self.modifyFile = function(item) {
                if(item.prod_order == null){
                    item.prod_order = 0;
                }

                if(isNaN(item.prod_order) ){
                    self.productFile = self.contrastContent;
                    $.toaster({ message : '排序請填入數字',  priority : 'warning'})
                    return false;
                }

                $scope.result = angular.equals(self.contrastContent, self.productFile);

                if(!$scope.result){
                    let data={
                        'prod_img_id': item.prod_img_id,
                        'fileName': item.prod_name,
                        'fileOrder': item.prod_order
                    }            
                    $http({
                        method: 'put',
                        url: self.modifyProductFileUrl + "/" + self.productId ,
                        data: data
                    }).success(function(data) {
                        if(data.status == 200){
                            self.productFile = data.productFile;
                            angular.forEach(self.productFile, function(item) {
                                item.prod_img_path = self.staticFilePath + item.prod_id + '/' + item.prod_img_name;
                            });
                            self.attachFileReset();
                            $.toaster({ message : '修改成功'})
                        }
                    }).error(function() {
                        $.toaster({ message : '發生錯誤', priority : 'danger' });
                    }) //error
                }
            }
            self.delFile = function(item) {
                var data = { 'item': item, 'productId': self.productId };
                self.actionItem(12, "put", self.productFileUrl_put, data);
            }

            self.actionItem = function(number, method, url, data) {
                $http({
                    method: method,
                    url: url,
                    data: data
                }).success(function(data) {
                    if (number == 15) {
                        // console.log(data);
                    }
                    if (data.status == '200') {
                        if (number == 'add'){
                            if( self.need_content ){
                                self.goToEditPage(); // 需詳細內容，跳至編輯畫面
                            }else{
                                self.backToProduct(); // 無需詳細內容，跳至列表頁面
                            }
                        } else if (number == 'del') {
                            self.backToProduct();
                        
                        } else if (number == 0) {
                            angular.element("input[type='file']").val(null);
                            self.item = data.item;
                            self.item.prod_img = self.staticFilePath + self.productId + '/' + data.item.prod_img;
                            self.item.prod_img2 = self.staticFilePath + self.productId + '/' + data.item.prod_img2;
                            $.toaster({ message : '修改成功'})

                        } else if (number == 1) {
                            self.categoryTags = data.categoryTags;
                            self.getItems();

                        } else if (number == 2) {
                            self.productDescribe = data.productDescribe;
                            $.toaster({ message : '修改成功'})

                        } else if (number == 3) {
                            // 主題欄位
                            $.toaster({ message : '修改成功'})

                        } else if (number == 6) {
                            self.productType = data.productType;
                            $.toaster({ message : '修改成功'})

                        } else if (number == 7) {
                            self.productSpec = data.productSpec;
                            $.toaster({ message : '修改成功'})

                        } else if (number == 10) {
                            if(data.status ==200){
                                self.productImg = data.productImg;
                                angular.forEach(self.productImg, function(item) {
                                    item.prod_img_name = self.staticFilePath + item.prod_id + '/' + item.prod_img_name;
                                    item.prod_img_name2 = self.staticFilePath + item.prod_id + '/' + item.prod_img_name2;
                                });
                                angular.element("input[type='file']").val(null);
                                $("#prodImgAdd").removeAttr("src");

                                self.bannerArrayReset();
                                $.toaster({ message : '修改成功'})  //刪除成功
                            }

                        } else if (number == 12) {
                            self.productFile = data.productFile;
                            angular.element("input[type='file']").val(null);
                            angular.forEach(self.productFile, function(item) {
                                item.prod_img_path = self.staticFilePath + item.prod_id + '/' + item.prod_img_name;
                            });
                            $.toaster({ message : '修改成功'})  //刪除成功

                        } else if (number == 14) {
                            location.reload();
                        }
                    } else {
                        $.toaster({ message : '資料庫無回應',  priority : 'warning'})
                    }
                }).error(function() {
                    $.toaster({ message : '發生錯誤', priority : 'danger' });
                }) //error
            }

            /*seo 區塊*/
            self.getSeoItems = function() {
                let data = { 'productId': self.productId };
                $http({
                    method: "post",
                    data: data,
                    url: '/admin/api/product/prod_seo/edit',
                }).success(function(data) {
                    if(data.status ==200){
                        self.getSeoProperty = data.getSeoProperty;
                    }
                    // console.log(self.getSeoProperty)
                }).error(function() {
                    $.toaster({ message : '發生錯誤', priority : 'danger' });
                }) //error
            }
            self.getSeoItems();

            self.prodPropertySeoEditUrl =  '/admin/api/product/prod_seo/property/edit';
            self.saveSeoPropertyModal = function() {
                var data = { 'item': self.getSeoProperty, 'productId': self.productId, 'productNum': self.productNum };
                // console.log(data)
                self.actionItem(15, "put", self.prodPropertySeoEditUrl, data);
            };
            //CRUD ====== end =======

            self.select = function(){
                $('.downSelect').selectMania({
                    // size: 'small',
                    placeholder: '-- 請選擇詢問項目 --',
                    themes: ['orange'],
                    search: true,
                    placeholder: '請選擇分類(至少一個)',
                });
            }

            self.clickCheckLabel = function(item) {
                let hasLabel = [];
                angular.forEach(self.getLabelTags, function(item) {
                    if (item.has_label == 1) {
                        hasLabel.push({'prod_id': parseInt(self.productId),'label_tag_id': item.label_tag_id  });
                    }
                });

                let data = { 'item':hasLabel, 'productId': self.productId };
                $http({
                    method: "put",
                    data: data,
                    url: '/admin/api/prod_label/edit',
                }).success(function(data) {
                    if(data.status == 200){
                        self.getLabels();
                        $.toaster({ message : '修改成功'})
                    }
                }).error(function() {
                    $.toaster({ message : '發生錯誤', priority : 'danger' });
                }) //error
            };

            self.getLabels = function(){
                let data = { 'productId': self.productId };
                $http({
                    method: "post",
                    data: data,
                    url: '/admin/api/prod_label/show',
                }).success(function(data) {
                    if(data.status == 200){
                        self.getLabelTags =data.getLabelTag;
                        // console.log(self.getLabelTags)
                    }
                }).error(function() {
                    $.toaster({ message : '發生錯誤', priority : 'danger' });
                }) //error
            }
            self.getLabels();

            // tabs
            self.getTabs = function(){
                let data = { 'productId': self.productId , productNum: self.productNum };
                $http({
                    method: "post",
                    data: data,
                    url: '/admin/api/prod_tabs/show',
                }).success(function(data) {
                    // console.log(data)
                    if(data.status == 200){
                        self.getTabsTags =data.getTabsTag;
                        self.tabsProductId = data.productId;
                    }

                    setTimeout(function() {
                        tabsAnimation('.tabs_use_box',1);
                    }, 50);
                }).error(function() {
                    $.toaster({ message : '發生錯誤', priority : 'danger' });
                }) //error
            }
            self.getTabs();

            self.modifyTabs = function(item) {
                let data = { 'item':item, 'productId': self.tabsProductId , 'lang':self.lang.lang_id };
                $http({
                    method: "put",
                    data: data,
                    url: '/admin/api/prod_tabs/edit',
                }).success(function(data) {
                    if(data.status == 200){
                        self.getTabsTags =data.getTabsTag;
                    }
                }).error(function() {
                    $.toaster({ message : '發生錯誤', priority : 'danger' });
                }) //error
            };

            self.tagifyUse = function(querySelectorID) {
                var inputElm = document.querySelector(querySelectorID),tagify = new Tagify (inputElm);
                if(inputElm){
                    inputElm.addEventListener('change', onChange);
                }
                function onChange(e){
                    self.modifyDescribe(self.productDescribe);
                }
            }
        }]).directive("ngFileSelect", function(fileReader, $timeout ,$http) {
            return {
                scope: {
                    ngModel: '=',
                    contentItem: '=contentItem',
                    proNum: '=',
                    proId: '=',
                    moBlock: '=',
                    prodImg: '=',
                },
                link: function($scope, el) {
                    function getFile(file) {
                        fileReader.readAsDataUrl(file, $scope)
                            .then(function(result) {
                                $timeout(function() {
                                    if($scope.moBlock == 0){ /*主圖、小縮圖*/
                                        $scope.ngModel = result;
                                        item = $scope.contentItem ;
                                        
                                        prod_img = $scope.prodImg ? 'prod_img'+$scope.prodImg : 'prod_img';
                                        item[prod_img] = result;
                                        let data = { 'item':item, 'productId': $scope.proId };
                                        $http({
                                            method: 'put',
                                            url: '/admin/api/product/main/edit',
                                            data: data
                                        }).success(function(data) {
                                            if (data.status == '200') {
                                                $.toaster({ message : '修改成功'})
                                            } else {
                                                $.toaster({ message : '資料庫無回應',  priority : 'warning'})
                                            }
                                        }).error(function() {
                                            $.toaster({ message : '網路錯誤', priority : 'danger' });
                                        }) //error
                                    }else if($scope.moBlock == 1){ /*主體欄位*/
                                        $scope.ngModel = result;
                                        item = $scope.contentItem ;
                                        angular.forEach(item , function(i) {
                                            if(i.prop_tag_id == $scope.proId[0]){
                                                i.prod_img_path =result;
                                            }
                                        });

                                        var data = { 'item': item, 'productId': $scope.proId[1], 'productNum': $scope.proNum };
                                        $http({
                                            method: 'put',
                                            url: '/admin/api/product_property',
                                            data: data
                                        }).success(function(data) {
                                            if (data.status == '200') {
                                                $.toaster({ message : '修改成功'})
                                            } else {
                                                $.toaster({ message : '資料庫無回應',  priority : 'warning'})
                                            }
                                        }).error(function() {
                                            $.toaster({ message : '網路錯誤', priority : 'danger' });
                                        }) //error
                                    }else if($scope.moBlock == 2){ /*檔案上傳*/
                                        $scope.ngModel = result;
                                        item = $scope.ngModel ;
                                        item= result;
                                        var data = { 'item': item, 'productId':$scope.proId , 'productNum':$scope.proNum , 'imgName':"", 'imgOrder': 0 };
                                        $http({
                                            method: 'post',
                                            url: '/admin/api/product/img',
                                            data: data
                                        }).success(function(data) {
                                            // console.log(data)
                                            if (data.status == '200') {
                                                $.toaster({ message : '修改成功'})
                                                $scope.contentItem= data.productImg;
                                                angular.forEach($scope.contentItem, function(item) {
                                                    item.prod_img_name = '/upload/product/' + item.prod_id + '/' + item.prod_img_name;
                                                    item.prod_img_name2 = '/upload/product/' + item.prod_id + '/' + item.prod_img_name2;
                                                });

                                            } else {
                                                $.toaster({ message : '資料庫無回應',  priority : 'warning'})
                                            }
                                        }).error(function() {
                                            $.toaster({ message : '網路錯誤', priority : 'danger' });
                                        }) //error
                                    }
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

        app.directive("ngFileProductImgSelect", function(fileReader, $timeout ,$http) {
            return {
                scope: {
                    ngModel: '=',
                    productImgColumn: '=',
                },
                link: function($scope, el) {
                    function getFile(file) {
                        fileReader.readAsDataUrl(file, $scope)
                            .then(function(result) {
                                $timeout(function() {
                                    if(result){
                                        $scope.ngModel[$scope.productImgColumn] = result;
                                        let data={
                                            'prod_img_id': $scope.ngModel.prod_img_id,
                                            'prod_img_name': $scope.ngModel.prod_img_name,
                                            'prod_img_name2': $scope.ngModel.prod_img_name2,
                                            'fileName': $scope.ngModel.prod_name,
                                            'imgDesc': $scope.ngModel.img_desc,
                                            'fileOrder': $scope.ngModel.prod_order,
                                        }
                                        angular.element("#ng_contCtrl").scope().subPicturModify(data);
                                    }
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

        app.directive("ngFileSelectSeo", function(fileReader, $timeout ,$http) {
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
        });
        
        app.directive("moreImgUpload",function($http,$compile){
            return {
                restrict : 'AE',
                scope : {
                    url : "@",
                    method : "@",
                    key : "=key",
                    data: "=" ,
                },
                data: "=" ,
                template :  '<input class="fileUpload" type="file" multiple />'+
                            '<div class="dropzone">'+
                                '<p class="msg">點擊或拖放文件即可上傳</p>'+
                            '</div>'
                        ,
                link : function(scope,elem,attrs){
                    var formData = new FormData();
                    scope.previewData = []; 

                    function previewFile(file){
                        var reader = new FileReader();
                        var obj = new FormData().append('file',file);           
                        reader.onload=function(data){
                            var src = data.target.result;
                            var size = ((file.size/(1024*1024)) > 1)? (file.size/(1024*1024)) + ' mB' : (file.size/     1024)+' kB';
                            scope.$apply(function(){
                                // console.log(scope.data)
                                last_order = scope.data.length>0 ? Number(scope.data[scope.data.length-1]['prod_order']) + 1 : 0;
                                // console.log(last_order);
                                // scope.previewData.push({'name':file.name,'size':size,'type':file.type, 'src':src,'data':obj,'order':0});
                                scope.upload({'name':file.name,'size':size,'type':file.type, 'src':src,'data':obj,'order':last_order});
                            });                                   
                            // console.log(scope.previewData);
                        }
                        reader.readAsDataURL(file);
                    }

                    function uploadFile(e,type){
                        e.preventDefault();         
                        var files = "";
                        if(type == "formControl"){
                            files = e.target.files;
                        } else if(type === "drop"){
                            files = e.originalEvent.dataTransfer.files;
                        }           
                        for(var i=0;i<files.length;i++){
                            var file = files[i];
                            if(file.type.indexOf("image") !== -1){
                                previewFile(file);                              
                            } else {
                                alert(file.name + " is not supported");
                            }
                        }
                    }   
                    elem.find('.fileUpload').bind('change',function(e){
                        uploadFile(e,'formControl');
                    });

                    elem.find('.dropzone').bind("click",function(e){
                        $compile(elem.find('.fileUpload'))(scope).trigger('click');
                    });

                    elem.find('.dropzone').bind("dragover",function(e){
                        e.preventDefault();
                    });

                    elem.find('.dropzone').bind("drop",function(e){
                        uploadFile(e,'drop');                                                                       
                    });

                    scope.upload=function(obj){
                        scope.data = [];
                        let data = { 'item': obj.src, 'productId': scope.key , 'imgName':"", 'imgOrder': obj.order};
                        $http({
                            method: scope.method,
                            url: scope.url,
                            data: data
                        }).success(function(data) {
                            let index= scope.previewData.indexOf(obj);
                            scope.previewData.splice(index,1);
                            if(data.status ==200){
                                scope.data = data.productImg;
                                angular.forEach(scope.data , function(item) {
                                    item.prod_img_name = '/upload/product/' + item.prod_id + '/' + item.prod_img_name;
                                    item.prod_img_name2 = '/upload/product/' + item.prod_id + '/' + item.prod_img_name2;
                                });
                            }
                        }).error(function() {
                        }) //error
                    }

                    scope.remove=function(data){
                        let index= scope.previewData.indexOf(data);
                        scope.previewData.splice(index,1);
                    }

                    scope.saveAll=function(){
                        angular.forEach(scope.previewData , function(item) {
                            scope.upload(item);
                        });
                    }
                }
            }
        });
    </script>
@endsection