<template>
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
</template>
<style>

</style>
<script>
    export default{
        props: ['goods_id','goods'],
        ready(){
            this.getGoodsSuppliers();
            var _this = this;
            $(".supplier-sortable-list").sortable({
                update: function (event, ui) {
                    _this.sortSuppliers($(this).sortable("toArray"));
                }
            }).disableSelection();
        },
        data(){
            return{
                suppliers: {},
                sup_sort:[]
            }
        },
        methods:{
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
            deleteSupplier(id){
                var _this = this;
                layer.confirm('确认删除？', {
                    btn: ['确认','取消'] //按钮
                }, function(index){
                    _this.$http.delete('/goods/suppliers/'+id+'.json').then(function(response){
                        if(response.data.status == true){
                            this.getGoodsSuppliers();
                            layer.close(index);
                        }else{
                            toastr.error(response.data.msg);
                        }
                    });
                });
            },
        }
    }
</script>
