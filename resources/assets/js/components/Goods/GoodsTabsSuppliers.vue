<template>
    <div class="full-height-scroll">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <th>供应商编号</th>
                <th>供应商名称</th>
                <th>联系人</th>
                <th>采购价(含税)</th>
                <th>采购价(不含税)</th>
                <th>QQ</th>
                <th>手机</th>
                <th>电话</th>
                <th>备注</th>
                <th>
                    <a @click="addSupplier()" class="btn btn-info btn-xs">添加供应商</a>
                    <span class="delimiter">|</span>
                    <a @click="connectSupplier()" class="btn btn-info btn-xs">关联供应商</a></th>
                </thead>
                <tbody class="supplier-sortable-list connectList">
                <tr id="supplier_{{s.id}}" v-for="s in suppliers">
                    <td>{{s.supplier_sn}}</td>
                    <td v-if="s.edit"><input type="text" class="form-control" v-model="s.name"></td><td v-else>{{s.name}}</td>
                    <td v-if="s.edit"><input type="text" class="form-control" v-model="s.contacts"></td><td v-else>{{s.contacts}}</td>
                    <td v-if="s.edit"><input type="number" class="form-control" v-model="s.tax_price"></td><td v-else>{{s.tax_price}}</td>
                    <td v-if="s.edit"><input type="number" class="form-control" v-model="s.price"></td><td v-else>{{s.price}}</td>
                    <td v-if="s.edit"><input type="text" class="form-control" v-model="s.qq"></td><td v-else>{{s.qq}}</td>
                    <td v-if="s.edit"><input type="text" class="form-control" v-model="s.mobile"></td><td v-else>{{s.mobile}}</td>
                    <td v-if="s.edit"><input type="text" class="form-control" v-model="s.tel"></td><td v-else>{{s.tel}}</td>
                    <td v-if="s.edit"><input type="text" class="form-control" v-model="s.mark"></td><td v-else>{{s.mark}}</td>
                    <td v-if="s.edit">
                        <a @click="submitSupplier(s)" class="btn btn-info btn-xs">保存</a>
                        <span class="delimiter">|</span>
                        <a @click="cancelSupplier(s,$index)" class="btn btn-success btn-xs">取消</a>
                    </td>
                    <td v-else>
                        <a @click="editSupplier(s)"><i class="fa fa-edit"></i> 编辑</a>
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
            addSupplier(){
                var new_sup = {};
                new_sup.id = 0;
                new_sup.name = '';
                new_sup.contacts = '';
                new_sup.tax_price = '';
                new_sup.price = '';
                new_sup.qq = '';
                new_sup.mobile = '';
                new_sup.contacts = '';
                new_sup.tel = '';
                new_sup.supplier_sn = '';
                new_sup.mark = '';
                new_sup.edit = true;
                this.$http.get('/supplier/max/id.json').then(function (response) {
                    new_sup.supplier_sn = 'G'+response.data
                });
                console.log(new_sup);
                this.suppliers.push(new_sup);
            },
            editSupplier(sup){
                sup.edit = true;
            },
            cancelSupplier(sup,index){
                if(sup.id == 0){
                    this.suppliers.splice(index,1);
                }else{
                    sup.edit = false;
                }
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
            submitSupplier(sup){
                if(sup.id == 0){//添加
                    this.$http.post('/supplier/add/'+this.goods_id+'.json', sup).then(function(response){
                        if(response.data.status == false){
                            toastr.error(response.data.msg);
                        }else{
                            sup.id = response.data.data.id;
                            this.getGoodsSuppliers();
                        }
                    });
                }else{
                    this.$http.put('/goods/supplier/'+sup.id+'.json', sup).then(function(response){
                        if(response.data.status == false){
                            toastr.error(response.data.msg);
                        }else{
                            this.getGoodsSuppliers();
                        }
                    });
                }
            },
            connectSupplier(){

            }
        }
    }
</script>
