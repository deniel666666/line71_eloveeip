@extends($extends_layouts)

<!-- html title -->
@section('htmlTitle') {{$topTitle}}  @endsection

<!-- 自定義 content -->
@section('content')
	<link rel="stylesheet" href="{{asset('/css/jqueryui/jquery-ui.min.css')}}">
	<script src="{{asset('/js/vendor/jqueryui/jquery-ui.min.js')}}"></script>

	<div class="w-100 mb-4">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">{{$topTitle}}</li>
				<!-- <li class="breadcrumb-item"><a href="@{{contCtrl.listPage}}"><span ng-bind="contCtrl.pageTitle"></span></a></li> -->
				<li class="breadcrumb-item active" aria-current="page">內容</li>
			</ol>
		</nav>
	</div>

	<div class="container-fluid">
		<div>
			<button class="btn btn-danger"  ng-if='contCtrl.model.contact_status == 3'  ng-click="contCtrl.delcontact(true)">刪除</button>
			<button class="btn btn-danger"  ng-if='contCtrl.model.contact_status != 3'  ng-click="contCtrl.delcontact(false)">垃圾桶</button>
		</div>
		<div>
			<div class=""><span>&nbsp;</span></div>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-md-6 mb-2">
					報名日期：<input type="text" ng-model="contCtrl.model.conta_datetime" readonly class="form-control input-sm">
					<!-- 日期：<input type="text"   datepicker ng-model="contCtrl.model.conta_datetime" readonly class="form-control input-sm"> -->
				</div>
				<div class="col-md-6 mb-2">
					狀態：@{{contCtrl.transStatus(contCtrl.model.contact_status)}}
				</div>

				<div class="col-md-3 col-12 mb-2">
					班別：<input type="text" ng-model="contCtrl.model.online_class" readonly class="form-control input-sm">
				</div>
				<div class="col-md-3 col-12 mb-2">
					梯別：<input type="text" ng-model="contCtrl.model.online_type" readonly class="form-control input-sm">
				</div>
				<div class="col-md-6 col-12 mb-2">
					<!-- 姓名：<input type="text" ng-model="contCtrl.model.conta_name" readonly class="form-control input-sm"> -->
				</div>
				<div class="col-md-12 col-12 mb-2">
					簡易問答：
					<!-- <textarea ng-model="contCtrl.model.qa" readonly class="form-control" rows="3"></textarea> -->
					<div ng-bind-html="contCtrl.model.qa" class="border"></div>
				</div>

				
				<!-- <div class="col-md-6 col-12 mb-2">
					信箱：<input type="text" ng-model="contCtrl.model.conta_email" readonly class="form-control input-sm">
				</div>
				<div class="col-md-6 col-12 mb-2">
					聯絡電話：<input type="text" ng-model="contCtrl.model.conta_phone" readonly class="form-control input-sm">
				</div> -->

				<!-- <div class="col-12 mb-2">
					通訊地址：
					<div class="row m-0">
						<div class="col-md-6 col-12 d-flex pl-0">
							<input type="text" ng-model="contCtrl.model.county" readonly class="form-control input-sm">
							<input type="text" ng-model="contCtrl.model.district" readonly class="form-control input-sm">
							<input type="text" ng-model="contCtrl.model.zipcode" readonly class="form-control input-sm">
						</div>
						<input class="col-md-6 col-12 form-control input-sm" type="text" ng-model="contCtrl.model.address" readonly>
					</div>
				</div> -->

				<!-- <div class="col-md-3 col-12 mb-2">
					性別：<input type="text" ng-model="contCtrl.model.gender" readonly class="form-control input-sm">
				</div> -->
				<!-- <div class="col-md-6 col-12 mb-2">
					西元出生年：<input type="text" ng-model="contCtrl.model.id_no" readonly class="form-control input-sm">
				</div> -->
				<!-- <div class="col-md-6 col-12 mb-2">
					出生日：<input type="text" ng-model="contCtrl.model.birthday" readonly class="form-control input-sm">
				</div> -->

				<!-- <div class="col-md-12 col-12 mb-2">
					戶籍：<input type="text" ng-model="contCtrl.model.domicile" readonly class="form-control input-sm">
				</div> -->

				<!-- <div class="col-md-6 mb-2">
					語系：@{{contCtrl.model.lang.lang_word}}
				</div> -->
				<!-- <div class="col-12 mb-2">
					<span>留言內容：</span>
					<textarea class="form-control" style="height:250px; " ng-model="contCtrl.model.conta_cont" readonly></textarea>
				</div> -->
				<div class="col-12 mb-2">
					<span>處理狀態紀錄：</span>
					<textarea summernote config="noteOptions" class="form-control" ng-model="contCtrl.model.conta_resp"></textarea>
				</div>
			</div>
	    </div>
		<div class="row mb-5">
			<div class="col-12">
				<button ng-if="contCtrl.model.contact_status < 2" class="btn btn-success btn-block" ng-click="contCtrl.submitAccount()">確認儲存</button>
			</div>
		</div>
	</div>
