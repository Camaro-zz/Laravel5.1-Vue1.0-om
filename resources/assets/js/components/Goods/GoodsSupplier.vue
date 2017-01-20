<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>关联供应商</h5>
                </div>
                <div class="ibox-content">
                    <form method="get" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">商品名称</label>

                            <div class="col-sm-4">
                                <p class="form-control">{{goods_name}}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">供应商</label>

                            <div class="col-sm-4">
                                <select v-model="supplier.supplier_id" data-placeholder="请选择供应商..." class="chosen-select" style="width:100%;" tabindex="2">
                                    <option value="0" hassubinfo="true">请选择供应商</option>
                                    <template v-for="s in suppliers">
                                        <option value="{{s.id}}">{{s.name}}</option>
                                    </template>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">采购价</label>

                            <div class="col-sm-4">
                                <input type="text" v-model="supplier.price" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">含税采购价</label>

                            <div class="col-sm-4">
                                <input type="text" v-model="supplier.tax_price" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">生产商名称</label>

                            <div class="col-sm-4">
                                <input type="text" v-model="supplier.mfrs_name" class="form-control">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="button" @click="postGoodsSupplier()">保存内容</button>
                                <button class="btn btn-white" type="button">取消</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default{
        created(){
            this.id = 0;
            this.goods_id = 0;
            if(this.$route.name == 'goods_supplier_add'){
                this.goods_id = this.$route.params.goods_id;
            }
            if(this.$route.name == 'goods_supplier_edit'){
                this.id = this.$route.params.id;
            }
        },
        ready(){
            this.getSuppliers();
            if(this.id > 0){//编辑
                this.getGoodsSupplier();
            }
            if(this.goods_id > 0){
                this.getGoodsName();
            }
        },
        data(){
            return{
                goods_name: '',
                suppliers: {},
                supplier: {}
            }
        },
        methods:{
            getGoodsName(){
                this.$http.get('/goods/'+this.goods_id+'.json').then(function(response){
                    if(response.data.status == true){
                        this.$set('goods_name', response.data.data.cn_name+'/'+response.data.data.en_name);
                    }else{
                        toastr.error(response.data.msg);
                    }
                });
            },
            getSuppliers(){
                this.$http.get('/suppliers.json').then(function(response){
                        this.$set('suppliers',response.data.data);
                });
            },
            getGoodsSupplier(){
                this.$http.get('/goods/supplier/'+this.id+'.json').then(function(response){
                    if(response.data.status == true){
                        this.$set('supplier', response.data.data);
                        this.$set('goods_name', response.data.goods_name);
                    }else{
                        toastr.error(response.data.msg);
                    }
                });
            },
            postGoodsSupplier(){
                this.supplier.supplier_id = $(".chosen-select").val();
                if(this.id > 0){//编辑
                    this.$http.put('/goods/supplier/'+this.id+'.json', this.supplier).then(function(response){
                        if(response.data.status == true){
                            this.$route.router.go({path: '/goods/info/'+this.goods_id})
                        }else{
                            toastr.error(response.data.msg);
                        }
                    });
                }else{//新增
                    this.$http.post('/goods/supplier/'+this.goods_id+'.json', this.supplier).then(function(response){
                        if(response.data.status == true){
                            this.$route.router.go({path: '/goods/info/'+this.goods_id})
                        }else{
                            toastr.error(response.data.msg);
                        }
                    });
                }
            }
        },
        watch:{
            'suppliers':function () {
                this.$nextTick(function(){
                    $(".chosen-select").chosen();
                    $(".chosen-select").val(this.supplier.supplier_id);
                    $(".chosen-select").trigger("chosen:updated");
                })
            }
        },
    }
</script>
