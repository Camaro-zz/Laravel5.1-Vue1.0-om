<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>所有产品</h5>
                    <div class="ibox-tools">
                        <a @click="addGoods()" class="btn btn-primary btn-xs">添加产品</a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row m-b-sm m-t-sm">
                        <div class="col-md-1">
                            <button type="button" id="loading-example-btn" v-on:click="goodsSerch()" class="btn btn-white btn-sm"><i class="fa fa-refresh"></i> 刷新</button>
                        </div>
                        <div class="col-md-5" style="float:right;">
                            <div class="input-group">
                                <input type="text" v-model="search_data.keywords" style="width:50% !important;float:right;" placeholder="请输入产品名称" class="input-sm form-control col-md-5">
                                <select class=" input-sm form-control col-md-3" style="width:20% !important;float:right;" v-model="search_data.type" number>
                                    <option value="0">中文品名</option>
                                    <option value="1">英文品名</option>
                                </select>

                                <select class=" input-sm form-control col-md-3" style="width:20% !important;" v-model="search_data.cat_id" number>
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
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped" >
                            <thead>
                            <tr>
                                <th></th>
                                <th>图片</th>
                                <th>产品编号</th>
                                <th>原厂编号</th>
                                <th>中文品名</th>
                                <th>英文品名</th>
                                <th>含税采购价</th>
                                <th>不含税采购价</th>
                                <th>适用车型</th>
                                <th>供应商</th>
                                <th>出货状态</th>
                                <th>备注</th>
                            </tr>
                            </thead>
                            <tbody v-if="all > 0">
                            <tr class="goods_list_css" v-for="goods in goodses">
                                <td  class="goods_list_css_jump"><input type="checkbox" value="{{goods.id}}" v-model="ids"></td>
                                <td  class="goods_list_css_jump" @click="goToInfo($event, goods.id)"><div class="goods_list_img"><img v-if="goods.img" class="goods_img" v-bind:src="goods.img"/></div></td>
                                <td  class="goods_list_css_jump" @click="goToInfo($event, goods.id)">{{goods.product_sn}}</td>
                                <td v-if="goods.mfrs != ''">
                                    {{goods.mfrs.mfrs_sn}}
                                </td>
                                <td v-else>暂无</td>
                                <td>{{goods.cn_name}}</td>
                                <td>{{goods.en_name}}</td>
                                <td v-if="goods.prop != ''">${{goods.prop[0].tax_price}}</td>
                                <td v-else>暂无</td>
                                <td v-if="goods.prop != ''">${{goods.prop[0].price}}</td>
                                <td v-else>暂无</td>
                                <td>
                                    <template v-for="c in goods.car_type">
                                        {{c.brand}}&nbsp;&nbsp;{{c.car_type}}<br>
                                    </template>
                                </td>
                                <td v-if="goods.prop != ''">
                                    <template v-for="p in goods.prop">
                                        {{p.name}}<br>
                                    </template>
                                </td>
                                <td v-else>暂无</td>
                                <td>{{goods.fyi_status}}</td>
                                <td>{{goods.mark}}</td>
                            </tr>
                            </tbody>
                            <tbody v-else>
                                <tr class="no-records-found"><td colspan="13">没有找到匹配的记录</td></tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="3">
                                    <button type="button" v-on:click="deleteGoods(ids)" class="btn btn-white btn-sm"><i class="fa fa-trash-o"></i> 删除</button>
                                </td>
                                <td colspan="8" v-if="all > 1">
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
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import GoodsAdd from './GoodsAdd.vue'
export default{
    ready(){
        this.cat_id = this.$route.query.cat_id;
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
    components:{
        GoodsAdd
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
            this.$http.get('/goods.json?en_name='+en_name+'&cn_name='+cn_name+'&cat_id='+cat_id+'&page='+page).then(function(response){
                this.$set('goodses',response.data.data);
                this.$set('all',response.data.all_page);
                this.$set('cur', page)
            });
        },
        goodsSerch(){
            this.getGoodses();
        },
        deleteGoods(ids){
            this.$http.delete('/goods/batch.json?ids='+ids).then(function(response){
                this.getGoodses();
            });
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
        goToInfo(event, goods_id){
            /*if(event.target.tagName === 'INPUT' || event.target.lastChild.tagName === 'INPUT'){
                return false;
            }*/
            this.$route.router.go({path: '/goods/info/'+goods_id})
        },
        getCats(){
            this.$http.get('/cats.json').then(function (response) {
                this.$set('cats', response.data.data);
            });
        },
        addGoods(){
            var new_goods = {};
            if(this.cat_id > 0){
                new_goods.cat_id = this.cat_id
            }
            this.$http.post('/goods/add.json',new_goods).then(function (response) {
                if(response.data.status == true){
                    this.$route.router.go({path: '/goods/info/'+response.data.data.id,query:{type:1}})
                }else{
                    toastr.error(response.data.msg);
                }
            });
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