@endsection

<!-- 自定義 javascript -->
@section('javascript')
    <script type="text/javascript">
    </script>
    <script src="/js/vendor/angular/angular-1.4.4/angular-sanitize.js" type="text/javascript"></script>
    <script type="text/javascript">
	    var app = angular.module('app',['summernote', 'ngSanitize']);
	    app.controller('ContentController', function($scope, $http){
    		
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

                height: 300,
                minHeight: 250,
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
                onFocus: true,
                onBlur: true,
                onChange:true,
                maximumImageFileSize: 1920 * 1920,
                callbacks: { 
                    onImageUploadError: function(msg) { alert(msg + ' (圖片尺寸超過1920px*1920px-3.52 MB)'); },
                    onPaste: function (e) {
                        var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                        e.preventDefault();
                        document.execCommand('insertText', false, bufferText);
                    },
                },
            };

			var self = this;
			self.status_text = ['新郵件','打開','已處理','垃圾桶'];
			var currUrl = window.location.pathname ;
			var urlSplit= currUrl.split('/');
			self.contactTypeId 	= urlSplit[4];
			self.contactId 		= urlSplit[5];

			self.listPage		= "/{{$use_end}}/{{$content_table}}/" + self.contactTypeId;
			self.getContactUrl	= "/{{$use_end}}/api/{{$content_table}}/edit/" + self.contactId;
			self.updContactUrl	= "/{{$use_end}}/api/{{$content_table}}/" + self.contactId;
			self.rmvContactUrl	= "/{{$use_end}}/api/{{$content_table}}/remove";
			self.delContactUrl	= "/{{$use_end}}/api/{{$content_table}}/delete";

			self.formatDate = function(date) {
					let getDate = new Date(date);
					return getDate.getFullYear()+'-'+('0' + (getDate.getMonth() + 1)).slice(-2)+'-'+('0' + getDate.getDate()).slice(-2);
			};

			self.transStatus = function(statusIndex){
				return self.status_text[statusIndex];
			}

			self.getContact = function(){
				$http({
					method : "get",
					url : self.getContactUrl,
				}).success(function(data){
					console.log(data);
					if (data.status=='200'){
						self.model = data.contact;
						// self.model.qa = self.model.qa.replaceAll("\n", "<br>");
						self.model.conta_datetime = self.formatDate (self.model.conta_datetime) ;
						self.pageTitle = data.pageTitle;
					}else{
						$.toaster({ message : '資料庫無回應', priority:'warning'});
					}
				}).error(function(){
					$.toaster({ message : '網路錯誤', priority:'warning'});
				})//error
			}
			self.getContact();

			self.updContact = function(){
				//console.log(self.model);
				$http({
					method : "put",
					url : self.updContactUrl,
					data: self.model,
				}).success(function(data){
					if (data.status=='200'){
						$.toaster({ message : '儲存成功'});
						setTimeout(function(){
							window.location = self.listPage;
						},1000);
					}else{
						$.toaster({ message : '資料庫無回應', priority:'warning'});
					}
				}).error(function(){
					$.toaster({ message : '網路錯誤', priority:'warning'});
				})//error
			}

			self.delcontact = function(type){
				let url = self.rmvContactUrl;
				let text = "確定丟進垃圾桶？";
				if(type){
					text = "確定刪除？";
					url = self.delContactUrl;
				}
				if (confirm(text)) {
					var ids = [];
					ids.push(self.contactId);
					let data = {'ids': ids};
					$http({
						method : "put",
						url : url,
						data: data
					}).success(function(data){
						if (data.status=='200'){
							window.location = self.listPage;
						}else{
							$.toaster({ message : '資料庫無回應', priority:'warning'});
						}
					}).error(function(){
						$.toaster({ message : '網路錯誤', priority:'warning'});
					})//error
				}
			}

			self.submitAccount = function(){
				self.updContact();
			}
		})
		.directive("datepicker", function () {
			function link(scope, element, attrs, controller) {
				// CALLING THE "datepicker()" METHOD USING THE "element" OBJECT
				element.datepicker({
					onSelect: function (val) {
						scope.$apply(function () {
							// UPDATING THE VIEW VALUE WITH THE SELECTED DATE
							controller.$setViewValue(val);   
						});
					},
					changeYear: true,
					changeMonth: true,
					dateFormat: "yy-mm-dd"
				});
			}
			return {
				require: 'ngModel',
				link: link
			};
		});
    </script>

@endsection