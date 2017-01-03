<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>所有供应商</h5>
                    <div class="ibox-tools">
                        <a v-link="{path:'/customer/add'}" class="btn btn-primary btn-xs">添加客户</a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row m-b-sm m-t-sm">
                        <div class="col-md-1">
                            <button type="button" id="loading-example-btn" v-on:click="customerSearch()" class="btn btn-white btn-sm"><i class="fa fa-refresh"></i> 刷新</button>
                        </div>
                        <div class="col-md-5" style="float:right;">
                            <div class="input-group">
                                <input type="text" v-model="search_data.keywords" style="width:50% !important;float:right;" v-bind:placeholder="search_tag" class="input-sm form-control col-md-5">
                                <select class=" input-sm form-control col-md-3" style="width:25% !important;float:right;" v-model="search_data.type" number>
                                    <option value="0">客户名称</option>
                                    <option value="1">客户编号</option>
                                </select>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-sm btn-primary" v-on:click="customerSearch()"> 搜索</button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <table class="footable table table-stripped toggle-arrow-tiny" v-bind:data-page-size="page_size" v-bind:data-navigation="page_count">
                        <thead>
                        <tr>
                            <th data-toggle="true" data-sort-ignore="true">客户名称</th>
                            <th data-sort-ignore="true">客户编号</th>
                            <th data-sort-ignore="true">联系人</th>
                            <th data-sort-ignore="true">电话</th>
                            <th data-sort-ignore="true">手机</th>
                            <th data-sort-ignore="true">邮箱</th>
                            <th data-sort-ignore="true">操作</th>
                        </tr>
                        </thead>
                        <tbody v-if="all > 0">
                        <tr v-for="customer in customers">
                            <td>{{customer.name}}</td>
                            <td>{{customer.customer_sn}}</td>
                            <td>{{customer.contact}}</td>
                            <td>{{customer.tel}}</td>
                            <td>{{customer.mobile}}</td>
                            <td>{{customer.email}}</td>
                            <td>
                                <a v-link="{name:'customer_edit', params:{id:customer.id}}"><i class="fa fa-edit"></i> 编辑</a>
                                <span class="delimiter">|</span>
                                <a @click="deleteCustomer(customer.id)"><i class="fa fa-remove"></i>   删除</a>
                            </td>
                        </tr>
                        </tbody>
                        <tbody v-else>
                        <tr class="no-records-found"><td colspan="4">没有找到匹配的记录</td></tr>
                        </tbody>
                        <tfoot v-if="all > 1">
                        <tr>
                            <td colspan="8">
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
            this.getCustomers()
        },
        data(){
            return{
                customers:{},
                search_data:{
                    type:0,
                    keywords:'',
                },
                page_size:1,
                page_count:0,
                cur: 1,
                all: 1,
                go_page_class: '',
                search_tag: '请输入客户名称'
            }
        },
        methods:{
            getCustomers(){
                var serch_data = this.search_data;
                var name = '';
                var customer_sn = '';
                if(serch_data.type == 0){//按客户名搜索
                    name = serch_data.keywords
                }else{//按客户编号搜索
                    supplier_sn = serch_data.keywords
                }
                var page = this.cur ? this.cur : 1;
                this.$http.get('/customers.json?name='+name+'&customer_sn='+customer_sn+'&page='+page).then(function(response){
                    this.$set('customers',response.data.data);
                    this.$set('all',response.data.all_page);
                    this.$set('cur', page)
                });
            },
            customerSearch(){
                this.getCustomers();
            },
            deleteCustomer(ids){
                this.$http.delete('/customer/batch.json?ids='+ids).then(function(response){
                    this.getCustomers();
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
                this.getCustomers()
            },
            btnClick(data){
                if(data != this.cur){
                    this.cur = data
                    this.$dispatch('btn-click',data)
                    this.getCustomers()
                }
            }
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
