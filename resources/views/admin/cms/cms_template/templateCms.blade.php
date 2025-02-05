
@section('content2')
    <div class='container-fluid'>
        @section('color_link')
            <a href="https://www.ifreesite.com/color/" target="_blank">查看色碼表</a>
        @show

        @section('cms_layout_selector')
            <!-- 套用母模板功能 -->
            <div class="row mb-3">
                <!-- 選擇母模板 -->
                <div class="col-lg-6 mb-3">
                    <h3>
                        <span>母模版列表(新增版型)</span>
                    </h3>
                    <div class="templateBtnBox" ng-repeat='item in contCtrl.mother_template_list'>
                        <button type="button" class="btn btn-dark hoverTooltip" ng-click="contCtrl.chang_add_template(item.id)" data-toggle="tooltip" data-placement="bottom" title="@{{item.layout_remarks}}">
                            <span ng-bind="item.cms_type_name != null ?item.cms_type_name+'-'+item.cont_type:'模版'" data-toggle="modal" data-target="#addLayout"></span>
                        </button>
                        <button type="button" class="btn btn-danger btn-use" ng-click="contCtrl.delete_mother_template(item.id)"><span>x</span></button>
                    </div>

                    <!-- Modal strat-->
                    <div class="modal fade" id="addLayout" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">建立應用子模板</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <span class="mark-use">預覽功能</span>
                                    <div class="form-group">
                                        <label for="layout-name-1" class="col-form-label">應用子模版名稱</label>
                                        <input type="text" class="form-control" id="layout-name-1" ng-bind="contCtrl.add_template.name" ng-model='contCtrl.add_template.name'>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" ng-click="contCtrl.add_child_template(contCtrl.add_template)">新增</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal end-->
                </div>

                <!-- 切換子模板 -->
                <div class="col-lg-6">
                    <div>
                        <h3>套用應用子模板</h3>
                        <div class="templateBtnBox">
                            <button type="button" class="btn btn-dark" 
                                    ng-disabled="@{{contCtrl.chiilTemplateId==0}}" 
                                    ng-class="contCtrl.chiilTemplateId==0 ? 'active' : ''"
                                    ng-click="contCtrl.switch_child_template(0)">預設</button>
                        </div>
                        <div ng-repeat='item in contCtrl.layout_list' class="templateBtnBox">
                            <button type="button" class="btn btn-dark" 
                                    ng-disabled="@{{item.child_template_id == contCtrl.chiilTemplateId ? 'item.active =true': 'item.active=false'}}" 
                                    ng-class="{true: 'active', false: ''}[item.active]" 
                                    ng-bind="item.name != null ?item.name:'預設'" 
                                    ng-click="contCtrl.switch_child_template(item.child_template_id)"></button>
                            <button type="button" class="btn btn-danger btn-use" ng-click="contCtrl.delete_child_tmplate(item.child_template_id)"><span>x</span></button>
                        </div>
                    </div>
                </div>                      
            </div>

            <!-- Modal start-->
            <div class="modal fade" id="addTemplateModal" tabindex="-1" role="dialog" aria-labelledby="addTemplateModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addTemplateModalLabel">建立母模版</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12">
                                        <label for="layout-name" class="col-form-label">常用選單：</label>
                                        <input type="text" class="form-control" id="layout-name" ng-bind="contCtrl.cmsTypeName" ng-model='contCtrl.cmsTypeName'>
                                    </div>
                                    <div class="col-12">
                                        <label for="layout-name" class="col-form-label">版型名稱：</label>
                                        <input type="text" class="form-control" id="layout-name" ng-bind="contCtrl.contType" ng-model='contCtrl.contType'>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" ng-click='contCtrl.add_mother_template()'>儲存</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal end-->
        @show

        @section('cms_edit_content')
            <div class="mb-2 addCmsBox">
                <button class='btn btn-mr-spacing btn-success' data-toggle="modal" data-target="#viewbox" ng-click="contCtrl.getView()">預覽全部</button>
                <a id="editView_btn" data-toggle="modal" data-target="#editView"></a>
                <span class="herinneren-use">1.如需嵌入Youtube、Google地圖等，請點擊編輯器「原始碼」按鈕，並將複製的語法貼入黑白畫面中。</span>
                <span class="herinneren-use">2.站外連結請包含 http:// 或 https://，站內連結建議使用相對路徑</span>
            </div>

            <!--cms內容 開始-->
            <div class="row">
                <div ng-repeat="(key,item) in contCtrl.items" 
                     id="cms_@{{item.cmsId}}"
                     class="proCmsBox border offset-lg-@{{item.pre_seg}} @{{contCtrl.get_col_class(item.seg)}} overflow-x-hidden">
                    <div class="h-100">
                        <div class="row use-box use-box d-flex align-content-between flex-wrap h-100">
                            <span ng-if="['img', 'text'].indexOf(item.type)!=-1">
                                <span class="use-sp-title _ly_title @{{item.type}}_ly_title">
                                    <select ng-model="item.type" ng-change="contCtrl.modifyItem(item,1)">
                                        <option value="text">文字版</option>
                                        <option value="img">圖片版</option>
                                    </select>
                                </span>
                                <!-- <span class="d-inline-block ml-3">
                                    <input type='checkbox' ng-model='item.layout.space' id="l-bbSpace-@{{item.cmsId}}" ng-change="contCtrl.changeItem(item)"/>
                                    <label class="form-check-label" for="l-bbSpace-@{{item.cmsId}}">區塊下間距</label>
                                </span>
                                <span class="d-inline-block ml-3">
                                    <input type='checkbox' ng-model='item.layout.space_lr' id="lr-pSpace-@{{item.cmsId}}" ng-change="contCtrl.changeItem(item)"/>
                                    <label class="form-check-label" for="lr-pSpace-@{{item.cmsId}}">區塊左右內縮</label>
                                </span> -->
                            </span>
                            <span ng-if="item.type=='template'" class="use-sp-title _ly_title @{{item.type}}_ly_title">
                                <select ng-model="item.name" ng-change="contCtrl.modifyTemplateName(item)"
                                        ng-options="option.show_name as option.show_name for option in contCtrl.get_template_option('template')">
                                </select>
                            </span>
                            <span ng-if="item.type=='img_colortext'" class="use-sp-title _ly_title template_ly_title">
                                <select ng-model="item.name" ng-change="contCtrl.modifyTemplateName(item)"
                                        ng-options="option.show_name as option.show_name for option in contCtrl.get_template_option('img_colortext')">
                                </select>
                            </span>
                            <span ng-if="item.type=='fullimg_colortext'" class="use-sp-title _ly_title template_ly_title">
                                <select ng-model="item.name" ng-change="contCtrl.modifyTemplateName(item)"
                                        ng-options="option.show_name as option.show_name for option in contCtrl.get_template_option('fullimg_colortext')">
                                </select>
                            </span>
                            <span ng-if="item.type=='fullimg_and_text'" class="use-sp-title _ly_title template_ly_title">
                                <select ng-model="item.name" ng-change="contCtrl.modifyTemplateName(item)"
                                        ng-options="option.show_name as option.show_name for option in contCtrl.get_template_option('fullimg_and_text')">
                                </select>
                            </span>
                            <span ng-if="item.type=='twoimg_and_text'" class="use-sp-title _ly_title template_ly_title">
                                <select ng-model="item.name" ng-change="contCtrl.modifyTemplateName(item)"
                                        ng-options="option.show_name as option.show_name for option in contCtrl.get_template_option('twoimg_and_text')">
                                </select>
                            </span>
                            <span ng-if="item.type=='threeimg_and_text'" class="use-sp-title _ly_title template_ly_title">
                                <select ng-model="item.name" ng-change="contCtrl.modifyTemplateName(item)"
                                        ng-options="option.show_name as option.show_name for option in contCtrl.get_template_option('threeimg_and_text')">
                                </select>
                            </span>
                            <span ng-if="item.type=='table'" class="use-sp-title _ly_title template_ly_title">
                                <select ng-model="item.name" ng-change="contCtrl.modifyTemplateName(item)"
                                        ng-options="option.show_name as option.show_name for option in contCtrl.get_template_option('table')">
                                </select>
                            </span>

                            <button class="btn btn-mr-spacing btn-success" data-toggle="modal" data-target="#viewbox" ng-click="contCtrl.getView(item.cmsId)">單一預覽</button>

                            <div class="col-12">
                                <div class="row">
                                    <div ng-if="['img', 'text'].indexOf(item.type)!=-1" class="col-md-12 use-box-btm">
                                        <div class="d-inline-block mr-3">
                                            版型大小：
                                            <select ng-model="item.seg" ng-options="option for option in contCtrl.get_seg_range(item)" ng-change="contCtrl.changeItem(item)">
                                            </select>
                                        </div>
                                        <div class="d-inline-block mr-3">
                                            前置留空：
                                            <select ng-model="item.pre_seg" ng-options="option for option in contCtrl.get_pre_seg_range(item)" ng-change="contCtrl.changeItem(item)">
                                            </select>
                                        </div>
                                        <br>
                                        <!-- <div class="d-inline-block mr-3">
                                            大螢幕水平對齊：(預設置左)
                                            <select ng-model='item.area_align_lg' ng-change="contCtrl.modifyTemplateName(item)">
                                                <option value="align-items-lg-start">置左</option>
                                                <option value="align-items-lg-center">置中</option>
                                                <option value="align-items-lg-end">置右</option>
                                            </select>
                                        </div>
                                        <div class="d-inline-block mr-3">
                                            大螢幕垂直對齊：(預設靠上)
                                            <select ng-model='item.area_align_v_lg' ng-change="contCtrl.modifyTemplateName(item)">
                                                <option value="justify-content-lg-start">靠上</option>
                                                <option value="justify-content-lg-center">靠中</option>
                                                <option value="justify-content-lg-end">靠下</option>
                                            </select>
                                        </div>
                                        <br>
                                        <div class="d-inline-block mr-3">
                                            小螢幕水平對齊：(預設置左)
                                            <select ng-model='item.area_align' ng-change="contCtrl.modifyTemplateName(item)">
                                                <option value="align-items-start">置左</option>
                                                <option value="align-items-center">置中</option>
                                                <option value="align-items-end">置右</option>
                                            </select>
                                        </div>
                                        <div class="d-inline-block mr-3">
                                            小螢幕垂直對齊：(預設靠上)
                                            <select ng-model='item.area_align_v' ng-change="contCtrl.modifyTemplateName(item)">
                                                <option value="justify-content-start">靠上</option>
                                                <option value="justify-content-center">靠中</option>
                                                <option value="justify-content-end">靠下</option>
                                            </select>
                                        </div> -->
                                    </div>

                                    <div class="col-md-12 use-box-btm">
                                        <span class="use-sp-title">順序</span>
                                        <input class="form-control form-control-use line-style" ng-model="item.order_id" type="" name="" ng-blur="contCtrl.modifyItem(item,1)" ng-focus="contCtrl.textRecording(item)">
                                    </div>
                                    <div class="col-md-12 use-box-btm">
                                        <button class='btn btn-dark cmsBtn-use cmsBtn-use btn-use line-style' 
                                                ng-click="contCtrl.open_edit_view(item, key, $event)">編輯</button>
                                        <button class='btn btn-dark cmsBtn-use cmsBtn-use btn-use line-style' 
                                                ng-click="contCtrl.copy_cms(item)">複製(圖片需重新上傳)</button>
                                        <button class='btn btn-secondary cmsBtn-use cmsBtn-use btn-use line-style float-right'
                                                ng-click='contCtrl.removeCms(item.cmsId,item.type)'>刪除</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--cms內容 結束-->

            <hr>
            <div class="mb-2 addCmsBox">
                <button class='btn btn-mr-spacing btn-success' data-toggle="modal" data-target="#examplebox">使用說明</button>

                <div class="d-flex">
                    <div style="width: 80px">一般模板：</div>
                    <div style="width: calc( 100% - 80px)">
                        <button ng-repeat='tmpItem in contCtrl.get_template_option("text,img")'
                                class='btn btn-dark btn-mr-spacing addCmsBtnBox btn-use line-style @{{tmpItem["type"]}}_btn' >
                            <span ng-bind='tmpItem.show_name' ng-click='contCtrl.addPart(tmpItem)'></span>
                        </button>
                    </div>
                </div>

                @section('all_template_select')
                    <div class="mt-2 d-flex">
                        <div style="width: 80px">特殊模板：</div>
                        <div style="width: calc( 100% - 80px)">
                            <!-- <button ng-repeat='tmpItem in  contCtrl.get_template_option("all_template")'
                                    class='btn btn-dark btn-mr-spacing addCmsBtnBox btn-use line-style template_btn' >
                                <span ng-bind='tmpItem.show_name' ng-click='contCtrl.addPart(tmpItem)'></span>
                            </button> -->
                            <span class="border d-inline-block p-1">
                                <button ng-repeat='tmpItem in  contCtrl.get_template_option("template")'
                                        class='btn btn-dark btn-mr-spacing addCmsBtnBox btn-use line-style template_btn mb-0' >
                                    <span ng-bind='tmpItem.show_name' ng-click='contCtrl.addPart(tmpItem)'></span>
                                </button>
                            </span>
                            <span class="border d-inline-block p-1">
                                <button ng-repeat='tmpItem in  contCtrl.get_template_option("img_colortext")'
                                        class='btn btn-dark btn-mr-spacing addCmsBtnBox btn-use line-style template_btn mb-0' >
                                    <span ng-bind='tmpItem.show_name' ng-click='contCtrl.addPart(tmpItem)'></span>
                                </button>
                            </span>
                            
                            <span class="border d-inline-block p-1">
                                <button ng-repeat='tmpItem in  contCtrl.get_template_option("fullimg_colortext")'
                                        class='btn btn-dark btn-mr-spacing addCmsBtnBox btn-use line-style template_btn mb-0' >
                                    <span ng-bind='tmpItem.show_name' ng-click='contCtrl.addPart(tmpItem)'></span>
                                </button>
                            </span>
                            <span class="border d-inline-block p-1">
                                <button ng-repeat='tmpItem in  contCtrl.get_template_option("fullimg_and_text")'
                                        class='btn btn-dark btn-mr-spacing addCmsBtnBox btn-use line-style template_btn mb-0' >
                                    <span ng-bind='tmpItem.show_name' ng-click='contCtrl.addPart(tmpItem)'></span>
                                </button>
                            </span>
                            <span class="border d-inline-block p-1">
                                <button ng-repeat='tmpItem in  contCtrl.get_template_option("twoimg_and_text")'
                                        class='btn btn-dark btn-mr-spacing addCmsBtnBox btn-use line-style template_btn mb-0' >
                                    <span ng-bind='tmpItem.show_name' ng-click='contCtrl.addPart(tmpItem)'></span>
                                </button>
                            </span>
                            <span class="border d-inline-block p-1">
                                <button ng-repeat='tmpItem in  contCtrl.get_template_option("threeimg_and_text")'
                                        class='btn btn-dark btn-mr-spacing addCmsBtnBox btn-use line-style template_btn mb-0' >
                                    <span ng-bind='tmpItem.show_name' ng-click='contCtrl.addPart(tmpItem)'></span>
                                </button>
                            </span>
                            <span class="border d-inline-block p-1">
                                <button ng-repeat='tmpItem in  contCtrl.get_template_option("table")'
                                        class='btn btn-dark btn-mr-spacing addCmsBtnBox btn-use line-style template_btn mb-0' >
                                    <span ng-bind='tmpItem.show_name' ng-click='contCtrl.addPart(tmpItem)'></span>
                                </button>
                            </span>
                        </div>
                    </div>
                @show
                
                <hr class="w-100">
            </div>
        @show

        
        @section('cms_btn')
            <div>
                <button type="button" class="btn btn-mr-spacing btn-danger w-100" ng-click="contCtrl.backToList()">返回列表</button>
            </div>
        @show
        
        @section('cms_layout_create_btn')
            <div>
                <button type="button" class="btn  btn-mr-spacing addTemplateBtn w-100" data-toggle="modal" data-target="#addTemplateModal">建立母模版</button>
            </div>
        @show

        <br><br><br><br><br><br>
    </div>

    <!-- 編輯畫面 跳出視窗 -->
    <div class="modal fade" id="editView" tabindex="-1" role="dialog" aria-labelledby="describeModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        編輯內容
                        <button class='btn btn-mr-spacing btn-success mr-2' data-toggle="modal" data-target="#viewbox" ng-click="contCtrl.getView(contCtrl.editItem.cmsId)">單一預覽</button>

                        <button class='btn btn-mr-spacing btn-success' data-toggle="modal" data-target="#viewbox" ng-click="contCtrl.getView()">預覽全部</button>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div ng-if="['img', 'text'].indexOf(contCtrl.editItem.type)!=-1" class="use-box-btm mb-3">
                        <!-- 一般CMS編輯器(文字/圖片版) -->
                        @include('admin.cms.edit_template.normal') 
                    </div>

                    @section('template_edit')
                        <div ng-if="contCtrl.editItem.type=='template'" class="use-box-btm mb-3">
                            <!-- 特殊版CMS編輯器 -->
                            @include('admin.cms.edit_template.template') 
                        </div>
                        <div ng-if="contCtrl.editItem.type=='img_colortext'" class="use-box-btm mb-3">
                            <!-- 圖左色塊字右、圖右色塊字左 -->
                            @include('admin.cms.edit_template.img_colortext') 
                        </div>
                        <div ng-if="contCtrl.editItem.type=='fullimg_colortext'" class="use-box-btm mb-3">
                            <!-- 滿圖右色塊字左、滿圖左色塊字右 -->
                            @include('admin.cms.edit_template.fullimg_colortext') 
                        </div>
                        <div ng-if="contCtrl.editItem.type=='fullimg_and_text'" class="use-box-btm mb-3">
                            <!-- 全版圖中、全版圖下文、全版圖雙背色、全版圖中字、全版圖中區塊字 -->
                            @include('admin.cms.edit_template.fullimg_and_text') 
                        </div>
                        <div ng-if="contCtrl.editItem.type=='twoimg_and_text'" class="use-box-btm mb-3">
                            <!-- 雙圖中、雙上圖、雙圖下文、雙圖雙背色 -->
                            @include('admin.cms.edit_template.twoimg_and_text') 
                        </div>
                        <div ng-if="contCtrl.editItem.type=='threeimg_and_text'" class="use-box-btm mb-3">
                            <!-- 3圖文、1左2右、2左1右、1左1右 -->
                            @include('admin.cms.edit_template.threeimg_and_text') 
                        </div>
                        <div ng-if="contCtrl.editItem.type=='table'" class="use-box-btm mb-3">
                            <!-- 表格 -->
                            @include('admin.cms.edit_template.table') 
                        </div>
                    @show
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" ng-click='contCtrl.getAllContact()'>關閉</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 預覽畫面 跳出視窗 -->
    <div class="modal fade" id="viewbox" tabindex="-1" role="dialog" aria-labelledby="dialogTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="w-100">
                        <div class="titleBox heading">
                            <h3 class="chText d-inline" id="dialogTitle">畫面預覽</h3>
                            <span class="text-danger">排序標示僅用於預覽時區分模塊，前台瀏覽時並不會顯示</span>
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                @section('view_content')
                    <div class="modal-body" id="view_content">
                    </div>
                @show
            </div>
        </div>
    </div>

    <!-- examplebox Modal -->
    <div class="modal fade" id="examplebox" tabindex="-1" role="dialog" aria-labelledby="loginaa" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <h5 class="modal-title" id="loginaa">Modal title</h5> -->
                    <div class="w-100">
                        <div class="titleBox heading">
                            <h2 class="chText" id="loginTilte">使用說明</h2>
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul style="list-style: initial; padding-left: 20px;">
                        <li>RWD編輯器有多種板型，可任意搭配使用，組合出適合您的介紹內容。</li>
                        <li>其中全版(滿版)代表數字12、半版代表數字6、1/3版代表數字4、1/4版代表數字3，每行最多只能放下合計12的版型，超過的版面會自動換行，如下圖所示：
                            <img src="/img/demo1.png" style="width:100%">
                        </li>
                        <li>可選擇「前置留空」，在大畫面顯示時預留設定大小的空白，以達到區塊後推的樣式。</li>
                        <li>可勾選「加大下間距」或「區塊下間距」，調整區塊上下間的距離，以達到分段留白的樣式。</li>
                        <li>如需顯示標題或內容，請勾選對應的「顯示標題」、「顯示內容」，這樣您輸入的文字才能在前台顯示。</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- 自定義 javascript -->
@section('javascript')
    <!-- 圖文編輯器js -->
    @include('admin.cms.cms_template.cms_js')

@endsection