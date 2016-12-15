<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="wrapper wrapper-content animated fadeInUp">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="m-b-md">
                                    <a href="project_detail.html#" class="btn btn-white btn-xs pull-right">编辑项目</a>
                                    <h2>{{goods.product_sn}}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <img alt="image" class="img-responsive info_bigimg" v-bind:src="goods.img">
                            </div>
                            <div class="col-sm-7 form-horizontal" id="cluster_info">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">中文品名：</label>

                                    <div class="col-sm-4">
                                        <input type="text" v-model="goods.cn_name" disabled class="form-control do_show">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">英文品名：</label>

                                    <div class="col-sm-4">
                                        <input type="text" v-model="goods.en_name" disabled class="form-control do_show">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">产品类目：</label>

                                    <div class="col-sm-4">
                                        <input type="text" v-model="goods.cn_name" disabled class="form-control do_show">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">FOB价格：</label>

                                    <div class="col-sm-4">
                                        <span class="input-group-addon unshow">$</span>
                                        <input v-model="goods.fob_price" type="number" step="0.01" disabled class="form-control do_show">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">备注：</label>

                                    <div class="col-sm-4">
                                        <textarea class="form-control do_show" disabled v-model="goods.mark">

                                        </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="row m-t-sm">
                            <div class="col-sm-12">
                                <Goodstabs :goods_id="goods_id"></Goodstabs>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Goodstabs from './GoodsTabs.vue'
    export default{
        created(){
            this.goods_id = this.$route.params.id;
        },
        ready(){
            this.getGoods();
        },
        data(){
            return{
                goods: {},
                goods_id: 0
            }
        },
        components:{
            Goodstabs
        },
        methods:{
            getGoods(){
                this.$http.get('/goods/'+this.goods_id+'.json').then(function(response){
                    if(response.data.status == true){
                        this.$set('goods', response.data.data);
                    }else{
                        toastr.error(response.data.msg);
                    }
                });
            }
        }
    }
</script>
