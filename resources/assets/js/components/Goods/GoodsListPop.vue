<template>
        <div>
            <div class="m-b-sm m-t-sm">
                <div class="input-group" style="width:90%;margin:auto">
                    <input type="text" v-model="search_data.keywords" style="width:50% !important;float:right;" placeholder="请输入产品名称" class="input-sm form-control col-md-5">
                    <select class=" input-sm form-control col-md-3" style="width:24% !important;float:right;" v-model="search_data.type" number>
                        <option value="0">中文品名</option>
                        <option value="1">英文品名</option>
                    </select>

                    <select class=" input-sm form-control col-md-3" style="width:24% !important;" v-model="search_data.cat_id" number>
                        <option value="">请选择类目</option>
                        <template v-for="cat in cats">
                        <option value="{{cat.id}}">{{cat.name}}</option>
                        </template>
                    </select>
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-sm btn-primary" v-on:click="goodsSerch()"> 搜索</button>
                    </span>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped" >
                    <thead>
                    <tr>
                        <th>{{ids}}</th>
                        <th>图片</th>
                        <th>产品编号</th>
                        <th>中文品名</th>
                        <th>英文品名</th>
                    </tr>
                    </thead>
                    <tbody v-if="all > 0">
                    <tr class="goods_list_css" v-for="goods in goodses">
                        <td><input type="checkbox" value="{{goods.id}}" v-model="ids"></td>
                        <td><img class="goods_img_pop" v-bind:src="goods.img"/></td>
                        <td>{{goods.product_sn}}</td>
                        <td>{{goods.cn_name}}</td>
                        <td>{{goods.en_name}}</td>
                    </tr>
                    </tbody>
                    <tbody v-else>
                        <tr class="no-records-found"><td colspan="6">没有找到匹配的记录</td></tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="6" v-if="all > 1">
                            <ul class="pagination pull-right">
                                <li class="footable-page-arrow">
                                    <input type="text" class="go_page_class" v-model="go_page_class" number>
                                    <a data-page="last" class="go_page_class_a" v-on:click="btnClick(go_page_class)">跳转</a>
                                </li>
                            </ul>
                            <ul class="pagination pull-right">
                                <li class="footable-page-arrow">
                                    <a data-page="first" v-on:click="goPage(2)">«</a>
                                </li>
                                <li class="footable-page-arrow">
                                    <a data-page="prev" v-on:click="goPage(0)">‹</a>
                                </li>
                                <li class="footable-page" v-for="index in indexs" v-bind:class="{ 'active': cur == index}">
                                    <a v-on:click="btnClick(index)">{{ index }}</a>
                                </li>
                                <li class="footable-page-arrow">
                                    <a data-page="next" v-on:click="goPage(1)">›</a>
                                </li>
                                <li class="footable-page-arrow">
                                    <a data-page="last" v-on:click="goPage(3)">»</a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <div>
                <form method="get" class="form-horizontal">
                    <div class="hr-line-dashed"></div>
                    <div class="table-responsive">
                        <div class="col-sm-12" style="text-align:center;margin-bottom:15px">
                            <button class="btn btn-w-m btn-primary" type="button" @click="postChoose()">选取</button>
                            <button class="btn btn-w-m btn-white" type="button" @click="cancelChoose()">取消</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
</template>
<script>
export default{
    props: ['type'],
    ready(){
        this.getGoodses()
        this.getCats()
    },
    data(){
        return{
            goodses:[],
            search_data:{
                type:0,
                keywords:'',
                cat_id:0
            },
            page_size:1,
            page_count:0,
            cur: 1,
            all: 1,
            go_page_class: '',
            ids: [],
            cats: {},
            cat_id: ''
        }
    },
    methods:{
        getGoodses(){
            var serch_data = this.search_data;
            var en_name = '';
            var cn_name = '';
            var cat_id = this.cat_id;
            if(serch_data.type == 0){//按中文名搜索
                cn_name = serch_data.keywords
            }else{
                en_name = serch_data.keywords
            }
            var page = this.cur ? this.cur : 1;
            this.$http.get('/goods.json?en_name='+en_name+'&cn_name='+cn_name+'&cat_id='+cat_id+'&page='+page+'&limit=5').then(function(response){
                this.$set('goodses',response.data.data);
                this.$set('all',response.data.all_page);
                this.$set('cur', page)
            });
        },
        goodsSerch(){
            this.getGoodses();
        },
        goPage(type){
            if(type == 1){//下一页
                if(this.cur < this.all){
                    this.cur++
                }
            }else if(type == 0){//上一页
                if(this.cur > 1){
                    this.cur--
                }
            }else if(type == 2){//第一页
                this.cur = 1
            }else if(type == 3){//最后一页
                this.cur = this.all
            }
            this.getGoodses()
        },
        btnClick(data){
            if(data != this.cur){
                this.cur = data
                this.$dispatch('btn-click',data)
                this.getGoodses()
            }
        },
        getCats(){
            this.$http.get('/cats.json').then(function (response) {
                this.$set('cats', response.data.data);
            });
        },
        postChoose(){
            if(this.type == 0){
                this.postXj();
            }else{
                this.postOrder();
            }
        },
        postXj(){
            /*this.$http.post('/customer/xjs.json',{ids:this.ids}).then(function (response) {

            });*/
        },
        postOrder(){

        },
        cancelChoose(){
            layer.closeAll();
        }
    },
    watch:{
        'goodses':function () {},
        '$route.query.cat_id':function(){
            this.cat_id = this.$route.query.cat_id;
            this.getGoodses();
        }
    },
    computed: {
        indexs: function(){
            var left = 1;
            var right = this.all;
            var ar = [];
            if(this.all>= 11){
                if(this.cur > 5 && this.cur < this.all-4){
                    left = this.cur - 5;
                    right = this.cur + 4
                }else{
                    if(this.cur<=5){
                        left = 1;
                        right = 10
                    }else{
                        right = this.all;
                        left = this.all -9
                    }
                }
            }
            while (left <= right){
                ar.push(left);
                left ++
            }
            return ar
        }
    },
}
</script>
