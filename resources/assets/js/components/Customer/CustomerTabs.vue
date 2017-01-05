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
                                <th>
                                    <a v-link="{path:'/supplier/add'}" class="btn btn-info btn-xs">添加供应商</a>
                                    <span class="delimiter">|</span>
                                    <a v-link="{name:'goods_supplier_add', params:{goods_id:goods_id}}" class="btn btn-info btn-xs">关联供应商</a></th>
                            </thead>
                            <tbody class="supplier-sortable-list connectList">
                                <tr id="supplier_{{s.id}}" v-for="s in suppliers">
                                    <td>{{s.supplier_sn}}</td>
                                    <td>{{s.name}}</td>
                                    <td>{{(parseFloat(s.price) + parseFloat(s.tax)).toFixed(2)}}</td>
                                    <td>{{s.price}}</td>
                                    <td>{{s.price}}</td>
                                    <td>
                                        <a v-link="{name:'goods_supplier_edit', params:{id:s.id}}"><i class="fa fa-edit"></i> 编辑</a>
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
                            <th><a @click="addCarType()" class="btn btn-info btn-xs">添加适用车型</a></th>
                            </thead>
                            <tbody class="car-type-sortable-list connectList">
                            <tr id="cartype_{{c.id}}" v-for="c in car_types">
                                <td>{{c.brand}}</td>
                                <td>{{c.car_type}}</td>
                                <td>{{c.engine}}</td>
                                <td>{{c.year}}</td>
                                <td>
                                    <a @click="editCarType(c)"><i class="fa fa-edit"></i> 编辑</a>
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
    import GoodsCarType from './GoodsCarType.vue'
    export default{
        props: ['goods_id'],
        ready(){
            this.getMfrses();
            this.getGoodsSuppliers();
            this.getGoodsImgs();
            this.getCarTypes();
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
            $(".car-type-sortable-list").sortable({
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
                edit_mfrs_id: 0,
                car_types:{}
            }
        },
        components:{
            Goodsmfrs,
            GoodsCarType,
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
            getGoodsSuppliers(){
                this.$http.get('/goods/suppliers/'+this.goods_id+'.json').then(function (response) {
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
            addCarType(){
                var _this = this;
                layer.open({
                    type: 1,
                    shade: false,
                    area: ['600px', '330px'], //宽高
                    title: '添加适用车型',
                    btn: ['保存','取消'],
                    yes: function (index) {
                        var car_type = {};
                        car_type.car_type = $('.form-car-type-cx').val();
                        car_type.year = $('.form-car-type-nf').val();
                        car_type.brand = $('.form-car-type-pp').val();
                        car_type.engine = $('.form-car-type-fdj').val();
                        _this.postCarType(car_type,index);

                    },
                    content: GoodsCarType.template,
                });
            },
            editCarType(car_type){
                var _this = this;
                layer.open({
                    type: 1,
                    shade: false,
                    area: ['600px', '330px'], //宽高
                    title: '编辑适用车型',
                    btn: ['保存','取消'],
                    yes: function (index) {
                        car_type.car_type = $('.form-car-type-cx').val();
                        car_type.year = $('.form-car-type-nf').val();
                        car_type.brand = $('.form-car-type-pp').val();
                        car_type.engine = $('.form-car-type-fdj').val();
                        _this.putCarType(car_type,index);

                    },
                    content: GoodsCarType.template,
                    success: function(){
                        $('.form-car-type-cx').val(car_type.car_type);
                        $('.form-car-type-nf').val(car_type.year);
                        $('.form-car-type-pp').val(car_type.brand);
                        $('.form-car-type-fdj').val(car_type.engine);
                    }
                });
            },
            getCarTypes(){
                this.$http.get('/goods/car_type/'+this.goods_id+'.json').then(function(response){
                    this.$set('car_types',response.data);
                });
            },
            postCarType(car_type,index){
                this.$http.post('/goods/car_type/'+this.goods_id+'.json', car_type).then(function(response){
                    if(response.data.status == false){
                        toastr.error(response.data.msg);
                    }else{
                        layer.close(index);
                        this.getCarTypes();
                    }
                });
            },
            putCarType(car_type, index){
                this.$http.put('/goods/car_type/'+car_type.id+'.json', car_type).then(function(response){
                    if(response.data.status == false){
                        toastr.error(response.data.msg);
                    }else{
                        layer.close(index);
                        this.getCarTypes();
                    }
                });
            },
            deleteCartype(id){
                this.$http.delete('/goods/car_type/'+id+'.json').then(function(response){
                    if(response.data.status == true){
                        this.getCarTypes();
                    }else{
                        toastr.error(response.data.msg);
                    }
                });
            }
        }
    }
</script>
