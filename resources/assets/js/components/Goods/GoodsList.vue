<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>所有产品</h5>
                    <div class="ibox-tools">
                        <a href="projects.html" class="btn btn-primary btn-xs">添加产品</a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row m-b-sm m-t-sm">
                        <div class="col-md-1">
                            <button type="button" id="loading-example-btn" class="btn btn-white btn-sm"><i class="fa fa-refresh"></i> 刷新</button>
                        </div>
                        <div class="col-md-11">
                            <div class="input-group">
                                <input type="text" placeholder="请输入产品名称" class="input-sm form-control"> <span class="input-group-btn">
                                <button type="button" class="btn btn-sm btn-primary"> 搜索</button> </span>
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
                            <th data-sort-ignore="true">采购价(含税)</th>
                            <th data-sort-ignore="true">采购价(不含税)</th>
                            <th data-hide="all">生产商</th>
                            <th data-hide="all">原厂编号</th>
                            <th data-hide="all">供应商</th>
                            <th data-hide="all">装箱数</th>
                            <th data-hide="all">规格</th>
                            <th data-hide="all">适用车型</th>
                            <th data-sort-ignore="true">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="goods in goodses">
                            <td>{{goods.en_name}}</td>
                            <td>{{goods.cn_name}}</td>
                            <td>{{goods.product_sn}}</td>
                            <td>{{goods.cat_name}}</td>
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
                                <a @click="deleteGoods(goods.id)"><i class="fa fa-remove"></i> 删除</a>
                            </td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="7">
                                <ul class="pagination pull-right">
                                    <li class="footable-page-arrow">
                                        <a data-page="first" href="#first">«</a>
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
                                        <a data-page="last" href="#last">»</a>
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
        this.getGoodes()
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
            all: 1
        }
    },
    methods:{
        getGoodes(){
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
                this.$set('all',response.data._count);
                this.$set('cur', page)
            });
        },
        deleteGoods(ids){
            this.$http.delete('/goods/batch.json?ids='+ids).then(function(response){
                this.getGoodes();
                $(".footable").data('footable').reset();
            });
        },
        goPage(type){
            if(type == 1){
                if(this.cur < this.all){
                    this.cur++
                }
            }else{
                if(this.cur > 1){
                    this.cur--
                }
            }
            console.log(this.cur);
            this.getGoodes()
            $(".footable").data('footable').reset();
        },
        btnClick(data){
            if(data != this.cur){
                this.cur = data
                this.$dispatch('btn-click',data)
                this.getGoodes()
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
            var left = 1
            var right = this.all
            var ar = []
            if(this.all>= 11){
                if(this.cur > 5 && this.cur < this.all-4){
                    left = this.cur - 5
                    right = this.cur + 4
                }else{
                    if(this.cur<=5){
                        left = 1
                        right = 10
                    }else{
                        right = this.all
                        left = this.all -9
                    }
                }
            }
            while (left <= right){
                ar.push(left)
                left ++
            }
            return ar
        }
    },
}
</script>
