<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>所有供应商</h5>
                    <div class="ibox-tools">
                        <a @click="addSupplier()" class="btn btn-primary btn-xs">添加供应商</a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row m-b-sm m-t-sm">
                        <div class="col-md-1">
                            <button type="button" id="loading-example-btn" v-on:click="supplierSearch()" class="btn btn-white btn-sm"><i class="fa fa-refresh"></i> 刷新</button>
                        </div>
                        <div class="col-md-5" style="float:right;">
                            <div class="input-group">
                                <input type="text" v-model="search_data.keywords" style="width:50% !important;float:right;" v-bind:placeholder="search_tag" class="input-sm form-control col-md-5">
                                <select class=" input-sm form-control col-md-3" style="width:25% !important;float:right;" v-model="search_data.type" number>
                                    <option value="0">供应商名称</option>
                                    <option value="1">供应商编号</option>
                                </select>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-sm btn-primary" v-on:click="supplierSearch()"> 搜索</button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <table class="table table-stripped">
                        <thead>
                        <tr>
                            <th></th>
                            <th>供应商名片</th>
                            <th>供应商编号</th>
                            <th>供应商名称</th>
                            <th>联系人</th>
                            <th>电话</th>
                            <th>手机</th>
                            <th>QQ</th>
                            <th>网站</th>
                        </tr>
                        </thead>
                        <tbody v-if="all > 0">
                        <tr class="goods_list_css" v-for="supplier in suppliers">
                            <td class="goods_list_css_jump"><input type="checkbox" value="{{supplier.id}}" v-model="ids"></td>
                            <td class="goods_list_css_jump"><div class="goods_list_img fancybox-box"><a class="fancybox" href="{{supplier.img}}"><img v-if="supplier.img" class="goods_img" v-bind:src="supplier.img"/></a></div></td>
                            <td class="goods_list_css_jump"><a href="/supplier/info/{{supplier.id}}" target="_blank">{{supplier.supplier_sn}}</a></td>
                            <td>{{supplier.name}}</td>
                            <td>{{supplier.contacts}}</td>
                            <td>{{supplier.tel}}</td>
                            <td>{{supplier.mobile}}</td>
                            <td>{{supplier.qq}}</td>
                            <td>{{supplier.website}}</td>
                        </tr>
                        </tbody>
                        <tbody v-else>
                        <tr class="no-records-found"><td colspan="4">没有找到匹配的记录</td></tr>
                        </tbody>
                        <tfoot >
                        <tr>
                            <td colspan="11">
                                <button type="button" v-on:click="deleteSupplier(ids)" class="btn btn-white btn-sm"><i class="fa fa-trash-o"></i> 删除</button>
                                <template  v-if="all > 1">
                                <ul class="pagination pull-right">
                                    <li class="footable-page-arrow">
                                        <input type="text" class="go_page_class" v-model="go_page_class" number>
                                        <a data-page="last" class="go_page_class_a" v-on:click="btnClick(go_page_class)">跳转</a>
                                    </li>
                                </ul>
                                <ul class="pagination pull-right">
                                    <li class="footable-page-arrow">
                                        <a data-page="first" v-on:click="goPage(2)">«</a>
                                    </li>
                                    <li class="footable-page-arrow">
                                        <a data-page="prev" v-on:click="goPage(0)">‹</a>
                                    </li>
                                    <li class="footable-page" v-for="index in indexs" v-bind:class="{ 'active': cur == index}">
                                        <a v-on:click="btnClick(index)">{{ index }}</a>
                                    </li>
                                    <li class="footable-page-arrow">
                                        <a data-page="next" v-on:click="goPage(1)">›</a>
                                    </li>
                                    <li class="footable-page-arrow">
                                        <a data-page="last" v-on:click="goPage(3)">»</a>
                                    </li>
                                </ul>
                                </template>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default{
        ready(){
            this.getSuppliers()
            $('.fancybox').fancybox({
                openEffect: 'none',
                closeEffect: 'none'
            });
        },
        data(){
            return{
                suppliers:{},
                search_data:{
                    type:0,
                    keywords:'',
                },
                page_size:1,
                page_count:0,
                cur: 1,
                all: 1,
                go_page_class: '',
                search_tag: '请输入供应商名称',
                ids: []
            }
        },
        methods:{
            getSuppliers(){
                var serch_data = this.search_data;
                var name = '';
                var supplier_sn = '';
                if(serch_data.type == 0){//按供应商名搜索
                    name = serch_data.keywords
                }else{//按供应商编号搜索
                    supplier_sn = serch_data.keywords
                }
                var page = this.cur ? this.cur : 1;
                this.$http.get('/suppliers.json?name='+name+'&supplier_sn='+supplier_sn+'&page='+page).then(function(response){
                    this.$set('suppliers',response.data.data);
                    this.$set('all',response.data.all_page);
                    this.$set('cur', page)
                });
            },
            supplierSearch(){
                this.getSuppliers();
            },
            deleteSupplier(ids){
                this.$http.delete('/supplier/batch.json?ids='+ids).then(function(response){
                    this.getSuppliers();
                });
            },
            goPage(type){
                if(type == 1){//下一页
                    if(this.cur < this.all){
                        this.cur++
                    }
                }else if(type == 0){//上一页
                    if(this.cur > 1){
                        this.cur--
                    }
                }else if(type == 2){//第一页
                    this.cur = 1
                }else if(type == 3){//最后一页
                    this.cur = this.all
                }
                this.getSuppliers()
            },
            btnClick(data){
                if(data != this.cur){
                    this.cur = data
                    this.$dispatch('btn-click',data)
                    this.getSuppliers()
                }
            },
            goToInfo(event, supplier_id){
                /*if(event.target.tagName === 'INPUT' || event.target.lastChild.tagName === 'INPUT'){
                    return false;
                }*/
                this.$route.router.go({path: '/supplier/info/'+supplier_id})
            },
            addSupplier(){
                this.$http.post('/supplier/add.json').then(function(response){
                    if(response.data.status == true){
                        this.$route.router.go({path: '/supplier/info/'+response.data.data.id,query:{type:1}})
                    }else{
                        toastr.error(response.data.msg);
                    }
                });
            }
        },
        watch:{
            'suppliers':function () {}
        },
        computed: {
            indexs: function(){
                var left = 1;
                var right = this.all;
                var ar = [];
                if(this.all>= 11){
                    if(this.cur > 5 && this.cur < this.all-4){
                        left = this.cur - 5;
                        right = this.cur + 4
                    }else{
                        if(this.cur<=5){
                            left = 1;
                            right = 10
                        }else{
                            right = this.all;
                            left = this.all -9
                        }
                    }
                }
                while (left <= right){
                    ar.push(left);
                    left ++
                }
                return ar
            }
        },
    }
</script>
