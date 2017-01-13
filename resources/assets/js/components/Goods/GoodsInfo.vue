<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="wrapper wrapper-content animated fadeInUp">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="m-b-md">
                                    <div class="goods_info_show">
                                        <a @click="showEditInfo()" class="btn btn-info btn-xs pull-right">编辑产品</a>
                                    </div>
                                    <div class="goods_info_edit" style="display:none !important;">
                                        <a @click="cancelEditInfo()" class="btn btn-xs btn-warning pull-right">取消编辑</a>
                                        <a @click="putGoods()" class="btn btn-primary btn-xs pull-right" style="margin-right:10px">保存产品</a>
                                    </div>
                                    <h2>{{goods.product_sn}}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <template v-if="goods.img != ''">
                                    <img alt="image" class="img-responsive info_bigimg" v-bind:src="goods.img">
                                </template>
                            </div>
                            <div class="col-sm-8 form-horizontal goods_info_show">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">中文品名：</label>

                                    <div class="col-sm-4">
                                        <p>{{goods.cn_name}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">英文品名：</label>

                                    <div class="col-sm-4">
                                        <p>{{goods.en_name}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">产品类目：</label>

                                    <div class="col-sm-4">
                                        <p>{{goods.cn_name}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">FOB价格：</label>

                                    <div class="col-sm-4">
                                        <p>${{goods.fob_price}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">装箱数：</label>

                                    <div class="col-sm-4">
                                        <p>${{goods.num}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">规格：</label>

                                    <div class="col-sm-2">
                                        长：{{goods.length}}
                                    </div>
                                    <div class="col-sm-2">
                                        宽：{{goods.width}}
                                    </div>
                                    <div class="col-sm-2">
                                        高：{{goods.height}}
                                    </div>
                                    <div class="col-sm-2">
                                        毛重：{{goods.gw}}
                                    </div>
                                    <div class="col-sm-2">
                                        净重：{{goods.nw}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">备注：</label>

                                    <div class="col-sm-6">
                                        <p>{{goods.mark}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8 form-horizontal goods_info_edit" style="display:none !important;">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">中文品名：</label>

                                    <div class="col-sm-4">
                                        <input type="text" v-model="goods.cn_name" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">英文品名：</label>

                                    <div class="col-sm-4">
                                        <input type="text" v-model="goods.en_name" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">产品类目：</label>

                                    <div class="col-sm-3">
                                        <select v-model="goods.cat_id" data-placeholder="请选择类目..." class="chosen-select" style="width:100%;" tabindex="2">
                                            <option value="0" hassubinfo="true">请选择类目</option>
                                            <template v-for="cat in cats">
                                                <option value="{{cat.id}}" hassubinfo="true">{{cat.name}}</option>
                                            </template>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <a @click="addCat()"><i class="fa fa-plus"></i>添加类目</a>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">FOB价格：</label>

                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">$</span>
                                            <input v-model="goods.fob_price" type="number" step="0.01" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">装箱数</label>

                                    <div class="col-sm-4">
                                        <input type="text" v-model="goods.num" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">规格</label>

                                    <div class="col-sm-1">
                                        长：<input type="text" v-model="goods.length" class="form-control">
                                    </div>
                                    <div class="col-sm-1">
                                        宽：<input type="text" v-model="goods.width" class="form-control">
                                    </div>
                                    <div class="col-sm-1">
                                        高：<input type="text" v-model="goods.height" class="form-control">
                                    </div>
                                    <div class="col-sm-1">
                                        毛重：<input type="text" v-model="goods.gw" class="form-control">
                                    </div>
                                    <div class="col-sm-1">
                                        净重：<input type="text" v-model="goods.nw" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">备注：</label>

                                    <div class="col-sm-6">
                                        <textarea class="form-control" rows="10" v-model="goods.mark">

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
            this.type = this.$route.query.type ? this.$route.query.type : 0;
            if(this.type == 1){
                this.showEditInfo();
            }
        },
        data(){
            return{
                goods: {},
                goods_id: 0,
                cats: {},
                type: 0
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
            },
            getCats(){
                this.$http.get('/cats.json').then(function(response){
                    this.$set('cats',response.data.data);
                });
            },
            addCat(){
                var __this = this;
                layer.prompt({title: '输入类目名称', formType: 0}, function(pass, index){
                    if(pass != ''){
                        __this.$http.post('/goods/cat/add.json',{name:pass}).then(function (response) {
                            if(response.data.status == true){
                                $(".chosen-select").chosen("destroy");
                                __this.getCats();
                                __this.$set('goods.cat_id',response.data.data.id)
                                layer.close(index);
                            }
                        });
                    }
                });
            },
            putGoods(){
                var goods_data = {};
                goods_data.cn_name = this.goods.cn_name;
                goods_data.en_name = this.goods.en_name;
                goods_data.fob_price = this.goods.fob_price;
                goods_data.mark = this.goods.mark;
                goods_data.cat_id = this.goods.cat_id;
                goods_data.product_sn = this.goods.product_sn;
                this.$http.put('/goods/'+this.goods_id+'.json',goods_data).then(function(response){
                    if(response.data.status == true){
                        this.$set('goods', response.data.data);
                        if(this.type == 1){
                            this.$route.router.go({path: '/goods/info/'+this.goods_id})
                        }
                        this.hideEditInfo();
                    }else{
                        toastr.error(response.data.msg);
                    }
                });
            },
            showEditInfo(){
                $('.goods_info_show').hide();
                $('.goods_info_edit').show();
                this.getCats()
            },
            hideEditInfo(){
                $('.goods_info_show').show();
                $('.goods_info_edit').hide();
            },
            cancelEditInfo(){
                if(this.type == 1){//添加产品
                    toastr.error('请先添加完善产品');
                    return false;
                }
                this.getGoods();
                this.hideEditInfo();
            }
        },
        watch:{
            'cats':function () {
                this.$nextTick(function(){
                    $(".chosen-select").chosen();
                    $(".chosen-select").val(this.goods.cat_id);
                    $(".chosen-select").trigger("chosen:updated");
                })
            }
        },
    }
</script>
