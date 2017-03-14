<template>
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
                    <td v-if="c.edit"><input type="text" class="form-control" v-model="c.brand"></td><td v-else>{{c.brand}}</td>
                    <td v-if="c.edit"><input type="text" class="form-control" v-model="c.car_type"></td><td v-else>{{c.car_type}}</td>
                    <td v-if="c.edit"><input type="text" class="form-control" v-model="c.engine"></td><td v-else>{{c.engine}}</td>
                    <td v-if="c.edit"><input type="text" class="form-control" v-model="c.year"></td><td v-else>{{c.year}}</td>
                    <td v-if="c.edit">
                        <a @click="submitCarType(c)" class="btn btn-info btn-xs">保存</a>
                        <span class="delimiter">|</span>
                        <a @click="cancelCarType(c,$index)" class="btn btn-success btn-xs">取消</a>
                    </td>
                    <td v-else>
                        <a @click="editCarType(c)"><i class="fa fa-edit"></i> 编辑</a>
                        <span class="delimiter">|</span>
                        <a @click="deleteCartype(c.id)"><i class="fa fa-remove"></i>   删除</a>
                        <span class="delimiter">|</span>
                        <a class="portlet-header"><i class="fa fa-arrows"></i>   拖动</a>
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
            this.getCarTypes();
            var _this = this;
            $(".car-type-sortable-list").sortable({
                handle: ".portlet-header",
                update: function (event, ui) {
                    _this.sortCartypes($(this).sortable("toArray"));
                }
            });
        },
        data(){
            return{
                car_types:{},
                car_types_sort:[]
            }
        },
        methods:{
            addCarType(){
                var new_car_type = {};
                new_car_type.id = 0;
                new_car_type.brand = '';
                new_car_type.car_type = '';
                new_car_type.engine = '';
                new_car_type.year = '';
                new_car_type.edit = true;
                this.car_types.push(new_car_type);
            },
            editCarType(car_type){
                car_type.edit = true;
            },
            cancelCarType(car_type,index){
                if(car_type.id == 0){
                    this.car_types.splice(index,1);
                }else{
                    car_type.edit = false;
                }
            },
            getCarTypes(){
                this.$http.get('/goods/car_type/'+this.goods_id+'.json').then(function(response){
                    this.$set('car_types',response.data);
                    this.goods.car_type = this.car_types.length > 0 ? this.car_types[0] : '';
                });
            },
            submitCarType(car_type){
                if(car_type.id == 0){//添加
                    this.$http.post('/goods/car_type/'+this.goods_id+'.json', car_type).then(function(response){
                        if(response.data.status == false){
                            toastr.error(response.data.msg);
                        }else{
                            car_type.id = response.data.data.id;
                            this.getCarTypes();
                            this.goods.car_type = this.car_types[0];
                        }
                    });
                }else{
                    this.$http.put('/goods/car_type/'+car_type.id+'.json', car_type).then(function(response){
                        if(response.data.status == false){
                            toastr.error(response.data.msg);
                        }else{
                            this.getCarTypes();
                        }
                    });
                }
            },
            deleteCartype(id){
                var _this = this;
                layer.confirm('确认删除？', {
                    btn: ['确认','取消'] //按钮
                }, function(index){
                    _this.$http.delete('/goods/car_type/'+id+'.json').then(function(response){
                        if(response.data.status == true){
                            _this.getCarTypes();
                            layer.close(index);
                        }else{
                            toastr.error(response.data.msg);
                        }
                    });
                });
            },
            sortCartypes(sort){
                var sort_length = this.car_types.length;
                var _this = this;
                $.each(sort,function (n, i) {
                    var c = {};
                    c.sort = sort_length - n;
                    c.id = i;
                    _this.car_types_sort.push(c);
                });
                this.$http.put('/goods/car_type/sort/'+this.goods_id+'.json', this.car_types_sort).then(function(response){
                    this.$set('car_types_sort',[]);
                    this.goods.car_type = response.data;
                });
            }
        }
    }
</script>
