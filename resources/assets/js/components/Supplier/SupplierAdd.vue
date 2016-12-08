<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>添加供应商</h5>
                </div>
                <div class="ibox-content">
                    <form method="get" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">供应商编号</label>

                            <div class="col-sm-4">
                                <input type="text" v-model="supplier.supplier_sn" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">供应商名称</label>

                            <div class="col-sm-4">
                                <input type="text" v-model="supplier.name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">联系人</label>

                            <div class="col-sm-4">
                                <input type="text" v-model="supplier.contacts" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">电话</label>

                            <div class="col-sm-4">
                                <input type="text" v-model="supplier.tel" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">手机</label>

                            <div class="col-sm-4">
                                <input type="text" v-model="supplier.mobile" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">QQ</label>

                            <div class="col-sm-4">
                                <input type="text" v-model="supplier.qq" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">网址</label>

                            <div class="col-sm-4">
                                <input type="text" v-model="supplier.website" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">地址</label>

                            <div class="col-sm-4">
                                <input type="text" v-model="supplier.address" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">备注</label>

                            <div class="col-sm-4">
                                <textarea class="form-control" v-model="supplier.mark">

                                </textarea>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="button" @click="postSupplier()">保存内容</button>
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
            this.id = this.$route.params.id;
            if(this.id > 0){//编辑
                this.getSupplier();
            }
        },
        data(){
            return{
                supplier: {}
            }
        },
        methods:{
            getSupplier(){
                this.$http.get('/supplier/'+this.id+'.json').then(function(response){
                    if(response.data.status == true){
                        this.$set('supplier', response.data.data);
                    }else{
                        toastr.error(response.data.msg);
                    }
                });
            },
            postSupplier(){
                if(this.id > 0){//编辑
                    this.$http.put('/supplier/'+this.id+'.json', this.supplier).then(function(response){
                        if(response.data.status == true){
                            this.$route.router.go({path: '/supplier/list'})
                        }else{
                            toastr.error(response.data.msg);
                        }
                    });
                }else{//新增
                    this.$http.post('/supplier/add.json', this.supplier).then(function(response){
                        if(response.data.status == true){
                            this.$route.router.go({path: '/supplier/list'})
                        }else{
                            toastr.error(response.data.msg);
                        }
                    });
                }
            }
        }
    }
</script>
