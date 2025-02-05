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
    <div class="mb-2 addCmsBox" style="z-index: 9999; position: fixed; top: 10px;">
        <button class='btn btn-mr-spacing btn-success' data-toggle="modal" data-target="#viewbox" ng-click="contCtrl.getView()">預覽全部</button>
        <a id="editView_btn" data-toggle="modal" data-target="#editView"></a>
    </div>

    <div class='container-fluid'>
        <div class="row border p-2">
            <h3 class="col-12 mt-2">形象大圖&nbsp;&nbsp;
                <span class="spanTitle h6">隱藏區塊:</span>
                <input type='checkbox' [checked]="contCtrl.items[0].template.hide"
                    ng-model='contCtrl.items[0].template.hide' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                    ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
            </h3>
            <div class="col-6">
                <div class="mb-2">
                    <span class="spanTitle">圖片：</span>
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
                    <p class="mark-use mb-3">建議尺寸：1920*1080px</p>
                </div>
            </div>
            <div class="col-6">
                <div ng-if='contCtrl.items[0].imageSrc != "" ' class="mb-2">
                    <img ng-src="@{{contCtrl.items[0].imageSrc}}" alt="" class="imgPreview w-100">
                </div>
            </div>
        </div>

        <div class="row border p-2">
            <h3 class="col-12 mt-2">文字介紹1&nbsp;&nbsp;
                <span class="spanTitle h6">隱藏區塊:</span>
                <input type='checkbox' [checked]="contCtrl.items[1].template.hide"
                    ng-model='contCtrl.items[1].template.hide' ng-blur="contCtrl.modifyItem(contCtrl.items[1],2)" 
                    ng-focus="contCtrl.textRecording(contCtrl.items[1])"/>
            </h3>
            <div class="col-12">
                <div class="mb-4">
                    <span class="spanTitle">區塊背景色：(請輸入#字號+6碼的色號)</span>
                    <input class="form-control" type='text' 
                        ng-model='contCtrl.items[1].template.bg_color' ng-blur="contCtrl.modifyItem(contCtrl.items[1],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[1])"/>
                </div>

                <div class="row mb-4">
                    <div class="col-6">
                        <span class="spanTitle mb-2">標題：</span>
                        <input class="form-control" type='text' 
                            ng-model='contCtrl.items[1].template.tilte_main' ng-blur="contCtrl.modifyItem(contCtrl.items[1],2)" 
                            ng-focus="contCtrl.textRecording(contCtrl.items[1])"/>
                    </div>
                    <div class="col-6">
                        <span class="spanTitle mb-2">標題字色：(請輸入#字號+6碼的色號)</span>
                        <input class="form-control" type='text' 
                            ng-model='contCtrl.items[1].template.tilte_main_color' ng-blur="contCtrl.modifyItem(contCtrl.items[1],2)" 
                            ng-focus="contCtrl.textRecording(contCtrl.items[1])"/>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <span class="spanTitle">副標題：(如需換行，請輸入&lt;br&gt;)</span>
                        <input class="form-control mb-2" type='text' 
                            ng-model='contCtrl.items[1].template.title_sub' ng-blur="contCtrl.modifyItem(contCtrl.items[1],2)" 
                            ng-focus="contCtrl.textRecording(contCtrl.items[1])"/>
                    </div>
                    <div class="col-6">
                        <span class="spanTitle">副標題背景色：(請輸入#字號+6碼的色號)</span>
                        <input class="form-control" type='text' 
                            ng-model='contCtrl.items[1].template.title_sub_bg' ng-blur="contCtrl.modifyItem(contCtrl.items[1],2)" 
                            ng-focus="contCtrl.textRecording(contCtrl.items[1])"/>
                    </div>
                    <div class="col-6">
                        <span class="spanTitle">副標題字色：(請輸入#字號+6碼的色號)</span>
                        <input class="form-control" type='text' 
                            ng-model='contCtrl.items[1].template.title_sub_color' ng-blur="contCtrl.modifyItem(contCtrl.items[1],2)" 
                            ng-focus="contCtrl.textRecording(contCtrl.items[1])"/>
                    </div>
                </div>

                <span class="spanTitle">內容：</span>
                <div class="mb-2" summernote ng-model="contCtrl.items[1].cont.text" config="noteOptions" int="1"></div>
                <span class="spanTitle">內容字色：(請輸入#字號+6碼的色號)</span>
                <input class="form-control mb-2" type='text' 
                    ng-model='contCtrl.items[1].template.content_color' ng-blur="contCtrl.modifyItem(contCtrl.items[1],2)" 
                    ng-focus="contCtrl.textRecording(contCtrl.items[1])"/>
            </div>
        </div>

        <div class="row border p-2">
            <h3 class="col-12 mt-2">大圖1&nbsp;&nbsp;
                <span class="spanTitle h6">隱藏區塊:</span>
                <input type='checkbox' [checked]="contCtrl.items[2].template.hide"
                    ng-model='contCtrl.items[2].template.hide' ng-blur="contCtrl.modifyItem(contCtrl.items[2],2)" 
                    ng-focus="contCtrl.textRecording(contCtrl.items[2])"/>
            </h3>
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
                    <p class="mark-use mb-3">建議尺寸：1920*1080px</p>
                </div>
            </div>
            <div class="col-6">
                <div ng-if='contCtrl.items[2].imageSrc != "" ' class="mb-2">
                    <img ng-src="@{{contCtrl.items[2].imageSrc}}" alt="" class="imgPreview w-100">
                </div>
            </div>
        </div>

        <div class="row border p-2">
            <h3 class="col-12 mt-2">大圖2&nbsp;&nbsp;
                <span class="spanTitle h6">隱藏區塊:</span>
                <input type='checkbox' [checked]="contCtrl.items[3].template.hide"
                    ng-model='contCtrl.items[3].template.hide' ng-blur="contCtrl.modifyItem(contCtrl.items[3],2)" 
                    ng-focus="contCtrl.textRecording(contCtrl.items[3])"/>
            </h3>
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
                    <p class="mark-use mb-3">建議尺寸：1920*1080px</p>
                </div>
            </div>
            <div class="col-6">
                <div ng-if='contCtrl.items[3].imageSrc != "" ' class="mb-2">
                    <img ng-src="@{{contCtrl.items[3].imageSrc}}" alt="" class="imgPreview w-100">
                </div>
            </div>
        </div>

        <div class="row border p-2">
            <h3 class="col-12 mt-2">大圖3&nbsp;&nbsp;
                <span class="spanTitle h6">隱藏區塊:</span>
                <input type='checkbox' [checked]="contCtrl.items[4].template.hide"
                    ng-model='contCtrl.items[4].template.hide' ng-blur="contCtrl.modifyItem(contCtrl.items[4],2)" 
                    ng-focus="contCtrl.textRecording(contCtrl.items[4])"/>
            </h3>
            <div class="col-6">
                <div class="mb-2">
                    <span class="spanTitle">圖片：</span>
                    <div class="input-group">
                        <div class="custom-file">
                              <input class="custom-file-input form-control-use line-style" type="file" 
                                                        ng-file-select="onFileSelect($files)" 
                                                        edit-content-url="contCtrl.editContentUrl" 
                                                        content-item='contCtrl.items[4]' 
                                                        cms-type-id='contCtrl.cmsTypeId' 
                                                        ng-model="contCtrl.items[4].imageSrc" 
                                                        class="custom-file-input form-control-use line-style" 
                                                        id="file-4"
                                                        key="4"
                                                        value="">
                            <label class="custom-file-label" for="file-img-4">選擇檔案</label>
                        </div>
                    </div>
                    <p class="mark-use mb-3">建議尺寸：1920*1080px</p>
                </div>
            </div>
            <div class="col-6">
                <div ng-if='contCtrl.items[4].imageSrc != "" ' class="mb-2">
                    <img ng-src="@{{contCtrl.items[4].imageSrc}}" alt="" class="imgPreview w-100">
                </div>
            </div>
        </div>


        {{-- 
        <div class="row border p-2">
            <h3 class="col-12 mt-2">XXXXX&nbsp;&nbsp;
                <span class="spanTitle h6">隱藏區塊:</span>
                <input type='checkbox' [checked]="contCtrl.items[0].template.hide"
                    ng-model='contCtrl.items[0].template.hide' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                    ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
            </h3>
            <div class="col-6">
                <div class="mb-2">
                    <span class="spanTitle">圖片：</span>
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
                    <p class="mark-use mb-3">建議尺寸：999*999px</p>
                </div>
                <div ng-if='contCtrl.items[0].imageSrc != "" ' class="mb-2">
                    <img ng-src="@{{contCtrl.items[0].imageSrc}}" alt="" class="imgPreview w-100" style="max-width:150px;">
                </div>

                <span class="spanTitle mb-2">標題：</span>
                <input class="form-control" type='text' 
                    ng-model='contCtrl.items[0].title.text' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                    ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>

                <span class="spanTitle mb-2">內容：</span>
                <div summernote ng-model="contCtrl.items[0].cont.text" config="noteOptions" int="0"></div>
            </div>
        </div>
        <span class="herinneren-use">請開啟google地圖，搜尋要嵌入的地址，點擊分享>嵌入地圖>複製HTML，然後貼入下方輸入區</span>
        --}}
    </div>
    <br><br>
@endsection

<!-- section('cms_layout_selector') -->
<!-- endsection -->

@section('cms_layout_create_btn')
@endsection

<!-- section('cms_layout_js') -->
<!-- endsection -->



