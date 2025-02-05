@extends('layouts.masterAdmin')

<!-- html title -->
@section('htmlTitle') {{$pageTitle}}  @endsection

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

	<div class="container-fluid">
		<div>
			<div class="form-group">
				<label for="formControlTextarea1">內容</label>
				<textarea summernote ng-model="contCtrl.model.consent" config="noteOptions" class="form-control" id="formControlTextarea1"></textarea>
			</div>
		</div>

		<div class="row">
			<div class="col-12">
				<button class="btn btn-success btn-block" ng-click="contCtrl.submitConsent()">確認送出</button>
			</div>
		</div>
	</div>
@endsection

<!-- 自定義 javascript -->
@section('javascript')
    <script type="text/javascript">
        var app = angular.module('app',['summernote']);
        app.controller('ContentController',['$http', '$scope',function($http, $scope){

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
        	self.model = {
        		miscId: '{{$miscId}}',
        	};
        	self.getMiscellaneous = function(){
				$http({
					method : "post",
					url : "/admin/api/miscellaneous",
					data: self.model,
				}).success(function(data){
					self.model.consent = data.consent;
					// console.log(self.model.recruitText);
				}).error(function(){
				})//error
			}//self.login
			self.getMiscellaneous();

			self.submitConsent = function(){
				$http({
					method : "put",
					url : "/admin/api/miscellaneous",
					data: self.model,
				}).success(function(data){
					if (data.status=='200'){
						$.toaster({ message : '資料已更新'})
						// window.location = "/admin/miscellaneous/{{$miscId}}";
					}else{
						$.toaster({ message : '資料庫無回應', priority : 'danger' });
					}
				}).error(function(){
				})//error
			}//self.login
        }])//app.controller()
    </script>
@endsection







