@extends($extends_layouts)

@extends('admin.cms.cms_template.templateCms')

<!-- html title -->
@section('htmlTitle') {{$pageTitle}}  @endsection

<!-- 自定義 樣式 -->
@section('css_header')
    <style type="text/css">
        #viewbox .modal-dialog{
            max-width: 1920px;
        }
    </style>
@endsection

<!-- 自定義 content -->
@section('content')
    <div class="w-100 mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">{{$topTitle}}</li>
                <!-- <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li> -->
            </ol>
        </nav>
    </div>
@endsection

@section('cms_edit_content')
    <div class='container-fluid'>
        <div class="row">
            <div class="col-4">
                <div class="mb-2">
                    <h3 class="">LOGO：</h3>
                    <!-- <span class="spanTitle"></span> -->
                    <div class="input-group">
                        <div class="custom-file">
                              <input class="custom-file-input form-control-use line-style" type="file" 
                                                        ng-file-select="onFileSelect($files)" 
                                                        edit-content-url="contCtrl.editContentUrl" 
                                                        content-item='contCtrl.items[0]' 
                                                        cms-type-id='contCtrl.cmsTypeId'
                                                        ng-model="contCtrl.items[0].imageSrc" 
                                                        class="custom-file-input form-control-use line-style" 
                                                        id="file-0"
                                                        key="0"
                                                        value="">
                            <label class="custom-file-label" for="file-img-0">選擇檔案</label>
                        </div>
                    </div>
                    <p class="mark-use mb-3">建議尺寸：314*96px</p>
                </div>
                <div ng-if='contCtrl.items[0].imageSrc != "" ' class="mb-2">
                    <img ng-src="@{{contCtrl.items[0].imageSrc}}" alt="" class="imgPreview w-100" style="max-width:314px;">
                </div>
            </div>
            <div class="col-2">
                <div class="mb-2">
                    <h3 class="">分頁圖示：</h3>
                    <!-- <span class="spanTitle"></span> -->
                    <div class="input-group">
                        <div class="custom-file">
                              <input class="custom-file-input form-control-use line-style" type="file" 
                                                        ng-file-select="onFileSelect($files)" 
                                                        edit-content-url="contCtrl.editContentUrl" 
                                                        content-item='contCtrl.items[0]' 
                                                        cms-type-id='contCtrl.cmsTypeId'
                                                        ng-model="contCtrl.items[0].template.pic_1" 
                                                        class="custom-file-input form-control-use line-style" 
                                                        id="file-pic_1"
                                                        key="0"
                                                        value=""
                                                        template-virable="'pic_1'">
                            <label class="custom-file-label" for="file-pic_1">選擇檔案</label>
                        </div>
                    </div>
                    <p class="mark-use mb-3">建議尺寸：32*32px</p>
                </div>
                <div ng-if='contCtrl.items[0].template.pic_1 != "" ' class="mb-2">
                    <img ng-src="@{{contCtrl.items[0].template.pic_1}}" alt="" class="imgPreview w-100" style="max-width:32px;">
                </div>
            </div>

            <div class="col-6">
                <h3 class="d-inline-block">社群連結：</h3>
                <span class="herinneren-use">站外連結請包含 http:// 或 https://，站內連結建議使用相對路徑</span>
                <div class="mb-2">
                    <span class="spanTitle mb-2">FB</span>
                    <input class="form-control" type='text' 
                        ng-model='contCtrl.items[0].template.fb_link' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                </div>
                <div class="mb-2">
                    <span class="spanTitle mb-2">LINE</span>
                    <input class="form-control" type='text' 
                        ng-model='contCtrl.items[0].template.line_link' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                </div>
                <div class="mb-2">
                    <span class="spanTitle mb-2">IG</span>
                    <input class="form-control" type='text' 
                        ng-model='contCtrl.items[0].template.ig_link' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                </div>
                <div class="mb-2">
                    <span class="spanTitle mb-2">Youtube</span>
                    <input class="form-control" type='text' 
                        ng-model='contCtrl.items[0].template.youtube_link' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                </div>
            </div>

            <div class="col-6">
                <h3 class="d-inline-block">聯絡資訊：</h3>
                <div class="mb-2">
                    <span class="spanTitle mb-2">標語：</span>
                    <input class="form-control" type='text' placeholder="標語" 
                        ng-model='contCtrl.items[0].template.logo_slogan' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                </div>
                <div class="mb-2">
                    <span class="spanTitle mb-2">電話：</span>
                    <input class="form-control" type='text' placeholder="電話1" 
                        ng-model='contCtrl.items[0].template.tel1' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                    <input class="form-control" type='text' placeholder="電話2" 
                        ng-model='contCtrl.items[0].template.tel2' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                    <input class="form-control" type='text' placeholder="電話3" 
                        ng-model='contCtrl.items[0].template.tel3' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                </div>
                <div class="mb-2">
                    <span class="spanTitle mb-2">傳真</span>
                    <input class="form-control" type='text' 
                        ng-model='contCtrl.items[0].template.fax' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                </div>
                <div class="mb-2">
                    <span class="spanTitle mb-2">信箱</span>
                    <input class="form-control" type='text' 
                        ng-model='contCtrl.items[0].template.email' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                </div>
                <div class="mb-2">
                    <span class="spanTitle mb-2">地址</span>
                    <input class="form-control" type='text' 
                        ng-model='contCtrl.items[0].template.address' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                </div>
                <div class="mb-2">
                    <span class="spanTitle mb-2">地址連結</span>
                    <span class="herinneren-use">站外連結請包含 http:// 或 https://，站內連結建議使用相對路徑</span>
                    <input class="form-control" type='text' 
                        ng-model='contCtrl.items[0].template.address_link' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                </div>
                <div class="mb-2">
                    <span class="spanTitle mb-2">場地營業時間：</span>
                    <div summernote ng-model="contCtrl.items[0].cont.text" config="noteOptions" int="0"></div>
                </div>
            </div>

            <div class="col-6">
                <h3 class="d-inline-block">其他課程時間：</h3>
                <!-- 
                    <div class="mb-3">
                        <h6 class="mb-0">報名處1：</h6>
                        <span class="spanTitle">名稱：</span>
                        <input class="form-control" type='text' placeholder="" 
                            ng-model='contCtrl.items[0].template.reg_name1' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                            ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                        <span class="spanTitle mb-2">電話：</span>
                        <input class="form-control" type='text' placeholder="電話1" 
                            ng-model='contCtrl.items[0].template.reg_tel1_1' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                            ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                        <input class="form-control" type='text' placeholder="電話2" 
                            ng-model='contCtrl.items[0].template.reg_tel1_2' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                            ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                    </div>
                    <div class="mb-3">
                        <h6 class="mb-0">報名處2：</h6>
                        <span class="spanTitle">名稱：</span>
                        <input class="form-control" type='text' placeholder="" 
                            ng-model='contCtrl.items[0].template.reg_name2' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                            ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                        <span class="spanTitle mb-2">電話：</span>
                        <input class="form-control" type='text' placeholder="電話1" 
                            ng-model='contCtrl.items[0].template.reg_tel2_1' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                            ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                        <input class="form-control" type='text' placeholder="電話2" 
                            ng-model='contCtrl.items[0].template.reg_tel2_2' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                            ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                    </div>
                    <div class="mb-3">
                        <h6 class="mb-0">報名處3：</h6>
                        <span class="spanTitle">名稱：</span>
                        <input class="form-control" type='text' placeholder="" 
                            ng-model='contCtrl.items[0].template.reg_name3' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                            ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                        <span class="spanTitle mb-2">電話：</span>
                        <input class="form-control" type='text' placeholder="電話1" 
                            ng-model='contCtrl.items[0].template.reg_tel3_1' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                            ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                        <input class="form-control" type='text' placeholder="電話2" 
                            ng-model='contCtrl.items[0].template.reg_tel3_2' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                            ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                    </div>
                    <div class="mb-3">
                        <h6 class="mb-0">報名處4：</h6>
                        <span class="spanTitle">名稱：</span>
                        <input class="form-control" type='text' placeholder="" 
                            ng-model='contCtrl.items[0].template.reg_name4' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                            ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                        <span class="spanTitle mb-2">電話：</span>
                        <input class="form-control" type='text' placeholder="電話1" 
                            ng-model='contCtrl.items[0].template.reg_tel4_1' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                            ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                        <input class="form-control" type='text' placeholder="電話2" 
                            ng-model='contCtrl.items[0].template.reg_tel4_2' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                            ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                    </div>
                -->
                <div class="mb-2">
                    <!-- <span class="spanTitle mb-2">其他課程時間：</span> -->
                    <div summernote ng-model="contCtrl.items[1].cont.text" config="noteOptions" int="1"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('color_link')
@endsection

@section('cms_layout_selector')
@endsection

@section('cms_layout_create_btn')
@endsection

@section('cms_btn')
@show

@section('cms_layout_js')
@endsection