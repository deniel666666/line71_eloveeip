@extends($extends_layouts)

<!-- html title -->
@section('htmlTitle') {{$pageTitle}}  @endsection

<!-- 自定義 content -->
@section('content')
	<div class="w-100 mb-4">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">{{$topTitle}}</li>
				<li class="breadcrumb-item ng-binding" aria-current="page">{{$pageTitle}}</li>
				<li class="breadcrumb-item active ng-binding" aria-current="page" ng-if="contCtrl.galleryId==0">新增</li>
				<li class="breadcrumb-item active ng-binding" aria-current="page" ng-if="contCtrl.galleryId!=0">修改</li>
			</ol>
	    </nav>
	</div>
	<div class="container-fluid">
		<div ng-if="contCtrl.galleryId!=0">
			<button class="btn btn-danger" ng-click="contCtrl.delSlider(contCtrl.galleryId)">刪除</button>
		</div>
		<br>
		<div class="row">
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-6">
						<div class="main-img-box admin mb-2">
							<div class="box">
								<div ng-if="contCtrl.model.slider" class="adminImg-responsive-1By1" ng-style="{'background-image': 'url('+contCtrl.model.slider+')'}"></div>
							</div>
						</div>
						<div><span>主圖(必須上傳)：</span></div>
						<div class="custom-file">
							<input class="inputFile w-100" type="file" mo-block="0" ng-file-select="onFileSelect($files)" ng-model="contCtrl.model.slider" class="custom-file-input form-control-use line-style" id="slider">
							<label class="custom-file-label" for="slider">選擇檔案</label>
						</div>
						<span class="herinneren-use">建議尺寸：600x300px</span>
					</div>
					<div class="col-md-6">
						<div class="main-img-box admin mb-2">
							<div class="box">
								<div ng-if="contCtrl.model.slider_m" class="adminImg-responsive-1By1" ng-style="{'background-image': 'url('+contCtrl.model.slider_m+')'}"></div>
							</div>
						</div>
						<div><span>副圖：</span></div>
						<div class="custom-file">
							<input class="inputFile w-100" type="file" mo-block="0" ng-file-select="onFileSelect($files)" ng-model="contCtrl.model.slider_m" class="custom-file-input form-control-use line-style" id="slider_m">
							<label class="custom-file-label" for="slider_m">選擇檔案</label>
						</div>
						<span class="herinneren-use">建議尺寸：600x300px</span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<p>
					<span>排序：</span>
					<input type="text" class="form-control" name="" ng-model="contCtrl.model.slider_order">(越小越前面)
				</p>
				<p>
					<span>語系：</span>
					<span ng-if="contCtrl.galleryId!=0" ng-bind="contCtrl.model.lang_word"></span>
					<select ng-if="contCtrl.galleryId==0" ng-model='contCtrl.model.lang_id' ng-options="option.lang_id as option.lang_word for option in contCtrl.langs"></select>
				</p>
				<p>
					<span>狀態：</span>
					<select ng-model="contCtrl.model.img_status" class="form-control">
						<option value="1">啟用</option>
						<option value="0">停用</option>
					</select> 	
				</p>
			</div>
		</div>
		<div class="row">
			<div class="col-12 mb-3">
				<span>標題：</span>
				<input type="text" ng-model="contCtrl.model.alt" name="" class="form-control input-sm">
			</div>
			<div class="col-12 mb-3">
				<span>副標題：</span>
				<input type="text" ng-model="contCtrl.model.gallery_cont.sub_title" name="" class="form-control input-sm">
			</div>
			<div class="col-12 mb-3">
				<span>URL：</span><span class="herinneren-use">站外連結請包含 http:// 或 https://，站內連結建議使用相對路徑</span>
				<input type="text" ng-model="contCtrl.model.gallery_cont.link" name="" class="form-control input-sm">
			</div>
			<div class="col-12 mb-3">
				<span>文字編輯：</span>
				<div class="note">
					<div summernote ng-model="contCtrl.model.gallery_cont.note" config="noteOptions"></div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<button ng-if="contCtrl.galleryId==0" class="btn btn-success btn-block" ng-click="contCtrl.createSlider()">確認送出</button>
				<button ng-if="contCtrl.galleryId!=0" class="btn btn-success btn-block" ng-click="contCtrl.uploadSlider()">確認送出</button>
			</div>
		</div>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
	</div>
@endsection

