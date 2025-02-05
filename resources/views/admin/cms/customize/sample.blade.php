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
        <div class="row">
            <h3 class="col-12">XXXXX</h3>
            
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
    </div>
    <span class="herinneren-use">請開啟google地圖，搜尋要嵌入的地址，點擊分享>嵌入地圖>複製HTML，然後貼入下方輸入區</span>
    <span class="herinneren-use">如需嵌入Youtube、Google地圖等，請點擊編輯器「原始碼」按鈕，並將複製的語法貼入黑白畫面中。</span>
    <span class="herinneren-use">站外連結請包含 http:// 或 https://，站內連結建議使用相對路徑</span>
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






