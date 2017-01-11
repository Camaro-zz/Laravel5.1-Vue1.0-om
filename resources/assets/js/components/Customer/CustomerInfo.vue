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
                                        <a @click="showEditInfo()" class="btn btn-info btn-xs pull-right">编辑客户</a>
                                    </div>
                                    <div class="goods_info_edit" style="display:none !important;">
                                        <a @click="cancelEditInfo()" class="btn btn-xs btn-warning pull-right">取消编辑</a>
                                        <a @click="putCustomer()" class="btn btn-primary btn-xs pull-right" style="margin-right:10px">保存客户</a>
                                    </div>
                                    <h2>{{customer.customer_sn}}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 goods_info_show">
                                <img alt="image" class="img-responsive info_bigimg" v-bind:src="customer.img">
                            </div>
                            <div class="col-sm-7 form-horizontal goods_info_show">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">客户名称：</label>

                                    <div class="col-sm-4">
                                        <p>{{customer.name}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">客户编号：</label>

                                    <div class="col-sm-4">
                                        <p>{{customer.customer_sn}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">联系人：</label>

                                    <div class="col-sm-4">
                                        <p>{{customer.contact}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">国家：</label>

                                    <div class="col-sm-4">
                                        <p>{{customer.country}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">地址：</label>

                                    <div class="col-sm-6">
                                        <p>{{customer.address}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">邮箱：</label>

                                    <div class="col-sm-6">
                                        <p>{{customer.email}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">电话：</label>

                                    <div class="col-sm-6">
                                        <p>{{customer.tel}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">手机：</label>

                                    <div class="col-sm-6">
                                        <p>{{customer.mobile}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">备注：</label>

                                    <div class="col-sm-6">
                                        <p>{{customer.mark}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 goods_info_edit" style="display:none !important;">
                                <a id="dropz" class=" btn btn-info btn-xs pull-right">重新上传</a>
                                <img alt="image" class="dropzone-previews img-responsive info_bigimg" v-bind:src="customer.img">
                            </div>
                            <div class="col-sm-7 form-horizontal goods_info_edit" style="display:none !important;">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">客户名称：</label>

                                    <div class="col-sm-4">
                                        <input type="text" v-model="customer.name" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">客户编号：</label>

                                    <div class="col-sm-4">
                                        <input type="text" v-model="customer.customer_sn" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">联系人：</label>

                                    <div class="col-sm-4">
                                        <input type="text" v-model="customer.contact" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">国家：</label>

                                    <div class="col-sm-4">
                                        <input type="text" v-model="customer.country" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">地址：</label>

                                    <div class="col-sm-4">
                                        <input type="text" v-model="customer.address" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">邮箱：</label>

                                    <div class="col-sm-4">
                                        <input type="text" v-model="customer.email" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">电话：</label>

                                    <div class="col-sm-4">
                                        <input type="text" v-model="customer.tel" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">手机：</label>

                                    <div class="col-sm-4">
                                        <input type="text" v-model="customer.mobile" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">备注：</label>

                                    <div class="col-sm-6">
                                        <textarea class="form-control" rows="10" v-model="customer.mark">

                                        </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="row m-t-sm">
                            <div class="col-sm-12">
                                <Customertabs :customer_id="customer_id"></Customertabs>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Customertabs from './CustomerTabs.vue'
    export default{
        created(){
            this.customer_id = this.$route.params.id;
        },
        ready(){
            this.getCustomer();
            var _this = this;
            $("#dropz").dropzone({
                url: "/upload.json",
                maxFiles: 10,
                maxFilesize: 512,
                acceptedFiles: ".png,.jpg,.jpeg,.gif",
                previewTemplate: '<div></div>',
                success:function (file, response, e) {
                    if(response.status == true){
                        _this.$set('customer.img',response.path);
                    }
                }
            });
        },
        data(){
            return{
                customer: {},
                customer_id: 0,
                old_img: ''
            }
        },
        components:{
            Customertabs
        },
        methods:{
            getCustomer(){
                this.$http.get('/customer/'+this.customer_id+'.json').then(function(response){
                    if(response.data.status == true){
                        this.$set('customer', response.data.data);
                        this.$set('old_img', response.data.data.img);
                    }else{
                        toastr.error(response.data.msg);
                    }
                });
            },
            putCustomer(){
                var customer_data = {};
                customer_data.name = this.customer.name;
                customer_data.img = this.customer.img;
                customer_data.customer_sn = this.customer.customer_sn;
                customer_data.contact = this.customer.contact;
                customer_data.mark = this.customer.mark;
                customer_data.country = this.customer.country;
                customer_data.address = this.customer.address;
                customer_data.tel = this.customer.tel;
                customer_data.email = this.customer.email;
                customer_data.mobile = this.customer.mobile;
                this.$http.put('/customer/'+this.customer_id+'.json',customer_data).then(function(response){
                    if(response.data.status == true){
                        this.$set('customer', response.data.data);
                        this.hideEditInfo();
                    }else{
                        toastr.error(response.data.msg);
                    }
                });
            },
            showEditInfo(){
                $('.goods_info_show').hide();
                $('.goods_info_edit').show();
            },
            hideEditInfo(){
                $('.goods_info_show').show();
                $('.goods_info_edit').hide();
            },
            cancelEditInfo(){
                this.getCustomer();
                this.hideEditInfo();
                this.$set('customer.img',this.old_img);
            }
        },
        watch:{
        },
    }
</script>
