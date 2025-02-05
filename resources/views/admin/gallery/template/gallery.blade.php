@extends($extends_layouts)

<!-- html title -->
@section('htmlTitle') {{$pageTitle}}  @endsection

@section('external_plugin')
	<!-- upload-more-image -->
    <link href="/ng-template/upload-more-image/upload-more-image.css" rel="stylesheet" type="text/css">
@endsection

<!-- 自定義 content -->
@section('content')
	<div class="w-100">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">{{$topTitle}}</li>
				<li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
			</ol>
		</nav>
		<div class="row bg-light no-gutters pageHeader">
	        <div class="col-lg-8 clearfix order-1 mb-2">
	            <div class="float-left">
	                <select class="use-form-control pdSpacing w-80px " ng-model='contCtrl.prodStateSel' ng-options="option.value as option.name for option in contCtrl.prodOption">
	                    <option ng-selected="true" value="">全部</option>
	                </select>

	                <input class="use-form-control w-180px" type='text' ng-model='contCtrl.searchText' placeholder="請填入搜尋主列表名稱" />

	                <span> <a href="" ng-click='contCtrl.getItems()'>搜尋</a></span>
	                <span> |</span>
	                <span> <a href="" ng-click='contCtrl.clearSearch()'>清除搜尋</a></span>
	            </div>
	        </div>
	        <div class="col-lg-4  clearfix order-lg-2 order-4 mb-2">
	            <div class="float-lg-right">
	                <span> 共<span ng-bind="contCtrl.itemCount"></span>項</span>
	                <span>
	                    <input class="use-form-control pdSpacing" style='width:50px;' type='text' ng-model="contCtrl.currentPage" ng-keydown="$event.keyCode === 13 && contCtrl.goto()" ng-blur="contCtrl.goto()" ng-focus="contCtrl.textRecording(contCtrl.currentPage)">/@{{contCtrl.pageCount}}
	                </span>
	                <span> <a href="" ng-click='contCtrl.prePage()'>上一頁</a></span>
	                <span> <a href="" ng-click='contCtrl.nextPage()'>下一頁</a></span>
	            </div>
	        </div>
	        <div class="col-12 clearfix order-2 use-flexbox-align mb-2">
				<div class="float-right mr-5px">
					<select id="lang_select" class="use-form-control maxWidth  w-80px" ng-model='contCtrl.selectLangItem' ng-change="contCtrl.changedListLang()" ng-options="option.lang_id as option.lang_word for option in contCtrl.langs">
						<option ng-selected="true" value="">全部</option>
					</select>
				</div>
	            <div class="admin-receivingMailBox">
					<a href="@{{contCtrl.addPage}}" class="addNewBtn btn-use">
						<span>新增</span>
					</a>
	            </div>
	        
	            <div class="uploadMoreImgs w-50 ml-4">
	                <div more-img-upload="" method="POST" class="ng-isolate-scope"
	                     ng-create-url="contCtrl.createSliderUrl" 
	                     ng-gallery-type-id="contCtrl.galleryId"
	                     ng-lang="contCtrl.selectLangItem">
	                	<input class="fileUpload" type="file" multiple="">
	                	<div class="dropzone"><p class="msg">點擊或拖放文件即可上傳</p></div>
	                </div>
	            </div>
	            <span class="herinneren-use">建議尺寸：600x300px</span>
	        </div>
		</div>
		<div>
		    <table class="table table-bordered admin-table-rwd">
				<thead>
			        <tr class="admin-tr-only-hide">
	                    <th class="w-20px" scope="col"><input type="checkbox" ng-model="contCtrl.selectedAll" ng-click="contCtrl.checkAll()" /></th>
						<th class="w-50px">編碼</th>
						<th class="w-100px">狀態</th>
						<th class="w-100px">主圖預覽</th>
						<th>標題(編輯修改)</th>
						<th class="w-100px">語系</th>
						<th class="w-120px cleear-fix" >
							<span class="float-left">排序</span>
							<span class="float-right reloadBtn" ng-click="contCtrl.reload()">更新排序</span>
						</th>
			        </tr>
				</thead>
				<tbody>
					<tr ng-repeat="(key,item) in contCtrl.galleryList">
	                    <td data-th="項目"><input type="checkbox" ng-model="item.selected" ng-click="contCtrl.checkWatch()" /></td>
						<td data-th="編碼" ng-bind="(key+1)+(contCtrl.currentPage -1)*contCtrl.countOfPage" galleryId="@{{item.gallery_id}}"></td>
						<td data-th="狀態">
							<span ng-disabled="@{{item.img_status == 1? 'item.itemColor =false': 'item.itemColor=true'}}" ng-class="{true: 'item_enable', false: 'item_disable'}[item.itemColor]" ng-bind="item.status_name"></span>
						</td>
						<td data-th="主圖預覽">
							<a href="" ng-click="contCtrl.go_edit(item.gallery_id)">
								<div class="adminImg-responsive-4halfBy3" ng-style="{'background-image': 'url('+item.url+')'}"></div>
							</a>
						</td>
						<td data-th="標題">
							<a class="editInfor w-100 d-inline-block" href="" ng-bind="item.alt" ng-click="contCtrl.go_edit(item.gallery_id)"></a>
						</td>
						<td data-th="語系" ng-bind="item.lang.lang_word"></td>
						<td data-th="排序"><input type="number" class="use-form-control maxWidth" ng-model="item.slider_order" ng-blur="contCtrl.changeOrder(item)" ng-focus="contCtrl.textRecording(item)"></td>
					</tr>
				</tbody>
			</table>
			<div class="row mb-5 pageHeader">
				<div class="col-lg-6 clearfix mb-2">
					<div class="admin-receivingMailBox">
						<a class="disableBtn btn-use" href="javascript:void(0);" ng-click='contCtrl.setStatus(1)'><span>啟用</span></a>
						<a class="enablewBtn btn-use" href="javascript:void(0);" ng-click='contCtrl.setStatus(0)'><span>停用</span></a>
						<a class="deleteBtn btn-use" href="javascript:void(0);" ng-click='contCtrl.remove()'><span>刪除</span></a>
					</div>
				</div>
				<div class="col-lg-6 mb-2" style="overflow:auto;">
					<div class="float-lg-right">
						<span> 共<span ng-bind="contCtrl.itemCount"></span>項</span>
						<span>
							<input class="use-form-control pdSpacing" style='width:50px;' type='text' ng-model="contCtrl.currentPage" ng-keydown="$event.keyCode === 13 && contCtrl.goto()" ng-blur="contCtrl.goto()" ng-focus="contCtrl.textRecording(contCtrl.currentPage)">/@{{contCtrl.pageCount}}
						</span>
						<span> <a href="" ng-click='contCtrl.prePage()'>上一頁</a></span>
						<span> <a href="" ng-click='contCtrl.nextPage()'>下一頁</a></span>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

