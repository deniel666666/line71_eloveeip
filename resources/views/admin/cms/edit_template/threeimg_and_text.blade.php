
<h5 class="row m-0">版型：
    <span class="use-sp-title _ly_title template_ly_title">
        <select ng-model="contCtrl.editItem.name" ng-change="contCtrl.modifyTemplateName(contCtrl.editItem)"
                ng-options="option.show_name as option.show_name for option in contCtrl.get_template_option('threeimg_and_text')">
        </select>
    </span>

    <div class="col-12"></div>
    <div class="col-6 mb-2"> 
        <span class="use-sp-title">背景色(請輸入#字號+6碼的色號)</span>
        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.bg_color' 
               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
    </div>
</h5>
<div class="col-12 row">
	<h5 class="w-100">區塊
		<span ng-if="contCtrl.editItem.name=='1左2右' || contCtrl.editItem.name=='2左1右'">(小)：</span>
		<span ng-if="contCtrl.editItem.name!='1左2右' && contCtrl.editItem.name!='2左1右'">1：</span>
	</h5>

	<div class="col-12"></div>
    <div class="col-6 mb-2"> 
        <span class="use-sp-title">區塊背景色(請輸入#字號+6碼的色號)</span>
        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.bg_color1' 
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
		                    <span ng-if="contCtrl.editItem.name=='3圖文'">
		                        991*580px，重點請放置於中間
		                    </span>
		                    <span ng-if="contCtrl.editItem.name=='1左2右'">
		                        455*310px
		                    </span>
		                    <span ng-if="contCtrl.editItem.name=='2左1右'">
		                        455*310px
		                    </span>
		                    <span ng-if="contCtrl.editItem.name=='1左1右'">
		                        850*430px，填滿區塊請用 840*700px
		                    </span>
		                    <span ng-if="contCtrl.editItem.name=='滿圖文'">
		                        1310*590px，重點請放置於中間
		                    </span>
		                </span>
	                    <div>
	                        <button class='btn btn-secondary cmsBtn-use cmsBtn-use btn-use line-style' ng-click='contCtrl.removeImg(contCtrl.editItem, "pic_1")'>刪除圖片</button>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

	<!-- 其他設定 -->
	<div class="col-12 row m-0">
	    <h5>文字區塊設定：</h5>
	    <div class="col-12"></div>

	    <!-- <div class="col-12 mb-2"> 
	        <span class="use-sp-title">副標題</span>
	        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.tilte_second' 
	               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
	    </div> -->
	    <div class="col-12 mb-2"> 
	        <span class="use-sp-title">大標題</span><span class="cms mark-use">可輸入&lt;br&gt;進行強制換行</span>
	        <div class="d-inline-block ml-3">
                水平對齊：(預設置左)
                <select ng-model='contCtrl.editItem.template.tilte_main_align' ng-change="contCtrl.modifyTemplateName(contCtrl.editItem)">
                    <option value="left">置左</option>
                    <option value="center">置中</option>
                    <option value="right">置右</option>
                </select>
            </div>
	        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.tilte_main' 
	               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
	    </div>
	    <div class="col-6 mb-2"> 
	        <span class="use-sp-title">標題文字色(請輸入#字號+6碼的色號)</span>
	        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.text_color1' 
	               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
	    </div>
	    <div summernote ng-model="contCtrl.editItem.template.content_1" config="noteOptions" int="@{{contCtrl.editItem.key}}"></div>
	</div>

	<hr class="col-12">
</div>

<div class="col-12 row" ng-if="contCtrl.editItem.name!='滿圖文'">
	<h5 class="w-100">區塊
		<span ng-if="contCtrl.editItem.name=='1左2右' || contCtrl.editItem.name=='2左1右'">(大)：</span>
		<span ng-if="contCtrl.editItem.name!='1左2右' && contCtrl.editItem.name!='2左1右'">2：</span>
	</h5>

	<div class="col-12"></div>
    <div class="col-6 mb-2"> 
        <span class="use-sp-title">區塊背景色(請輸入#字號+6碼的色號)</span>
        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.bg_color2' 
               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
    </div>

	<!-- 圖片設定 -->
	<div class="col-12 row m-0">
	    <h5>圖片設定：</h5>
	    <div class="col-12  use-box-btm mb-3">
	        <div class="cms-upload-img-box">
	            <div class="img-box">
	                <div class="adminImg-responsive-1By1"
	                	 ng-style="{'background-image': 'url('+contCtrl.editItem.template.pic_2+')'}"></div>
	            </div>                                      
	            <div class="upload-box">
	                <div class="input-group mb-1">
	                    <div class="custom-file">
	                        <input class="inputFile w-100" type="file" 
	                                ng-file-select="onFileSelect($files)" 
	                                edit-content-url="contCtrl.editContentUrl" 
	                                template-virable="'pic_2'"
	                                content-item='contCtrl.editItem' 
	                                cms-type-id='contCtrl.cmsTypeId' 
	                                ng-model="contCtrl.editItem.template.pic_2" 
	                                class="custom-file-input form-control-use line-style" 
	                                id="file-pic_2-@{{contCtrl.editItem.key}}" 
	                                ng-key="contCtrl.editItem.key" 
	                                value="">
	                        <label class="custom-file-label" for="file-pic_2-@{{contCtrl.editItem.key}}">選擇檔案</label>
	                    </div>
	                </div>
	                <div class="d-flex justify-content-between align-items-center">
	                	<span class="cms mark-use">
	                		建議上傳尺寸為 
		                    <span ng-if="contCtrl.editItem.name=='3圖文'">
		                        991*580px，重點請放置於中間
		                    </span>
		                    <span ng-if="contCtrl.editItem.name=='1左2右'">
		                        405*610px
		                    </span>
		                    <span ng-if="contCtrl.editItem.name=='2左1右'">
		                        405*610px
		                    </span>
		                    <span ng-if="contCtrl.editItem.name=='1左1右'">
		                        850*430px，填滿版區塊請用 840*700px
		                    </span>
		                </span>
	                    <div>
	                        <button class='btn btn-secondary cmsBtn-use cmsBtn-use btn-use line-style' ng-click='contCtrl.removeImg(contCtrl.editItem, "pic_2")'>刪除圖片</button>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

	<!-- 其他設定 -->
	<div class="col-12 row m-0">
	    <h5>文字區塊設定：</h5>
	    <div class="col-12"></div>

	    <!-- <div class="col-12 mb-2"> 
	        <span class="use-sp-title">副標題</span>
	        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.tilte_second2' 
	               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
	    </div> -->
	    <div class="col-12 mb-2"> 
	        <span class="use-sp-title">大標題</span><span class="cms mark-use">可輸入&lt;br&gt;進行強制換行</span>
	        <div class="d-inline-block ml-3">
                水平對齊：(預設置左)
                <select ng-model='contCtrl.editItem.template.tilte_main_align2' ng-change="contCtrl.modifyTemplateName(contCtrl.editItem)">
                    <option value="left">置左</option>
                    <option value="center">置中</option>
                    <option value="right">置右</option>
                </select>
            </div>
	        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.tilte_main2' 
	               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
	    </div>
	    <div class="col-6 mb-2"> 
	        <span class="use-sp-title">標題文字色(請輸入#字號+6碼的色號)</span>
	        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.text_color2' 
	               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
	    </div>
	    <div summernote ng-model="contCtrl.editItem.template.content_2" config="noteOptions" int="@{{contCtrl.editItem.key}}"></div>
	</div>
	
	<hr class="col-12">
</div>

<div class="col-12 row" ng-if="contCtrl.editItem.name=='3圖文'">
	<h5 class="w-100">區塊3：</h5>

	<div class="col-12"></div>
    <div class="col-6 mb-2"> 
        <span class="use-sp-title">區塊背景色(請輸入#字號+6碼的色號)</span>
        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.bg_color3' 
               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
    </div>

	<!-- 圖片設定 -->
	<div class="col-12 row m-0">
	    <h5>圖片設定：</h5>
	    <div class="col-12  use-box-btm mb-3">
	        <div class="cms-upload-img-box">
	            <div class="img-box">
	                <div class="adminImg-responsive-1By1"
	                	 ng-style="{'background-image': 'url('+contCtrl.editItem.template.pic_3+')'}"></div>
	            </div>                                      
	            <div class="upload-box">
	                <div class="input-group mb-1">
	                    <div class="custom-file">
	                        <input class="inputFile w-100" type="file" 
	                                ng-file-select="onFileSelect($files)" 
	                                edit-content-url="contCtrl.editContentUrl" 
	                                template-virable="'pic_3'"
	                                content-item='contCtrl.editItem' 
	                                cms-type-id='contCtrl.cmsTypeId' 
	                                ng-model="contCtrl.editItem.template.pic_3" 
	                                class="custom-file-input form-control-use line-style" 
	                                id="file-pic_3-@{{contCtrl.editItem.key}}" 
	                                ng-key="contCtrl.editItem.key" 
	                                value="">
	                        <label class="custom-file-label" for="file-pic_3-@{{contCtrl.editItem.key}}">選擇檔案</label>
	                    </div>
	                </div>
	                <div class="d-flex justify-content-between align-items-center">
	                	<span class="cms mark-use">
	                		建議上傳尺寸為 
		                    <span ng-if="contCtrl.editItem.name=='3圖文'">
		                        991*580px，重點請放置於中間
		                    </span>
		                </span>
	                    <div>
	                        <button class='btn btn-secondary cmsBtn-use cmsBtn-use btn-use line-style' ng-click='contCtrl.removeImg(contCtrl.editItem, "pic_3")'>刪除圖片</button>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

	<!-- 其他設定 -->
	<div class="col-12 row m-0">
	    <h5>文字區塊設定：</h5>
	    <div class="col-12"></div>

	    <!-- <div class="col-12 mb-2"> 
	        <span class="use-sp-title">副標題</span>
	        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.tilte_second3' 
	               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
	    </div> -->
	    <div class="col-12 mb-2"> 
	        <span class="use-sp-title">大標題</span><span class="cms mark-use">可輸入&lt;br&gt;進行強制換行</span>
	        <div class="d-inline-block ml-3">
                水平對齊：(預設置左)
                <select ng-model='contCtrl.editItem.template.tilte_main_align3' ng-change="contCtrl.modifyTemplateName(contCtrl.editItem)">
                    <option value="left">置左</option>
                    <option value="center">置中</option>
                    <option value="right">置右</option>
                </select>
            </div>
	        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.tilte_main3' 
	               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
	    </div>
	    <div class="col-6 mb-2"> 
	        <span class="use-sp-title">標題文字色(請輸入#字號+6碼的色號)</span>
	        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.text_color3' 
	               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
	    </div>
	    <div summernote ng-model="contCtrl.editItem.template.content_3" config="noteOptions" int="@{{contCtrl.editItem.key}}"></div>
	</div>
</div>