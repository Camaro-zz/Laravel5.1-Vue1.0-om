<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>添加产品</h5>
                </div>
                <div class="ibox-content">
                    <form method="get" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">中文品名</label>

                            <div class="col-sm-4">
                                <input type="text" v-model="goods.cn_name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">英文品名</label>

                            <div class="col-sm-4">
                                <input type="text" v-model="goods.en_name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">产品类目</label>

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
                            <label class="col-sm-2 control-label">产品编号</label>

                            <div class="col-sm-4">
                                <input type="text" v-model="goods.product_sn" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">FOB价格</label>

                            <div class="col-sm-4">
                                <input type="number" step="0.01" v-model="goods.fob_price" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">适用车型</label>

                            <div class="col-sm-4">
                                <textarea class="form-control" v-model="goods.car_types">

                                </textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">备注</label>

                            <div class="col-sm-4">
                                <textarea class="form-control" v-model="goods.mark">

                                </textarea>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="submit">保存内容</button>
                                <button class="btn btn-white" type="submit">取消</button>
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
    ready(){
        this.getCats();
    },
    data(){
        return{
            cats: [],
            goods: {
                cat_id:0
            },
        }
    },
    methods:{
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
        postGoods(){
            if(this.goods.cn_name){
                return false;
            }
            if(this.goods.en_name){
                return false;
            }
            if(this.goods.product_sn){
                return false;
            }
            if(this.goods.cat_id == 0){
                return false;
            }
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
