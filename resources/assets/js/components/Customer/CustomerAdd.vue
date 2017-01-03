<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>添加客户</h5>
                </div>
                <div class="ibox-content">
                    <form method="get" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">客户编号</label>

                            <div class="col-sm-4">
                                <input type="text" v-model="customer.customer_sn" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">客户名称</label>

                            <div class="col-sm-4">
                                <input type="text" v-model="customer.name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">联系人</label>

                            <div class="col-sm-4">
                                <input type="text" v-model="customer.contact" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">电话</label>

                            <div class="col-sm-4">
                                <input type="text" v-model="customer.tel" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">手机</label>

                            <div class="col-sm-4">
                                <input type="text" v-model="customer.mobile" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">邮箱</label>

                            <div class="col-sm-4">
                                <input type="text" v-model="customer.email" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">国家</label>

                            <div class="col-sm-4">
                                <input type="text" v-model="customer.country" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">地址</label>

                            <div class="col-sm-4">
                                <input type="text" v-model="customer.address" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">备注</label>

                            <div class="col-sm-4">
                                <textarea class="form-control" v-model="customer.mark">

                                </textarea>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="button" @click="postCustomer()">保存</button>
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
                this.getCustomer();
            }
        },
        data(){
            return{
                customer: {}
            }
        },
        methods:{
            getCustomer(){
                this.$http.get('/customer/'+this.id+'.json').then(function(response){
                    if(response.data.status == true){
                        this.$set('customer', response.data.data);
                    }else{
                        toastr.error(response.data.msg);
                    }
                });
            },
            postCustomer(){
                if(this.id > 0){//编辑
                    this.$http.put('/customer/'+this.id+'.json', this.customer).then(function(response){
                        if(response.data.status == true){
                            this.$route.router.go({path: '/customer/list'})
                        }else{
                            toastr.error(response.data.msg);
                        }
                    });
                }else{//新增
                    this.$http.post('/customer/add.json', this.customer).then(function(response){
                        if(response.data.status == true){
                            this.$route.router.go({path: '/customer/list'})
                        }else{
                            toastr.error(response.data.msg);
                        }
                    });
                }
            }
        }
    }
</script>
