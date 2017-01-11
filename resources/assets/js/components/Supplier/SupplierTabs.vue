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
                                <th><a @click="addGoods()" class="btn btn-info btn-xs">添加询价记录</a></th>
                            </thead>
                            <tbody class="xj-sortable-list connectList">
                                <tr id="goods_{{g.id}}" v-for="g in goodses">
                                    <td>{{g.product_sn}}</td>
                                    <td><img class="goods_img"  v-bind:src="g.img"></td>
                                    <td>{{g.mfrs_sn}}</td>
                                    <td>{{g.cn_name}}</td>
                                    <td>{{g.en_name}}</td>
                                    <td>{{g.num}}</td>
                                    <td>L:{{g.length}}<br>W:{{g.width}}<br>H:{{g.height}}</td>
                                    <td>{{g.gw}}</td>
                                    <td>{{g.nw}}</td>
                                    <td>
                                        <a @click=""><i class="fa fa-edit"></i> 编辑</a>
                                        <span class="delimiter">|</span>
                                        <a @click=""><i class="fa fa-remove"></i>   删除</a>
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
            this.getGoods();
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
            getGoods(){
                this.$http.get('/supplier/goods/'+this.supplier_id+'.json').then(function (response) {
                    this.$set('goodses', response.data);
                });
            }
        }
    }
</script>
