<template>
    <div class="clients-list">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab-1"><i class="fa fa-cubes"></i> 供应产品</a></li>
        </ul>
        <div class="tab-content">
            <div id="tab-1" class="tab-pane active">
                <div class="full-height-scroll">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <th>产品编号</th>
                                <th>图片</th>
                                <th>原厂编号</th>
                                <th>中文品名</th>
                                <th>英文品名</th>
                                <th>装箱数</th>
                                <th>L W H</th>
                                <th>G.W</th>
                                <th>N.W</th>
                                <th>
                                    <a @click="addGoods()" class="btn btn-info btn-xs">添加产品</a>
                                    <span class="delimiter">|</span>
                                    <a @click="connectGoods()" class="btn btn-info btn-xs">关联产品</a>
                                </th>
                            </thead>
                            <tbody class="xj-sortable-list connectList">
                                <tr id="goods_{{g.id}}" v-for="g in goodses">
                                    <td v-if="g.edit"><input type="text" class="form-control" v-model="g.product_sn"></td><td v-else>{{g.product_sn}}</td>
                                    <td><div class="goods_list_img"><img class="goods_img" v-if="g.img" v-bind:src="g.img"></div></td>
                                    <td v-if="g.edit"><input type="text" class="form-control" v-model="g.mfrs_sn"></td><td v-else>{{g.mfrs_sn}}</td>
                                    <td v-if="g.edit"><input type="text" class="form-control" v-model="g.cn_name"></td><td v-else>{{g.cn_name}}</td>
                                    <td v-if="g.edit"><input type="text" class="form-control" v-model="g.en_name"></td><td v-else>{{g.en_name}}</td>
                                    <td v-if="g.edit"><input type="text" class="form-control" v-model="g.num"></td><td v-else>{{g.num}}</td>
                                    <td v-if="g.edit">L:<input type="text" class="form-control" v-model="g.length"><br>W:<input type="text" class="form-control" v-model="g.width"><br>H:<input type="text" class="form-control" v-model="g.height"></td><td v-else>L:{{g.length}}<br>W:{{g.width}}<br>H:{{g.height}}</td>
                                    <td v-if="g.edit"><input type="text" class="form-control" v-model="g.gw"></td><td v-else>{{g.gw}}</td>
                                    <td v-if="g.edit"><input type="text" class="form-control" v-model="g.nw"></td><td v-else>{{g.nw}}</td>
                                    <td v-if="g.edit">
                                        <a @click="submitGoods(g)" class="btn btn-info btn-xs">保存</a>
                                        <span class="delimiter">|</span>
                                        <a @click="cancelGoods(g,$index)" class="btn btn-success btn-xs">取消</a>
                                    </td>
                                    <td v-else>
                                        <a @click="editGoods(g)"><i class="fa fa-edit"></i> 编辑</a>
                                        <span class="delimiter">|</span>
                                        <a @click="deleteGood(g.id)"><i class="fa fa-remove"></i>   删除</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style>

</style>
<script>
    export default{
        props: ['supplier_id'],
        ready(){
            this.getGoodses();
            var _this = this;
            $('.fancybox').fancybox({
                openEffect: 'none',
                closeEffect: 'none'
            });
        },
        data(){
            return{
                goodses: {}
            }
        },
        components:{

        },
        methods:{
            getGoodses(){
                this.$http.get('/supplier/goods/'+this.supplier_id+'.json').then(function (response) {
                    this.$set('goodses', response.data);
                });
            },
            addGoods(){
                var new_goods = {};
                new_goods.id = 0;
                new_goods.product_sn = '';
                new_goods.mfrs_sn = '';
                new_goods.cn_name = '';
                new_goods.en_name = '';
                new_goods.num = '';
                new_goods.length = '';
                new_goods.width = '';
                new_goods.height = '';
                new_goods.gw = '';
                new_goods.nw = '';
                new_goods.edit = true;
                this.goodses.push(new_goods);
            },
            submitGoods(goods){
                if(goods.id == 0){//添加
                    this.$http.post('/supplier/goods/'+this.supplier_id+'.json', goods).then(function(response){
                        if(response.data.status == false){
                            toastr.error(response.data.msg);
                        }else{
                            goods.id = response.data.data.id;
                            this.getGoodses();
                        }
                    });
                }else{
                    this.$http.put('/mfrs/'+mfrs.id+'.json', mfrs).then(function(response){
                        if(response.data.status == false){
                            toastr.error(response.data.msg);
                        }else{
                            this.getGoodses();
                        }
                    });
                }
            },
            cancelGoods(goods, index){
                if(goods.id == 0){
                    this.goodses.splice(index,1);
                }else{
                    goods.edit = false;
                }
            },
            editGoods(goods){
                goods.edit = true;
            },
            connectGoods(){

            }
        }
    }
</script>
