<template>
    <div class="clients-list">
        <ul class="nav nav-tabs">
            <li v-bind:class="{active:active==0}"><a data-toggle="tab" href="#tab-1"><i class="fa fa-cubes"></i> 询价记录</a></li>
            <li v-bind:class="{active:active==1}"><a data-toggle="tab" href="#tab-2"><i class="fa fa-briefcase"></i> 采购记录</a></li>
            <li v-bind:class="{active:active==2}" v-if="show_new_tab"><a data-toggle="tab" href="#tab-3"><i class="fa fa-briefcase"></i> {{new_tab_name}}订单详情</a></li>
        </ul>
        <div class="tab-content">
            <div id="tab-1" class="tab-pane" v-bind:class="{active:active==0}">
                <div class="full-height-scroll">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <th>产品编号</th>
                                <th>图片</th>
                                <th>原厂编号</th>
                                <th>英文品名</th>
                                <th>适用车型</th>
                                <th>供应商</th>
                                <th>FOB</th>
                                <th>采购价(含)</th>
                                <th>采购价(不含)</th>
                                <th><a @click="addXj()" class="btn btn-info btn-xs">添加询价记录</a></th>
                            </thead>
                            <tbody class="xj-sortable-list connectList">
                                <tr id="xj_{{x.id}}" v-for="x in xjs">
                                    <td>{{x.product_sn}}</td>
                                    <td><div class="goods_list_img"><img class="goods_img" v-if="x.img" v-bind:src="x.img"></div></td>
                                    <td>{{x.mfrs_sn}}</td>
                                    <td>{{x.en_name}}</td>
                                    <td>{{x.car_type}}</td>
                                    <td>{{x.supplier}}</td>
                                    <td v-if="x.edit"><input type="number" class="form-control" v-model="x.fob_price"></td><td v-else>{{x.fob_price}}</td>
                                    <td v-if="x.edit"><input type="number" class="form-control" v-model="x.tax_price"></td><td v-else>{{x.tax_price}}</td>
                                    <td v-if="x.edit"><input type="number" class="form-control" v-model="x.price"></td><td v-else>{{x.price}}</td>
                                    <td v-if="x.edit">
                                        <a @click="submitXj(x)" class="btn btn-info btn-xs">保存</a>
                                        <span class="delimiter">|</span>
                                        <a @click="cancelXj(x,$index)" class="btn btn-success btn-xs">   取消</a>
                                    </td>
                                    <td v-else>
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
            <div id="tab-2" class="tab-pane" v-bind:class="{active:active==1}">
                <div class="full-height-scroll">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <th>合同编号</th>
                                <th>合同金额</th>
                                <th>备注</th>
                                <th>
                                    <a @click="addOrder()" class="btn btn-info btn-xs">添加订单</a>
                            </thead>
                            <tbody class="supplier-sortable-list connectList">
                                <tr id="order_{{o.id}}" v-for="o in orders">
                                    <td>{{o.contract_sn}}</td>
                                    <td v-if="o.edit"><input type="number" class="form-control" v-model="o.price"></td><td v-else>{{parseFloat(o.price)}}</td>
                                    <td v-if="o.edit"><input type="text" class="form-control" v-model="o.mark"></td><td v-else>{{o.mark}}</td>
                                    <td v-if="o.edit">
                                        <a @click="submitOrder(o)" class="btn btn-info btn-xs">保存</a>
                                        <span class="delimiter">|</span>
                                        <a @click="cancelOrder(o,$index)" class="btn btn-success btn-xs">   取消</a>
                                    </td>
                                    <td v-else>
                                        <a @click="editOrder(o)"><i class="fa fa-edit"></i> 编辑</a>
                                        <span class="delimiter">|</span>
                                        <a @click="getOrderInfo(o.id, o.contract_sn)"><i class="fa fa-edit"></i> 查看详情</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="tab-3" class="tab-pane" v-bind:class="{active:active==2}" v-if="show_new_tab">
                <div class="full-height-scroll">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                            <th>产品编号</th>
                            <th>图片</th>
                            <th>原厂编号</th>
                            <th>英文品名</th>
                            <th>适用车型</th>
                            <th>供应商</th>
                            <th>FOB</th>
                            <th>采购价(含)</th>
                            <th>采购价(不含)</th>
                            <th>
                                <a @click="addOrderInfo()" class="btn btn-info btn-xs">添加订单商品</a>
                                <span class="delimiter">|</span>
                                <a @click="closeOrderInfoTab()" class="btn btn-info btn-xs">关闭</a>
                            </th>
                            </thead>
                            <tbody class="xj-sortable-list connectList">
                            <tr id="goods_{{x.id}}" v-for="x in goodses">
                                <td>{{x.product_sn}}</td>
                                <td><div class="goods_list_img"><img class="goods_img" v-if="x.img" v-bind:src="x.img"></div></td>
                                <td>{{x.mfrs_sn}}</td>
                                <td>{{x.en_name}}</td>
                                <td>{{x.car_type}}</td>
                                <td>{{x.supplier}}</td>
                                <td v-if="x.edit"><input type="number" class="form-control" v-model="x.fob_price"></td><td v-else>{{x.fob_price}}</td>
                                <td v-if="x.edit"><input type="number" class="form-control" v-model="x.tax_price"></td><td v-else>{{x.tax_price}}</td>
                                <td v-if="x.edit"><input type="number" class="form-control" v-model="x.price"></td><td v-else>{{x.price}}</td>
                                <td v-if="x.edit">
                                    <a @click="submitOrderInfo(x)" class="btn btn-info btn-xs">保存</a>
                                    <span class="delimiter">|</span>
                                    <a @click="cancelOrder(x,$index)" class="btn btn-success btn-xs">   取消</a>
                                </td>
                                <td v-else>
                                    <a @click="editXj(x)"><i class="fa fa-edit"></i> 编辑</a>
                                    <span class="delimiter">|</span>
                                    <a @click="deleteOrderInfo(x.id)"><i class="fa fa-remove"></i>   删除</a>
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
            //this.$root.popup = true;
        },
        data(){
            return{
                xjs: {},
                orders:{},
                show_new_tab: false,
                new_tab_name: '',
                goodses: {},
                tab_order_id: 0,
                tab_contract_sn: '',
                active: 0,
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
            addXj(){
                this.$root.tag_id = this.customer_id;
                this.goodsPop(0);
            },
            goodsPop(type){
                var _this = this;
                this.$root.type = type;
                layer.open({
                    type: 1,
                    title: '选择产品', //不显示标题
                    move: false,
                    area: '600px',
                    offset: '100px',
                    zIndex: 1989101400,
                    content: $('#goods_list_popup'), //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
                    ready: function(){
                        _this.$root.popup = true;
                    },
                    success: function () {
                        _this.$root.popup = true;
                    },
                    cancel: function () {
                        _this.$root.popup = false;
                    },
                    end: function () {
                        _this.$root.popup = false;
                        type==0 ? _this.getXjs() : _this.getOrderInfo(_this.tab_order_id,_this.tab_contract_sn);
                        console.log(_this.active)
                    }
                });
            },
            editXj(xj){
                xj.edit = true;
            },
            cancelXj(xj, index){
                if(xj.id == 0){
                    this.xjs.splice(index,1);
                }else{
                    xj.edit = false;
                }
            },
            submitXj(xj){
                this.submitUse(xj,0);
            },
            submitUse(data,type){
                var _this = this;
                this.$http.put('/customer/xjs/'+data.id+'.json', data).then(function(response){
                    if(response.data.status == false){
                        toastr.error(response.data.msg);
                    }else{
                        type==0 ? _this.getXjs() : _this.getOrderInfo(_this.tab_order_id,_this.tab_contract_sn);
                    }
                });
            },
            deleteXj(id){
                this.deleteUse(id,0);
            },
            deleteUse(id,type){
                var _this = this;
                layer.confirm('确认删除？', {
                    btn: ['确认','取消'] //按钮
                }, function(index){
                    _this.$http.delete('/customer/xjs/'+id+'.json').then(function(response){
                        if(response.data.status == false){
                            toastr.error(response.data.msg);
                        }else{
                            type==0 ? _this.getXjs() : _this.getOrderInfo(_this.tab_order_id,_this.tab_contract_sn);
                            layer.close(index);
                        }
                    });
                });
            },
            getOrders(){
                this.$http.get('/customer/orders/'+this.customer_id+'.json').then(function (response) {
                    this.$set('orders', response.data);
                });
            },
            addOrder(){
                var new_order = {};
                new_order.id = 0;
                new_order.price = 0;
                new_order.mark = '';
                new_order.edit = true;
                this.$http.get('/customer/contract_sn/'+this.customer_id+'.json').then(function (response) {
                    new_order.contract_sn = response.data
                    this.orders.push(new_order);
                });
            },
            editOrder(order){
                order.edit = true;
            },
            cancelOrder(order, index){
                if(order.id == 0){
                    this.orders.splice(index,1);
                }else{
                    order.edit = false;
                }
            },
            submitOrder(order){
                if(order.id == 0){//添加
                    this.$http.post('/order/add/'+this.customer_id+'.json', order).then(function(response){
                        if(response.data.status == false){
                            toastr.error(response.data.msg);
                        }else{
                            order.id = response.data.data.id;
                            this.getOrders();
                        }
                    });
                }else{
                    this.$http.put('/order/'+order.id+'.json', order).then(function(response){
                        if(response.data.status == false){
                            toastr.error(response.data.msg);
                        }else{
                            this.getOrders();
                        }
                    });
                }
            },
            getOrderInfo(order_id,contract_sn){
                this.$http.get('/customer/order_info/'+order_id+'.json').then(function (response) {
                    this.$set('goodses', response.data);
                    this.active != 2 ? $('.active').removeClass('active') : '';
                    this.show_new_tab = true;
                    this.active = 2;
                    this.tab_contract_sn = this.new_tab_name = contract_sn;
                    this.tab_order_id = order_id
                });
            },
            closeOrderInfoTab(){
                this.show_new_tab = false;
                this.active = 1;
                //this.goodses = {}
            },
            addOrderInfo(){
                this.$root.tag_id = this.tab_order_id;
                this.goodsPop(1);
            },
            deleteOrderInfo(id){
                this.deleteUse(id,1);
            },
            submitOrderInfo(info){
                this.submitUse(info,1);
            },
        }
    }
</script>
