@extends('layouts.masterAdmin')

<!-- html title -->
@section('htmlTitle') {{$pageTitle}}  @endsection

<!-- 自定義 content -->
@section('content')
	<div class="w-100">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">系統管理</li>
				{{-- <li class="breadcrumb-item"><a href="/admin/account_do_log">{{$pageTitle}}</a></li> --}}
				<li class="breadcrumb-item">{{$pageTitle}}</li>
				<li class="breadcrumb-item active" aria-current="page">列表</li>
			</ol>
		</nav>
	</div>
	<div class="container-fluid" style="padding: 0px;">
		<div>
			<table class="table">
				<thead>
					<tr>
						<th scope="col">帳號</th>
						<th scope="col">姓名</th>
						<th scope="col">IP</th>
						<th scope="col">請求網址</th>
						<th scope="col">請求方法</th>
						<th scope="col">操作說明</th>
						<th scope="col">操作時間</th>
					</tr>
				</thead>
				<tbody>
					@foreach($account_do_log as $log)
						<tr>
							<th>{{$log->acct}}</th>
							<th>{{$log->user_name}}</th>
							<th>{{$log->ip}}</th>
							<th>{{$log->request_url}}</th>
							<th>{{$log->method}}</th>
							<th>{{$log->description}}</th>
							<th>{{$log->datetime}}</th>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@endsection

<!-- 自定義 javascript -->
@section('javascript')
    <script type="text/javascript">
        var app = angular.module('app',[]);
        app.controller('ContentController',['$http',function($http){
        	var self = this;

        }])//app.controller()
    </script>
@endsection