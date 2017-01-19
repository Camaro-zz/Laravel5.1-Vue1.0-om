<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="wrapper wrapper-content animated fadeInUp">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="m-b-md">
                                    <h2 style="display:inline-block">产品编号：{{goods.product_sn}}</h2>
                                    <span class="goods_info_show">
                                        <a @click="showEditInfo()" class="btn btn-info btn-sm">编辑产品</a>
                                    </span>
                                    <span class="goods_info_edit" style="display:none !important;">
                                        <a @click="putGoods()" class="btn btn-primary btn-sm" style="margin-right:10px">保存产品</a>
                                        <a @click="cancelEditInfo()" class="btn btn-sm btn-warning">取消编辑</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 form-horizontal goods_info_show">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label title_width">中文品名：</label>

                                    <div class="col-sm-4">
                                        <p>{{goods.cn_name}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label title_width">英文品名：</label>

                                    <div class="col-sm-4">
                                        <p>{{goods.en_name}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label title_width">产品类目：</label>

                                    <div class="col-sm-4">
                                        <p>{{goods.cat_name}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label title_width">原厂编号：</label>

                                    <div class="col-sm-4">
                                        <p>{{goods.mfrs_sn}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 form-horizontal goods_info_show">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label title_width">适用车型：</label>

                                    <div class="col-sm-4">
                                        <p>{{goods.car_type.brand}} {{goods.car_type.car_type}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label title_width">供应商名称：</label>

                                    <div class="col-sm-4">
                                        <p>{{goods.supplier.name}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label title_width">采购价(含)：</label>

                                    <div class="col-sm-4">
                                        <p>${{(parseFloat(goods.supplier.price) + parseFloat(goods.supplier.tax)).toFixed(2)}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label title_width">采购价(不含)：</label>

                                    <div class="col-sm-4">
                                        <p>${{(parseFloat(goods.supplier.price)).toFixed(2)}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 form-horizontal goods_info_show">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label title_width">HS编码：</label>

                                    <div class="col-sm-4">
                                        <p>{{goods.hs_code}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label title_width">出货状态：</label>

                                    <div class="col-sm-4">
                                        <p>{{goods.fyi_status}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label title_width">退税率：</label>

                                    <div class="col-sm-4">
                                        <p>{{goods.tax_rate}}%</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label title_width">报关要素：</label>

                                    <div class="col-sm-6">
                                        <p>{{goods.report_key}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label title_width">备注：</label>

                                    <div class="col-sm-6">
                                        <p>{{goods.mark}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-9 form-horizontal goods_info_edit" style="display:none !important;">
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
                                    <label class="col-sm-3 control-label">HS编码：</label>

                                    <div class="col-sm-4">
                                        <input type="text" v-model="goods.hs_code" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">退税率</label>

                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <input v-model="goods.tax_rate" type="number" step="0.01" class="form-control">
                                            <span class="input-group-addon">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">出货状态：</label>

                                    <div class="col-sm-4">
                                        <input type="text" v-model="goods.fyi_status" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">报关要素：</label>

                                    <div class="col-sm-6">
                                        <textarea class="form-control" rows="10" v-model="goods.report_key">

                                        </textarea>
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
                            <div class="col-sm-3">
                                <template v-if="goods.img != ''">
                                    <img alt="image" class="img-responsive info_bigimg" v-bind:src="goods.img">
                                </template>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="row m-t-sm">
                            <div class="col-sm-12">
                                <Goodstabs :goods_id="goods_id" :goods="goods"></Goodstabs>
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
                goods_data.mark = this.goods.mark;
                goods_data.cat_id = this.goods.cat_id = $(".chosen-select").val();
                goods_data.hs_code = this.goods.hs_code;
                goods_data.report_key = this.goods.report_key;
                goods_data.tax_rate = this.goods.tax_rate;
                goods_data.fyi_status = this.goods.fyi_status;
                console.log(goods_data);
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
