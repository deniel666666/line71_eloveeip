/*點擊元件初始化後會觸發外部函式：init_after_get_distributors()*/
/*點擊元件內供應商觸發外部函式：click_distributor_emit(id)*/
/*可由 this.$refs.distributors_area.distributors_current 取得當前供應商ID*/
/*可由 this.$refs.distributors_area.my_distributor_id 取得自己供應商ID(平台為0)*/
if(Vue){
	Vue.component('distributors_area',{
        template: `
            <div v-if="distributors.length>1" class="d-inline-block">
                查看供應商：
                <button @click="click_distributor(-1)"
                        v-if="need_all"
                        :class="['btn mr-3', distributors_current==-1 ? 'btn-primary' : '']">全部</button>
                <button v-for="item in distributors" 
                        v-text="item.shop_name ? item.shop_name : item.name"
                        @click="click_distributor(item.id)"
                        :class="['btn mr-3', distributors_current==item.id ? 'btn-primary' : '']"></button>
            </div>
        `,
        data: function (){
            return {
                distributors: [],
                distributors_current: 0,
            }
        },
        props: {
            my_distributor_id: Number,
            need_all: Boolean,
            current_distributor_id: String,
        },
        beforeMount: async function(){
            self = this;
            main_url = location.href.split('/').slice(0, 4).join('/');
            main_url = main_url.replace('orderdistribution', 'distribution');
            main_url = main_url.replace('order', 'admin');
            // console.log(main_url);

            await $.ajax({
                url: main_url+"/layertree/get_distributors", //請求的url地址
                dataType: "json", //返回格式為json
                type: "GET", //請求方式
                success: function(req) {
                    // console.log(req)
                    self.distributors = req;

                    if(self.current_distributor_id){
                        self.distributors_current = self.current_distributor_id;
                    }else{
                        self.distributors_current = req[0].id;
                    }

                    if(init_after_get_distributors){
                        init_after_get_distributors();
                    }
                },
                error: function() {
                    //請求出錯處理
                }
            });
        },
        methods:{
            click_distributor: function(id){
                this.distributors_current = id;
                if(click_distributor_emit){ click_distributor_emit(id); }
            },
        },
    });
}