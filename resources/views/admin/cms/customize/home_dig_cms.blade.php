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
                <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
            </ol>
        </nav>
    </div>
@endsection

@section('cms_edit_content')
    <div class='container-fluid'>
        <div class="row mb-4">
            <h3 class="col-12">介紹影片</h3>
            <div class="col-12">
                <span class="herinneren-use">請開啟youtube，搜尋要嵌入的影片，點擊分享>嵌入>複製HTML，然後貼入下方輸入區</span>
                <textarea class="form-control" type='text' rows="6" 
                    ng-model='contCtrl.items[0].title.text' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                    ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                </textarea>
            </div>
        </div>

        <hr class="w-100">

        <div class="row mb-4">
            <h3 class="col-12">區塊1</h3>
            <div class="col-6">
                <span class="spanTitle mb-2">大標題：</span>
                <input class="form-control" type='text' 
                    ng-model='contCtrl.items[1].template.title' ng-blur="contCtrl.modifyItem(contCtrl.items[1],2)" 
                    ng-focus="contCtrl.textRecording(contCtrl.items[1])"/>

                <span class="spanTitle mb-2">小標題：</span>
                <input class="form-control" type='text' 
                    ng-model='contCtrl.items[1].title.text' ng-blur="contCtrl.modifyItem(contCtrl.items[1],2)" 
                    ng-focus="contCtrl.textRecording(contCtrl.items[1])"/>

                <span class="spanTitle mb-2">內容：</span>
                <div summernote ng-model="contCtrl.items[1].cont.text" config="noteOptions" int="1"></div>
            </div>
            <div class="col-6">
                <div class="mb-2">
                    <span class="spanTitle">圖片：</span>
                    <div class="input-group">
                        <div class="custom-file">
                              <input class="custom-file-input form-control-use line-style" type="file" 
                                                        ng-file-select="onFileSelect($files)" 
                                                        edit-content-url="contCtrl.editContentUrl" 
                                                        content-item='contCtrl.items[1]' 
                                                        cms-type-id='contCtrl.cmsTypeId' 
                                                        ng-model="contCtrl.items[1].imageSrc" 
                                                        class="custom-file-input form-control-use line-style" 
                                                        id="file-1"
                                                        key="1"
                                                        value="">
                            <label class="custom-file-label" for="file-img-1">選擇檔案</label>
                        </div>
                    </div>
                    <p class="mark-use mb-3">建議尺寸：564*368px</p>
                </div>
                <div ng-if='contCtrl.items[1].imageSrc != "" ' class="mb-1">
                    <img ng-src="@{{contCtrl.items[1].imageSrc}}" alt="" class="imgPreview w-100" style="max-width:564px;">
                </div>
            </div>
        </div>

        <hr class="w-100">

        <div class="row mb-4">
            <h3 class="col-12">區塊2</h3>

            <div class="col-12">
                <span class="spanTitle mb-2">區塊標題：</span>
                <input class="form-control" type='text' 
                    ng-model='contCtrl.items[2].template.title_area' ng-blur="contCtrl.modifyItem(contCtrl.items[2],2)" 
                    ng-focus="contCtrl.textRecording(contCtrl.items[2])"/>
            </div>
            <div class="col-6">
                <div class="mb-2">
                    <span class="spanTitle">圖片：</span>
                    <div class="input-group">
                        <div class="custom-file">
                              <input class="custom-file-input form-control-use line-style" type="file" 
                                                        ng-file-select="onFileSelect($files)" 
                                                        edit-content-url="contCtrl.editContentUrl" 
                                                        content-item='contCtrl.items[2]' 
                                                        cms-type-id='contCtrl.cmsTypeId' 
                                                        ng-model="contCtrl.items[2].imageSrc" 
                                                        class="custom-file-input form-control-use line-style" 
                                                        id="file-2"
                                                        key="2"
                                                        value="">
                            <label class="custom-file-label" for="file-img-2">選擇檔案</label>
                        </div>
                    </div>
                    <p class="mark-use mb-3">建議尺寸：1025*648px</p>
                </div>
                <div ng-if='contCtrl.items[2].imageSrc != "" ' class="mb-2">
                    <img ng-src="@{{contCtrl.items[2].imageSrc}}" alt="" class="imgPreview w-100" style="max-width:564px;">
                </div>
            </div>
            <div class="col-6">
                <span class="spanTitle mb-2">大標題：</span>
                <input class="form-control" type='text' 
                    ng-model='contCtrl.items[2].template.title' ng-blur="contCtrl.modifyItem(contCtrl.items[2],2)" 
                    ng-focus="contCtrl.textRecording(contCtrl.items[2])"/>

                <span class="spanTitle mb-2">小標題：</span>
                <input class="form-control" type='text' 
                    ng-model='contCtrl.items[2].title.text' ng-blur="contCtrl.modifyItem(contCtrl.items[2],2)" 
                    ng-focus="contCtrl.textRecording(contCtrl.items[2])"/>

                <span class="spanTitle mb-2">內容：</span>
                <div summernote ng-model="contCtrl.items[2].cont.text" config="noteOptions" int="2"></div>
            </div>

            <div class="col-6">
                <span class="spanTitle mb-2">大標題：</span>
                <input class="form-control" type='text' 
                    ng-model='contCtrl.items[3].template.title' ng-blur="contCtrl.modifyItem(contCtrl.items[3],2)" 
                    ng-focus="contCtrl.textRecording(contCtrl.items[3])"/>

                <span class="spanTitle mb-2">小標題：</span>
                <input class="form-control" type='text' 
                    ng-model='contCtrl.items[3].title.text' ng-blur="contCtrl.modifyItem(contCtrl.items[3],2)" 
                    ng-focus="contCtrl.textRecording(contCtrl.items[3])"/>

                <span class="spanTitle mb-2">內容：</span>
                <div summernote ng-model="contCtrl.items[3].cont.text" config="noteOptions" int="3"></div>
            </div>
            <div class="col-6">
                <div class="mb-2">
                    <span class="spanTitle">圖片：</span>
                    <div class="input-group">
                        <div class="custom-file">
                              <input class="custom-file-input form-control-use line-style" type="file" 
                                                        ng-file-select="onFileSelect($files)" 
                                                        edit-content-url="contCtrl.editContentUrl" 
                                                        content-item='contCtrl.items[3]' 
                                                        cms-type-id='contCtrl.cmsTypeId' 
                                                        ng-model="contCtrl.items[3].imageSrc" 
                                                        class="custom-file-input form-control-use line-style" 
                                                        id="file-3"
                                                        key="3"
                                                        value="">
                            <label class="custom-file-label" for="file-img-3">選擇檔案</label>
                        </div>
                    </div>
                    <p class="mark-use mb-3">建議尺寸：1025*648px</p>
                </div>
                <div ng-if='contCtrl.items[3].imageSrc != "" ' class="mb-2">
                    <img ng-src="@{{contCtrl.items[3].imageSrc}}" alt="" class="imgPreview w-100" style="max-width:564px;">
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






