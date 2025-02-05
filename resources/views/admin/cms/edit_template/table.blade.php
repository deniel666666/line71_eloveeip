<h5 class="row m-0">版型：
    <span class="use-sp-title _ly_title template_ly_title">
        <select ng-model="contCtrl.editItem.name" ng-change="contCtrl.modifyTemplateName(contCtrl.editItem)"
                ng-options="option.show_name as option.show_name for option in contCtrl.get_template_option('table')">
        </select>
    </span>

    <div class="col-12"></div> 
    <div class="col-6 mb-2"> 
        <span class="use-sp-title">區塊背景色(請輸入#字號+6碼的色號)</span>
        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.bg_color' 
               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
    </div>
</h5>

<div class="row m-0">
    <!-- 表頭設定 -->
    <h5>表頭設定：<span class="cms mark-use">欄位1表頭只在手機板顯示</span></h5>
    <div class="col-12"></div>
    <!-- <div class="col-6 mb-2"> 
        <span class="use-sp-title">背景色(請輸入#字號+6碼的色號)</span>
        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.thead_bg_color' 
               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
    </div>
    <div class="col-6 mb-2"> 
        <span class="use-sp-title">文字色(請輸入#字號+6碼的色號)</span>
        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.thead_color' 
               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
    </div> -->

    <div class="col-3 mb-2"> 
        <span class="use-sp-title">欄位1</span></h5>
        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.thead1' 
               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
    </div>
    <div class="col-3 mb-2"> 
        <span class="use-sp-title">欄位2</span>
        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.thead2' 
               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
    </div>
    <div class="col-3 mb-2"> 
        <span class="use-sp-title">欄位3</span>
        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.thead3' 
               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
    </div>
    <div class="col-3 mb-2"> 
        <span class="use-sp-title">欄位4</span>
        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.thead4' 
               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
    </div>
</div>
<hr class="w-100 mb-2">

<div class="row m-0">
    <!-- 表頭設定 -->
    <h5>資料設定：<span class="cms mark-use">都沒輸入則會隱藏此列</span></h5>
    <div class="col-12"></div>
    <!-- <div class="col-6 mb-2"> 
        <span class="use-sp-title">文字色(請輸入#字號+6碼的色號)</span>
        <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.tbody_color' 
               ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
    </div> -->
    <div class="col-12 row m-0 p-0">
        <h6 class="col-12">資料1：</h6>
        <div class="col-3 mb-2"> 
            <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.data1_1' 
                   ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
        </div>
        <div class="col-3 mb-2"> 
            <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.data1_2' 
                   ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
        </div>
        <div class="col-3 mb-2"> 
            <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.data1_3' 
                   ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
        </div>
        <div class="col-3 mb-2"> 
            <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.data1_4' 
                   ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
        </div>
    </div>

    <div class="col-12 row m-0 p-0">
        <h6 class="col-12">資料2：</h6>
        <div class="col-3 mb-2"> 
            <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.data2_1' 
                   ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
        </div>
        <div class="col-3 mb-2"> 
            <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.data2_2' 
                   ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
        </div>
        <div class="col-3 mb-2"> 
            <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.data2_3' 
                   ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
        </div>
        <div class="col-3 mb-2"> 
            <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.data2_4' 
                   ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
        </div>
    </div>

    <div class="col-12 row m-0 p-0">
        <h6 class="col-12">資料3：</h6>
        <div class="col-3 mb-2"> 
            <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.data3_1' 
                   ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
        </div>
        <div class="col-3 mb-2"> 
            <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.data3_2' 
                   ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
        </div>
        <div class="col-3 mb-2"> 
            <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.data3_3' 
                   ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
        </div>
        <div class="col-3 mb-2"> 
            <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.data3_4' 
                   ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
        </div>
    </div>

    <div class="col-12 row m-0 p-0">
        <h6 class="col-12">資料4：</h6>
        <div class="col-3 mb-2"> 
            <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.data4_1' 
                   ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
        </div>
        <div class="col-3 mb-2"> 
            <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.data4_2' 
                   ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
        </div>
        <div class="col-3 mb-2"> 
            <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.data4_3' 
                   ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
        </div>
        <div class="col-3 mb-2"> 
            <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.data4_4' 
                   ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
        </div>
    </div>

    <div class="col-12 row m-0 p-0">
        <h6 class="col-12">資料5：</h6>
        <div class="col-3 mb-2"> 
            <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.data5_1' 
                   ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
        </div>
        <div class="col-3 mb-2"> 
            <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.data5_2' 
                   ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
        </div>
        <div class="col-3 mb-2"> 
            <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.data5_3' 
                   ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
        </div>
        <div class="col-3 mb-2"> 
            <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.data5_4' 
                   ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
        </div>
    </div>

    <div class="col-12 row m-0 p-0">
        <h6 class="col-12">資料6：</h6>
        <div class="col-3 mb-2"> 
            <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.data6_1' 
                   ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
        </div>
        <div class="col-3 mb-2"> 
            <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.data6_2' 
                   ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
        </div>
        <div class="col-3 mb-2"> 
            <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.data6_3' 
                   ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
        </div>
        <div class="col-3 mb-2"> 
            <input class="form-control form-control-use line-style" type='text' ng-model='contCtrl.editItem.template.data6_4' 
                   ng-blur="contCtrl.modifyItem(contCtrl.editItem, 2)" ng-focus="contCtrl.textRecording(contCtrl.editItem)"/>
        </div>
    </div>
</div>
