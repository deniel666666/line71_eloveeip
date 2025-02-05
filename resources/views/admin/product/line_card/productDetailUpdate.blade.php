@extends('admin.product.line_card.productMainCreate')

@section('act_name')
    <li class="breadcrumb-item active" aria-current="page">修改細節</li>
@endsection

@section('select_lang')
    <!-- <div>
        <span class="use-sp-title">語系：</span>
        <div>
            <span ng-bind="contCtrl.lang.lang_word"></span>
        </div>                        
    </div> -->
@endsection

@section('bottom_btn')
    <div class="row">
        <div class="col-12">
            <a ng-if="contCtrl.need_content" href="" class="btn btn-info w-100 mb-2" ng-click='contCtrl.goToEditPage()'>編輯詳細內容</a>
            <button class="btn btn-secondary btn-block" ng-click='contCtrl.backToProduct()'>返回列表</button>
        </div>
    </div>
@endsection

<script type="text/javascript">
    @section('angular_js')
        self.getItems = function() {
            let data = { 'productId': self.productId };
            $http({
                method: "post",
                data: data,
                url: self.listUrl,
            }).success(function(data) {
                console.log(data);
                self.categoryTags = data.categoryTags;
                
                var downSelectVal=[];
                angular.forEach(self.categoryTags, function(item ,key ) {
                    if(self.categoryTags[key].status == 1){
                        downSelectVal.push('number:'+self.categoryTags[key].cate_tag_id)
                    }
                });

                setTimeout(function() {
                    self.select();
                    $('.downSelect').val(downSelectVal);
                    $('.downSelect').selectMania('update');
                }, 50);

                self.lang = data.lang;
                self.item = data.item;
                self.setLayoutImageSize(self.item.style);
                // console.log(self.item);
                // self.item.prod_s_datetime =Date.parse(new Date(self.item.prod_s_datetime));
                self.item.prod_e_datetime = self.item.prod_e_datetime.split(' ')[0];

                //----------------------------------------------------------------
                //----------------------------------------------------------------
                //----------------------------------------------------------------
                //----------------------------------------------------------------
                $('#proShowStartTime').datetimepicker({
                    defaultDate: self.item.prod_show_s_datetime ,
                    locale: 'zh-tw',
                    format: 'YYYY-MM-D',
                    ignoreReadonly: true,
                    icons: {
                        time: "fa fa-clock-o",
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    }
                });

                $('#proShowEndTime').datetimepicker({
                    defaultDate: self.item.prod_show_e_datetime ,
                    locale: 'zh-tw',
                    format: 'YYYY-MM-D',
                    ignoreReadonly: true,
                    icons: {
                        time: "fa fa-clock-o",
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    }
                });

                $("#proShowStartTime").on("change.datetimepicker", function (e) {
                    $('#proShowEndTime').datetimepicker('minDate', e.date);
                });

                $("#proShowEndTime").on("change.datetimepicker", function (e) {
                    $('#proShowStartTime').datetimepicker('maxDate', e.date);
                });

                // ----------------------------------------------------------------------------

                $('#proStartTime').datetimepicker({
                    defaultDate: self.item.prod_s_datetime ,
                    locale: 'zh-tw',
                    format: 'YYYY-MM-D HH:mm:ss',
                    ignoreReadonly: true,
                    icons: {
                        time: "fa fa-clock-o",
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    }
                });

                $('#proEndTime').datetimepicker({
                    defaultDate: self.item.prod_e_datetime,
                    locale: 'zh-tw',
                    format: 'YYYY-MM-D',
                    ignoreReadonly: true,
                    icons: {
                        // time: "fa fa-clock-o",
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    }
                });

                $("#proStartTime").on("change.datetimepicker", function (e) {
                    $('#proEndTime').datetimepicker('minDate', e.date);
                });

                $("#proEndTime").on("change.datetimepicker", function (e) {
                    $('#proStartTime').datetimepicker('maxDate', e.date);
                });
                //----------------------------------------------------------------
                //----------------------------------------------------------------
                //----------------------------------------------------------------
                //----------------------------------------------------------------

                self.productNum = data.item.product_num;
                self.item.prod_img = self.staticFilePath + self.productId + '/' + data.item.prod_img;
                self.item.prod_img2 = self.staticFilePath + self.productId + '/' + data.item.prod_img2;
                self.item.prod_img3 = self.staticFilePath + self.productId + '/' + data.item.prod_img3;
                self.productDescribe = data.productDescribe;

                self.showProd_describe = $sce.trustAsHtml(self.productDescribe[2].prod_describe);
                self.propertyTag = data.propertyTag;
                self.productType = data.productType;
                self.productSpec = data.productSpec;
                self.productImg = data.productImg;
                angular.forEach(self.productImg, function(item) {
                    item.prod_img_name = self.staticFilePath + item.prod_id + '/' + item.prod_img_name;
                    item.prod_img_name2 = self.staticFilePath + item.prod_id + '/' + item.prod_img_name2;
                });

                self.productFile = data.productFile;
                angular.forEach(self.productFile, function(item) {
                    item.prod_img_path = self.staticFilePath + item.prod_id + '/' + item.prod_img_name;
                });
                // console.log( Date.parse(self.item.prod_e_datetime) )

                // if (Date.parse(self.item.prod_e_datetime) == Date.parse( '2222-01-01 00:00:00')) {
                //     self.endDateStatus = 1;
                //     $("#proEndTime").hide();
                // }
            }).error(function() {
                $.toaster({ message : '發生錯誤', priority : 'danger' });
            }) //error
        }
        self.getItems();
    @endsection
</script>
