
    <!-- 區塊設定 -->
    <div class="row m-0">
        <h5>區塊設定：</h5>
        <div class="col-12 mb-2"> 
            <span class="use-sp-title _ly_title @{{contCtrl.editItem.type}}_ly_title">
                <select ng-model="contCtrl.editItem.type" ng-change="contCtrl.modifyItem(contCtrl.editItem, 2)">
                    <option value="text">文字版</option>
                    <option value="img">圖片版</option>
                </select>
            </span>
            <span class="d-inline-block ml-3">
                <input type='checkbox' ng-model='contCtrl.editItem.layout.space' id="l-bbSpace-@{{contCtrl.editItem.cmsId}}" ng-change="contCtrl.changeItem(contCtrl.editItem)"/>
                <label class="form-check-label" for="l-bbSpace-@{{contCtrl.editItem.cmsId}}">區塊下間距</label>
            </span>
            <span class="d-inline-block ml-3">
                <input type='checkbox' ng-model='contCtrl.editItem.layout.space_lr' id="lr-pSpace-@{{contCtrl.editItem.cmsId}}" ng-change="contCtrl.changeItem(contCtrl.editItem)"/>
                <label class="form-check-label" for="lr-pSpace-@{{contCtrl.editItem.cmsId}}">區塊左右內縮</label>
            </span>
        </div>

        <div class="col-md-12 mb-2">
            <div class="d-inline-block mr-3">
                版型大小：
                <select ng-model="contCtrl.editItem.seg" 
                        ng-options="option for option in contCtrl.get_seg_range(contCtrl.editItem)" 
                        ng-change="contCtrl.changeItem(contCtrl.editItem)">
                </select>
            </div>
            <div class="d-inline-block mr-3">
                前置留空：
                <select ng-model="contCtrl.editItem.pre_seg" 
                        ng-options="option for option in contCtrl.get_pre_seg_range(contCtrl.editItem)" 
                        ng-change="contCtrl.changeItem(contCtrl.editItem)">
                </select>
            </div>
            <br>
            <div class="d-inline-block mr-3">
                大螢幕水平對齊：(預設置左)
                <select ng-model='contCtrl.editItem.area_align_lg' ng-change="contCtrl.modifyTemplateName(contCtrl.editItem)">
                    <option value="align-items-lg-start">置左</option>
                    <option value="align-items-lg-center">置中</option>
                    <option value="align-items-lg-end">置右</option>
                </select>
            </div>
            <div class="d-inline-block mr-3">
                大螢幕垂直對齊：(預設靠上)
                <select ng-model='contCtrl.editItem.area_align_v_lg' ng-change="contCtrl.modifyTemplateName(contCtrl.editItem)">
                    <option value="justify-content-lg-start">靠上</option>
                    <option value="justify-content-lg-center">靠中</option>
                    <option value="justify-content-lg-end">靠下</option>
                </select>
            </div>
            <br>
            <div class="d-inline-block mr-3">
                小螢幕水平對齊：(預設置左)
                <select ng-model='contCtrl.editItem.area_align' ng-change="contCtrl.modifyTemplateName(contCtrl.editItem)">
                    <option value="align-items-start">置左</option>
                    <option value="align-items-center">置中</option>
                    <option value="align-items-end">置右</option>
                </select>
            </div>
            <div class="d-inline-block mr-3">
                小螢幕垂直對齊：(預設靠上)
                <select ng-model='contCtrl.editItem.area_align_v' ng-change="contCtrl.modifyTemplateName(contCtrl.editItem)">
                    <option value="justify-content-start">靠上</option>
                    <option value="justify-content-center">靠中</option>
                    <option value="justify-content-end">靠下</option>
                </select>
            </div>
            <br>
        </div>

        <div class="col-md-12 mb-2">
            <span class="use-sp-title">順序</span>
            <input class="form-control form-control-use line-style" 
                   ng-model="contCtrl.editItem.order_id" ng-blur="contCtrl.modifyItem(contCtrl.editItem,1)" ng-focus="contCtrl.textRecording(contCtrl.editItem)">
        </div>

        <div class="col-6 mb-2">
            <span class="use-sp-title">背景色(請輸入#字號+6碼的色號)</span>
            <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.area_bg_color' 
                   ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
        </div>
        <div class="col-6  mb-2"> 
            <span class="use-sp-title">文字色(請輸入#字號+6碼的色號)</span>
            <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.area_color' 
                   ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
        </div>

        <div class="col-6 mb-2">
            <span class="use-sp-title">大螢幕最小高度：</span>
            <input class="form-control form-control-use line-style w-50 d-inline" type='number' min="0" step="1"
                   ng-model='contCtrl.editItem.min_height_pc' 
                   ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
            <span class="ml-2">px</span>
        </div>
        <div class="col-6 mb-2">
            <span class="use-sp-title">小螢幕最小高度：</span>
            <input class="form-control form-control-use line-style w-50 d-inline" type='number' min="0" step="1"
                   ng-model='contCtrl.editItem.min_height' 
                   ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
            <span class="ml-2">px</span>
        </div>
    </div>
    <hr class="w-100">

    <!-- 標題設定 -->
    <div class="row m-0">
        <h5>標題設定：<span class="cms mark-use">可輸入&lt;br&gt;進行強制換行</span></h5>
        <div class="col-12 mb-2">
            <input type='checkbox' id="title_indent-@{{contCtrl.editItem.cmsId}}" 
                   ng-model='contCtrl.editItem.title.indent' ng-change="contCtrl.changeItem(contCtrl.editItem)"
                   ng-true-value="'indent'" ng-false-value="''"/>
            <label class="form-check-label" for="title_indent-@{{contCtrl.editItem.cmsId}}">縮排</label>&nbsp;&nbsp;
            <input type='checkbox' id="l-tShow-@{{contCtrl.editItem.cmsId}}" 
                   ng-model='contCtrl.editItem.title.show' ng-change="contCtrl.changeItem(contCtrl.editItem)"/>
            <label class="form-check-label" for="l-tShow-@{{contCtrl.editItem.cmsId}}">顯示標題</label>&nbsp;&nbsp;
            <input type='checkbox' id="l-tbSpace-@{{contCtrl.editItem.cmsId}}" 
                   ng-model='contCtrl.editItem.title.space' ng-change="contCtrl.changeItem(contCtrl.editItem)"/>
            <label class="form-check-label" for="l-tbSpace-@{{contCtrl.editItem.cmsId}}">加大下間距</label>&nbsp;&nbsp;
            <span class="d-inline-block mr-3">
                <input type='checkbox' ng-model='contCtrl.editItem.title.bold' id="bold-@{{contCtrl.editItem.cmsId}}" 
                       ng-change="contCtrl.changeItem(contCtrl.editItem)"
                       ng-true-value="'font-weight-bold'"/>
                <label class="form-check-label" for="bold-@{{contCtrl.editItem.cmsId}}">加粗</label>
            </span>
            <br>
            <div class="d-inline-block mr-3">
                水平對齊：(預設置左)
                <select ng-model='contCtrl.editItem.title.align' ng-change="contCtrl.modifyTemplateName(contCtrl.editItem)">
                    <option value="left">置左</option>
                    <option value="center">置中</option>
                    <option value="right">置右</option>
                </select>
            </div>
            <div class="d-inline-block mr-3">
                字體大小：
                <select ng-model='contCtrl.editItem.title.size' ng-change="contCtrl.modifyTemplateName(contCtrl.editItem)">
                    <option value="">小字體</option>
                    <option value="normal">一般</option>
                    <option value="font_medium">中字體</option>
                    <option value="font_big">大字體</option>
                </select>
            </div>

            <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.title.text' 
                   ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"
                   placeholder="請輸入標題" />
        </div>

        <div class="col-6 mb-2">
            <span class="use-sp-title">標題背景色(請輸入#字號+6碼的色號)</span>
            <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.title.bg_color' 
                   ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
        </div>
        <div class="col-6 mb-2">
            <span class="use-sp-title">標題底線色(請輸入#字號+6碼的色號)</span>
            <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.title.bborder_color' 
                   ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
        </div>
        <div class="col-6 mb-2">
            <span class="use-sp-title">標題區寬度</span><br>
            <input class="form-control form-control-use line-style w-50 d-inline" type='number' min="0" step="1"
                   ng-model='contCtrl.editItem.title.width' 
                   ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
            <span class="ml-2">px</span>
        </div>
    </div>
    <hr class="w-100">

    <!-- 圖片設定 -->
    <div class="row m-0">
        <h5><span ng-if='contCtrl.editItem.type == "text"'>背景</span>圖片設定：</h5>
        <div class="col-12 use-box-btm mb-3">
            <span ng-if='contCtrl.editItem.type == "img"'>
                <sapn class="d-inline-block mr-3">
                    <input type='checkbox' id="img_ori_width-@{{contCtrl.editItem.cmsId}}" 
                       ng-model='contCtrl.editItem.img_ori_width' ng-change="contCtrl.changeItem(contCtrl.editItem)"
                       ng-true-value="'img_ori_width'" ng-false-value="''"/>
                    <label class="form-check-label" for="img_ori_width-@{{contCtrl.editItem.cmsId}}">原始大小</label>
                </sapn>

                大螢幕對齊模式：(預設置中)
                <select class="mr-3" 
                        ng-model='contCtrl.editItem.img_align_lg' ng-change="contCtrl.modifyItem(contCtrl.editItem, 2)">
                    <option value="justify-content-lg-start">置左</option>
                    <option value="justify-content-lg-center">置中</option>
                    <option value="justify-content-lg-end">置右</option>
                </select>

                小螢幕對齊模式：(預設置中)
                <select class="mr-3" 
                        ng-model='contCtrl.editItem.img_align' ng-change="contCtrl.modifyItem(contCtrl.editItem, 2)">
                    <option value="justify-content-start">置左</option>
                    <option value="justify-content-center">置中</option>
                    <option value="justify-content-end">置右</option>
                </select>
            </span>
            <div class="cms-upload-img-box">
                <div class="img-box">
                    <div class="adminImg-responsive-1By1" ng-style="{'background-image': 'url('+contCtrl.editItem.imageSrc+')'}"></div>
                </div>                                      
                <div class="upload-box">
                    <div class="input-group mb-1">
                        <div class="custom-file">
                            <input class="inputFile w-100" type="file" 
                                    ng-file-select="onFileSelect($files)" 
                                    edit-content-url="contCtrl.editContentUrl" 
                                    content-item='contCtrl.editItem' 
                                    cms-type-id='contCtrl.cmsTypeId' 
                                    ng-model="contCtrl.editItem.imageSrc" 
                                    class="custom-file-input form-control-use line-style" 
                                    id="file-@{{contCtrl.editItem.key}}" 
                                    ng-key="contCtrl.editItem.key" 
                                    value="">
                            <label class="custom-file-label" for="file-@{{contCtrl.editItem.key}}">選擇檔案</label>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="cms mark-use">
                            建議上傳尺寸寬度為
                            <span ng-if="contCtrl.editItem.seg == 12">1140px</span>
                            <span ng-if="contCtrl.editItem.seg < 12 && contCtrl.editItem.seg >= 6">600px</span>
                            <span ng-if="contCtrl.editItem.seg < 6 && contCtrl.editItem.seg >= 4">400px</span>
                            <span ng-if="contCtrl.editItem.seg < 4 && contCtrl.editItem.seg >= 3">300px</span>
                            <span ng-if="contCtrl.editItem.seg < 3">270px</span>
                            ，圖會隨版面寬度100%縮放
                        </span>
                        <div>
                            <button class='btn btn-secondary cmsBtn-use cmsBtn-use btn-use line-style' ng-click='contCtrl.removeImg(contCtrl.editItem)'>刪除圖片</button>
                        </div>
                    </div>
                </div>
            </div>
            <span class="use-sp-title">圖片連結：(請包含http:// 或 https:// 或 使用相對路徑)</span>
            <input type='checkbox' id="img_link_open-@{{contCtrl.editItem.cmsId}}" 
                   ng-model='contCtrl.editItem.img_link_open' ng-change="contCtrl.changeItem(contCtrl.editItem)"/>
            <label class="form-check-label" for="img_link_open-@{{contCtrl.editItem.cmsId}}">新分頁開啟</label>
            <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.img_link' 
                   ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
        </div>
        <div class="col-6 mb-2" ng-if='contCtrl.editItem.type == "img"'>
            <span class="use-sp-title">圖片區寬度</span><br>
            <input class="form-control form-control-use line-style w-50 d-inline" type='number' min="0" step="1"
                   ng-model='contCtrl.editItem.template.img_width' 
                   ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
            <span class="ml-2">px</span>
        </div>
    </div>
    <hr class="w-100">

    <!-- 內容設定 -->
    <div class="row m-0">
        <h5>內容設定：<span class="cms mark-use">可使用 Shift + Enter 建立較小間距的換行</span></h5></h5>
        <div class="col-12">
            <input type='checkbox' id="cont_indent-@{{contCtrl.editItem.cmsId}}" 
                   ng-model='contCtrl.editItem.cont.indent' ng-change="contCtrl.changeItem(contCtrl.editItem)"
                   ng-true-value="'indent'" ng-false-value="''"/>
            <label class="form-check-label" for="cont_indent-@{{contCtrl.editItem.cmsId}}">縮排</label>&nbsp;&nbsp;
            <input type='checkbox' id="l-conShow-@{{contCtrl.editItem.cmsId}}" 
                   ng-model='contCtrl.editItem.cont.show' ng-change="contCtrl.changeItem(contCtrl.editItem)"/>
            <label class="form-check-label" for="l-conShow-@{{contCtrl.editItem.cmsId}}">顯示內容</label>&nbsp;&nbsp;
            <input type='checkbox' id="l-conSpace-@{{contCtrl.editItem.cmsId}}" 
                   ng-model='contCtrl.editItem.cont.space' ng-change="contCtrl.changeItem(contCtrl.editItem)"/>
            <label class="form-check-label" for="l-conSpace-@{{contCtrl.editItem.cmsId}}">加大下間距</label>

            <div class="d-inline-block mr-3">
                字體大小：
                <select ng-model='contCtrl.editItem.cont.size' ng-change="contCtrl.modifyTemplateName(contCtrl.editItem)">
                    <option value="">一般</option>
                    <option value="font_medium">中字體</option>
                    <option value="font_big">大字體</option>
                </select>
            </div>

            <span ng-if='contCtrl.editItem.type == "img"'>
                <input type='checkbox' id="order_class-@{{contCtrl.editItem.cmsId}}" 
                       ng-model='contCtrl.editItem.cont.order_class' ng-change="contCtrl.changeItem(contCtrl.editItem)"
                       ng-true-value="'order-1'" ng-false-value="'order-3'"/>
                <label class="form-check-label" for="order_class-@{{contCtrl.editItem.cmsId}}">顯示於圖片之上</label>
            </span>

            <div class="row">
                <div class="col-md-12 use-box-btm">
                    <div class="collapse show" id="content@{{contCtrl.editItem.cmsId}}">
                        <div summernote ng-model="contCtrl.editItem.cont.text" config="noteOptions" int="@{{contCtrl.editItem.key}}"></div>
                        <div class="cms mark-use">
                            <span>
                                <ul>
                                    <li>編輯器新增的圖片，需要針對圖片按右鍵做100%設定，才可隨著版面寬度縮放。</li>
                                    <li>內中的iframe將自動設定與區塊預設高度相同。</li>
                                </ul>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 mb-2">
            <span class="use-sp-title">內容區寬度</span><br>
            <input class="form-control form-control-use line-style w-50 d-inline" type='number' min="0" step="1"
                   ng-model='contCtrl.editItem.cont.width' 
                   ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
            <span class="ml-2">px</span>
        </div>
    </div>