<!-- 自定義 javascript -->
@section('javascript')
	<script type="text/javascript">
		var app = angular.module('app',['summernote']);
		app.controller('ContentController',['$http','$scope',function($http,$scope){
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

	            height: 500,
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
	            maximumImageFileSize: 1920 * 1920,
	            callbacks: { 
	                onImageUploadError: function(msg) { alert(msg + ' (圖片尺寸超過1920px*1920px-3.52 MB)'); },
	                onPaste: function (e) {
	                    var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
	                    e.preventDefault();
	                    document.execCommand('insertText', false, bufferText);
	                }
	            },
	        };

			var self = this;
			self.model = {};

			self.galleryTypeId 	= '{{$galleryTypeId}}';
			self.galleryId 		= '{{$galleryId}}';
			self.model.lang_id = 0;

			self.getLangUrl			= "/api/lang";
			self.getGalleryUrl 		= "/{{$use_end}}/api/{{$content_table}}/" + self.galleryId;
			self.createSliderUrl	= "/{{$use_end}}/api/{{$content_table}}/" + self.galleryTypeId;
			self.updateGalleryUrl 	= "/{{$use_end}}/api/{{$content_table}}/update/" + self.galleryId;
			self.delSliderUrl 		= "/{{$use_end}}/api/{{$content_table}}/" + self.galleryTypeId + "/" + self.galleryId;
			self.listPage			= "/{{$use_end}}/{{$content_table}}/" + self.galleryTypeId;

			self.getLang = function(){
				$http({
					method : "get",
					url : self.getLangUrl,
				}).success(function(data){
					if (data.status=='200'){
						self.langs=  data.langs;
						self.model.lang_id = data.langs[0]['lang_id'];
					}else{
						alert('資料庫無回應');
					}
				}).error(function(){
					alert('網路錯誤');
				})//error
			}
			self.getLang();

			self.getGallery = function(){
				$http({
					method : "get",
					url : self.getGalleryUrl,
					//data: orderPost,
				}).success(function(data){
					// console.log(data);
					self.langs = data.langs;
					self.model = data.gallery
					console.log(self.model)
					self.model.img_status	= data.gallery.img_status.toString();
					self.model.slider 		= "/"+data.gallery.url;
					self.model.slider_m		= "/"+data.gallery.url_m;
					self.model.lang_word	= data.gallery.lang.lang_word;
				}).error(function(){
				})//error
			}//self.login
			if(self.galleryId!=0){// 編輯
				self.getGallery();

			}else{// 新增
				self.model.img_status	= '1';
				self.model.slider_order = 0;
				self.model.alt   		= '';
				self.model.gallery_cont = {};
			}

			self.createSlider = function(){
				$http({
					method: "post",
					url: self.createSliderUrl,
					data: self.model
				}).success(function(data) {
						if(data['status']==200){
							window.location = self.listPage;
						} else {
							alert('資料庫無回應');
						}
				}).error(function() {
					$.toaster({ message : '發生錯誤', priority : 'danger' });
				}) //error
			}//self.createSlider 

			self.uploadSlider = function(){
				$http({
					method: "post",
					url: self.updateGalleryUrl,
					data: self.model
				}).success(function(data) {
					if(data['status']==200){
						window.location = self.listPage;
					} else {
						// alert('資料庫無回應');
					}
				}).error(function() {
					$.toaster({ message : '發生錯誤', priority : 'danger' });
				}) //error
			}//self.uploadSlider 

			self.delSlider = function(galleryId){
				if (!confirm("確定刪除？")) {
	                return;
	            }

				var delInfo = {'galleryId':self.galleryId}
				$http({
					method : "delete",
					url : self.delSliderUrl,
					data: delInfo,
				}).success(function(data){
					if(data['status']==200){
						window.location = self.listPage;
					} else {
						// alert('資料庫無回應');
					}
				}).error(function(){
					// alert('網路錯誤');
				})//error
			}

			self.updateSlider =function(){
				console.log(self.model.slider)
			}
	    }])//app.controller()
		.directive("ngFileSelect", function(fileReader, $timeout) {
	        return {
	            scope: {
	                ngModel: '='
	            },
	            link: function($scope, el) {
	                function getFile(file) {
	                    fileReader.readAsDataUrl(file, $scope)
	                    .then(function(result) {
	                        $timeout(function() {
	                            $scope.ngModel = result;
	                        });
	                    });
	                }
	                el.bind("change", function(e) {
	                    var file = (e.srcElement || e.target).files[0];
	                    getFile(file);
	                });
	            }
	        };
	    })
	    .factory("fileReader", function($q, $log) {
	        var onLoad = function(reader, deferred, scope) {
	            return function() {
	                scope.$apply(function() {
	                    deferred.resolve(reader.result);
	                });
	            };
	        };
	        var onError = function(reader, deferred, scope) {
	            return function() {
	                scope.$apply(function() {
	                    deferred.reject(reader.result);
	                });
	            };
	        };
	        var onProgress = function(reader, scope) {
	            return function(event) {
	                scope.$broadcast("fileProgress", {
	                    total: event.total,
	                    loaded: event.loaded
	                });
	            };
	        };
	        var getReader = function(deferred, scope) {
	            var reader = new FileReader();
	            reader.onload = onLoad(reader, deferred, scope);
	            reader.onerror = onError(reader, deferred, scope);
	            reader.onprogress = onProgress(reader, scope);
	            return reader;
	        };
	        var readAsDataURL = function(file, scope) {
	            var deferred = $q.defer();
	            var reader = getReader(deferred, scope);
	            reader.readAsDataURL(file);
	            return deferred.promise;
	        };
	        return {
	            readAsDataUrl: readAsDataURL
	        };
	    });
	</script>
@endsection







