    <script type='text/javascript'>
        function update(msgStr) {
            var msg = msgStr;
            if (confirm(msg) == true) {
                return true;
            } else {
                return false;
            }
        }   

        var app = angular.module('app', ['summernote']);
        app.controller('ContentController', function($scope, $http){
            /*一般Cms功能*/
            {
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
                        onFocus: function(item) {
                            self.textRecording($(this).summernote('code'));
                        },
                        onBlur: function(item) {
                            let int = this.getAttribute('int');
                            $scope.result = angular.equals(self.contrastContent, $(this).summernote('code') );
                            if(!$scope.result){
                                self.saveOneCmsEdit(self.items[int]);
                            }
                        },
                        onChange: function(item, change_type='normal') {
                            if(change_type == 'plugin_set'){
                                let int = this.getAttribute('int');
                                let code = $(this).summernote('code');
                                self.items[int].cont.text = code;
                                self.saveOneCmsEdit(self.items[int]);
                            }
                        },
                        onBlurCodeview: function(item) {
                            let int = this.getAttribute('int');
                            let code = $(this).summernote('code');
                            self.items[int].cont.text = code;
                            self.saveOneCmsEdit(self.items[int]);
                            if($(this).next().hasClass('codeview')){
                                $(this).summernote('codeview.toggle');
                            }
                        }
                    },
                };

                var currUrl = window.location.pathname;
                var urlSplit = currUrl.split('/');
                var self = this;
                self.cmsTypeId = urlSplit.pop(); //urlSplit[3];
                self.items = [];
                self.editItem = { seg: 1, order_id: 0, pre_seg: 0, type:'text', template:{viewBlade:"",} };
                self.itemMax = 5;
                self.chiilTemplateId    = "{{$child_template_id}}"  /*子模板id(預設為0)*/

                @if (isset($typePage))
                    self.typePage           = "{{$typePage}}";
                @else
                    self.typePage           = "/{{$use_end}}/{{$content_table}}/management/type";
                @endif                
                
                self.viewPage           = "/{{$use_end}}/api/{{$content_table}}/" + self.cmsTypeId + "/view";
                self.showContentUrl     = "/{{$use_end}}/api/{{$content_table}}/showContent/" + self.cmsTypeId;
                self.addContentUrl      = "/{{$use_end}}/api/{{$content_table}}/add";
                self.editContentUrl     = "/{{$use_end}}/api/{{$content_table}}/edit";
                self.deleteContentUrl   = "/{{$use_end}}/api/{{$content_table}}/delete";
                self.deleteImgUrl       = "/{{$use_end}}/api/{{$content_table}}/delete/img";

                self.backToList=function(){
                    location.href = self.typePage;
                }
                /* 處理圖片路徑 */
                self.imgSplit=function(con){
                    for (let v of con){
                        if(v.type =='img'){
                            let str =v.imageSrc.split('/');
                            if(str[str.length-1] ==""){
                                v.imageSrc="";
                            }
                        }
                    }
                }
                /* 顯示cms內容 */
                self.showAllCmsByType = function() {
                    let url = self.showContentUrl;
                    $http({
                        method: "get",
                        url: url
                    }).success(function(data) {
                        self.items = data.cms;
                        self.imgSplit(self.items);
                        // console.log(self.items);
                    }).error(function() {})
                }
                self.showAllCmsByType();

                self.saveOneCmsEdit = function(item) {
                    // delete item['cont']['order']; // 取消修改排序
                    let url = self.editContentUrl;
                    if(item.order_id===''){
                        $.toaster({ message : '請提供排序', priority:'warning'});
                        return;
                    }
                    let data = { 'cms': item, 'cmsTypeId': self.cmsTypeId ,'method': 1 };
                    self.actionItem(1, "put", url, data);
                }

                self.saveOrder = function(item) {
                    let url = self.editContentUrl;
                    if(item.order_id===''){
                        $.toaster({ message : '請提供排序', priority:'warning'});
                        return;
                    }
                    let data = { 'cms': item, 'cmsTypeId': self.cmsTypeId ,'method': 1 };
                    self.actionItem(2, "put", url, data);
                }

                self.delProContId = null;
                self.removeCms = function(cmsId, type) {
                    self.delProContId =cmsId;
                    let data = { 'cmsId': cmsId, 'type': type, 'cmsTypeId': self.cmsTypeId };
                    let deleteurl = self.deleteContentUrl;
                    self.actionItem(3, "post", deleteurl, data);
                }

                self.removeImg = function(item, templateVirable="") {
                    let deleteurlImg = self.deleteImgUrl;
                    let data = { 'item': item , 'cmsId':item.cmsId, 'templateVirable':templateVirable };
                    self.actionItem(5, "post", deleteurlImg, data);
                }

                self.actionItem = function(number, method, url, data) {
                    $http({
                        method: method,
                        url: url,
                        data: data
                    }).success(function(res) {
                        // console.log(res)
                        if (res.status == '200') {
                            if (number == 1) {
                                for (var i = 0; i < self.items.length; i++) {
                                    if(self.items[i]['cmsId'] == data.cms.cmsId){
                                        self.items[i] = data.cms;
                                        break;
                                    }
                                }
                                $.toaster({ message : '修改成功'});
                            }
                            else if(number == 2){
                                self.items = res.cms;
                                $.toaster({ message : '修改成功'});
                            }
                            else if(number == 3){
                                angular.forEach(self.items, function(item ,key ) {  
                                    if(item.cmsId == self.delProContId){
                                        self.items.splice(key, 1);
                                        self.delProContId = null;
                                    }
                                });
                                $.toaster({ message : '刪除成功'})
                            }
                            else if(number == 5){
                                if(res.message == 'success'){
                                    $.toaster({ message : '刪除成功'})
                                    angular.forEach(self.items, function(item ,key ) {
                                        if(item.cmsId == res.cmsId){
                                            item.imageSrc ="";
                                        }
                                    });
                                }
                            }
                            else{
                            }
                        }else{
                            $.toaster({ message : '資料庫無回應',  priority : 'danger'});
                        }
                    }).error(function() {
                        $.toaster({ message : '發生錯誤',  priority : 'danger'});
                    }) //error
                }
              
                // 模板版型選擇(請確保template的name值不重複(用於對應view), show_name:後台看到的板型選項, rename:資料庫紀錄的版型類型)
                self.tmpNameItems = [
                    {show_name:'全版文字',name:'tmp_normal', rename:'文字版', type:'text', seg:12,},
                    {show_name:'半版文字',name:'tmp_normal', rename:'文字版', type:'text', seg:6,},
                    {show_name:'1/3版文字',name:'tmp_normal', rename:'文字版', type:'text', seg:4,},
                    {show_name:'1/4版文字',name:'tmp_normal', rename:'文字版', type:'text', seg:3,},
                    {show_name:'1/6版文字',name:'tmp_normal', rename:'文字版', type:'text', seg:2,},
                    {show_name:'1/12版文字',name:'tmp_normal', rename:'文字版', type:'text', seg:1,},
                    
                    {show_name:'全版圖片',name:'tmp_normal', rename:'圖片版', type:'img', seg:12,},
                    {show_name:'半版圖片',name:'tmp_normal', rename:'圖片版', type:'img', seg:6,},
                    {show_name:'1/3圖片',name:'tmp_normal', rename:'圖片版', type:'img', seg:4,},
                    {show_name:'1/4版圖片',name:'tmp_normal', rename:'圖片版', type:'img', seg:3,},
                    {show_name:'1/6版圖片',name:'tmp_normal', rename:'圖片版', type:'img', seg:2,},
                    {show_name:'1/12版圖片',name:'tmp_normal', rename:'圖片版', type:'img', seg:1,},
                    
                    {show_name:'左滿圖右字', name:'tmp_left_full_img_right_text', rename:'左滿圖右字', type:'template', seg:12,},
                    {show_name:'右滿圖左字', name:'tmp_right_full_img_left_text', rename:'右滿圖左字', type:'template', seg:12,},
                    {show_name:'左字右圖', name:'tmp_left_text_right_img', rename:'左字右圖', type:'template', seg:12,},
                    {show_name:'左圖右字', name:'tmp_left_img_right_text', rename:'左圖右字', type:'template', seg:12,},
                    {show_name:'全版圖上字', name:'tmp_full_img_top_text', rename:'全版圖上字', type:'template', seg:12,},
                    {show_name:'全版圖右字', name:'tmp_full_img_right_text', rename:'全版圖右字', type:'template', seg:12,},
                    {show_name:'全版圖左字', name:'tmp_full_img_left_text', rename:'全版圖左字', type:'template', seg:12,},
                    {show_name:'半版左', name:'tmp_helf_left', rename:'半版左', type:'template', seg:6,},
                    {show_name:'半版右', name:'tmp_helf_right', rename:'半版右', type:'template', seg:6,},
                    {show_name:'三分之一版', name:'tmp_one_third', rename:'三分之一版', type:'template', seg:4,},

                    {show_name:'圖左色塊字右', name:'tmp_img_colortext', rename:'圖左色塊字右', type:'img_colortext', seg:12,},
                    {show_name:'圖右色塊字左', name:'tmp_img_colortext', rename:'圖右色塊字左', type:'img_colortext', seg:12,},

                    {show_name:'滿圖右色塊字左', name:'tmp_fullimg_colortext', rename:'滿圖右色塊字左', type:'fullimg_colortext', seg:12,},
                    {show_name:'滿圖左色塊字右', name:'tmp_fullimg_colortext', rename:'滿圖左色塊字右', type:'fullimg_colortext', seg:12,},

                    {show_name:'全版圖中', name:'tmp_fullimg_and_text', rename:'全版圖中', type:'fullimg_and_text', seg:12,},
                    {show_name:'全版圖下文', name:'tmp_fullimg_and_text', rename:'全版圖下文', type:'fullimg_and_text', seg:12,},
                    {show_name:'全版圖雙背色', name:'tmp_fullimg_and_text', rename:'全版圖雙背色', type:'fullimg_and_text', seg:12,},
                    {show_name:'全版圖中字', name:'tmp_fullimg_and_text', rename:'全版圖中字', type:'fullimg_and_text', seg:12,},
                    {show_name:'全版圖中區塊字', name:'tmp_fullimg_and_text', rename:'全版圖中區塊字', type:'fullimg_and_text', seg:12,},

                    {show_name:'雙圖中', name:'tmp_twoimg_and_text', rename:'雙圖中', type:'twoimg_and_text', seg:12,},
                    {show_name:'雙上圖', name:'tmp_twoimg_and_text', rename:'雙上圖', type:'twoimg_and_text', seg:12,},
                    {show_name:'雙圖下文', name:'tmp_twoimg_and_text', rename:'雙圖下文', type:'twoimg_and_text', seg:12,},
                    {show_name:'雙圖雙背色', name:'tmp_twoimg_and_text', rename:'雙圖雙背色', type:'twoimg_and_text', seg:12,},

                    {show_name:'3圖文', name:'tmp_threeimg_and_text', rename:'3圖文', type:'threeimg_and_text', seg:12,},
                    {show_name:'1左2右', name:'tmp_threeimg_and_text', rename:'1左2右', type:'threeimg_and_text', seg:12,},
                    {show_name:'2左1右', name:'tmp_threeimg_and_text', rename:'2左1右', type:'threeimg_and_text', seg:12,},
                    {show_name:'1左1右', name:'tmp_threeimg_and_text', rename:'1左1右', type:'threeimg_and_text', seg:12,},
                    {show_name:'滿圖文', name:'tmp_threeimg_and_text', rename:'滿圖文', type:'threeimg_and_text', seg:12,},
                                        
                    {show_name:'表格', name:'tmp_table', rename:'表格', type:'table', seg:12,},
                ];

                self.addPart = function(tmpItem) {
                    let addOrder = 0;
                    if( self.items.length != 0 ){
                        addOrder = parseInt(self.items[self.items.length-1]['order_id'] )+1;
                    }
                    self.addItems = [];

                    name = tmpItem['rename'];
                    type = tmpItem['type'];
                    seg  = tmpItem['seg'];
                    viewBlade = tmpItem['name'];

                    self.addItems.push({
                        name: name, type: type,
                        seg: seg, pre_seg: 0,
                        cont: {show:true, space:false, text:"", indent:false,}, 
                        title: {show:true, space:false, text:"", align:"", bg_color:"", min_width:""}, 
                        layout: {show:true, space:false, space_lr:true,},
                        template: {viewBlade: viewBlade,},
                        pics: [],
                        order_id: addOrder,
                    });
                    self.addContent(); 
                }

                self.copy_cms = function(item){
                    copy_item = Object.assign({}, item);
                    delete copy_item["cmsId"];
                    copy_item['order_id'] = parseInt(self.items[self.items.length-1]['order_id'] )+1;
                    self.addItems = [];
                    self.addItems.push(copy_item);
                    self.addContent();
                }

                self.addContent = function() {
                    let data = {'cmsTypeId': self.cmsTypeId ,'cms': self.addItems, 'child_template_id': self.chiilTemplateId};
                    $http({
                        method : "post",
                        url : self.addContentUrl,
                        data : data
                    }).success(function(data){                    
                        if (data.status=='200'){
                            self.items.push(data.cms[data.cms.length-1]);
                            self.imgSplit(self.items);
                            $.toaster({ message : '新增成功'});
                        }
                        else if(data.msg){
                            $.toaster({ message : data.msg,  priority : 'danger'});
                        }
                        else{
                            $.toaster({ message : '資料庫無回應',  priority : 'danger'});
                        }
                    }).error(function(){
                    })//error
                }
                // add item end

                self.textRecording = function(item) {
                    // console.log(item)
                    self.contrastContent="";
                    self.contrastContent = angular.copy(item, self.contrastContent);            
                }

                self.modifyItem = function(item, methodInt) {
                    // console.log(item)
                    /* 不修改排序就隱藏 */
                    if(isNaN(item.order_id) ){
                        $.toaster({ message : '排序請填入數字',  priority : 'warning'});
                        return false;
                    }
                    $scope.result = angular.equals(self.contrastContent, item);

                    if(!$scope.result){
                        if(methodInt ==1){
                            self.saveOrder(item);
                        }else if(methodInt ==2){
                            self.saveOneCmsEdit(item);
                        }
                    }
                }

                /*切換模組模板類型*/
                self.modifyTemplateName = function(item){
                    // console.log(item);
                    for (var i = 0; i < self.tmpNameItems.length; i++) {
                        if(self.tmpNameItems[i].show_name == item.name){ /*依據切換的模組切換版面尺寸、對應view*/
                            item.seg = self.tmpNameItems[i].seg;
                            item.template.viewBlade = self.tmpNameItems[i].name;
                            break;
                        }
                    }
                    self.saveOneCmsEdit(item);
                }

                self.changeItem = function(item) {
                    self.saveOneCmsEdit(item);
                }

                /* 取得切換模板的選項 */
                self.get_template_option = function (text) {
                    range = self.tmpNameItems.filter(function(item){
                        if(text=='all_template'){
                            return ['text', 'img'].indexOf(item.type) == -1;
                        }else{
                            return text.split(",").indexOf(item.type) != -1;
                        }
                    });
                    return range;
                }
                /* 取得版型大小選項 */
                self.get_seg_range = function(item){
                    range = [...Array(12 - item['pre_seg']).keys()].map(function(value, index) {
                        return index + 1;
                    });
                    return range;
                }
                /* 取得前置留空選項 */
                self.get_pre_seg_range = function(item){
                    range = [...Array(13 - item['seg']).keys()].map(function(value, index) {
                        return index;
                    });
                    return range;
                }

                /*開啟編輯畫面*/
                self.open_edit_view = function(item, key, $event){
                    /*傳入編輯資料*/
                    self.editItem = Object.assign({}, item);
                    console.log(self.editItem);
                    var $scope = angular.element('#ng_contCtrl').scope();
                    setTimeout(function(){ $scope.$apply(function() {
                        $scope.contCtrl.editItem.key = key;
                    }); });
                    
                    // $('#editView_btn').click();
                    $('#editView').modal('show');

                    /*標記編輯對象*/
                    // console.log($event.currentTarget);
                    $('.proCmsBox').removeClass('border-danger');
                    $('#cms_'+item['cmsId']).addClass('border-danger');
                }

                /*取得cms版面大小class*/
                self.get_col_class = function(seg){
                    var class_name = "col-lg-" + seg
                    if( seg * 2 >= 12){
                        class_name += ' col-md-12';
                    }else if ( seg * 3 >= 12){
                        class_name += ' col-md-6';
                    }else if ( seg * 4 >= 12){
                        class_name += ' col-md-3';
                    }else{
                        class_name += ' col-md-' + (seg * 2);
                    }
                    
                    if ( seg * 3 > 12){
                        class_name += ' col-12';
                    }else if ( seg * 4 > 12){
                        class_name += ' col-6';
                    }else if ( seg * 6 >= 12){
                        class_name += ' col-6';
                    }else{
                        class_name += ' col-4';
                    }

                    return class_name;
                }

                /*取得預覽畫面*/
                self.getView = function(cmsId=""){
                    $('.order_btn').off();
                    // alert(cmsId);
                    $http({
                        method: "get",
                        url: self.viewPage +"?cmsId=" + cmsId,
                    }).success(function(data) {
                        $('#view_content').html(data);

                        $('.order_btn span').on('click', function(e){
                            var order = $(this).text().split('排序：');
                            if(order.length==1){ return; }
                            order = order[1];
                            for (var i = 0; i < self.items.length; i++) {
                                if(order==self.items[i].order_id){
                                    self.open_edit_view(self.items[i], i, e);
                                    $('#viewbox').modal('hide');
                                    return;
                                }
                            }
                        });
                    }).error(function() {})
                }
            }

            @section('cms_layout_js')
                /*套用模版功能*/
                self.cmsTypeId          = "{{$cms_type_id ?? ''}}"    /*cms類型id*/
                self.selectLangItem     = "{{$lang_id ?? ''}}"        /*語言版id*/
                self.edit_view          = "{{$edit_view ?? ''}}"      /*編輯顯示畫面*/
                self.view_view          = "{{$view_view ?? ''}}"      /*展示顯示畫面*/
                self.motherTemplateShowUrl      = '/admin/api/{{$content_table}}_layout/mother_template/show';      /*顯示母模板*/
                self.motherTemplateDeleteUrl    = '/admin/api/{{$content_table}}_layout/management/cmsType/delete'; /*刪除母模板*/
                self.motherTemplateAddUrl       = '/admin/api/{{$content_table}}_layout/mother_template/add';       /*建立母模板*/
                self.childTemplateShowUrl       = '/admin/api/{{$content_table}}_layout/child_template/show';       /*顯示子模板*/
                self.childTemplateAddUrl        = '/admin/api/{{$content_table}}_layout/child_template/add';        /*建立子模板*/
                self.childTemplateSwitchUrl     = '/admin/api/{{$content_table}}_layout/child_template/switch';     /*切換子模板*/
                self.childTemplateDeleteUrl     = '/admin/api/{{$content_table}}_layout/child_template/delete';     /*刪除子模版*/

                self.motherTemplateShow = function() {
                    $http({
                        method: "post",
                        data:{
                            selectLangItem  : self.selectLangItem,  /*語言版id*/
                        },
                        url: self.motherTemplateShowUrl,
                    }).success(function(data) {
                        // console.log(data);
                        var mother_template_list = data;
                        self.mother_template_list = mother_template_list;
                        $(function () {
                            $('[data-toggle="tooltip"]').tooltip();
                        });
                    }).error(function() {})
                }
                self.motherTemplateShow();

                self.delete_mother_template = function(id) {
                    if(update("您確定要刪除嗎？\n請確認！")){
                        $http({
                            method: "put",
                            data:{
                                'ids':[id],
                            },
                            url: self.motherTemplateDeleteUrl,
                        }).success(function(data) {
                            // console.log(data)
                            if(data.status == 200){
                                self.motherTemplateShow();
                            }else{
                                $.toaster({ message : '資料庫無回應',  priority : 'danger'});
                            }
                        }).error(function() {
                            $.toaster({ message : '發生錯誤',  priority : 'danger'});
                        })
                    }
                }

                self.add_mother_template = function(){
                    // console.log( self.items.length )
                    if( self.items.length <= 0){
                        $.toaster({ message : '無內容，無法新增模板',  priority : 'warning'});
                        return false;
                    }

                    if(self.cmsTypeName=="" || self.cmsTypeName==undefined){
                        $.toaster({ message : '請填入常用選單',  priority : 'warning'});
                        return false;
                    }

                    if(self.contType=="" || self.contType==undefined){
                        $.toaster({ message : '請填入版型名稱',  priority : 'warning'});
                        return false;
                    }

                    if(update("您確定要新建模版嗎？\n請確認！")){
                        let data={
                            item :{
                                'cms_type_name' : self.cmsTypeName,
                                'cont_type'     : self.contType,
                                'lang_id'       : self.selectLangItem,
                                'cate_status'   : 1,
                                'edit_view'     : self.edit_view,
                                'view_view'     : self.view_view,
                            },
                            cms_type_id         : self.cmsTypeId,
                            child_template_id   : self.chiilTemplateId,
                        }
                        console.log(data);
                        // return;
                        $('#block_area').show();
                        $.toaster({ message : '處理中，請稍候'});
                        $http({
                            method: 'post',
                            url: self.motherTemplateAddUrl,
                            data: data
                        }).success(function(data) {
                            // console.log(data)
                            if(data.status == 200){
                                self.motherTemplateShow();
                                $.toaster({ message : '新增成功'});                        
                                $('#addTemplateModal').modal('hide');
                                self.clearTemplateName();
                                $('#block_area').hide();
                            }else{
                                $.toaster({ message : '儲存失敗',  priority : 'danger'});
                                $('#block_area').hide();
                            }
                        }).error(function() {
                            $.toaster({ message : '發生錯誤',  priority : 'danger'});
                            $('#block_area').hide();
                        })
                    }
                }
                self.clearTemplateName = function(){
                    self.cmsTypeName="";
                    self.contType="";
                }

                self.childTemplateShow = function() {
                    let data = {
                        'cms_type_id'   : self.cmsTypeId,
                    };
                    $http({
                        method: "post",
                        data: data,
                        url: self.childTemplateShowUrl,
                    }).success(function(data) {
                        self.layout_list =data;
                    }).error(function() {})
                }
                self.childTemplateShow();

                self.chang_add_template = function(id) {
                    self.add_template=[];
                    self.add_template.template_id = id;
                }
                self.add_child_template=function(add_template){
                    if(add_template['name'] ==undefined){
                        $.toaster({ message : '請填入版型名稱',  priority : 'warning'});
                        return false;
                    }
                    $('#block_area').show();
                    $.toaster({ message : '處理中，請稍候'});
                    $http({
                        method: "post",
                        data:{
                            'mother_template_id':add_template['template_id'],
                            'name':add_template['name'],
                            'cms_type_id':self.cmsTypeId,
                        },
                        url: self.childTemplateAddUrl,
                    }).success(function(data) {
                        // console.log(data);
                        if(data.status == 200){
                            $.toaster({ message : '新增成功'});
                            setTimeout(function(){ location.reload(); }, 500);
                        }
                        $('#block_area').hide();
                    }).error(function() {
                        $('#block_area').hide();
                    });
                }

                self.switch_child_template=function(child_template_id){
                    let data = {
                        'cms_type_id':self.cmsTypeId,
                        'child_template_id': child_template_id,
                    };
                    $http({
                        method: "post",
                        data:data,
                        url: self.childTemplateSwitchUrl,
                    }).success(function(data) {
                        // console.log(data)
                        if(data.status == 200){
                           location.reload();
                        }
                    }).error(function() {})
                }

                self.delete_child_tmplate = function(id) {
                    if(update("您確定要刪除嗎？\n請確認！")){
                        $http({
                            method: "post",
                            data:{
                                'child_template_id':id,
                                'cms_type_id':self.cmsTypeId,
                            },
                            url: self.childTemplateDeleteUrl,
                        }).success(function(data) {
                            // console.log(data)
                            // 切換-------------
                            if(data.status == 200){
                                location.reload();
                            }else{
                                $.toaster({ message : '資料庫無回應',  priority : 'danger'});
                            }
                        }).error(function() {
                            $.toaster({ message : '發生錯誤',  priority : 'danger'});
                        })
                    }
                }
            @show
        })

        app.directive("ngFileSelect", function(fileReader, $timeout , $http) {
            return {
                scope: {
                    ngModel: '=',
                    editContentUrl: '=',
                    templateVirable: '=',
                    contentItem: '=contentItem',
                    cmsTypeId: '=',
                    ngKey: "=",
                },
                link: function($scope, el) {
                    function getFile(file) { fileReader.readAsDataUrl(file, $scope)
                        .then(function(result) {
                            $timeout(function() {
                                $scope.ngModel = result;
                                item = $scope.contentItem ;
                                if(item.order_id===''){
                                    $.toaster({ message : '請提供排序', priority:'warning'});
                                    return;
                                }

                                if($scope.templateVirable==undefined){ /*一般圖片*/
                                    item['imageSrc'] = result;
                                }
                                else{ /*模板圖片*/
                                    item['template'][$scope.templateVirable] = result;
                                }

                                // console.log(item);return;
                                let data = { 'cms': item, 'cmsTypeId':$scope.cmsTypeId ,'method': 1 };
                                $http({
                                    method: 'put',
                                    url: $scope.editContentUrl,
                                    data: data
                                }).success(function(data) {
                                    if (data.status == '200') {
                                        var $scope2 = angular.element('#ng_contCtrl').scope();
                                        $timeout(function(){
                                            $scope2.$apply(function() {
                                                $scope2.contCtrl.items[$scope.ngKey].imageSrc = data.cms[$scope.ngKey].imageSrc;
                                            });
                                        });
                                        
                                        $.toaster({ message : '修改成功'})
                                    } else {
                                        alert('資料庫無回應');
                                    }
                                }).error(function() {
                                }) //error
                            });
                        });
                    }

                    el.bind("change", function(e) {
                        var file = (e.srcElement || e.target).files[0];
                        getFile(file);
                        $(e.srcElement || e.target).val("");
                    });
                }
            };
        });

        app.factory("fileReader", function($q, $log) {
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