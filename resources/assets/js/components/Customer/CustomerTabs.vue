<template>
    <div class="clients-list">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab-1"><i class="fa fa-cubes"></i> 询价记录</a></li>
            <li class=""><a data-toggle="tab" href="#tab-2"><i class="fa fa-briefcase"></i> 采购记录</a></li>
        </ul>
        <div class="tab-content">
            <div id="tab-1" class="tab-pane active">
                <div class="full-height-scroll">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <th>产品编号</th>
                                <th>图片</th>
                                <th>原厂编号</th>
                                <th>英文品名</th>
                                <th>适用车型</th>
                                <th>FOB</th>
                                <th>供应商</th>
                                <th><a @click="addXj()" class="btn btn-info btn-xs">添加询价记录</a></th>
                            </thead>
                            <tbody class="xj-sortable-list connectList">
                                <tr id="xj_{{x.id}}" v-for="x in xjs">
                                    <td>{{x.product_sn}}</td>
                                    <td><img class="goods_img"  v-bind:src="x.img"></td>
                                    <td>{{x.mfrs_sn}}</td>
                                    <td>{{x.en_name}}</td>
                                    <td>{{x.car_type}}</td>
                                    <td>{{x.fob_price}}</td>
                                    <td>{{x.supplier}}</td>
                                    <td>
                                        <a @click="editXj(x)"><i class="fa fa-edit"></i> 编辑</a>
                                        <span class="delimiter">|</span>
                                        <a @click="deleteXj(x.id)"><i class="fa fa-remove"></i>   删除</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="tab-2" class="tab-pane">
                <div class="full-height-scroll">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <th>合同编号</th>
                                <th>合同金额</th>
                                <th>备注</th>
                                <th>
                                    <a v-link="{path:'/order/add'}" class="btn btn-info btn-xs">添加订单</a>
                            </thead>
                            <tbody class="supplier-sortable-list connectList">
                                <tr id="order_{{o.id}}" v-for="o in orders">
                                    <td>{{o.contract_sn}}</td>
                                    <td>{{parseFloat(o.price)}}</td>
                                    <td>{{o.mark}}</td>
                                    <td>
                                        <a v-link="{name:'order_detail', params:{id:s.id}}"><i class="fa fa-edit"></i> 查看详情</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style>

</style>
<script>
    export default{
        props: ['customer_id'],
        ready(){
            this.getXjs();
            this.getOrders();
            var _this = this;
            $('.fancybox').fancybox({
                openEffect: 'none',
                closeEffect: 'none'
            });
        },
        data(){
            return{
                xjs: {},
                orders:{}
            }
        },
        components:{

        },
        methods:{
            getXjs(){
                this.$http.get('/customer/xjs/'+this.customer_id+'.json').then(function (response) {
                    this.$set('xjs', response.data);
                });
            },
            deleteXjs(id){
                this.$http.delete('/customer/xjs/'+id+'.json').then(function(response){
                    if(response.data.status == true){
                        this.getXjs();
                    }else{
                        toastr.error(response.data.msg);
                    }
                });
            },
            getOrders(){
                this.$http.get('/customer/orders/'+this.customer_id+'.json').then(function (response) {
                    this.$set('orders', response.data);
                });
            }
        }
    }
</script>
