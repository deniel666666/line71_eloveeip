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
            <div class="col-12 text-danger mb-3">
                1.設定空值則使用全站設定<br>
                2.文章類(ex:關於我們分類介紹、最新消息詳細內容,跑馬燈詳細內容、課程介紹、場地介紹)的標題、關鍵字、說明文字請到個別文章進行設定
            </div>
            <div class="col-6 mb-4">
                <h3 class="d-inline-block">首頁：</h3>
                <div class="mb-2">
                    <span class="spanTitle mb-2">標題</span>
                    <input class="form-control" type='text' 
                        ng-model='contCtrl.items[0].template.home_title' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                </div>
                <div class="mb-2">
                    <span class="spanTitle mb-2">關鍵字(請以英文逗號分隔字組)</span>
                    <input class="form-control" type='text' 
                        ng-model='contCtrl.items[0].template.home_keyword' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                </div>
                <div class="mb-2">
                    <span class="spanTitle mb-2">說明文字</span>
                    <input class="form-control" type='text' 
                        ng-model='contCtrl.items[0].template.home_description' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                </div>
            </div>

            <div class="col-6 mb-4">
                <h3 class="d-inline-block">關於我們-聯絡我們：</h3>
                <div class="mb-2">
                    <span class="spanTitle mb-2">標題</span>
                    <input class="form-control" type='text' 
                        ng-model='contCtrl.items[0].template.about_contact_title' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                </div>
                <div class="mb-2">
                    <span class="spanTitle mb-2">關鍵字(請以英文逗號分隔字組)</span>
                    <input class="form-control" type='text' 
                        ng-model='contCtrl.items[0].template.about_contact_keyword' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                </div>
                <div class="mb-2">
                    <span class="spanTitle mb-2">說明文字</span>
                    <input class="form-control" type='text' 
                        ng-model='contCtrl.items[0].template.about_contact_description' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                </div>
            </div>

            <div class="col-6 mb-4">
                <h3 class="d-inline-block">最新消息列表：</h3>
                <div class="mb-2">
                    <span class="spanTitle mb-2">標題</span>
                    <input class="form-control" type='text' 
                        ng-model='contCtrl.items[0].template.news_title' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                </div>
                <div class="mb-2">
                    <span class="spanTitle mb-2">關鍵字(請以英文逗號分隔字組)</span>
                    <input class="form-control" type='text' 
                        ng-model='contCtrl.items[0].template.news_keyword' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                </div>
                <div class="mb-2">
                    <span class="spanTitle mb-2">說明文字</span>
                    <input class="form-control" type='text' 
                        ng-model='contCtrl.items[0].template.news_description' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                </div>
            </div>

            <div class="col-6 mb-4">
                <h3 class="d-inline-block">跑馬燈列表：</h3>
                <div class="mb-2">
                    <span class="spanTitle mb-2">標題</span>
                    <input class="form-control" type='text' 
                        ng-model='contCtrl.items[0].template.marquee_title' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                </div>
                <div class="mb-2">
                    <span class="spanTitle mb-2">關鍵字(請以英文逗號分隔字組)</span>
                    <input class="form-control" type='text' 
                        ng-model='contCtrl.items[0].template.marquee_keyword' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                </div>
                <div class="mb-2">
                    <span class="spanTitle mb-2">說明文字</span>
                    <input class="form-control" type='text' 
                        ng-model='contCtrl.items[0].template.marquee_description' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                </div>
            </div>

            <div class="col-6 mb-4">
                <h3 class="d-inline-block">報名位置：</h3>
                <div class="mb-2">
                    <span class="spanTitle mb-2">標題</span>
                    <input class="form-control" type='text' 
                        ng-model='contCtrl.items[0].template.apply_title' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                </div>
                <div class="mb-2">
                    <span class="spanTitle mb-2">關鍵字(請以英文逗號分隔字組)</span>
                    <input class="form-control" type='text' 
                        ng-model='contCtrl.items[0].template.apply_keyword' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                </div>
                <div class="mb-2">
                    <span class="spanTitle mb-2">說明文字</span>
                    <input class="form-control" type='text' 
                        ng-model='contCtrl.items[0].template.apply_description' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                </div>
            </div>

            <div class="col-6 mb-4">
                <h3 class="d-inline-block">體檢須知：</h3>
                <div class="mb-2">
                    <span class="spanTitle mb-2">標題</span>
                    <input class="form-control" type='text' 
                        ng-model='contCtrl.items[0].template.examination_title' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                </div>
                <div class="mb-2">
                    <span class="spanTitle mb-2">關鍵字(請以英文逗號分隔字組)</span>
                    <input class="form-control" type='text' 
                        ng-model='contCtrl.items[0].template.examination_keyword' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                </div>
                <div class="mb-2">
                    <span class="spanTitle mb-2">說明文字</span>
                    <input class="form-control" type='text' 
                        ng-model='contCtrl.items[0].template.examination_description' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                </div>
            </div>

            <div class="col-6 mb-4">
                <h3 class="d-inline-block">線上報名：</h3>
                <div class="mb-2">
                    <span class="spanTitle mb-2">標題</span>
                    <input class="form-control" type='text' 
                        ng-model='contCtrl.items[0].template.online_title' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                </div>
                <div class="mb-2">
                    <span class="spanTitle mb-2">關鍵字(請以英文逗號分隔字組)</span>
                    <input class="form-control" type='text' 
                        ng-model='contCtrl.items[0].template.online_keyword' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                </div>
                <div class="mb-2">
                    <span class="spanTitle mb-2">說明文字</span>
                    <input class="form-control" type='text' 
                        ng-model='contCtrl.items[0].template.online_description' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                </div>
            </div>

            <div class="col-6 mb-4">
                <h3 class="d-inline-block">相關連結：</h3>
                <div class="mb-2">
                    <span class="spanTitle mb-2">標題</span>
                    <input class="form-control" type='text' 
                        ng-model='contCtrl.items[0].template.link_title' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                </div>
                <div class="mb-2">
                    <span class="spanTitle mb-2">關鍵字(請以英文逗號分隔字組)</span>
                    <input class="form-control" type='text' 
                        ng-model='contCtrl.items[0].template.link_keyword' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
                </div>
                <div class="mb-2">
                    <span class="spanTitle mb-2">說明文字</span>
                    <input class="form-control" type='text' 
                        ng-model='contCtrl.items[0].template.link_description' ng-blur="contCtrl.modifyItem(contCtrl.items[0],2)" 
                        ng-focus="contCtrl.textRecording(contCtrl.items[0])"/>
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