<template>
    <div class="clients-list">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab-1"><i class="fa fa-cubes"></i> 图片</a></li>
            <li class=""><a data-toggle="tab" href="#tab-2"><i class="fa fa-briefcase"></i> 原厂编号</a></li>
            <li class=""><a data-toggle="tab" href="#tab-3"><i class="fa fa-briefcase"></i> 供应商</a></li>
            <li class=""><a data-toggle="tab" href="#tab-4"><i class="fa fa-briefcase"></i> 适用车型</a></li>
            <li class=""><a data-toggle="tab" href="#tab-5"><i class="fa fa-briefcase"></i> 报价记录</a></li>
        </ul>
        <div class="tab-content">
            <div id="tab-1" class="tab-pane active">
                <div class="full-height-scroll">
                    <div class="table-responsive">
                        <template v-for="img in imgs">
                        <a class="fancybox" href="{{img.img}}">
                            <img alt="image" v-bind:src="img.img" />
                        </a>
                        </template>
                    </div>
                </div>
            </div>
            <div id="tab-2" class="tab-pane">
                <div class="full-height-scroll">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <th>原厂商</th>
                                <th>原厂编号</th>
                                <th><a @click="addMfrs()" class="btn btn-info btn-xs">添加原厂编号</a></th>
                            </thead>
                            <tbody class="mfrs-sortable-list connectList">
                                <tr id="mfrs_{{m.id}}" v-for="m in mfrs">
                                    <td>{{m.mfrs_name}}</td>
                                    <td>{{m.mfrs_sn}}</td>
                                    <td>
                                        <a @click="editMfrs(m)"><i class="fa fa-edit"></i> 编辑</a>
                                        <span class="delimiter">|</span>
                                        <a @click="deleteMfrs(m.id)"><i class="fa fa-remove"></i>   删除</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="tab-3" class="tab-pane">
                <div class="full-height-scroll">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <th>供应商编号</th>
                                <th>供应商名称</th>
                                <th>采购价(含税)</th>
                                <th>采购价(不含税)</th>
                                <th>其他</th>
                                <th><a @click="addSupplier()" class="btn btn-info btn-xs">添加供应商</a></th>
                            </thead>
                            <tbody class="supplier-sortable-list connectList">
                                <tr id="supplier_{{s.id}}" v-for="s in suppliers">
                                    <td>{{s.supplier_sn}}</td>
                                    <td>{{s.name}}</td>
                                    <td>{{(parseFloat(s.price) + parseFloat(s.tax)).toFixed(2)}}</td>
                                    <td>{{s.price}}</td>
                                    <td>{{s.price}}</td>
                                    <td>
                                        <a @click="editSupplier(s)"><i class="fa fa-edit"></i> 编辑</a>
                                        <span class="delimiter">|</span>
                                        <a @click="deleteSupplier(s.id)"><i class="fa fa-remove"></i>   删除</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="tab-4" class="tab-pane">
                <div class="full-height-scroll">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                            <th>品牌</th>
                            <th>车型</th>
                            <th>发动机</th>
                            <th>年份</th>
                            <th></th>
                            </thead>
                            <tbody class="sortable-list connectList">
                            <tr id="cartype_{{s.id}}" v-for="c in car_types">
                                <td>{{c.name}}</td>
                                <td>{{c.car_type}}</td>
                                <td>{{c.engine}}</td>
                                <td>
                                    <a @click="editCartype(c)"><i class="fa fa-edit"></i> 编辑</a>
                                    <span class="delimiter">|</span>
                                    <a @click="deleteCartype(c.id)"><i class="fa fa-remove"></i>   删除</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="tab-5" class="tab-pane">
                <div class="full-height-scroll">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                            <th>客户编号</th>
                            <th>公司名</th>
                            <th>联系人</th>
                            <th>邮箱</th>
                            <th>FOB</th>
                            <th></th>
                            </thead>
                            <tbody class="sortable-list connectList">
                            <tr id="offer_{{o.id}}" v-for="o in offers">
                                <td>{{o.customer_sn}}</td>
                                <td>广州</td>
                                <td><i class="fa fa-flag"></i> 中国</td>
                                <td class="client-status"><span class="label label-primary">已验证</span>
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
    import Goodsmfrs from './GoodsMfrs.vue'
    export default{
        props: ['goods_id'],
        ready(){
            this.getMfrses();
            this.getSuppliers();
            this.getGoodsImgs();
            var _this = this;
            $(".mfrs-sortable-list").sortable({
                update: function (event, ui) {
                    _this.sortMfrses($(this).sortable("toArray"));
                }
            }).disableSelection();
            $(".supplier-sortable-list").sortable({
                update: function (event, ui) {
                    _this.sortSuppliers($(this).sortable("toArray"));
                }
            }).disableSelection();
            $('.fancybox').fancybox({
                openEffect: 'none',
                closeEffect: 'none'
            });
        },
        data(){
            return{
                mfrs: {},
                mfrs_sort: [],
                suppliers: {},
                sup_sort:[],
                imgs:{},
                edit_mfrs_id: 0
            }
        },
        components:{
            Goodsmfrs
        },
        methods:{
            getMfrses(){
                this.$http.get('/goods/mfrs/goods/'+this.goods_id+'.json').then(function (response) {
                    this.$set('mfrs', response.data);
                });
            },
            sortMfrses(sort){
                var mfrs_length = this.mfrs.length;
                var _this = this;
                $.each(sort,function (n, i) {
                    var m = {};
                    m.sort = mfrs_length - n;
                    m.id = i;
                    _this.mfrs_sort.push(m);
                });
                this.$http.put('/mfrs/sort/'+this.goods_id+'.json', this.mfrs_sort).then(function(response){
                    this.$set('mfrs_sort',[]);
                });
            },
            deleteMfrs(id){
                this.$http.delete('/mfrs/'+id+'.json').then(function(response){
                    if(response.data.status == true){
                        this.getMfrses();
                    }else{
                        toastr.error(response.data.msg);
                    }
                });
            },
            addMfrs(){
                var _this = this;
                layer.open({
                    type: 1,
                    shade: false,
                    area: ['600px', '230px'], //宽高
                    title: '添加原厂编号',
                    btn: ['保存','取消'],
                    yes: function (index) {
                        var mfrs = {};
                        mfrs.mfrs_sn = $('.form-mfrs-sn').val();
                        mfrs.mfrs_name = $('.form-mfrs-name').val();
                        _this.postMfrs(mfrs,index);

                    },
                    content: Goodsmfrs.template,
                });
            },
            editMfrs(mfrs){
                var _this = this;
                layer.open({
                    type: 1,
                    shade: false,
                    area: ['600px', '230px'], //宽高
                    title: '编辑原厂编号',
                    btn: ['保存','取消'],
                    yes: function (index) {
                        mfrs.mfrs_sn = $('.form-mfrs-sn').val();
                        mfrs.mfrs_name = $('.form-mfrs-name').val();
                        _this.putMfrs(mfrs,index);

                    },
                    content: Goodsmfrs.template,
                    success: function(){
                        $('.form-mfrs-sn').val(mfrs.mfrs_sn);
                        $('.form-mfrs-name').val(mfrs.mfrs_name);
                    }
                });
            },
            putMfrs(mfrs, index){
                this.$http.put('/mfrs/'+mfrs.id+'.json', mfrs).then(function(response){
                    if(response.data.status == false){
                        toastr.error(response.data.msg);
                    }else{
                        layer.close(index);
                        this.getMfrses();
                    }
                });
            },
            postMfrs(mfrs,index){
                this.$http.post('/goods/mfrs/'+this.goods_id+'.json', mfrs).then(function(response){
                    if(response.data.status == false){
                        toastr.error(response.data.msg);
                    }else{
                        layer.close(index);
                        this.getMfrses();
                    }
                });
            },
            getSuppliers(){
                this.$http.get('/goods/supplier/'+this.goods_id+'.json').then(function (response) {
                    this.$set('suppliers', response.data);
                });
            },
            sortSuppliers(sort){
                var sup_length = this.suppliers.length;
                var _this = this;
                $.each(sort,function (n, i) {
                    var m = {};
                    m.sort = sup_length - n;
                    m.id = i;
                    _this.sup_sort.push(m);
                });
                this.$http.put('/supplier/sort/'+this.goods_id+'.json', this.sup_sort).then(function(response){
                    this.$set('sup_sort',[]);
                });
            },
            getGoodsImgs(){
                this.$http.get('/goods/imgs/'+this.goods_id+'.json').then(function(response){
                    this.$set('imgs',response.data);
                });
            },
            getMfrs(){
                this.$http.get('/mfrs/'+this.id+'.json').then(function(response){
                    this.$set('mfrs', response.data.data);
                    this.$set('goods_name', response.data.goods_name);
                    this.$set('goods_id', response.data.goods_id);
                });
            },
            addSupplier(){

            }
        }
    }
</script>
