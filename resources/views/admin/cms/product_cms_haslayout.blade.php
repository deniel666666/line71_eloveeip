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
                <li class="breadcrumb-item active" aria-current="page">編輯詳細內容</li>
            </ol>
        </nav>
    </div>
@endsection

@section('cms_btn')
<div>
    <a href="{{$editPageUrl}}" class="btn btn-info w-100 mb-2">編輯主列表</a>

    <button type="button" class="btn btn-mr-spacing btn-danger w-100" onclick="location.href='{{$listPageUrl}}'">返回列表</button>
</div>
@endsection

<!-- 隱藏子母模板功能 -->
<!-- section('cms_layout_selector')
endsection

section('cms_layout_create_btn')
endsection

section('cms_layout_js')
endsection -->