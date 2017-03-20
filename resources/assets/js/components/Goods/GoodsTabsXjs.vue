<template>
    <div class="full-height-scroll">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <th>客户编号</th>
                <th>公司名</th>
                <th>联系人</th>
                <th>邮箱</th>
                <th>FOB</th>
                <th>采购价(含)</th>
                <th>采购价(不含)</th>
                </thead>
                <tbody class="sortable-list connectList">
                <tr id="xjs_{{x.id}}" v-for="x in xjs">
                    <td>{{x.customer_sn}}</td>
                    <td>{{x.name}}</td>
                    <td>{{x.contact}}</td>
                    <td>{{x.email}}</td>
                    <td>{{x.fob_price}}</td>
                    <td>{{x.tax_price}}</td>
                    <td>{{x.price}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default{
        props: ['goods_id','goods'],
        ready(){
            this.getXjs();
        },
        data(){
            return{
                xjs: ''
            }
        },
        methods:{
            getXjs(){
                this.$http.get('/goods/xjs/'+this.goods_id+'.json').then(function (response) {
                    this.$set('xjs', response.data);
                });
            }
        }
    }
</script>
