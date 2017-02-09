<template>
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
                    <td v-if="m.edit"><input type="text" class="form-control" v-model="m.mfrs_name"></td><td v-else>{{m.mfrs_name}}</td>
                    <td v-if="m.edit"><input type="text" class="form-control" v-model="m.mfrs_sn"></td><td v-else>{{m.mfrs_sn}}</td>
                    <td v-if="m.edit">
                        <a @click="submitMfrs(m)" class="btn btn-info btn-xs">保存</a>
                        <span class="delimiter">|</span>
                        <a @click="cancelMfrs(m,$index)" class="btn btn-success btn-xs">取消</a>
                    </td>
                    <td v-else>
                        <a @click="editMfrs(m)"><i class="fa fa-edit"></i> 编辑</a>
                        <span class="delimiter">|</span>
                        <a @click="deleteMfrs(m.id)"><i class="fa fa-remove"></i>   删除</a>
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
            this.getMfrses();
            var _this = this;
            $(".mfrs-sortable-list").sortable({
                update: function (event, ui) {
                    _this.sortMfrses($(this).sortable("toArray"));
                }
            }).disableSelection();
        },
        data(){
            return{
                mfrs: {},
                mfrs_sort: []
            }
        },
        methods:{
            getMfrses(){
                this.$http.get('/goods/mfrs/goods/'+this.goods_id+'.json').then(function (response) {
                    this.$set('mfrs', response.data);
                    this.goods.mfrs_sn = this.mfrs.length > 0 ? this.mfrs[0].mfrs_sn : '';
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
                    this.goods.mfrs_sn = response.data;
                });
            },
            deleteMfrs(id){
                var _this = this;
                layer.confirm('确认删除？', {
                    btn: ['确认','取消'] //按钮
                }, function(index){
                    _this.$http.delete('/mfrs/'+id+'.json').then(function(response){
                        if(response.data.status == true){
                            _this.getMfrses();
                            layer.close(index);
                        }else{
                            toastr.error(response.data.msg);
                        }
                    });
                });
            },
            addMfrs(){
                var new_mfrs = {};
                new_mfrs.id = 0;
                new_mfrs.mfrs_name = '';
                new_mfrs.mfrs_sn = '';
                new_mfrs.edit = true;
                this.mfrs.push(new_mfrs);
            },
            editMfrs(mfrs){
                mfrs.edit = true;
            },
            cancelMfrs(mfrs,index){
                if(mfrs.id == 0){
                    this.mfrs.splice(index,1);
                }else{
                    mfrs.edit = false;
                }
            },
            submitMfrs(mfrs){
                if(mfrs.id == 0){//添加
                    this.$http.post('/goods/mfrs/'+this.goods_id+'.json', mfrs).then(function(response){
                        if(response.data.status == false){
                            toastr.error(response.data.msg);
                        }else{
                            mfrs.id = response.data.data.id;
                            this.getMfrses();
                            this.goods.mfrs_sn = this.mfrs[0].mfrs_sn;
                        }
                    });
                }else{
                    this.$http.put('/mfrs/'+mfrs.id+'.json', mfrs).then(function(response){
                        if(response.data.status == false){
                            toastr.error(response.data.msg);
                        }else{
                            this.getMfrses();
                        }
                    });
                }
            }
        }
    }
</script>
