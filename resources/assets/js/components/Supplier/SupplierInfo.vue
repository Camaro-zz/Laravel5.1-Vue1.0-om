<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="wrapper wrapper-content animated fadeInUp">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="m-b-md">
                                    <h2 style="display:inline-block">供应商编号：{{supplier.supplier_sn}}</h2>
                                    <span class="goods_info_show">
                                        <a @click="showEditInfo()" class="btn btn-info btn-sm">编辑供应商</a>
                                    </span>
                                    <span class="goods_info_edit" style="display:none !important;">
                                        <a @click="putSupplier()" class="btn btn-primary btn-sm" style="margin-right:10px">保存供应商</a>
                                        <a @click="cancelEditInfo()" class="btn btn-sm btn-warning">取消编辑</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 form-horizontal goods_info_show">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">供应商名称：</label>

                                    <div class="col-sm-4">
                                        <p>{{supplier.name}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">联系人：</label>

                                    <div class="col-sm-4">
                                        <p>{{supplier.contacts}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">地址：</label>

                                    <div class="col-sm-6">
                                        <p>{{supplier.address}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">手机：</label>

                                    <div class="col-sm-6">
                                        <p>{{supplier.mobile}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 form-horizontal goods_info_show">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">QQ：</label>

                                    <div class="col-sm-4">
                                        <p>{{supplier.qq}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">网址：</label>

                                    <div class="col-sm-6">
                                        <p>{{supplier.website}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">电话：</label>

                                    <div class="col-sm-6">
                                        <p>{{supplier.tel}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">备注：</label>

                                    <div class="col-sm-6">
                                        <p>{{supplier.mark}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 goods_info_show">
                                <template v-if="supplier.img != ''">
                                    <img alt="image" class="img-responsive info_bigimg" v-bind:src="supplier.img">
                                </template>
                            </div>
                            <div class="col-sm-7 form-horizontal goods_info_edit" style="display:none !important;">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">供应商名称：</label>

                                    <div class="col-sm-4">
                                        <input type="text" v-model="supplier.name" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">联系人：</label>

                                    <div class="col-sm-4">
                                        <input type="text" v-model="supplier.contacts" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">地址：</label>

                                    <div class="col-sm-4">
                                        <input type="text" v-model="supplier.address" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">手机：</label>

                                    <div class="col-sm-4">
                                        <input type="text" v-model="supplier.mobile" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">QQ：</label>

                                    <div class="col-sm-4">
                                        <input type="text" v-model="supplier.qq" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">网址：</label>

                                    <div class="col-sm-4">
                                        <input type="text" v-model="supplier.website" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">电话：</label>

                                    <div class="col-sm-4">
                                        <input type="text" v-model="supplier.tel" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">备注：</label>

                                    <div class="col-sm-6">
                                        <textarea class="form-control" rows="10" v-model="supplier.mark">

                                        </textarea>
                                    </div>
                                </div>
                                <div class="form-group" style="text-align:center">
                                    <a @click="putSupplier()" class="btn btn-primary btn-sm" style="margin-right:10px">保存供应商</a>
                                    <a @click="cancelEditInfo()" class="btn btn-sm btn-warning">取消编辑</a>
                                </div>
                            </div>
                            <div class="col-sm-4 goods_info_edit" style="display:none !important;">
                                <a id="dropz" class=" btn btn-info btn-sm">重新上传</a>
                                <template v-if="supplier.img != ''">
                                    <img alt="image" class="dropzone-previews img-responsive info_bigimg" v-bind:src="supplier.img">
                                </template>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="row m-t-sm">
                            <div class="col-sm-12">
                                <Suppliertabs :supplier_id="supplier_id"></Suppliertabs>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Suppliertabs from './SupplierTabs.vue'
    export default{
        created(){
            this.supplier_id = this.$route.params.id;
        },
        ready(){
            this.type = this.$route.query.type ? this.$route.query.type : 0;
            if(this.type == 1){
                this.showEditInfo();
            }
            this.getSupplier();
            var _this = this;
            $("#dropz").dropzone({
                url: "/upload.json",
                maxFiles: 10,
                maxFilesize: 512,
                acceptedFiles: ".png,.jpg,.jpeg,.gif",
                previewTemplate: '<div></div>',
                success:function (file, response, e) {
                    if(response.status == true){
                        _this.$set('supplier.img',response.path);
                    }
                }
            });
        },
        data(){
            return{
                supplier: {},
                supplier_id: 0,
                old_img: ''
            }
        },
        components:{
            Suppliertabs
        },
        methods:{
            getSupplier(){
                this.$http.get('/supplier/'+this.supplier_id+'.json').then(function(response){
                    if(response.data.status == true){
                        this.$set('supplier', response.data.data);
                        this.$set('old_img', response.data.data.img);
                    }else{
                        toastr.error(response.data.msg);
                    }
                });
            },
            putSupplier(){
                var supplier_data = {};
                supplier_data.name = this.supplier.name;
                supplier_data.img = this.supplier.img;
                supplier_data.supplier_sn = this.supplier.supplier_sn;
                supplier_data.contacts = this.supplier.contacts;
                supplier_data.mark = this.supplier.mark;
                supplier_data.qq = this.supplier.qq;
                supplier_data.address = this.supplier.address;
                supplier_data.tel = this.supplier.tel;
                supplier_data.email = this.supplier.email;
                supplier_data.mobile = this.supplier.mobile;
                supplier_data.website = this.supplier.website;
                this.$http.put('/supplier/'+this.supplier_id+'.json',supplier_data).then(function(response){
                    if(response.data.status == true){
                        this.$set('supplier', response.data.data);
                        if(this.type == 1){
                            this.$route.router.go({path: '/supplier/info/'+this.supplier_id})
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
            },
            hideEditInfo(){
                $('.goods_info_show').show();
                $('.goods_info_edit').hide();
            },
            cancelEditInfo(){
                this.getSupplier();
                this.hideEditInfo();
                this.$set('supplier.img',this.old_img);
            }
        },
        watch:{
        },
    }
</script>
