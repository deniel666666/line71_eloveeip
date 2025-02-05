
<!-- 圖片設定 -->
<h5>版型：
    <span class="use-sp-title _ly_title @{{contCtrl.editItem.type}}_ly_title">
        <select ng-model="contCtrl.editItem.name" ng-change="contCtrl.modifyTemplateName(contCtrl.editItem)"
                ng-options="option.show_name as option.show_name for option in contCtrl.get_template_option('template')">
        </select>
    </span>
</h5>
<div class="row m-0">
    <h5>圖片設定：</h5>
    <div class="col-12  use-box-btm mb-3">
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
                        建議上傳尺寸為
                        <span ng-if="['左滿圖右字', '右滿圖左字'].indexOf(contCtrl.editItem.name) !=-1">1920*576px，重點請放置於左側</span>
                        <span ng-if="['左字右圖', '左圖右字'].indexOf(contCtrl.editItem.name) !=-1">555*505px</span>
                        <span ng-if="['全版圖上字'].indexOf(contCtrl.editItem.name) !=-1">1920*855px</span>
                        <span ng-if="['全版圖右字', '全版圖左字'].indexOf(contCtrl.editItem.name) !=-1">1920*576px</span>
                        <span ng-if="['半版左', '半版右'].indexOf(contCtrl.editItem.name) !=-1">387*300px</span>
                        <span ng-if="['三分之一版'].indexOf(contCtrl.editItem.name) !=-1">276*300px</span>
                    </span>
                    <div>
                        <button class='btn btn-secondary cmsBtn-use cmsBtn-use btn-use line-style' ng-click='contCtrl.removeImg(contCtrl.editItem)'>刪除圖片</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="col-12 mb-3">
        <span class="use-sp-title">圖片連結：(請包含http:// 或 https:// 或 使用相對路徑)</span>
        <input type='checkbox' id="img_link_open-@{{contCtrl.editItem.cmsId}}" 
               ng-model='contCtrl.editItem.img_link_open' ng-change="contCtrl.changeItem(contCtrl.editItem)"/>
        <label class="form-check-label" for="img_link_open-@{{contCtrl.editItem.cmsId}}">新分頁開啟</label>
        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.img_link' 
               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
    </div> -->
    <div class="col-6 mb-3"
         ng-if="['tmp_left_full_img_right_text', 'tmp_right_full_img_left_text'].indexOf(contCtrl.editItem.template.viewBlade) != -1">
        <span class="use-sp-title">圖片最小高度：</span><br>
        <input class="form-control form-control-use line-style w-50 d-inline" type='number' min="0" step="1"
               ng-model='contCtrl.editItem.template.img_min_height' 
               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
        <span class="ml-2">px</span>
    </div>
</div>
<hr class="w-100 mb-2">

<!-- 其他設定 -->
<div class="row m-0">
    <h5>文字區塊設定：</h5>
    <div class="col-12">
        <span class="d-inline-block"
              ng-if="['tmp_left_full_img_right_text', 'tmp_right_full_img_left_text', 
                      'tmp_full_img_right_text', 'tmp_full_img_left_text'].indexOf(contCtrl.editItem.template.viewBlade) != -1">
            <input type='checkbox' ng-model='contCtrl.editItem.template.text_area_extend' id="text_area_extend-@{{contCtrl.editItem.cmsId}}" 
                   ng-change="contCtrl.changeItem(contCtrl.editItem)"
                   ng-true-value="'w-100'" ng-false-value="'container w1400'"/>
            <label class="form-check-label" for="text_area_extend-@{{contCtrl.editItem.cmsId}}">文字區塊外擴</label>
        </span>
    </div>

    <div class="col-6 mb-2"> 
        <span class="use-sp-title">文字區塊背景色(請輸入#字號+6碼的色號)</span>
        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.bg_color' 
               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
    </div>
    <div class="col-6 mb-2"> 
        <span class="use-sp-title">文字色(請輸入#字號+6碼的色號)</span>
        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.tilte_color' 
               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
    </div>
    <div class="col-6 mb-2"> 
        <span class="use-sp-title">文字對齊區塊方式(預設置中)</span>
        <select ng-model='contCtrl.editItem.template.text_align' ng-change="contCtrl.modifyItem(contCtrl.editItem, 2)"
                class="form-control form-control-use line-style">
            <option value="text-left">置左</option>
            <option value="text-center">置中</option>
            <option value="text-right">置右</option>
        </select>
    </div>
    <div class="col-6 mb-2"> 
        <span class="use-sp-title">文字區塊寬度</span><br>
        <input class="form-control form-control-use line-style w-50 d-inline" type='number' min="0" step="1"
               ng-model='contCtrl.editItem.template.text_width' 
               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
        <span class="ml-2">px</span>
    </div>

    <div class="col-12 mb-2"> 
        <span class="use-sp-title">副標題</span>
        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.tilte_second' 
               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
    </div>
    <div class="col-12 mb-2"> 
        <span class="use-sp-title">大標題</span>
        <span class="d-inline-block ml-3">
            <input type='checkbox' ng-model='contCtrl.editItem.template.tilte_main_big' id="tilte_main_big-@{{contCtrl.editItem.cmsId}}" 
                   ng-change="contCtrl.changeItem(contCtrl.editItem)"
                   ng-true-value="'font_big'"/>
            <label class="form-check-label" for="tilte_main_big-@{{contCtrl.editItem.cmsId}}">加大字體</label>
        </span>
        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.tilte_main' 
               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
    </div>
    <div class="col-12 mb-2"> 
        <span class="use-sp-title">次標題</span><span class="cms mark-use">可輸入&lt;br&gt;進行強制換行</span>
        <textarea class="form-control form-control-use line-style" type='text' rows="4" 
               ng-model='contCtrl.editItem.template.tilte_sub' 
               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
        </textarea>
    </div>
    <div class="col-12 mb-2"> 
        <span class="use-sp-title">小標題</span>
        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.tilte_small' 
               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
    </div>

    <hr class="col-12 p-0">

    <div class="col-12 mb-2"> 
        <span class="use-sp-title">按鈕文字(若不輸入，則隱藏按鈕)</span>
        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.btn_text' 
               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
    </div>
    <div class="col-6 mb-2"> 
        <span class="use-sp-title">按鈕文字背景色(請輸入#字號+6碼的色號)</span>
        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.btn_bg_color' 
               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
    </div>
    <div class="col-6 mb-2"> 
        <span class="use-sp-title">按鈕文字色(請輸入#字號+6碼的色號)</span>
        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.btn_color' 
               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
    </div>
    
    <div class="col-12 mb-2"> 
        <span class="use-sp-title">按鈕連結(請包含http:// 或 https:// 或 使用相對路徑)</span>
        <input type='checkbox' id="btn_link_open-@{{contCtrl.editItem.cmsId}}" 
               ng-model='contCtrl.editItem.template.btn_link_open' ng-change="contCtrl.changeItem(contCtrl.editItem)"/>
        <label class="form-check-label" for="btn_link_open-@{{contCtrl.editItem.cmsId}}">新分頁開啟</label>
        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.btn_link' 
               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
    </div>
</div>
<hr class="w-100">

<div class="row m-0">
    <div class="col-12 mb-2"> 
        <span class="use-sp-title">文字連結文字(若不輸入，則隱藏按鈕)</span>
        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.atext_text' 
               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
    </div>
    <div class="col-6 mb-2"> 
        <span class="use-sp-title">文字連結色(請輸入#字號+6碼的色號)</span>
        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.atext_color' 
               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
    </div>
    <div class="col-12 mb-2"> 
        <span class="use-sp-title">文字連結連結(請包含http:// 或 https:// 或 使用相對路徑)</span>
        <input type='checkbox' id="atext_link_open-@{{contCtrl.editItem.cmsId}}" 
               ng-model='contCtrl.editItem.template.atext_link_open' ng-change="contCtrl.changeItem(contCtrl.editItem)"/>
        <label class="form-check-label" for="atext_link_open-@{{contCtrl.editItem.cmsId}}">新分頁開啟</label>
        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.atext_link' 
               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
    </div>
</div>