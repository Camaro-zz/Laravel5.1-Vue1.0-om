<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>所有产品</h5>
                    <div class="ibox-tools">
                        <a v-link="{path:'/goods/add'}" class="btn btn-primary btn-xs">添加产品</a>
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
                                <select class=" input-sm form-control col-md-3" style="width:25% !important;float:right;" v-model="search_data.type" number>
                                    <option value="0">中文品名</option>
                                    <option value="1">英文品名</option>
                                </select>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-sm btn-primary" v-on:click="goodsSerch()"> 搜索</button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <table class="footable table table-stripped toggle-arrow-tiny" v-bind:data-page-size="page_size" v-bind:data-navigation="page_count">
                        <thead>
                        <tr>
                            <th data-toggle="true" data-sort-ignore="true">英文品名</th>
                            <th data-sort-ignore="true">中文品名</th>
                            <th data-sort-ignore="true">产品编号</th>
                            <th data-sort-ignore="true">类目</th>
                            <th data-sort-ignore="true">FOB价格</th>
                            <th data-hide="all">采购价(含税)</th>
                            <th data-hide="all">采购价(不含税)</th>
                            <th data-hide="all">生产商</th>
                            <th data-hide="all">原厂编号</th>
                            <th data-hide="all">供应商</th>
                            <th data-hide="all">装箱数</th>
                            <th data-hide="all">规格</th>
                            <th data-hide="all">适用车型</th>
                            <th data-sort-ignore="true">操作</th>
                        </tr>
                        </thead>
                        <tbody v-if="all > 0">
                        <tr v-for="goods in goodses">
                            <td>{{goods.en_name}}</td>
                            <td>{{goods.cn_name}}</td>
                            <td>{{goods.product_sn}}</td>
                            <td>{{goods.cat_name}}</td>
                            <td>{{goods.fob_price}}</td>
                            <td v-if="goods.prop != ''">{{goods.prop.price + goods.prop.tax}}</td>
                            <td v-else>0</td>
                            <td v-if="goods.prop != ''">{{goods.prop.price}}</td>
                            <td v-else>0</td>
                            <td v-if="goods.mfrs != ''">{{goods.mfrs.mfrs_name}}</td>
                            <td v-else>暂无</td>
                            <td v-if="goods.mfrs != ''">>{{goods.mfrs.mfrs_sn}}</td>
                            <td v-else>暂无</td>
                            <td v-if="goods.prop != ''">{{goods.prop.name}}</td>
                            <td v-else>暂无</td>
                            <td v-if="goods.prop != ''">{{goods.prop.num}}</td>
                            <td v-else>0</td>
                            <td v-if="goods.prop != ''">长:{{goods.prop.length}}|宽:{{goods.prop.width}}|高:{{goods.prop.height}}|毛重:{{goods.prop.gw}}|净重:{{goods.prop.nw}}</td>
                            <td v-else>暂无</td>
                            <td>{{goods.car_types}}</td>
                            <td>
                                <a v-link="{name:'goods_edit', params:{id:goods.id}}"><i class="fa fa-edit"></i> 编辑</a>
                                <span class="delimiter">|</span>
                                <a @click="deleteGoods(goods.id)"><i class="fa fa-remove"></i> 删除</a>
                                <span class="delimiter">|</span>
                                <a v-link="{name:'goods_mfrs_add', params:{goods_id:goods.id}}"><i class="fa fa-cubes"></i> 添加生产商</a>
                                <span class="delimiter">|</span>
                                <a v-link="{name:'goods_supplier_add', params:{goods_id:goods.id}}"><i class="fa fa-cubes"></i> 关联供应商</a>
                            </td>
                        </tr>
                        </tbody>
                        <tbody v-else>
                            <tr class="no-records-found"><td colspan="4">没有找到匹配的记录</td></tr>
                        </tbody>
                        <tfoot v-if="all > 0">
                        <tr>
                            <td colspan="7">
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
</template>
<script>
export default{
    ready(){
        this.getGoodses()
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
            go_page_class: ''
        }
    },
    methods:{
        getGoodses(){
            var serch_data = this.search_data;
            var en_name = '';
            var cn_name = '';
            var cat_id = 0;
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
            $(".footable").data('footable').reset();
        },
        deleteGoods(ids){
            this.$http.delete('/goods/batch.json?ids='+ids).then(function(response){
                this.getGoodses();
                $(".footable").data('footable').reset();
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
            $(".footable").data('footable').reset();
        },
        btnClick(data){
            if(data != this.cur){
                this.cur = data
                this.$dispatch('btn-click',data)
                this.getGoodses()
                $(".footable").data('footable').reset();
            }
        }
    },
    watch:{
        'goodses':function () {
            this.$nextTick(function(){
                $(".footable").footable({
                    'paginate':false
                })
            })
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
