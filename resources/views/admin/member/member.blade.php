@extends('layouts.masterAdmin')

<!-- html title -->
@section('htmlTitle') {{$pageTitle}}  @endsection

@section('css_header')
    <style type="text/css">
        @media (min-width: 576px){
            .modal-dialog{
                max-width: 80vw;
            }
        }
    </style>
@endsection

<!-- 自定義 content -->
@section('content')
    <div class="w-100">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page">{{$pageTitle}}</li>
                <li class="breadcrumb-item active">店家列表</li>
            </ol>
        </nav>
    </div>
    <div class="container-fluid" style="padding: 0px;">
        <div class="row bg-light no-gutters pageHeader">
            <div class="col-12">
                <div class="d-inline-block mb-2">
                    <span>
                        <select class="use-form-control pdSpacing" style="width: 100px;" ng-model='contCtrl.selectItem'> 
                            <option  value="">搜尋項目</option>
                            <option  value="user_name">姓名</option>
                            <option  value="acct">帳號</option>
                        </select>
                    </span>
                    <span><input class="use-form-control" style="width: 200px;" ng-model="contCtrl.keyword" type="text" name=""></span>
                </div>
                <div class="d-inline-block mb-2">
                    登入狀態：
                    <span>
                        <select  class="use-form-control" style="width: 100px;"  ng-model='contCtrl.seek.user_status'> 
                            <option  value="">全部</option>
                            <option  value="1">啟用</option>
                            <option  value="0">停用</option>
                            <option  value="2">黑名單</option>
                        </select>
                    </span>
                </div>
                <div class="d-inline-block mb-2">
                    顯示狀態：
                    <span>
                        <select class="use-form-control" style="width: 100px;"  ng-model='contCtrl.seek.show_status'> 
                            <option  value="">全部</option>
                            <option  value="1">顯示</option>
                            <option  value="0">隱藏</option>
                        </select>
                    </span>
                    <span><a href="" ng-click="contCtrl.search()">搜尋</a> | <a href="" ng-click="contCtrl.clrSearch()">清除搜尋</a> </span>
                </div>      
            </div>
            <div class="float-lg-left admin-receivingMailBox">
                <span class="ng-scope mailActive"> 
                    <a href="@{{contCtrl.editPage}}0">新增</a>
                </span>

                <span class="ng-scope mailActive bg-success"> 
                    <a href="#" ng-click="contCtrl.export()">匯出搜尋結果</a>
                    <form id="form_export" name="form_export" action="@{{contCtrl.exportPageUrl}}" method="post" class="d-none"></form>
                </span>
            </div>
        </div>
        <!-- ///////////////////////// -->

        <div>
            <table class="table table-bordered admin-table-rwd form">
                <thead>
                    <tr class="admin-tr-only-hide">
                        <th class="w-20px" scope="col"><input id="selectAll" type="checkbox" ng-model="contCtrl.selAll" ng-click="contCtrl.checkAll()" /></th>
                        <th class="w-100px" scope="col">登入狀態</th>
                        <th style="width:100px;" scope="col">信箱驗證</th>
                        <th scope="col">帳號</th>
                        <th scope="col">姓名</th>
                        <th scope="col">方案紀錄</th>
                        <th scope="col">統編</th>
                        <th scope="col">顯示狀態</th>
                        <th scope="col">手機</th>
                        <th scope="col">地址</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="item in contCtrl.model.member">
                        <td data-th="項目"><input type="checkbox" ng-model="item.selected"/></td>
                        <td data-th="登入狀態">@{{contCtrl.memberStatus[item.user_status]}}</td>    
                        <td data-th="信箱驗證">
                            @{{contCtrl.userActive[item.user_active]}}
                            <br>
                            <span ng-show="item.user_active==0"><a href=""  ng-click="contCtrl.reSentActiveCode(item)">[重新發送]</a></span>
                        </td>
                        <td data-th="帳號"><a class="editInfor" href="@{{contCtrl.editPage}}@{{item.id}}">@{{item.acct}}</a></td>
                        <td data-th="姓名"><a class="editInfor" href="@{{contCtrl.editPage}}@{{item.id}}">@{{item.user_name}}</a></td>
                        <td data-th="方案紀錄"><a href class="editInfor" data-toggle="modal" data-target="#itemData" ng-click='contCtrl.openModal(item)'>查看</a></td>
                        <td data-th="統編">@{{item.id_code}}</td>
                        <td data-th="顯示狀態">
                            <!--@{{contCtrl.showStatus[item.show_status].value}}-->
                            <select 
                                    ng-model='contCtrl.showStatus[item.show_status].key'
                                    ng-options='member.key as member.value for member in contCtrl.showStatus'
                                    ng-change="contCtrl.ShowSatausChange(item,'show_status')">
                            </select>
                        </td>
                        <td data-th="手機">@{{item.cellphone}}</td>
                        <td data-th="地址">@{{item.zipcode}}@{{item.city}}@{{item.district}}@{{item.road}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row mb-5 pageHeader">
            <div class="col-lg-6" >
                <div>
                    <!--span> <a href="" ng-click='contCtrl.remove()'>垃圾桶</a></span-->
                    <a class="disableBtn btn-use" href="javascript:void(0);" ng-click='contCtrl.remove(1,"user_status")'><span>啟用</span></a>
                    <a class="enablewBtn btn-use" href="javascript:void(0);" ng-click='contCtrl.remove(0,"user_status")'><span>停用</span></a>
                    <a class="deleteBtn btn-use" href="javascript:void(0);" ng-click='contCtrl.remove(2,"user_status")'><span>黑名單</span></a>
                </div>
            </div>
            <div class="col-lg-6">
                <p class="float-lg-right">
                    <span>頁數: @{{contCtrl.currentPage}}/@{{contCtrl.totalPage}} (共@{{contCtrl.totalItem}}項)</span>
                    <span><a href=""><span ng-click="contCtrl.prevPage(contCtrl.prevPageIndex)"> 上一頁</span></a> /
                    <a href=""><span ng-click="contCtrl.nextPage(contCtrl.nextPageIndex)">下一頁</span></a> </span>
                </p>
            </div>
        </div>

        <!--Modal -->
        <div id="itemData" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">方案紀錄</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 col-12">
                                <label>方案類別</label>
                                <select class="form-control" ng-model="contCtrl.add_type.type">
                                    <option value="A">A.資訊型店家</option>
                                    <option value="B">B.促銷型店家</option>
                                    <option value="C">C.VIP型店家</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-12">
                                <label>開始日期</label><span class="herinneren-use">當天0時0分</span>
                                <input class="form-control" type="date" ng-model="contCtrl.add_type.start_time">
                            </div>
                            <div class="col-md-4 col-12">
                                <label>結束日期</label><span class="herinneren-use">當天23時59分</span>
                                <input class="form-control" type="date" ng-model="contCtrl.add_type.end_time">
                            </div>
                            <div class="col-md-4 col-12">
                                <label>合約編號</label>
                                <input class="form-control" type="text" ng-model="contCtrl.add_type.contract_number">
                            </div>
                            <div class="col-md-8 col-12">
                                <label>備註</label>
                                <textarea class="form-control" ng-model="contCtrl.add_type.note"></textarea>
                            </div>
                        </div>
                        <button class="btn btn-success col-12 mt-3" ng-click="contCtrl.do_add_type()">新增方案</button>
                        <hr>

                        <table class="table table-bordered admin-table-rwd form">
                            <thead>
                                <tr class="admin-tr-only-hide">
                                    <th class="w-100px" scope="col">方案類別</th>
                                    <th class="w-100px" scope="col">開始日期<span class="herinneren-use">當天0時0分</span></th>
                                    <th class="w-100px" scope="col">結束日期<span class="herinneren-use">當天23時59分</span></th>
                                    <th class="w-50px" scope="col">合計天數</th>
                                    <th class="w-100px">合約編號</th>
                                    <th class="w-200px">備註</th>
                                    <th class="w-50px">編輯</th>
                                    <th class="w-50px">刪除</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="item in contCtrl.type_record">
                                    <td data-th="方案類別" ng-bind="item.type"></td>
                                    <td data-th="開始日期" ng-bind="item.start_time"></td>
                                    <td data-th="結束日期" ng-bind="item.end_time"></td>
                                    <td data-th="合計天數" ng-bind="item.days+'天'"></td>
                                    <td data-th="合約編號" ng-bind="item.contract_number"></td>
                                    <td data-th="備註" ng-bind-html="item.note"></td>
                                    <th class="w-50px"><a href ng-click="contCtrl.openEditType(item)" data-toggle="modal" data-target="#editData">編輯</a></th>
                                    <th class="w-50px"><a href ng-click="contCtrl.deleteType(item.id)">刪除</a></th>
                                </tr> 
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" ng-click='contCtrl.closeModal()'>關閉</button>
                    </div>
                </div>
            </div>
        </div>
        <!--Modal End-->

        <!--Modal -->
        <div id="editData" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">修改方案</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 col-12">
                                <label>方案類別</label>
                                <select class="form-control" ng-model="contCtrl.edit_type.type">
                                    <option value="A">A.資訊型店家</option>
                                    <option value="B">B.促銷型店家</option>
                                    <option value="C">C.VIP型店家</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-12">
                                <label>開始日期</label><span class="herinneren-use">當天0時0分</span>
                                <input class="form-control" type="date" ng-model="contCtrl.edit_type.start_time" value="@{{contCtrl.edit_type.start_time}}">
                            </div>
                            <div class="col-md-4 col-12">
                                <label>結束日期</label><span class="herinneren-use">當天23時59分</span>
                                <input class="form-control" type="date" ng-model="contCtrl.edit_type.end_time" value="@{{contCtrl.edit_type.end_time}}">
                            </div>
                            <div class="col-md-4 col-12">
                                <label>合約編號</label>
                                <input class="form-control" type="text" ng-model="contCtrl.edit_type.contract_number">
                            </div>
                            <div class="col-md-8 col-12">
                                <label>備註</label>
                                <textarea class="form-control" ng-model="contCtrl.edit_type.note"></textarea>
                            </div>
                        </div>
                        <button class="btn btn-success col-12 mt-3" ng-click="contCtrl.do_edit_type()">確認修改</button>
                    </div>
                    <div class="modal-footer">
                        <button id="closeEditBtn" type="button" class="btn btn-default" data-dismiss="modal" ng-click='contCtrl.closeEditType()'>關閉</button>
                    </div>
                </div>
            </div>
        </div>
        <!--Modal End-->
    </div>
@endsection

<!-- 自定義 javascript -->
@section('javascript')
    <script src="/js/vendor/angular/angular-1.4.4/angular-sanitize.js" type="text/javascript"></script>
    <script type="text/javascript">
        var app = angular.module('app',['ngSanitize']);
        app.controller('ContentController',['$http',function($http){
            var self = this;
            self.currentPage = 1;
            self.countOfPage = 20;
            self.memberStatus = ['停用','啟用','黑名單'];
            self.userActive   = ['未驗證','已驗證'];
            self.showStatus   = [
                {key:'0',value:'隱藏'},
                {key:'1',value:'顯示'}
            ];

            self.seek = {};

            self.selectItem = '';
            self.keyword = '';

            self.model = {}
            /////////////////////////////////////////////////////////////////////////////////////////////
            /////////////////////////////////////////////////////////////////////////////////////////////
            self.editPage           = "/admin/member/";
            self.getPageUrl         = "/admin/api/member/page/get";
            self.exportPageUrl      = "/admin/api/member/page/export";
            self.sendActiveCodeUrl  = "/admin/api/member/sendActiveCode";
            self.updateStatusUrl    = "/admin/api/member/updateUserStatus";

            self.export = function(){
                $('#form_export').html("");

                var input = document.createElement("input");
                input.name = 'file_name';
                input.value = '會員資料';
                form_export.appendChild(input);

                var input = document.createElement("input");
                input.name = self.selectItem;
                input.value = self.keyword;
                form_export.appendChild(input);

                keys = Object.keys(self.seek);
                for (var i = 0; i < keys.length; i++) {
                    var input = document.createElement("input");
                    input.name = keys[i];
                    input.value = self.seek[ keys[i] ];
                    form_export.appendChild(input);
                }
                form_export.submit();
            }

            self.getPage = function(){
                post_data = {
                    currentPage     : self.currentPage,
                    countOfPage     : self.countOfPage,
                } 
                post_data[self.selectItem] = self.keyword;
                keys = Object.keys(self.seek);
                for (var i = 0; i < keys.length; i++) {
                    post_data[keys[i]] = self.seek[ keys[i] ];
                }
                // console.log(post_data);

                $http({
                    method  : "post",
                    url     : self.getPageUrl,
                    data    : post_data
                }).success(function(data){
                    // console.log(data);
                    self.model.member = data.res;
                    // console.log(data.res);
                    for(var prop in self.model.member){
                        self.model.member[prop]['selected'] = false;
                    }//for

                    self.totalItem      = data.totalItem;
                    self.totalPage      = data.totalPage;
                    self.totalPage      = data.totalPage;

                    self.pageNavIndex = proj.getNavPageIndex(self.currentPage,self.totalPage);

                    $('#selectAll').prop('checked', false);
                }).error(function(){
                })//error
            }//self.getPageOrder
            self.getPage();

            self.prevPage = function(){
                self.currentPage = self.pageNavIndex.prevIndex;
                self.getPage()
            }
            self.nextPage = function(){
                self.currentPage = self.pageNavIndex.nextIndex;
                self.getPage()
            }

            self.checkAll = function(){
                for(var prop in self.model.member){
                    self.model.member[prop]['selected'] = self.selAll;
                }
            }//self.checkAll

            self.clrSearch = function(){
                self.seek = {};
                self.selectItem = '';
                self.keyword = '';
                self.currentPage = 1;
                self.getPage();
            }

            self.ShowSatausChange = function(item,status_column){
                change_status = item.show_status== 1 ? 0 : 1

                $http({
                    method : "post",
                    url : self.updateStatusUrl,  //
                    data    : { 
                                member_array    : [item.id],
                                status_column   : status_column,
                                status_value    : change_status
                              }
                }).success(function(data){
                    if (data.status == '200'){
                        $.toaster({ message : '已更新'});
                        setTimeout(function(){
                            window.location.reload();
                        },1000)
                    }else{
                        $.toaster({ message : '網路錯誤', priority : 'danger'});
                    }
                }).error(function(){
                })//error
            }

            self.search = function(){
                self.currentPage = 1;
                self.getPage();
            }

            self.remove = function(x,status){
                var member_array=[];
                for(var prop in self.model.member){
                        if(self.model.member[prop]['selected'] == true ){
                            member_array.push(self.model.member[prop].id);
                        }
                }

                $http({
                    method : "post",
                    url : self.updateStatusUrl,  //
                    data    : { 
                                member_array    : member_array,
                                status_column   : status,
                                status_value : x
                              }
                }).success(function(data){
                    if (data.status == '200'){
                        $.toaster({ message : '已更新'});
                        self.getPage();
                    }else{
                        $.toaster({ message : '網路錯誤', priority : 'danger'});
                    }
                }).error(function(){
                })//error

                console.log(status);
            }

            /*---------------------------------------------------------------*/
            /*店家管理特有功能-----------------*/
            self.MemberTypeUrl = "/admin/api/member/Types";

            self.reSentActiveCode = function(item){
                $http({
                    method : "post",
                    url : self.sendActiveCodeUrl,
                    data: {id:item.id},
                }).success(function(data){
                    if (data.status == '200'){
                        $.toaster({ message : '驗證信箱已發出'});
                    }else{
                        $.toaster({ message : '網路錯誤', priority : 'danger'});
                    }
                }).error(function(){
                })//error
            }

            self.add_type = {};
            self.edit_type = {};
            self.type_record = [];
            self.clearAddType = function(model){
                self[model]['type']             = "A";
                self[model]['start_time']       = "";
                self[model]['end_time']         = "";
                self[model]['contract_number']  = "";
                self[model]['note']             = "";
            }

            self.getMemberTypes = function(member_id){
                $http({
                    method : "get",
                    url : self.MemberTypeUrl +'/'+ member_id,
                }).success(function(data){
                    self.type_record = data;
                }).error(function(){
                    $.toaster({ message : '網路錯誤', priority : 'danger'});
                })//error
            }

            self.openModal = function(item){
                copy_item = Object.assign({}, item);
                self.add_type.user_id = copy_item.id;
                self.getMemberTypes(self.add_type.user_id);
            }
            self.do_add_type = function(){
                if(self.add_type.start_time==''){ $.toaster({ message : '請選擇開始日期', priority : 'warning'}); return;}
                if(self.add_type.end_time==''){ $.toaster({ message : '請選擇結束日期', priority : 'warning'}); return;}
                if(self.add_type.start_time > self.add_type.end_time){ $.toaster({ message : '開始日期不可在結束日期之後', priority : 'warning'}); return;}

                $http({
                    method : "post",
                    url : self.MemberTypeUrl,
                    data: self.add_type,
                }).success(function(data){
                    $.toaster({ message : '新增成功'});
                    self.getMemberTypes(self.add_type.user_id);
                    self.clearAddType('add_type');

                }).error(function(){
                    $.toaster({ message : '網路錯誤', priority : 'danger'});
                })//error
            }
            self.closeModal = function(item){
                self.clearAddType('add_type');
            }

            self.openEditType = function(item){
                var edit_type = Object.assign({}, item);
                edit_type.start_time = new Date(edit_type.start_time);
                edit_type.end_time = new Date(edit_type.end_time);
                self.edit_type = edit_type
            }
            self.do_edit_type = function(){
                $http({
                    method : "put",
                    url : self.MemberTypeUrl,
                    data: self.edit_type,
                }).success(function(data){
                    $.toaster({ message : '修改成功'});
                    self.getMemberTypes(self.add_type.user_id);
                    $('#editData').modal('toggle');
                    self.clearAddType('edit_type');
                }).error(function(){
                    $.toaster({ message : '網路錯誤', priority : 'danger'});
                })//error
            }
            self.closeEditType = function(){
                self.clearAddType('edit_type');
            }

            self.deleteType = function(item_id){
                if(!confirm("確定要刪除嗎?")) return;

                $http({
                    method : "post",
                    url : self.MemberTypeUrl +'/delete',
                    data :{
                        id : item_id
                    }
                }).success(function(data){
                    $.toaster({ message : '刪除成功'});
                    self.getMemberTypes(self.add_type.user_id);

                }).error(function(){
                    $.toaster({ message : '網路錯誤', priority : 'danger'});
                })//error
            }

        }])//app.controller()
    </script>
@endsection