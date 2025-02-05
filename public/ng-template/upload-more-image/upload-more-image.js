app.directive("moreImgUpload",function($http,$compile){
    return {
        restrict : 'AE',
        scope : {
            url : "@",
            method : "@",
            key : "=key",
            data: "=" ,
        },
        data: "=" ,
        template : 	'<input class="fileUpload" type="file" multiple />'+
                    '<div class="dropzone">'+
                        '<p class="msg">點擊或拖放文件即可上傳</p>'+
                    '</div>'+
                    '<div class="preview clearfix">'+
                        '<div class="previewData clearfix" ng-repeat="data in previewData track by $index">'+
                            '<div class="boxCenter">'+
                                '<div class="imgBox clearfix">'+
                                    '<img src=@{{data.src}} />'+
                                '</div>'+
                                '<div class="previewDetails">'+
                                    '<div class="detail"><b>檔案名稱 : </b>@{{data.name}}</div>'+
                                    '<div class="detail"><b>檔案類型 : </b>@{{data.type}}</div>'+
                                    '<div class="detail"><b>檔案大小 : </b> @{{data.size}}</div>'+

                                    '<div class="detail orderInputBox"><div class="title">排序 :</div><input type="number" class="form-control" ng-model="data.order"></div>'+
                                '</div>'+
                                '<div class="previewControls">'+
                                    '<span ng-click="upload(data)" class="circle upload">'+
                                        '<i class="fa fa-check"></i>'+
                                    '</span>'+
                                    '<span ng-click="remove(data)" class="circle remove">'+
                                        '<i class="fa fa-close"></i>'+
                                    '</span>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="" ng-hide="previewData.length == 0">'+
                        '<button type="button" class="btn btn-default w-100" ng-click="saveAll()">一次上傳全部</button>'+
                    '</div>',
        link : function(scope,elem,attrs){
            var formData = new FormData();
            scope.previewData = [];	

            function previewFile(file){
                var reader = new FileReader();
                var obj = new FormData().append('file',file);			
                reader.onload=function(data){
                    var src = data.target.result;
                    var size = ((file.size/(1024*1024)) > 1)? (file.size/(1024*1024)) + ' mB' : (file.size/		1024)+' kB';
                    scope.$apply(function(){
                        scope.previewData.push({'name':file.name,'size':size,'type':file.type, 'src':src,'data':obj,'order':0});
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
                    if(file.type.indexOf("image") !== -1){
                        previewFile(file);								
                    } else {
                        alert(file.name + " is not supported");
                    }
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
                // console.log(obj)
                scope.data = [];
                let data = { 'item': obj.src, 'productId': scope.key , 'imgName':"", 'imgOrder': obj.order};
                $http({
                    method: scope.method,
                    url: scope.url,
                    data: data
                }).success(function(data) {
                    let index= scope.previewData.indexOf(obj);
                    scope.previewData.splice(index,1);

                    if(data.status ==200){
                        console.log(data.productImg)
                        scope.data = data.productImg;
                        angular.forEach(scope.data , function(item) {
                            item.prod_img_name = '/upload/product/' + item.prod_id + '/' + item.prod_img_name;
                        });
                    }

                }).error(function() {
                }) //error
            }

            scope.remove=function(data){
                let index= scope.previewData.indexOf(data);
                scope.previewData.splice(index,1);
            }

            scope.saveAll=function(){
            }
        }
    }
});