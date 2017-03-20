<template>
    <div class="clients-list">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab-1"><i class="fa fa-photo"></i> 图片</a></li>
            <li class=""><a data-toggle="tab" href="#tab-2"><i class="fa fa-cubes"></i> 原厂编号</a></li>
            <li class=""><a data-toggle="tab" href="#tab-3"><i class="fa fa-magnet"></i> 供应商</a></li>
            <li class=""><a data-toggle="tab" href="#tab-4"><i class="fa fa-car"></i> 适用车型</a></li>
            <li class=""><a data-toggle="tab" href="#tab-5"><i class="fa fa-briefcase"></i> 报价记录</a></li>
            <li class=""><a data-toggle="tab" href="#tab-6"><i class="fa fa-inbox"></i> 包装细节</a></li>
        </ul>
        <div class="tab-content">
            <div id="tab-1" class="tab-pane active">
                <Goodsimgs :goods_id="goods_id" :goods="goods"></Goodsimgs>
            </div>
            <div id="tab-2" class="tab-pane">
                <Goodsmfrs :goods_id="goods_id" :goods="goods"></Goodsmfrs>
            </div>
            <div id="tab-3" class="tab-pane">
                <Goodssuppliers :goods_id="goods_id" :goods="goods"></Goodssuppliers>
            </div>
            <div id="tab-4" class="tab-pane">
                <Goodscartypes :goods_id="goods_id" :goods="goods"></Goodscartypes>
            </div>
            <div id="tab-5" class="tab-pane">
                <Goodsxjs :goods_id="goods_id" :goods="goods"></Goodsxjs>

            </div>
            <div id="tab-6" class="tab-pane">
                <Goodspack :goods_id="goods_id" :goods="goods"></Goodspack>
            </div>
        </div>
    </div>
</template>
<style>

</style>
<script>
    import Goodsimgs from './GoodsTabsImgs.vue'
    import Goodsmfrs from './GoodsTabsMfrs.vue'
    import Goodssuppliers from './GoodsTabsSuppliers.vue'
    import Goodscartypes from './GoodsTabsCartypes.vue'
    import Goodspack from './GoodsTabsPack.vue'
    import Goodsxjs from './GoodsTabsXjs.vue'
    export default{
        props: ['goods_id','goods'],
        ready(){

        },
        data(){
            return{

            }
        },
        components:{
            Goodsimgs,
            Goodsmfrs,
            Goodssuppliers,
            Goodscartypes,
            Goodspack,
            Goodsxjs
        },
        methods:{
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
