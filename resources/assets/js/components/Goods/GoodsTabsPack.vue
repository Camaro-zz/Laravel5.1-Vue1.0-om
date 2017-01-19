<template>
    <div class="full-height-scroll">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <th>长</th>
                <th>宽</th>
                <th>高</th>
                <th>毛重</th>
                <th>净重</th>
                <th>装箱数</th>
                <th>包装类型</th>
                <th>备注</th>
                <th></th>
                </thead>
                <tbody class="sortable-list connectList">
                <tr>
                    <td v-if="edit"><input type="number" class="form-control" v-model="pack.length"></td><td v-else>{{pack.length}}</td>
                    <td v-if="edit"><input type="number" class="form-control" v-model="pack.width"></td><td v-else>{{pack.width}}</td>
                    <td v-if="edit"><input type="number" class="form-control" v-model="pack.height"></td><td v-else>{{pack.height}}</td>
                    <td v-if="edit"><input type="number" class="form-control" v-model="pack.gw"></td><td v-else>{{pack.gw}}</td>
                    <td v-if="edit"><input type="number" class="form-control" v-model="pack.nw"></td><td v-else>{{pack.nw}}</td>
                    <td v-if="edit"><input type="number" class="form-control" v-model="pack.num"></td><td v-else>{{pack.num}}</td>
                    <td v-if="edit"><input type="text" class="form-control" v-model="pack.pack_type"></td><td v-else>{{pack.pack_type}}</td>
                    <td v-if="edit"><input type="text" class="form-control" v-model="pack.mark"></td><td v-else>{{pack.mark}}</td>
                    <td v-if="edit">
                        <a @click="submitPack()" class="btn btn-info btn-xs">保存</a>
                        <span class="delimiter">|</span>
                        <a @click="cancelPack()" class="btn btn-success btn-xs">取消</a>
                    </td>
                    <td v-else>
                        <a @click="editPack()"><i class="fa fa-edit"></i> 编辑</a>
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
            this.getPack();
        },
        data(){
            return{
                pack: {
                    id: 0,
                    length: '',
                    width: '',
                    height: '',
                    gw: '',
                    nw: '',
                    num: '',
                    mark: '',
                    pack_type: ''
                },
                edit: false
            }
        },
        methods:{
            getPack(){
                this.$http.get('/goods/pack/'+this.goods_id+'.json').then(function (response) {
                    this.edit = false;
                    this.$set('pack', response.data);
                });
            },
            editPack(){
                this.edit = true;
            },
            cancelPack(){
                this.edit = false;
            },
            submitPack(){
                if(this.pack.id == 0){//添加
                    this.$http.post('/goods/pack/'+this.goods_id+'.json', this.pack).then(function(response){
                        if(response.data.status == false){
                            toastr.error(response.data.msg);
                        }else{
                            this.pack.id = response.data.data.id;
                            this.getPack();
                        }
                    });
                }else{
                    this.$http.put('/goods/pack/'+this.goods_id+'.json', this.pack).then(function(response){
                        if(response.data.status == false){
                            toastr.error(response.data.msg);
                        }else{
                            this.getPack();
                        }
                    });
                }
            }
        }
    }
</script>
