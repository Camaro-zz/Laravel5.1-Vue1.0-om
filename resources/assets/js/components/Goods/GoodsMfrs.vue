<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>添加生产商</h5>
                </div>
                <div class="ibox-content">
                    <form method="get" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">关联产品名称</label>

                            <div class="col-sm-4">
                                <p class="form-control" style="font-size: 20px">{{goods_name}}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">原厂编号</label>

                            <div class="col-sm-4">
                                <input type="text" v-model="mfrs.mfrs_sn" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">生产商名称</label>

                            <div class="col-sm-4">
                                <input type="text" v-model="mfrs.mfrs_name" class="form-control">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="button" @click="postMfrs()">保存内容</button>
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
            this.goods_id = 0;
            this.id = 0;
            if(this.$route.name == 'goods_mfrs_add'){
                this.goods_id = this.$route.params.goods_id;
            }
            if(this.$route.name == 'goods_mfrs_edit'){
                this.id = this.$route.params.id;
            }
        },
        ready(){
            if(this.goods_id > 0){
                this.getGoodsName();
            }
            if(this.id > 0){
                this.getMfrs();
            }
        },
        data(){
            return{
                goods_name: '',
                mfrs: {}
            }
        },
        methods:{
            getGoodsName(){
                this.$http.get('/goods/'+this.goods_id+'.json').then(function(response){
                    if(response.data.status == true){
                        this.$set('goods_name', response.data.data.en_name);
                    }else{
                        toastr.error(response.data.msg);
                    }
                });
            },
            postMfrs(){
                if(this.id > 0){//编辑
                    this.$http.put('/mfrs/'+this.id+'.json', this.mfrs).then(function(response){
                        if(response.data.status == true){
                            this.$route.router.go({path: '/goods/edit/'+this.goods_id})
                        }else{
                            toastr.error(response.data.msg);
                        }
                    });
                }else{
                    this.$http.post('/goods/mfrs/'+this.goods_id+'.json', this.mfrs).then(function(response){
                        if(response.data.status == true){
                            this.$route.router.go({path: '/goods/edit/'+this.goods_id})
                        }else{
                            toastr.error(response.data.msg);
                        }
                    });
                }
            },
            getMfrs(){
                this.$http.get('/mfrs/'+this.id+'.json').then(function(response){
                    this.$set('mfrs', response.data.data);
                    this.$set('goods_name', response.data.goods_name);
                    this.$set('goods_id', response.data.goods_id);
                });
            }
        }
    }
</script>