<!-- 自定義 javascript -->
@section('javascript')
    <script type="text/javascript">
        var app = angular.module('app',[]);
        app.controller('ContentController',['$scope','$http',function($scope,$http){

        	var currentPath = window.location.pathname;
			var currPathAry = currentPath.split("/");

        	var self = this;
			self.galleryId 	= currPathAry[3];
			self.selectLangItem = get_record_lang();

			self.addPage 		 = "/{{$use_end}}/{{$content_table}}/" + self.galleryId + "/create";
			self.createSliderUrl = "/{{$use_end}}/api/{{$content_table}}/" + self.galleryId;
			self.editPage		 = "/{{$use_end}}/{{$content_table}}/" + self.galleryId + "/edit/";
			self.listUrl 		 = "/{{$use_end}}/api/{{$content_table}}/showAll/" + self.galleryId;
		    self.setStatusUrl	 = "/{{$use_end}}/api/{{$content_table}}/status/multiple";
		    self.updateUrl		 = "/{{$use_end}}/api/{{$content_table}}/update/";
		    self.deleteUrl		 = "/{{$use_end}}/api/{{$content_table}}/delete";
		    
		    self.go_edit = function(item_id){
		    	location.href = self.editPage + item_id;
		    }

			self.changedListLang = function(){        
	            if(self.selectLangItem === null){
	                  self.selectLangItem = 0;
	            }
              	self.getItems();
          	}

		    self.checkAllItem = function(ids) {
		        var ids = [];
		        self.selectedAll = false;
		        angular.forEach(self.items, function(item) {
		            if (item.selected) {
		                ids.push(item.gallery_id);
		            }
		        });
		        return ids;
		    };

			self.changeOrder = function(item ){  
				if(item.slider_order == undefined){
					self.getItems();
					$.toaster({ message : '排序請填入數字',  priority : 'warning'})
				}
				$scope.result = angular.equals(self.contrastContent, item);
				if(!$scope.result){
					$http({
						method : "post",
						url : self.updateUrl + item.gallery_id,
						data: item,
					}).success(function(data){
						if (data.status == '200'){
							self.getItems();
							$.toaster({ message : '修改成功'})
							// location.reload();
						}
					}).error(function(){
					})//error
				}
			}

			self.reload = function(){  
				location.reload();
			}

		    self.currentPage = 1;
			self.countOfPage = 20;
		    self.searchText = '';
		    self.prodOption = [
		        // { name: '下架', value: 1 },
		        // { name: '上架', value: 2 },
		        { name: '停用', value: '0' },
		        { name: '啟用', value: '1' },
		    ]

		    self.columItem = [
		        { id: 1, name: '狀態', value: 'img_status' },
		    ]

		    self.prodStateSel = '';

		    self.itemData = {};
		    self.itemData.cate_status = 0;
		    self.selectedAll = false;
		    self.selectColumItem = self.columItem[0].value;

		    // clearSearch----------------------------------------------
		    self.resetItem = function() {
		        self.itemData = {};
		        // self.selectItemStatus = self.status[0];
		        self.itemData.lang_id = self.langs[0]['lang_id'];
		        // console.log(self.itemData.lang_id)
		        self.itemData.cate_status = 0;
		        self.prodStateSel = '';
		    }

		    self.clearSearch = function() {
		        self.currentPage = 1;
		        self.selectedAll = false;
		        self.searchText = '';
		        self.selectLangItem = 0;
		        self.prodStateSel = '';
		        self.resetItem();
		        self.getItems();
		    }
		    // clearSearch----------------------------------------------

		    self.checkAll = function() {
		        if (self.selectedAll) {
		            self.selectedAll = true;
		        } else {
		            self.selectedAll = false;
		        }
		        angular.forEach(self.items, function(item) {
		        	// console.log(item)
		            item.selected = self.selectedAll;
		        });
		    };

		    self.checkWatch = function() {
		        var check = 0;
		        angular.forEach(self.items, function(item) {
		            if (item.selected && item.selected === true) {
		                check++;
		            }
		        });
		        if (check == self.countOfPage) {
		            self.selectedAll = true;
		        } else {
		            self.selectedAll = false;
		        }
		    	// console.log(self.selectedAll)
		    	// return false;
		    };

		    self.prePage = function() {
		        if (self.currentPage > 1) {
		            self.currentPage--;
		            self.selectedAll = false;
		            self.getItems();
		        }
		    }

		    self.nextPage = function() {
		        if (self.currentPage < self.pageCount) {
		            self.currentPage++;
		            self.selectedAll = false;
		            self.getItems();
		        }
		    }

			// Pagination localStorage start -------------------------------------------
			if(localStorage.getItem("{{$_SERVER['REQUEST_URI']}}") != null ){
				self.currentPage = localStorage.getItem("{{$_SERVER['REQUEST_URI']}}");
			}else{
				// localStorage.clear();
				localStorage.setItem( "{{$_SERVER['REQUEST_URI']}}" , null);
			}
			self.setPage = function(page) {
				localStorage.setItem( "{{$_SERVER['REQUEST_URI']}}" ,page);
			}
			// -------------------------------------------------------------------------

		    self.getItems = function() {
		        var data = {
		            'selectLangItem': self.selectLangItem,
		            'imgStatus': self.prodStateSel,
		            // 'searchCate': self.categorySel,
		            'searchByText': self.searchText,
		            'currentPage': self.currentPage,
		            'countOfPage': self.countOfPage,
				};
				// Pagination localStorage start -------------------------------------------				
				self.setPage(self.currentPage);
				// -------------------------------------------------------------------------
		        $http({
		            method: "post",
		            url: self.listUrl,
		            data: data
		        }).success(function(data) {
		        	console.log(data)
					self.itemCount= data.count;
		            self.count = data.count;
		            self.pageCount = data.pageCount;
		            self.langs = data.langs;
		            // self.itemData.lang_id = data.langs[0]['lang_id'];
		        	// console.log(data.langs[0])
		            self.items = data.items;
					self.galleryList = data.items;
					// console.log(self.galleryList)

					for(var prop in self.galleryList){
						if(self.galleryList[prop]['img_status']==1){
							self.galleryList[prop]['status_name'] ="啟用"
						}else{
							self.galleryList[prop]['status_name'] ="停用"
						}
						self.galleryList[prop]['slider_order'] = parseInt(self.galleryList[prop]['slider_order']);
					}
		        }).error(function() {
		            $.toaster({ message : '發生錯誤', priority : 'danger' });
		        }) //error
		    }
		    self.getItems();

		    self.setStatus = function(status) {
		        var ids = self.checkAllItem(ids);
		        if (ids.length > 0) {
		            self.setStatusItem(ids, status);
		        } else {
		            $.toaster({ message : '請選擇商品', priority : 'warning' });
		        }
		    };

		    self.setStatusItem = function(ids, status) {
		        var data = { 'ids': ids, 'status': status, 'type': self.selectColumItem };
		        // console.log(data);
		        self.actionItem("put", self.setStatusUrl, data);
		    }

		    self.actionItem = function(method, url, data) {
		        // console.log(data);
		        $http({
		            method: method,
		            url: url,
		            data: data
		        }).success(function(data) {
		        	console.log(data)
		            if (data.status == '200') {
		                // self.resetItem();
		                self.getItems();
		            } else {
		            	$.toaster({ message : '資料庫無回應', priority : 'warning' });
		            }
		        }).error(function() {
		            $.toaster({ message : '錯誤', priority : 'warning' });
		        }) //error
		    }

		    self.remove = function() {
		        var ids = self.checkAllItem(ids);
		        if (ids.length > 0) {
		            if (confirm("確定刪除？")) {
		                self.deleteItem(ids);
		            }
		        }
		    };

		    self.deleteItem = function(ids) {
		        // console.log(ids);
		        $http({
		            method: "put",
		            url: self.deleteUrl,
		            data: { galleryId: ids },
		        }).success(function(data) {
		            if (data.status == '200') {
		                $.toaster({ message : '資料已刪除'});
		                setTimeout( function(){
		                	location.reload();
		                }, 1000 );
		            } else {
		                $.toaster({ message : data.msg, priority : 'warning' });

		            }
		        }).error(function() {
		        }) //error
		    }

			self.textRecording = function(item) {
				self.contrastContent="";
				self.contrastContent = angular.copy(item, self.contrastContent);            
			}

			self.goto = function() {
                if (self.currentPage <= 0) {
                    self.currentPage = 1;
                    $.toaster({ message : '頁數需大於 0',  priority : 'warning'})
                    self.currentPage = self.contrastContent;
                } else if (self.currentPage > self.pageCount) {
                    $.toaster({ message : '頁數需小於於總頁數 : ' + self.pageCount,  priority : 'warning'})
                    self.currentPage = self.contrastContent;
                } else {
                    self.getItems();
                }

            } //self.goto
        }])//app.controller()

		app.directive("moreImgUpload",function($http,$compile){
            return {
                restrict: 'AE',
                scope: {
                    ngCreateUrl: "=", /*ng-create-url*/
                    ngGalleryTypeId: "=", /*ng-gallery-type-id*/
                    ngLang: "=", /*ng-lang*/
                },
                data: "=" ,
                template :  '<input class="fileUpload" type="file" multiple />'+
                            '<div class="dropzone">'+
                                '<p class="msg">點擊或拖放文件即可上傳</p>'+
                            '</div>'
                        ,
                link : function(scope,elem,attrs){
                    var formData = new FormData();
                    scope.previewData = []; 

                    function previewFile(file){
                        var reader = new FileReader();
                        var obj = new FormData().append('file', file);           
                        reader.onload=function(data){
                            var src = data.target.result;
                            var size = ((file.size/(1024*1024)) > 1)? (file.size/(1024*1024)) + ' mB' : (file.size/     1024)+' kB';
                            scope.$apply(function(){
                                // console.log(scope.data)
                                last_order = 0;
                                // console.log(last_order);
                                scope.upload({
                                	'alt':file.name,
                                	'gallery_type_id': scope.galleryTypeId,
                                	'slider':src,
                                	'gallery_cont': {},
                                	'img_status': "1",
                                	'slider_order':0,
                                	'lang_id': scope.ngLang ? scope.ngLang : 1,
                                });
                            });                                   
                            // console.log(scope.previewData);
                        }
                        reader.readAsDataURL(file);
                    }

                    function uploadFile(e,type){
                        e.preventDefault();         
                        var files = "";
                        if(type == "formControl"){
                            files = e.target.files;
                        } else if(type === "drop"){
                            files = e.originalEvent.dataTransfer.files;
                        }           

                        for(var i=0;i<files.length;i++){
                            var file = files[i];
                            // if(file.type.indexOf("image") !== -1){
                                previewFile(file);                              
                            // } else {
                            //     alert(file.name + " is not supported");
                            // }
                        }
                    }   
                    elem.find('.fileUpload').bind('change',function(e){
                        uploadFile(e,'formControl');
                    });

                    elem.find('.dropzone').bind("click",function(e){
                        $compile(elem.find('.fileUpload'))(scope).trigger('click');
                    });

                    elem.find('.dropzone').bind("dragover",function(e){
                        e.preventDefault();
                    });

                    elem.find('.dropzone').bind("drop",function(e){
                        uploadFile(e,'drop');                                                                       
                    });

                    scope.upload=function(obj){
                    	// console.log(obj);return;

                        $http({
							method: "post",
							url: scope.ngCreateUrl,
							data: obj,
						}).success(function(data) {
								console.log(data);
								if(data['status']==200){
									window.location.reload();
								} else {
									alert('資料庫無回應');
								}
						}).error(function() {
							$.toaster({ message : '發生錯誤', priority : 'danger' });
						}) //error
                    }
                }
            }
        });
    </script>
@endsection







