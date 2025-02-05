
<h5 class="row m-0">版型：
    <span class="use-sp-title _ly_title template_ly_title">
        <select ng-model="contCtrl.editItem.name" ng-change="contCtrl.modifyTemplateName(contCtrl.editItem)"
                ng-options="option.show_name as option.show_name for option in contCtrl.get_template_option('twoimg_and_text')">
        </select>
    </span>

    <div class="col-12"></div>
    <div class="col-6 mb-2" ng-if="['雙圖中', '雙上圖', '雙圖雙背色'].indexOf(contCtrl.editItem.name)!=-1"> 
        <span class="use-sp-title">背景色(請輸入#字號+6碼的色號)</span>
        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.bg_color' 
               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
    </div>
    <div class="col-6 mb-2" ng-if="['雙圖中', '雙上圖', '雙圖雙背色'].indexOf(contCtrl.editItem.name)!=-1"> 
        <span class="use-sp-title">文字色(請輸入#字號+6碼的色號)</span>
        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.tilte_main_color' 
               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
    </div>
    <div class="col-6 mb-2" ng-if="['雙圖雙背色'].indexOf(contCtrl.editItem.name)!=-1"> 
        <span class="use-sp-title">文字區背景色(請輸入#字號+6碼的色號)</span>
        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.text_area_bg_color' 
               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
    </div>
    <div class="col-6 mb-2" ng-if="['雙圖雙背色'].indexOf(contCtrl.editItem.name)!=-1"> 
        <span class="use-sp-title">標題背景色(請輸入#字號+6碼的色號)</span>
        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.tilte_bg_color' 
               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
    </div>
</h5>
<div class="col-12 row">
	<h5 class="w-100">區塊1：</h5>

	<div class="col-12"></div>
	<div class="col-6 mb-2" ng-if="contCtrl.editItem.name=='雙圖下文'"> 
        <span class="use-sp-title">背景色(請輸入#字號+6碼的色號)</span>
        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.bg_color' 
               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
    </div>
    <div class="col-6 mb-2" ng-if="contCtrl.editItem.name=='雙圖下文'"> 
        <span class="use-sp-title">文字色(請輸入#字號+6碼的色號)</span>
        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.tilte_main_color' 
               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
    </div>

	<!-- 圖片設定 -->
	<div class="col-12 row m-0">
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
		                    <span class="cms mark-use" ng-if="contCtrl.editItem.name=='雙圖中'">
		                        700*450px
		                    </span>
		                    <span ng-if="contCtrl.editItem.name=='雙上圖' || contCtrl.editItem.name=='雙圖雙背色'">
		                        713*481px
		                    </span>
		                    <span class="cms mark-use" ng-if="contCtrl.editItem.name=='雙圖下文'">
		                        957*764px
		                    </span>
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
	</div>

	<!-- 其他設定 -->
	<div class="col-12 row m-0">
	    <h5>文字區塊設定：</h5>
	    <div class="col-12"></div>

	    <div class="col-12 mb-2"> 
	        <span class="use-sp-title">副標題</span><span class="cms mark-use">可輸入&lt;br&gt;進行強制換行</span>
	        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.tilte_second' 
	               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
	    </div>
	    <div class="col-12 mb-2"> 
	        <span class="use-sp-title">大標題</span>
	        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.tilte_main' 
	               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
	    </div>
	    <div class="col-12 mb-2"> 
	        <span class="use-sp-title">說明文字</span><span class="cms mark-use">可輸入&lt;br&gt;進行強制換行</span>
	        <textarea class="form-control form-control-use line-style" type='text' rows="4" 
	               ng-model='contCtrl.editItem.template.tilte_sub' 
	               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
	        </textarea>
	    </div>
	</div>
</div>
<hr class="col-12">

<div class="col-12 row">
	<h5 class="w-100">區塊2：</h5>

	<div class="col-12"></div>
	<div class="col-6 mb-2" ng-if="contCtrl.editItem.name=='雙圖下文'"> 
        <span class="use-sp-title">背景色(請輸入#字號+6碼的色號)</span>
        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.bg_color2' 
               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
    </div>
    <div class="col-6 mb-2" ng-if="contCtrl.editItem.name=='雙圖下文'"> 
        <span class="use-sp-title">文字色(請輸入#字號+6碼的色號)</span>
        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.tilte_main_color2' 
               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
    </div>

	<!-- 圖片設定 -->
	<div class="col-12 row m-0">
	    <h5>圖片設定：</h5>
	    <div class="col-12  use-box-btm mb-3">
	        <div class="cms-upload-img-box">
	            <div class="img-box">
	                <div class="adminImg-responsive-1By1"
	                	 ng-style="{'background-image': 'url('+contCtrl.editItem.template.pic_1+')'}"></div>
	            </div>                                      
	            <div class="upload-box">
	                <div class="input-group mb-1">
	                    <div class="custom-file">
	                        <input class="inputFile w-100" type="file" 
	                                ng-file-select="onFileSelect($files)" 
	                                edit-content-url="contCtrl.editContentUrl" 
	                                template-virable="'pic_1'"
	                                content-item='contCtrl.editItem' 
	                                cms-type-id='contCtrl.cmsTypeId' 
	                                ng-model="contCtrl.editItem.template.pic_1" 
	                                class="custom-file-input form-control-use line-style" 
	                                id="file-pic_1-@{{contCtrl.editItem.key}}" 
	                                ng-key="contCtrl.editItem.key" 
	                                value="">
	                        <label class="custom-file-label" for="file-pic_1-@{{contCtrl.editItem.key}}">選擇檔案</label>
	                    </div>
	                </div>
	                <div class="d-flex justify-content-between align-items-center">
	                	<span class="cms mark-use">
	                		建議上傳尺寸為
		                    <span class="cms mark-use" ng-if="contCtrl.editItem.name=='雙圖中'">
		                        700*450px
		                    </span>
		                    <span ng-if="contCtrl.editItem.name=='雙上圖' || contCtrl.editItem.name=='雙圖雙背色'">
		                        713*481px
		                    </span>
		                    <span class="cms mark-use" ng-if="contCtrl.editItem.name=='雙圖下文'">
		                        957*764px
		                    </span>
		                </span>
	                    <div>
	                        <button class='btn btn-secondary cmsBtn-use cmsBtn-use btn-use line-style' ng-click='contCtrl.removeImg(contCtrl.editItem, "pic_1")'>刪除圖片</button>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	    <!-- <div class="col-12 mb-3">
	        <span class="use-sp-title">圖片連結：(請包含http:// 或 https:// 或 使用相對路徑)</span>
	        <input type='checkbox' id="img_link_open2-@{{contCtrl.editItem.cmsId}}" 
	               ng-model='contCtrl.editItem.img_link_open2' ng-change="contCtrl.changeItem(contCtrl.editItem)"/>
	        <label class="form-check-label" for="img_link_open2-@{{contCtrl.editItem.cmsId}}">新分頁開啟</label>
	        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.img_link2' 
	               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
	    </div> -->
	</div>

	<!-- 其他設定 -->
	<div class="col-12 row m-0">
	    <h5>文字區塊設定：</h5>
	    <div class="col-12"></div>

	    <div class="col-12 mb-2"> 
	        <span class="use-sp-title">副標題</span><span class="cms mark-use">可輸入&lt;br&gt;進行強制換行</span>
	        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.tilte_second2' 
	               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
	    </div>
	    <div class="col-12 mb-2"> 
	        <span class="use-sp-title">大標題</span>
	        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.tilte_main2' 
	               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
	    </div>
	    <div class="col-12 mb-2"> 
	        <span class="use-sp-title">說明文字</span><span class="cms mark-use">可輸入&lt;br&gt;進行強制換行</span>
	        <textarea class="form-control form-control-use line-style" type='text' rows="4" 
	               ng-model='contCtrl.editItem.template.tilte_sub_2' 
	               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
	        </textarea>
	    </div>
	</div>
</div>