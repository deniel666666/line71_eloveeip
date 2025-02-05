@extends('layouts.masterAdmin')

<!-- html title -->
@section('htmlTitle') {{$pageTitle}}  @endsection

<!-- 自定義 content -->
@section('content')

<div class="container-fluid">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
		</ol>
    </nav>
    <div class="form-group">
        <div class="form-group">
            <div class="row">
                 <div class="col">商品主體<br>
                    語系:<span>@{{contCtrl.lang.lang_word}}</span><br>
                    產品名稱:<span>@{{contCtrl.item.prod_name}}</span><br>
                    產品主圖:<img width=200  ng-src="@{{contCtrl.item.prod_img}}" /><br>
                    開始時間:<span>@{{contCtrl.changeMainDateTime(contCtrl.item.prod_s_datetime)}}</span><br>
                    <div ng-if="contCtrl.endDateStatus ==0">結束時間:<span>@{{contCtrl.changeMainDateTime(contCtrl.item.prod_e_datetime)}}</span><br></div>
                    順序:<span>@{{contCtrl.item.prod_order}}</span><br>
                </div>		
                <div class="col">
                    類別
                        <div style="width: 400px;height: 160px;overflow: auto;" >
                            <label class="col" ng-repeat="r in contCtrl.categoryTags">
                              <span ng-if="r.status ==1">@{{r.cate_name}}</span>
                            </label>
                        </div>
                </div>		
            </div>
        </div>
        <div class="form-group">
            <div class="row" >
                <div class="col" >
                   <span> 商品簡述</span>
                   <div style="width: 400px;height: 160px;overflow: auto;" >
                        <table class="table">
                            <tr  ng-repeat="r in contCtrl.productDescribe">
                                <td ng-if="r.prod_describe_type == 'ProdKey'" >商品關鍵字</td>
                                <td ng-if="r.prod_describe_type == 'ProdKey'">@{{r.prod_describe}}</td>
                                <td ng-if="r.prod_describe_type == 'ProdNo'">商品編號</td>
                                <td ng-if="r.prod_describe_type == 'ProdNo'">@{{r.prod_describe}}</td>
                                <td ng-if="r.prod_describe_type == 'ProdSimpleIntro'">商品小介紹</td>
                                <td ng-if="r.prod_describe_type == 'ProdSimpleIntro'">@{{r.prod_describe}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col" >
                   <span> 商品屬性</span>
                   <div style="width: 400px;height: 160px;overflow: auto;" >
                        <table class="table" style="width: 260px;height: 160px;overflow: auto;">
                            <tr ng-repeat="t in contCtrl.propertyTag">
                                <td>@{{t.prop_tag_name}}</td>
                                <td>@{{t.prod_prop}}</td>
                            </tr>
                        </table>
                    </div>	
                </div>							
            </div>
        </div>
        <div class="form-group">
            <div class="row" >
                <div class="col" >
                   <span> 商品副圖</span>
                   <div style="width: 450px;;" >
                        <table class="table">
                            <tr >
                                <td ng-repeat="t in contCtrl.productImg"> <img width=40 ng-src="@{{t.prod_img_name}}" /></td>
                            </tr>
                        </table>
                    </div>	
                </div>
                <div class="col" >
                    <span>附加檔案</span>
                    <div style="width: 400px;height: 160px;overflow: auto;" >
                        <table class="table">
                            <tr ng-repeat="t in contCtrl.productFile">
                                <td> <a href="@{{t.prod_img_path}}" target="_blank">@{{t.prod_img_name}}</a></td>
                            </tr>
                        </table>
                    </div>
                </div>							
            </div>
        </div>
        <p>
        <p>
        商品包裝:
        <table class="table">
			<thead>
				<tr>
                    <th scope="col">包裝名稱</th>
                    <th scope="col">價格</th>
                    <th scope="col">售價</th>
                    <th scope="col">商品/套裝 編號</th>
                    <th scope="col">狀態</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="item in contCtrl.productType">
					<td>@{{item.prod_type}}</td>
					<td>@{{item.type_price}}</td>
					<td>@{{item.type_sales_price}}</td>
					<td>@{{item.prod_sn}}</td>
					<td>@{{contCtrl.productTypeStatus[item.type_status].name}}</td>
				</tr>
			</tbody>
        </table>
        <p>
        <p>
        商品規格:
        <table class="table">
			<thead>
				<tr>
                    <th scope="col">規格名稱</th>
                    <th scope="col">分組</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="item in contCtrl.productSpec">
					<td>@{{item.spec_name}}</td>
					<td>@{{item.spec_no}}</td>
				</tr>
			</tbody>
        </table>
        <p>
        <p>
    </div>
    內容:
  <table class="table" ng-repeat="item in contCtrl.contents">
            <tr ng-if='item.type == "img"' >
                <td>
                    <p><span ng-bind='item.name'></span>
                    <span ng-if="item.layout.show == true">顯示文字內容 </span>
                     <span ng-if="item.layout.space == true">顯示區塊下間距 </span>
                    </p> 
                    <p>(圖片預覽)            
                        <img width=220 ng-src="@{{item.imageSrc}}" />
                    </p> 
                    <p>介紹標題 
                        <input type='text' ng-model='item.title.text' /> 
                        <span ng-if="item.title.show == true">顯示內容 </span>
                         <span ng-if="item.title.space == true">顯示下間距 </span>
                    </p> 
                    <p>介紹內容 
                        <textarea style="margin: 0px; height: 253px; width: 420px;" ng-model="item.cont.text"></textarea>
                         <span ng-if="item.cont.show == true">顯示內容 </span>
                         <span ng-if="item.cont.space == true">顯示下間距 </span>
                    </p> 
                </td >  
            </tr>
            <tr ng-if='item.type == "text"' >
                <td>
                    <p><span ng-bind='item.name'></span>
                    <span ng-if="item.layout.space == true">顯示區塊下間距 </span>
                    </p>
                    <p>標題
                        <input type='text' ng-model='item.title.text' />
                        <span ng-if="item.title.show == true">顯示內容 </span>
                         <span ng-if="item.title.space == true">顯示下間距 </span>
                    </p>
                    <p>內容
                        <textarea style="margin: 0px; height: 253px; width: 420px;" ng-model="item.cont.text"></textarea>
                         <span ng-if="item.cont.show == true">顯示內容 </span>
                         <span ng-if="item.cont.space == true">顯示下間距 </span>
                    </p>
                </td >  
            </tr>
		</table>
</div>

@endsection

<!-- 自定義 javascript -->
@section('javascript')
    <link href="/css/datetimepicker/angular-datetime-picker.css" rel="stylesheet">
    <script src="/js/datetimepicker/moment.2.11.2.min.js" type="text/javascript"></script>
    <script src="/js/datetimepicker/angular-datetime-picker.js" type="text/javascript"></script>
    <script type="text/javascript">
      var app = angular.module('app', ['angular.circular.datetimepicker']);

      app.controller('ContentController',['$scope','$http',function($scope,$http){
           
        var self = this;


var currUrl = window.location.pathname ;
		var urlSplit= currUrl.split('/');
        self.productId  = urlSplit[3];

      
        
        //======= area start=======
        self.listUrl = '/admin/api/product/detail/edit';
        self.listConentUrl = '/admin/api/product/content/one';
        self.prodImgPath = '/upload/product/';
        self.productUrl = '/admin/product';

        self.productTypeStatus = [
                                  {name: '下架',value: 0},
                                  {name: '上架',value: 1}
                            ]
        self.selectProductTypeStatus = self.productTypeStatus[0];
        self.contents = [];

        self.endDateStatus = 0;



        self.transStatus = function(statusIndex){
            return self.status_text[statusIndex];
        }

        self.getItems = function(){
           let data = {'productId': self.productId};
            $http({
                method : "post",
                data : data,
                url : self.listUrl,
            }).success(function(data){
                console.log(data);
                self.categoryTags = data.categoryTags;
                self.lang = data.lang;
                self.item = data.item;
                self.item.prod_img = self.prodImgPath+self.productId+'/'+data.item.prod_img;
                self.productDescribe = data.productDescribe;
                self.propertyTag = data.propertyTag;
                self.productType = data.productType;
                self.productSpec= data.productSpec;
                self.productImg = data.productImg;
                angular.forEach(self.productImg, function(item){
                    item.prod_img_name = self.prodImgPath+item.prod_id+'/'+item.prod_img_name;
                });
                self.productFile = data.productFile;
                angular.forEach(self.productFile, function(item){
                    item.prod_img_path= self.prodImgPath+item.prod_id+'/'+item.prod_img_name;
                });
                 if(self.item.prod_e_datetime == '2222-01-01 00:00:00'){
                    self.endDateStatus = 1;
                    $("#tt").hide();
                }
        }).error(function(){
                alert('錯誤');
            })//error
        }	
        self.getItems();

        self.getContents = function(){
              let data = {'productId': self.productId};
              $http({
                  method : "post",
                  data : data,
                  url : self.listConentUrl,
              }).success(function(data){
                self.contents = data.contents;
              }).error(function(){
              })
          }
          self.getContents();
        //CRUD ====== end =======
        Date.prototype.Format = function (fmt) { 
            var o = {
                "M+": this.getMonth() + 1, //月份 
                "d+": this.getDate(), //日 
                "h+": this.getHours(), //小时 
                "m+": this.getMinutes(), //分 
                //"s+": this.getSeconds(), //秒 
                "s+": 00, //秒 
                "q+": Math.floor((this.getMonth() + 3) / 3), //季度 
                "S": this.getMilliseconds() //毫秒 
            };
            if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
            for (var k in o)
                if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
                return fmt;
            }
      }]);
    </script>
@endsection



