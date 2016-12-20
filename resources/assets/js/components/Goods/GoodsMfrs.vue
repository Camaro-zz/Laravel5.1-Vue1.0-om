<template>
    <div class="ibox-content">
        <form method="get" class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-3 control-label">关联产品名称</label>

                <div class="col-sm-8">
                    <p class="form-control" style="font-size: 20px">{{goods_name}}</p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">原厂编号</label>

                <div class="col-sm-8">
                    <input type="text" v-model="mfrs.mfrs_sn" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">生产商名称</label>

                <div class="col-sm-8">
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
</template>

<script>
    export default{
        props: ['goods_id','id'],
        ready(){
            if(this.goods_id > 0){
                this.getGoodsName();
            }
            if(this.id > 0){
                this.getMfrs();
            }
            console.log(this.goods_id);
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
