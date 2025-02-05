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

        .sampleImg {
            width: 85%;
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
            <div class="row align-items-center">
                <div class="col-md-6 mb-2">
                    <div class="mb-2">
                        <a href="https://www.ifreesite.com/color/" target="_blank">查看色碼表</a>
                    </div>
                    <div class="d-flex mb-2">
                        
                        <div>
                            選擇對象：<select class="form-control" ng-options='option.value as option.name for option in contCtrl.memberOptions' ng-model='contCtrl.item.selectUser' ng-blur="contCtrl.modifyItemOnwer(contCtrl.item)" ></select>
                        </div>
                    </div>
                    <div>
                        <span class="use-sp-title">總排序：</span><span class="herinneren-use">數字小的在前面</span>
                        <input type='text' ng-model="contCtrl.item.prod_order" placeholder="請填入順序" class="form-control input-sm" ng-blur="contCtrl.modifyItem(contCtrl.item)" ng-focus="contCtrl.textRecording(contCtrl.item)">
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <div>
                        <h4 class="use-h4-title">版型選擇：</h4>
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#sampleModal">版型示範</button>
                    </div>
                    <div class="d-flex flex-wrap">       
                        <div class="mr-2">
                            <input type="radio" ng-model="contCtrl.item.style" ng-change="setLayout(contCtrl.item.prod_id,1)" value="1" id="style_one_@{{contCtrl.item.prod_id}}">
                            <label for="style_one_@{{contCtrl.item.prod_id}}">個人介紹</lable>
                        </div>
                        <div class="mr-2">
                            <input type="radio" ng-model="contCtrl.item.style" ng-change="setLayout(contCtrl.item.prod_id,2)" value="2" id="style_two_@{{contCtrl.item.prod_id}}">
                            <label for="style_two_@{{contCtrl.item.prod_id}}">官網介紹</lable>
                        </div>
                        <div class="mr-2">
                            <input type="radio" ng-model="contCtrl.item.style" ng-change="setLayout(contCtrl.item.prod_id,3)" value="3" id="style_three_@{{contCtrl.item.prod_id}}">
                            <label for="style_three_@{{contCtrl.item.prod_id}}">專業版型一</lable>
                        </div>
                        <div class="mr-2">
                            <input type="radio" ng-model="contCtrl.item.style" ng-change="setLayout(contCtrl.item.prod_id,4)" value="4" id="style_four_@{{contCtrl.item.prod_id}}">
                            <label for="style_four_@{{contCtrl.item.prod_id}}">專業版型二</lable>
                        </div>
                        <!-- <div class="mr-2">
                            <input type="radio" ng-model="contCtrl.item.style" ng-change="setLayout(contCtrl.item.prod_id,5)" value="5" id="style_five_@{{contCtrl.item.prod_id}}">
                            <label for="style_five_@{{contCtrl.item.prod_id}}">更多聯絡</lable>
                        </div> -->
                        <div class="mr-2">
                            <input type="radio" ng-model="contCtrl.item.style" ng-change="setLayout(contCtrl.item.prod_id,6)" value="6" id="style_six_@{{contCtrl.item.prod_id}}">
                            <label for="style_six_@{{contCtrl.item.prod_id}}">全版無廣告</lable>
                        </div>
                        <div class="mr-2">
                            <input type="radio" ng-model="contCtrl.item.style" ng-change="setLayout(contCtrl.item.prod_id,7)" value="7" id="style_seven_@{{contCtrl.item.prod_id}}">
                            <label for="style_seven_@{{contCtrl.item.prod_id}}">奧斯丁</lable>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12 mb-2">
                    <span class="use-sp-title">名片下架日期(凌晨零點)：</span>
                    <!-- <span class="mark-use">結束日期不能小於等於開始時間</span> -->
                    <div class="input-group date d-flex" id="proEndTime" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target="#proEndTime" ng-model="contCtrl.item.prod_e_datetime" ng-blur="contCtrl.modifyItemTime(contCtrl.item)" ng-focus="contCtrl.textRecording(contCtrl.item)"/>
                        <div class="input-group-append" data-target="#proEndTime" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                    <!-- <div class="onbeperktTimeBox">
                        <input type="checkbox" ng-model="contCtrl.endDateStatus" ng-true-value="1" ng-false-value="0" ng-click="contCtrl.noEndTime()">無結束時間
                    </div> -->
                </div>
            </div>
            <h4 class="use-h4-title">圖片區塊 :</h4>
            <div class="row mb-3">
                <div class="leftBox col-md-6 col-12">
                    <div class="main-img-box admin mb-2">
                        <div class="box" style="padding-bottom: 50%;">
                            <div ng-if="contCtrl.item.prod_img" class="adminImg-responsive-1By1 pb-0" ng-style="{'background-image': 'url('+contCtrl.item.prod_img+')'}"></div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <div>
                            <p style="font-size:18px; font-weight:bold;color:#8c4a1c;">*重要資訊/圖像應置於圖片中間處，請依建議尺寸上傳較美觀(但會依實際比例調整顯示)*</p>
                            <div>建議尺寸1：<span class="highlight" ng-bind="contCtrl.imageSize"></span> (或圖片長寬比為<span class="highlight" ng-bind="contCtrl.imageRatio"></span>)</div>
                            <div ng-if="contCtrl.imageSize_2">
                                建議尺寸2：<span class="highlight" ng-bind="contCtrl.imageSize_2"></span> (或圖片長寬比為<span class="highlight" ng-bind="contCtrl.imageRatio_2"></span>)
                            </div>
                        </div>
                    </div>
                    <div class="custom-file mb-2">
                        <input class="inputFile w-100" type="file" mo-block="0" ng-file-select="onFileSelect($files)" ng-model="contCtrl.item.prod_img" class="custom-file-input form-control-use line-style" id="file-main-img" pro-num='contCtrl.productNum' content-item='contCtrl.item' pro-id="contCtrl.productId" value="">
                        <label class="custom-file-label" for="file-main-img">選擇檔案</label>
                    </div>
                    <!-- <div class="mb-2">
                        <span class="use-sp-title">圖片連結：</span><span class="herinneren-use">(點擊後前往的頁面，請填入含 http:// 或 https:// 的網址，<b>挑選「個人介紹」版型可填入</b>)</span>
                        <input type='text' class="form-control input-sm" ng-model="contCtrl.item.prod_main_sku" ng-blur="contCtrl.modifyItem(contCtrl.item)" ng-focus="contCtrl.textRecording(contCtrl.item)">
                    </div> -->
                </div>
                <div class="col-md-6 col-12">
                </div>    
                <!-- 
                    <div class="col-md-6 mb-2">
                        <div class="main-img-box admin mb-2">
                            <div class="box" style="padding-bottom: 25%;">
                                <div ng-if="contCtrl.item.prod_img2" class="adminImg-responsive-1By1 pb-0" ng-style="{'background-image': 'url('+contCtrl.item.prod_img2+')'}"></div>
                            </div>
                        </div>
                        <div><span>個人頭像：</span><span class="herinneren-use">(頭像應清晰具體，盡量位於照片中間)</span></div>
                        <div class="custom-file">
                            <input class="inputFile w-100" type="file" mo-block="0" prod-img="2" ng-file-select="onFileSelect($files)" ng-model="contCtrl.item.prod_img2" class="custom-file-input form-control-use line-style" id="file-main-img2" pro-num='contCtrl.productNum' content-item='contCtrl.item' pro-id="contCtrl.productId" value="">
                            <label class="custom-file-label" for="file-main-img2">選擇檔案</label>
                        </div>
                    </div> 
                -->
            </div>
            <h4 class="use-h4-title">卡身區塊-底色與介紹:</h4>
            <div class="row">
                <div class="col-md-6 col-12 mb-2">
                    <span class="use-sp-title">卡身區塊底色：</span><span class="herinneren-use">(請輸入含#的六碼色碼)</span>
                    <div class="d-flex align-items-center">
                        <input type='color' class="form-control input-sm" ng-model="contCtrl.item.prod_subtitle" ng-blur="contCtrl.modifyItem(contCtrl.item)" ng-focus="contCtrl.textRecording(contCtrl.item)" style="width: 20%; height: 38px;">
                        <input type='text' class="form-control input-sm" ng-model="contCtrl.item.prod_subtitle" ng-blur="contCtrl.modifyItem(contCtrl.item)" ng-focus="contCtrl.textRecording(contCtrl.item)">
                    </div>
                </div>
            </div>
            <div class="row" ng-if="contCtrl.item.style==1">
                <div class="col-md-12 d-flex justify-content-between">
                    @section('select_lang')
                    <!-- <div>
                        <span class="use-sp-title">選擇語系：</span>
                        <select class="form-control input-sm" ng-model='contCtrl.item.lang_id'
                            ng-options="option.lang_id as option.lang_word for option in contCtrl.langs"
                            ng-change="contCtrl.langSelect(contCtrl.item)">
                        </select>
                        <span class="herinneren-use">完成新增後無法修改</span>
                    </div> -->
                    @show
                    <!-- <h4 class="use-h4-title d-flex align-items-center"><a href="" data-toggle="modal" data-target="#seoPropertyModal" data-backdrop="static" data-keyboard="false"><span>編輯<br>SEO</span></a></h4> -->
                </div>
                <!-- <div class="col-md-12">
                    <hr>
                    <h4 style="font-size:18px; font-weight:bold;color:#8c4a1c;">*欲挑選「個人介紹」版型請依序輸入*</h4>
                </div> -->
                <div class="col-md-4 col-12 mb-4">
                    <span class="use-sp-title">公司名：</span>
                    <input type='text' ng-model="contCtrl.item.prod_name" class="form-control input-sm" ng-blur="contCtrl.modifyItemName(contCtrl.item)" ng-focus="contCtrl.textRecording(contCtrl.item)">
                </div>
                <!-- 公司名顏色 -->
                <div class="col-md-4 col-12 mb-4">
                    <span class="use-sp-title" ng-bind="contCtrl.propertyTag[0].prop_tag_name"></span><span class="herinneren-use">(請輸入含#的六碼色碼)</span>
                    <div class="d-flex align-items-center">
                        <input class="form-control" type="color" ng-model="contCtrl.propertyTag[0]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)" style="width: 20%; height: 38px;">
                        <input class="form-control" type="text" ng-model="contCtrl.propertyTag[0]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)">
                    </div>
                </div>
                <!-- 公司名字型大小 -->
                <div class="col-md-4 col-12 mb-4">
                    <span class="use-sp-title">公司名字型大小(像素(px))：</span>
                    <input class="form-control" type="text" ng-model="contCtrl.propertyTag[17]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)">
                </div>
                <!-- 中文名 -->
                <div class="col-md-4 col-12 mb-4">
                    <span class="use-sp-title" ng-bind="contCtrl.propertyTag[1].prop_tag_name"></span>
                    <input class="form-control" type="text" ng-model="contCtrl.propertyTag[1]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)">
                </div>
                <!-- 中文名顏色 -->
                <div class="col-md-4 col-12 mb-4">
                    <span class="use-sp-title" ng-bind="contCtrl.propertyTag[2].prop_tag_name"></span><span class="herinneren-use">(請輸入含#的六碼色碼)</span>
                    <div class="d-flex align-items-center">
                        <input class="form-control" type="color" ng-model="contCtrl.propertyTag[2]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)" style="width: 20%; height: 38px;">
                        <input class="form-control" type="text" ng-model="contCtrl.propertyTag[2]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)">
                    </div>
                </div>
                <!-- 中文名字型大小 -->
                <div class="col-md-4 col-12 mb-4">
                    <span class="use-sp-title">中文名字型大小(像素(px))：</span>
                    <input class="form-control" type="text" ng-model="contCtrl.propertyTag[18]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)">
                </div>
                <!-- 英文名 -->
                <div class="col-md-4 col-12 mb-4">
                    <span class="use-sp-title" ng-bind="contCtrl.propertyTag[9].prop_tag_name"></span>
                    <input class="form-control" type="text" ng-model="contCtrl.propertyTag[9]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)">
                </div>
                <!-- 英文名顏色 -->
                <div class="col-md-4 col-12 mb-4">
                    <span class="use-sp-title" ng-bind="contCtrl.propertyTag[10].prop_tag_name"></span><span class="herinneren-use">(請輸入含#的六碼色碼)</span>
                    <div class="d-flex align-items-center">
                        <input class="form-control" type="color" ng-model="contCtrl.propertyTag[10]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)" style="width: 20%; height: 38px;">
                        <input class="form-control" type="text" ng-model="contCtrl.propertyTag[10]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)">
                    </div>
                </div>
                <!-- 英文名字型大小 -->
                <div class="col-md-4 col-12 mb-4">
                    <span class="use-sp-title">英文名字型大小(像素(px))：</span>
                    <input class="form-control" type="text" ng-model="contCtrl.propertyTag[19]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)">
                </div>
                <!-- 職稱 -->
                <div class="col-md-4 col-12 mb-4">
                    <span class="use-sp-title" ng-bind="contCtrl.propertyTag[5].prop_tag_name"></span>
                    <input class="form-control"  type="text" ng-model="contCtrl.propertyTag[5]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)">
                </div>
                <!-- 職稱顏色 -->
                <div class="col-md-4 col-12 mb-4">
                    <span class="use-sp-title" ng-bind="contCtrl.propertyTag[6].prop_tag_name"></span><span class="herinneren-use">(請輸入含#的六碼色碼)</span>
                    <div class="d-flex align-items-center">
                        <input class="form-control" type="color" ng-model="contCtrl.propertyTag[6]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)" style="width: 20%; height: 38px;">
                        <input class="form-control" type="text" ng-model="contCtrl.propertyTag[6]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)">
                    </div>
                </div>
                <!-- 職稱字型大小 -->
                <div class="col-md-4 col-12 mb-4">
                    <span class="use-sp-title">職稱字型大小(像素(px))：</span>
                    <input class="form-control" type="text" ng-model="contCtrl.propertyTag[20]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)">
                </div>
            </div>
            <!-- <div class="col-md-12">
                <hr>
                <h4 style="font-size:18px; font-weight:bold;color:#8c4a1c;">*欲挑選「官網介紹」版型請依序輸入，挑選「個人介紹」版型僅需填入介紹文字*</h4>
            </div> -->
            <div class="row">
                <!-- 標題 -->
                <div class="col-md-4 col-12 mb-4" ng-if="contCtrl.item.style==2 || contCtrl.item.style==3">
                    <span class="use-sp-title" ng-bind="contCtrl.propertyTag[11].prop_tag_name"></span>
                    <input class="form-control" ng-model="contCtrl.propertyTag[11]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)" row="20">
                </div>
                <!-- 標題 -->
                <div class="col-md-4 col-12 mb-4" ng-if="contCtrl.item.style==7">
                    <span class="use-sp-title">區塊標題：</span>
                    <input class="form-control" ng-model="contCtrl.propertyTag[11]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)" row="20">
                </div>
                <!-- 標題顏色 -->
                <div class="col-md-4 col-12 mb-4" ng-if="contCtrl.item.style==2 || contCtrl.item.style==3">
                    <span class="use-sp-title" ng-bind="contCtrl.propertyTag[12].prop_tag_name"></span><span class="herinneren-use">(請輸入含#的六碼色碼)</span>
                    <div class="d-flex align-items-center">
                        <input class="form-control" type="color" ng-model="contCtrl.propertyTag[12]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)" style="width: 20%; height: 38px;">
                        <input class="form-control" type="text" ng-model="contCtrl.propertyTag[12]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)">
                    </div>
                </div>
                <!-- 區塊標題顏色 -->
                <div class="col-md-4 col-12 mb-4" ng-if="contCtrl.item.style==7">
                    <span class="use-sp-title">區塊標題顏色：</span><span class="herinneren-use">(請輸入含#的六碼色碼)</span>
                    <div class="d-flex align-items-center">
                        <input class="form-control" type="color" ng-model="contCtrl.propertyTag[12]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)" style="width: 20%; height: 38px;">
                        <input class="form-control" type="text" ng-model="contCtrl.propertyTag[12]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)">
                    </div>
                </div>
                <!-- 標題字型大小 -->
                <div class="col-md-4 col-12 mb-4" ng-if="contCtrl.item.style==2 || contCtrl.item.style==3">
                    <span class="use-sp-title">標題字型大小(像素(px))：</span>
                    <input class="form-control" type="text" ng-model="contCtrl.propertyTag[17]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)">
                </div>
                <!-- 區塊標題字型大小 -->
                <div class="col-md-4 col-12 mb-4" ng-if="contCtrl.item.style==7">
                    <span class="use-sp-title">區塊標題字型大小(像素(px))：</span>
                    <input class="form-control" type="text" ng-model="contCtrl.propertyTag[17]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)">
                </div>

                <!-- 介紹文字 -->
                <div class="col-md-4 col-12 mb-4" ng-if="contCtrl.item.style==1 || contCtrl.item.style==2 || contCtrl.item.style==3">
                    <span class="use-sp-title" ng-bind="contCtrl.propertyTag[3].prop_tag_name"></span>
                    <span class="herinneren-use">(可透過「&lt;br&gt;」或「enter」換行調整間距。可自行拖拉文字輸入框高度)</span>
                    <textarea class="form-control" ng-model="contCtrl.propertyTag[3]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)" row="20"></textarea>
                </div>
                <!-- 區塊內文 -->
                <div class="col-md-4 col-12 mb-4" ng-if="contCtrl.item.style==7">
                    <span class="use-sp-title">區塊內文：</span><span class="herinneren-use">(可自行拖拉文字輸入框高度)</span>
                    <textarea class="form-control" ng-model="contCtrl.propertyTag[3]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)" row="20"></textarea>
                </div>
                <!-- 介紹文字顏色 -->
                <div class="col-md-4 col-12 mb-4" ng-if="contCtrl.item.style==1 || contCtrl.item.style==2 || contCtrl.item.style==3">
                    <span class="use-sp-title" ng-bind="contCtrl.propertyTag[4].prop_tag_name"></span><span class="herinneren-use">(請輸入含#的六碼色碼)</span>
                    <div class="d-flex align-items-center">
                        <input class="form-control" type="color" ng-model="contCtrl.propertyTag[4]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)" style="width: 20%; height: 38px;">
                        <input class="form-control" type="text" ng-model="contCtrl.propertyTag[4]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)">
                    </div>
                </div>
                <!-- 區塊內文顏色 -->
                <div class="col-md-4 col-12 mb-4" ng-if="contCtrl.item.style==7">
                    <span class="use-sp-title">區塊內文顏色：</span><span class="herinneren-use">(請輸入含#的六碼色碼)</span>
                    <div class="d-flex align-items-center">
                        <input class="form-control" type="color" ng-model="contCtrl.propertyTag[4]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)" style="width: 20%; height: 38px;">
                        <input class="form-control" type="text" ng-model="contCtrl.propertyTag[4]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)">
                    </div>
                </div>
                <!-- 介紹文字字型大小 -->
                <div class="col-md-4 col-12 mb-4" ng-if="contCtrl.item.style==1 || contCtrl.item.style==2 || contCtrl.item.style==3">
                    <span class="use-sp-title">介紹文字字型大小(像素(px))：</span>
                    <input class="form-control" type="text" ng-model="contCtrl.propertyTag[22]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)">
                </div>
                <!-- 區塊內文字型大小 -->
                <div class="col-md-4 col-12 mb-4" ng-if="contCtrl.item.style==7">
                    <span class="use-sp-title">區塊內文字型大小(像素(px))：</span>
                    <input class="form-control" type="text" ng-model="contCtrl.propertyTag[22]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)">
                </div>
            </div>

            <div class="row" ng-if="contCtrl.item.style==1">
                <div class="col-md-12">
                    <h4 class="use-h4-title">卡身區塊-社群 QRCODE 圖片</h4>
                </div>
                <div class="col-md-6">
                    <div class="main-img-box admin mb-2 position-relative">
                        <div class="box" style="padding-bottom: 25%;">
                            <div ng-if="contCtrl.item.prod_img2" class="adminImg-responsive-1By1 pb-0" ng-style="{'background-image': 'url('+contCtrl.item.prod_img2+')'}"></div>
                        </div>
                        <button ng-click="contCtrl.cancelImg(contCtrl.item, 'prod_img2')"  
                                class="btn btn-danger position-absolute right bottom" 
                                style="bottom: 0px; right:0px"
                                type="button"
                        >x</button>
                    </div>
                    <div><span>QRCODE 1：</span><span class="highlight">&nbsp;(建議尺寸：300*300px，但會依實際比例調整顯示)</span></div>
                    <div class="custom-file mb-2">
                        <input class="inputFile w-100" type="file" mo-block="0" prod-img="2" ng-file-select="onFileSelect($files)" ng-model="contCtrl.item.prod_img2" class="custom-file-input form-control-use line-style" id="file-main-img2" pro-num='contCtrl.productNum' content-item='contCtrl.item' pro-id="contCtrl.productId" value="">
                        <label class="custom-file-label" for="file-main-img2">選擇檔案</label>
                    </div>
                     <!-- 社群文字 -->
                    <div class="mb-2">
                        <span class="use-sp-title" ng-bind="contCtrl.propertyTag[13].prop_tag_name"></span>
                        <input class="form-control" ng-model="contCtrl.propertyTag[13]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)" row="20">
                    </div>
                    <!-- 文字顏色 -->
                    <div>
                        <span class="use-sp-title" ng-bind="contCtrl.propertyTag[14].prop_tag_name"></span><span class="herinneren-use">(請輸入含#的六碼色碼)</span>
                        <div class="d-flex align-items-center">
                            <input class="form-control" type="color" ng-model="contCtrl.propertyTag[14]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)" style="width: 20%; height: 38px;">
                            <input class="form-control" type="text" ng-model="contCtrl.propertyTag[14]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)">
                        </div>
                    </div>
                    <!-- 社群文字字型大小 -->
                    <div>
                        <span class="use-sp-title">社群文字1字型大小(像素(px))：</span>
                        <input class="form-control" type="text" ng-model="contCtrl.propertyTag[23]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="main-img-box admin mb-2 position-relative">
                        <div class="box" style="padding-bottom: 25%;">
                            <div ng-if="contCtrl.item.prod_img3" class="adminImg-responsive-1By1 pb-0" ng-style="{'background-image': 'url('+contCtrl.item.prod_img3+')'}"></div>
                        </div>
                        <button ng-click="contCtrl.cancelImg(contCtrl.item, 'prod_img3')"  
                                class="btn btn-danger position-absolute right bottom" 
                                style="bottom: 0px; right:0px"
                                type="button"
                        >x</button>
                    </div>
                    <div><span>QRCODE 2：</span><span class="highlight">&nbsp;(建議尺寸：300*300px，但會依實際比例調整顯示)</span></div>
                    <div class="custom-file mb-2">
                        <input class="inputFile w-100" type="file" mo-block="0" prod-img="3" ng-file-select="onFileSelect($files)" ng-model="contCtrl.item.prod_img3" class="custom-file-input form-control-use line-style" id="file-main-img3" pro-num='contCtrl.productNum' content-item='contCtrl.item' pro-id="contCtrl.productId" value="">
                        <label class="custom-file-label" for="file-main-img3">選擇檔案</label>
                    </div>
                      <!-- 社群文字 -->
                    <div class="mb-2">
                        <span class="use-sp-title" ng-bind="contCtrl.propertyTag[15].prop_tag_name"></span>
                        <input class="form-control" ng-model="contCtrl.propertyTag[15]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)" row="20">
                    </div>
                    <!-- 文字顏色 -->
                    <div>
                        <span class="use-sp-title" ng-bind="contCtrl.propertyTag[16].prop_tag_name"></span><span class="herinneren-use">(請輸入含#的六碼色碼)</span>
                        <div class="d-flex align-items-center">
                            <input class="form-control" type="color" ng-model="contCtrl.propertyTag[16]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)" style="width: 20%; height: 38px;">
                            <input class="form-control" type="text" ng-model="contCtrl.propertyTag[16]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)">
                        </div>
                    </div>
                    <!-- 社群文字字型大小 -->
                    <div>
                        <span class="use-sp-title">社群文字2字型大小(像素(px))：</span>
                        <input class="form-control" type="text" ng-model="contCtrl.propertyTag[24]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)">
                    </div>
                </div>  
            </div>

            <div class="row">
                <hr class="col-12 area_break p-0"/>
                
                <!-- 主體包裝 type start -->
                <div class="col-6">
                    <div class="tableBoxUse">
                        <h4 class="use-h4-title">連結按鈕區</h4>
                        <!-- <span class="use-remarks"><a href="" data-toggle="modal" data-target="#productTypeModal" data-backdrop="static" data-keyboard="false" ng-click='contCtrl.addProductType()'>新增包裝</a></span> -->
                        <a class="link" href="javascript:void(0)" ng-click="contCtrl.addProductTypeModal()" ng-if="contCtrl.item.style > 0"><span>+</span></a>
                    </div>
                    <!-- 區塊顏色 -->
                    <div class="row mb-4" ng-if="[6,'6'].indexOf(contCtrl.item.style)==-1">
                        <div class="col-12">
                            <span class="use-sp-title" ng-bind="contCtrl.propertyTag[7].prop_tag_name"></span><span class="herinneren-use">(請輸入含#的六碼色碼)</span>
                            <div class="d-flex align-items-center">
                                <input class="form-control" type="color" ng-model="contCtrl.propertyTag[7]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)" style="width: 20%; height: 38px;">
                                <input class="form-control" type="text" ng-model="contCtrl.propertyTag[7]['prod_prop']" ng-blur="contCtrl.modifyPropertyTag(contCtrl.propertyTag)" ng-focus="contCtrl.textRecording(contCtrl.propertyTag)">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 mb-3">
                    連結輸入說明，請依照說明填入：
                    <ul>
                        <li>1. 連結為一般網頁網址：請輸入含 https 之完整網址，如：<b>https://google.com.tw</b></li>
                        <li>2. 欲讓人可撥打電話：室內電話範例為：<span class="font-weight-bold"><span class="highlight">tel:+886</span>-2-1234567</span>、手機號碼範例為：<span class="font-weight-bold"><span class="highlight">tel:+886</span>-988765432</span></li>
                        <li>3. 欲讓人可寄信：範例為：<span class="font-weight-bold"><span class="highlight">mailto:</span>service@gmail.com</span></li>
                        <li>4. 若要分享按鈕，連結請輸入>>> <span class="font-weight-bold highlight">https://line.me</span></li>
                        <li>5. 若填入其他格式，則為複製文字</li>
                        <li>6. 名片按鈕將依照所設定排序顯示</li>
                    </ul>
                </div>
                <div class="col-12">
                    <table class="table table-bordered admin-table-rwd form">
                        <thead>
                            <tr class="admin-tr-only-hide">
                                <th scope="col">按鈕樣式<span class="herinneren-use">須設定，否則不顯示按鈕</span></th>
                                <th scope="col">底色</th>
                                <th scope="col">按鈕文字<span class="herinneren-use">須設定，否則不顯示按鈕</span></th>
                                <th scope="col">按鈕連結<span class="herinneren-use">須設定，否則不顯示按鈕</span></th>
                                <th class="w-65px" scope="col">排序</th>
                                <th class="w-65px" scope="col">狀態</th>
                                <th class="w-65px" scope="col">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="item in contCtrl.productType">
                                <td data-th="按鈕樣式">
                                    <select class="form-control" ng-model="item.prod_type" ng-change="contCtrl.saveProductTypeModal(item)">
                                        <!-- <option value=""></option> -->
                                        <option value="link">連結(有色字)</option>
                                        <option value="primary">主按鈕(白字+底色)</option>
                                        <option value="secondary">次按鈕(黑字+底色)</option>
                                    </select>                      
                                </td>
                                <td data-th="底色">
                                    <div class="d-flex align-items-center" ng-if="item.prod_type=='primary'||item.prod_type=='secondary'">
                                        <input class="use-form-control pdSpacing" type="color" ng-model="item.type_sales_price" ng-blur="contCtrl.saveProductTypeModal(item)" ng-focus="contCtrl.textRecording(item)" style="width: 20%; height: 35px;">
                                        <input class="use-form-control pdSpacing w-100" type="text" ng-model="item.type_sales_price" ng-blur="contCtrl.saveProductTypeModal(item)" ng-focus="contCtrl.textRecording(item)">
                                    </div>
                                    <div class="d-flex align-items-center" ng-if="item.prod_type=='link'">
                                        <label class="pdSpacing w-25" for="bgColorlink_@{{item.prod_type_id}}">字色</label>
                                        <input class="use-form-control pdSpacing" id="bgColorlink_@{{item.prod_type_id}}" type="color" ng-model="item.type_sales_price" ng-blur="contCtrl.saveProductTypeModal(item)" ng-focus="contCtrl.textRecording(item)" style="width: 20%; height: 35px;">
                                        <input class="use-form-control pdSpacing w-100" type="text" ng-model="item.type_sales_price" ng-blur="contCtrl.saveProductTypeModal(item)" ng-focus="contCtrl.textRecording(item)">
                                        <label class="pdSpacing w-25 ml-2" for="bdColorlink_@{{item.prod_type_id}}">按鈕<br>底色</label>
                                        <input class="use-form-control pdSpacing" id="bdColorlink_@{{item.prod_type_id}}" type="color" ng-model="item.type_sales_price_prime" ng-blur="contCtrl.saveProductTypeModal(item)" ng-focus="contCtrl.textRecording(item)" style="width: 20%; height: 35px;">
                                        <input class="use-form-control pdSpacing w-100" type="text" ng-model="item.type_sales_price_prime" ng-blur="contCtrl.saveProductTypeModal(item)" ng-focus="contCtrl.textRecording(item)">
                                    </div>
                                </td>
                                <td data-th="按鈕文字">
                                    <input class="use-form-control pdSpacing w-100" type="text" ng-model="item.type_price" ng-blur="contCtrl.saveProductTypeModal(item)" ng-focus="contCtrl.textRecording(item)">                                
                                </td>
                                <td data-th="按鈕連結">
                                    <input class="use-form-control pdSpacing w-100" type="text" ng-model="item.prod_sn" ng-blur="contCtrl.saveProductTypeModal(item)" ng-focus="contCtrl.textRecording(item)">                                
                                </td>
                                <td data-th="排序">
                                    <input class="use-form-control" type="text" ng-model="item.order_id" ng-blur="contCtrl.saveProductTypeModal(item)" ng-focus="contCtrl.textRecording(item)">
                                </td>
                                <td data-th="狀態">
                                    <a href="javascipt:void(0)" ng-bind="contCtrl.productTypeStatus[item.type_status].name" ng-click="contCtrl.changeProductTypeStatus(item)"></a>
                                </td>
                                <td data-th="操作">
                                    <button ng-click='contCtrl.delProductType(item.prod_type_id)' type="button" class="btn btn-danger">x</button>
                                    <!-- <span> <a href="" data-toggle="modal" data-target="#productTypeModal" ng-click='contCtrl.editProductType(item)'>修改</a></span> / <span> <a href="" ng-click='contCtrl.delProductType(item.prod_type_id)'>刪除</a></span> -->
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 分類 start -->
            <div class="row">
                <div class="col-md-6 col-12">
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

    <!--Modal -->
    <div class="modal fade" id="sampleModal" tabindex="-1" role="dialog" aria-labelledby="sampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">版型示範</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body d-flex flex-column">
                    <div class="d-flex justify-content-around">
                        <div class="sample">
                            <span>個人介紹</span>
                            <div>
                                <img class="sampleImg" src="/public/img/product_card_sample/cardSample1.png?{{ time() }}" />
                            </div>
                        </div>
                        <div class="sample">
                            <span>官網介紹</span>
                            <div>
                                <img class="sampleImg" src="/public/img/product_card_sample/cardSample2.png?{{ time() }}" />
                            </div>
                        </div>
                        <div class="sample">
                            <span>專業版型一</span>
                            <div>
                                <img class="sampleImg" src="/public/img/product_card_sample/cardSample3.png?{{ time() }}" />
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-around mt-4">
                        <div class="sample">
                            <span>專業版型二</span>
                            <div>
                                <img class="sampleImg" src="/public/img/product_card_sample/cardSample4.png?{{ time() }}" />
                            </div>
                        </div>
                        <div class="sample">
                            <span>全版無廣告</span>
                            <div>
                                <img class="sampleImg" src="/public/img/product_card_sample/cardSample5.png?{{ time() }}" />
                            </div>
                        </div>
                        <div class="sample">
                            <span>奧斯丁</span>
                            <div>
                                <img class="sampleImg" src="/public/img/product_card_sample/cardSample6.png?{{ time() }}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Modal End-->
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
                        console.info('111');
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
            self.role="{{$role}}";
            self.user_id="{{$user_id}}";
            
            @foreach($member_list as $member)
                var member = {
                    value: {{$member['id']}},
                    name: "{{$member['user_name']}}",
                }
                self.memberOptions[{{$member['id']}}]=member;
            @endforeach

            //self.memberOptions=JSON.stringify(self.memberOptions);
            //console.info(self.memberOptions);
            self.productId = "{{$productId}}";
            self.listUrl = '/admin/api/product/detail/edit'; /*取得商品完整內容api*/
            self.staticFilePath = '/upload/product/';           /*靜態檔案讀取位置*/
            // self.need_content = true; /*需編輯詳細內容*/
            self.need_content = false; /*無需編輯詳細內容*/
           
            
            //self.items.selectUser="2";
            

                
            @section('angular_js')
            {
                //self.member="2";
                /*新增特有method-----------------開始*/
                
                
                // self.auto_click_tag = true; /*需自動勾選tag*/
                self.auto_click_tag = false; /*無需自動勾選tag*/

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

                    // var check_img = self.checkImage(self.item.style);
                    // console.info(check_img);
                    // if(check_img==false){
                    //     alert("圖片不符合尺寸,請重新上傳");
                    //     return;
                    // }
                
                    // for(var j=0;j<self.propertyTag.length;j++){

                    //     if(self.item.style==1){

                            
                    //         if(self.propertyTag[j].prop_tag_id==6 && self.propertyTag[j].prod_prop.length<7){
                    //             self.propertyTag[j].prod_prop='#FFFFFF';
                    //             alert("必填資料,不完全");
                    //             location.reload();
                    //             return;
                    //         }
                    //         if(self.propertyTag[j].prop_tag_id==14 && self.propertyTag[j].prod_prop.length<2){                                
                    //             alert("必填資料,不完全");
                    //             location.reload();
                    //             return;
                    //         }
                    //         if(self.propertyTag[j].prop_tag_id==15 && self.propertyTag[j].prod_prop.length<7){
                    //             self.propertyTag[j].prod_prop='#FFFFFF';
                    //             alert("必填資料,不完全");   
                    //             location.reload();                             
                    //             return;
                    //         }

                    //         if(self.propertyTag[j].prop_tag_id==3 && self.propertyTag[j].prod_prop.length<2){                                
                    //             alert("必填資料,不完全");  
                    //             location.reload();                                         
                    //             return;
                    //         }
                                                    
                            
                    //     }else if(self.item.style==2){
                            
                            
                    //         if(self.propertyTag[j].prop_tag_id==6 && self.propertyTag[j].prod_prop.length<7){
                    //             self.propertyTag[j].prod_prop='#FFFFFF';
                    //             alert("必填資料,不完全");
                    //             return;
                    //         }
                    //         if(self.propertyTag[j].prop_tag_id==14 && self.propertyTag[j].prod_prop.length<2){
                                
                    //             alert("必填資料,不完全");
                    //             return;
                    //         }
                    //         if(self.propertyTag[j].prop_tag_id==15 && self.propertyTag[j].prod_prop.length<7){
                    //             self.propertyTag[j].prod_prop='#FFFFFF';
                    //             alert("必填資料,不完全");
                    //             return;
                    //         }

                    //     }else if(self.item.style==3){

                    //     }else if(self.item.style==4){

                    //     }else if(self.item.style==5){

                    //     }

                    // }

                    if(self.role=='member'){
                        self.item.selectUser = self.user_id
                    }                 
                    
                    if(self.item.selectUser==undefined){
                        $.toaster({ message : '至少選擇一對象',  priority : 'warning'})
                        return false;
                    }
                    

                    if(self.endDateStatus == 0){
                        if(self.item.prod_e_datetime <=  self.item.prod_s_datetime){
                            alert('結束日期不能小於等於開始時間');
                            return false;
                        }
                    }else{
                        self.item.prod_e_datetime = '2222-01-01';  //2018-01-01 08:00:00
                    }

                    if( self.item.prod_img == "" || self.item.prod_img ==null){
                        // alert('請上傳圖片');
                        // return false;
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

                self.selectTarget = function(prod_id){
                    console.info(prod_id);
                    //console.info($(this).val());            
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

                        self.setLayoutImageSize(self.item.style);
                        //self.item.selectUser = data.item.owner;
                        //console.log(self.item.style);
                        // self.item.prod_s_datetime =Date.parse(new Date(self.item.prod_s_datetime));

                        //----------------------------------------------------------------
                        //----------------------------------------------------------------
                        //----------------------------------------------------------------
                        //----------------------------------------------------------------
                        $('#proShowStartTime').datetimepicker({
                            defaultDate: self.item.prod_show_s_datetime ,
                            locale: 'zh-tw',
                            format: 'YYYY-MM-DD',
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
                            format: 'YYYY-MM-DD',
                            ignoreReadonly: true,
                            icons: {
                                // time: "fa fa-clock-o",
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
                                // time: "fa fa-clock-o",
                                date: "fa fa-calendar",
                                up: "fa fa-arrow-up",
                                down: "fa fa-arrow-down"
                            }
                        });

                        if (self.item.prod_e_datetime == '2222-01-01 00:00:00') {
                            // 預設為今天 + 30天
                            let today = new Date();
                            // 計算30天後的日期
                            today.setDate(today.getDate() + 30);
                            // 格式化日期為 YYYY-MM-DD
                            let year = today.getFullYear();
                            let month = String(today.getMonth() + 1).padStart(2, '0');
                            let day = String(today.getDate()).padStart(2, '0');

                            self.item.prod_e_datetime = `${year}-${month}-${day} 00:00:00`;
                        }
                        $('#proEndTime').datetimepicker({
                            defaultDate: self.item.prod_e_datetime,
                            locale: 'zh-tw',
                            format: 'YYYY-MM-DD',
                            ignoreReadonly: true,
                            icons: {
                                // time: "fa fa-clock-o",
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
                        self.item.prod_img3 = self.staticFilePath + self.productId + '/' + data.item.prod_img3;
                        self.productDescribe = data.productDescribe;

                        self.showProd_describe = $sce.trustAsHtml(self.productDescribe[2].prod_describe);
                        self.propertyTag = data.propertyTag;
                        self.productType = data.productType;
                        self.productSpec = data.productSpec;
                        self.productImg = data.productImg;
                        angular.forEach(self.productImg, function(item) {
                            item.prod_img_name = self.staticFilePath + item.prod_id + '/' + item.prod_img_name;
                            item.prod_img_name2 = self.staticFilePath + item.prod_id + '/' + item.prod_img_name2;
                            item.prod_img_name3 = self.staticFilePath + item.prod_id + '/' + item.prod_img_name3;
                        });

                        self.productFile = data.productFile;
                        angular.forEach(self.productFile, function(item) {
                            item.prod_img_path = self.staticFilePath + item.prod_id + '/' + item.prod_img_name;
                        });
                        // console.log( Date.parse(self.item.prod_e_datetime) )

                        // if (Date.parse(self.item.prod_e_datetime) == Date.parse( '2222-01-01 00:00:00')) {
                        //     self.endDateStatus = 1;
                        //     $("#proEndTime").hide();
                        // }
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
            self.productOwnerUrl = '/admin/api/product/owner';
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
            self.setLayoutUrl = '/admin/api/product/setlayout';
            self.imageSize = "";
            self.imageSize_2 = "";
            self.imageRatio = "";
            self.imageRatio_2 = "";

            $scope.setLayout = function(prod_id,style) {
                self.setLayoutImageSize(style);
                
                // return
                var data = { 'prod_id': prod_id, 'style': style };
                self.actionItem(4,"post", self.setLayoutUrl, data);

                setTimeout(function() {
                    self.getItems();
                }, 1000);
            }

            self.setLayoutImageSize = function (style){
                if(style==1){
                    self.imageSize = "400*400px";
                    self.imageRatio = "1:1"
                    self.imageSize_2 = "400*280px";
                    self.imageRatio_2 = "10:7"
                }else if(style==2){
                    self.imageSize = "400*400px";
                    self.imageRatio = "1:1"
                }else if(style==3){
                    self.imageSize = "400*600px";
                    self.imageRatio = "1:1.5"
                }else if(style==4){
                    self.imageSize = "400*800px";
                    self.imageRatio = "1:2"
                }else if(style==5){
                    self.imageSize = "400*400px";
                    self.imageRatio = "1:1"
                }else if(style==6){
                    self.imageSize = "400*720px";
                    self.imageRatio = "5:9"
                }else if(style==7){
                    self.imageSize = "600*400px";
                    self.imageRatio = "3:2"
                }
            }

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

                /* var data = JSON.stringify(self);
                var data = JSON.parse(data); */
                
                //console.info(self.item.style);                
                // var check_img = self.checkImage(self.item.style);
                // console.info(check_img);
                // if(check_img==false){
                //     alert("圖片不符合尺寸,請重新上傳");
                //     return;
                // }
                
                // for(var j=0;j<self.propertyTag.length;j++){
 
                //     if(self.item.style==1){

                        
                //         if(self.propertyTag[j].prop_tag_id==6 && self.propertyTag[j].prod_prop.length<7){
                //             self.propertyTag[j].prod_prop='#FFFFFF';
                //             alert("必填資料,不完全");
                //             return;
                //         }
                //         if(self.propertyTag[j].prop_tag_id==14 && self.propertyTag[j].prod_prop.length<2){
                            
                //             alert("必填資料,不完全");
                //             return;
                //         }
                //         if(self.propertyTag[j].prop_tag_id==15 && self.propertyTag[j].prod_prop.length<7){
                //             self.propertyTag[j].prod_prop='#FFFFFF';
                //             alert("必填資料,不完全");
                //             return;
                //         }

                //         if(self.propertyTag[j].prop_tag_id==3 && self.propertyTag[j].prod_prop.length<2){
                            
                //             alert("必填資料,不完全");
                //             return;
                //         }
                                                
                        
                //     }else if(self.item.style==2){
                        
                //         if(self.propertyTag[j].prop_tag_id==5 && self.propertyTag[j].prod_prop.length<2){
                //             alert(self.propertyTag[j].prod_prop.length);
                //             alert("必填資料,不完全");
                //             return;
                //         }
                //         if(self.propertyTag[j].prop_tag_id==6 && self.propertyTag[j].prod_prop.length<7){
                //             self.propertyTag[j].prod_prop='#FFFFFF';
                //             alert("必填資料,不完全");
                //             return;
                //         }
                //         if(self.propertyTag[j].prop_tag_id==14 && self.propertyTag[j].prod_prop.length<2){
                            
                //             alert("必填資料,不完全");
                //             return;
                //         }
                //         if(self.propertyTag[j].prop_tag_id==15 && self.propertyTag[j].prod_prop.length<7){
                //             self.propertyTag[j].prod_prop='#FFFFFF';
                //             alert("必填資料,不完全");
                //             return;
                //         }

                //     }else if(self.item.style==3){

                //     }else if(self.item.style==4){

                //     }else if(self.item.style==5){

                //     }

                // }
                

                location.href = '/admin/product/' + self.productNum;
            }
            self.endDateStatus = 0;

            // self.checkImage = function(style){
            //     var url = self.item.prod_img;
            //     var w='';
            //     var h='';
            //     var img=new Image;
            //     img.src=url;
            //     img.onload=function(){};
        
            //     var image_ratio = img.naturalHeight / img.naturalWidth;
                
            //     if(style==1 && image_ratio!=1){
            //         return false;
            //     }else if(style==2 && image_ratio!=1){
            //         console.info(image_ratio);
            //         return false;
            //     }else if(style==3 && image_ratio!=1.5){
            //         return false;
            //     }else if(style==4 && image_ratio!=2){
            //         return false;
            //     }else if(style==5 && image_ratio!=1){
            //         return false;
            //     }

            //     return true;
                
            // }

            self.noEndTime = function() {
                if( self.endDateStatus == 0){
                    $("#proEndTime").show();
                    self.item.prod_e_datetime =self.item.prod_s_datetime ;
                }else{
                    $("#proEndTime").hide();
                    self.item.prod_e_datetime = '2222-01-01';
                    self.modifyItem(self.item);
                }
            }

            self.productTypeItem ={
                prod_type: 'link',
                type_price: "",
                type_sales_price: '#ffffff',
                type_sales_price_prime: '#000000',
                prod_sn: '',
                type_status: 1,
                order_id: 0,
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
                    prod_type: 'link',
                    type_price: "",
                    type_sales_price: '#ffffff',
                    type_sales_price_prime: '#000000',
                    prod_sn: '',
                    type_status: 1,
                    order_id: 0,
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

                if(self.item.selectUser == undefined){
                    $.toaster({ message : '請先選擇對象',  priority : 'warning'})
                    return false;
                }
                
                var data = { 'item': self.item, 'productId': self.productId };
                console.log(self.editMainUrl, data);
                self.actionItem(0, "put", self.editMainUrl, data);
            };

            self.textRecording = function(item) {
                self.contrastContent="";
                self.contrastContent = angular.copy(item, self.contrastContent);            
            }

            self.modifyItemOnwer = function(item) {
                if(item.selectUser==undefined){
                    $.toaster({ message : '至少選擇一對象',  priority : 'warning'})
                    return false;
                }
                
                var data = { 'owner': item.selectUser, 'prod_id': item.prod_id };                
                self.actionItem(4, "post", self.productOwnerUrl, data);
            }
            self.modifyItem = function(item) {
                //console.info(self.selectUser);
                if(isNaN(item.prod_order) ){
                    self.item = self.contrastContent;
                    $.toaster({ message : '排序請填入數字',  priority : 'warning'})
                    return false;
                }

                if (self.item.prod_img.length === 0) {
                    $.toaster({ message : '請上傳圖片',  priority : 'warning'})
                    return false;
                }

                $scope.result = angular.equals(self.contrastContent, item);

                if(!$scope.result){
                    self.saveMainModal(item);
                }
            }

            self.modifyItemName = function(item) {
                if (self.item.prod_name.length === 0) {
                    $.toaster({ message : '請填寫公司名',  priority : 'warning'})
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

                    if (self.item.prod_e_datetime == '2222-01-01 00:00:00') {
                        // 預設日期為今天往後數30天
                        today = new Date();
                        today.setDate(today.getDate() + 30);
                        self.item.prod_e_datetime = today.Format("yyyy-MM-dd");
                    }
                } else {
                    self.item.prod_e_datetime = '2222-01-01 00:00:00';
                }

                $scope.result = angular.equals(self.contrastContent, item);
                if(!$scope.result){
                    self.saveMainModal(item);
                }
            }
            self.cancelImg = function(item, column) {
                if (['prod_img','prod_img2','prod_img3'].indexOf(column)==-1) {
                    $.toaster({ message : '無此欄位',  priority : 'warning'})
                    return false;
                }
                item[column] = -1;
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
                var data = { 'item': self.productDescribe ,'productId': self.productId };console.log(data);
                self.timeoutAct = setTimeout(function(){ 
                    self.actionItem(2, "put", self.prodDescribeEditUrl, data);
                }, 100);
            };

            self.savePropertyTagModal = function() {
               
                var data = { 'item': self.propertyTag, 'productId': self.productId, 'productNum': self.productNum };
               
                self.actionItem(3, "put", self.prodPropertyEditUrl, data);
            };

            self.addProductTypeModal = function() {
                let data, item = self.productTypeItem;

                if (!self.productType) {
                    data = { 'item': self.productTypeItem, 'productId': self.productId };
                } else {
                    if (self.productType.length > 0) {
                        let last_item_order = self.productType[self.productType.length - 1].order_id;
                        item.order_id = Number(last_item_order) + 1;
                    } else {
                        item.order_id = 0;
                    }

                    data = { 'item': item, 'productId': self.productId };
                }

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
                            item.prod_img_name3 = self.staticFilePath + item.prod_id + '/' + item.prod_img_name3;
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
                            //self.item = data.item;
                            self.item.prod_img = self.staticFilePath + self.productId + '/' + data.item.prod_img;
                            self.item.prod_img2 = self.staticFilePath + self.productId + '/' + data.item.prod_img2;
                            self.item.prod_img3 = self.staticFilePath + self.productId + '/' + data.item.prod_img3;
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

                        }else if (number == 4) {
                            // 主題欄位
                            $.toaster({ message : '設定成功'})

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
                                    item.prod_img_name3 = self.staticFilePath + item.prod_id + '/' + item.prod_img_name3;
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
                                            } else if (data.status == '100') {
                                                $.toaster({ message : data.msg ,  priority : 'danger'})
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
                                                    item.prod_img_name3 = '/upload/product/' + item.prod_id + '/' + item.prod_img_name3;
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
                                            'prod_img_name3': $scope.ngModel.prod_img_name3,
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
                                    item.prod_img_name3 = '/upload/product/' + item.prod_id + '/' + item.prod_img_name3;
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