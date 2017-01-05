<template>
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="nav-close"><i class="fa fa-times-circle"></i>
        </div>
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <span>
                            <img alt="image" class="img-circle" v-if="user.avatar" src="{{user.avatar}}" />
                            <img alt="image" class="img-circle" v-else src="/img/profile_small.jpg" />
                        </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear">
                               <span class="block m-t-xs"><strong class="font-bold">{{user.name}}</strong></span>

                                <span class="text-muted text-xs block" v-if="user.is_admin == 1">超级管理员<b class="caret"></b></span>
                                </span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a class="J_menuItem" href="form_avatar.html">修改头像</a>
                            </li>
                            <li><a class="J_menuItem" href="profile.html">个人资料</a>
                            </li>
                            <li><a class="J_menuItem" href="contacts.html">联系我们</a>
                            </li>
                            <li><a class="J_menuItem" href="mailbox.html">信箱</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="/auth/logout.json">安全退出</a>
                            </li>
                        </ul>
                    </div>
                    <div class="logo-element">H+
                    </div>
                </li>
                <li>
                    <a v-link="{path:'/'}">
                        <i class="fa fa-home"></i>
                        <span class="nav-label">主页</span>
                    </a>

                </li>
                <li>
                    <a class="J_menuItem">
                        <i class="fa fa-th" @click="goGoodsList()"></i>
                        <span class="nav-label" @click="goGoodsList()">产品</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li v-for="cat in cats">
                            <a class="J_menuItem" v-link="{path:'/goods/list',query:{cat_id:cat.id}}">{{cat.name}}</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a v-link="{path:'/supplier/list'}">
                        <i class="fa fa-columns"></i>
                        <span class="nav-label">供应商</span>
                    </a>
                </li>
                <li>
                    <a v-link="{path:'/customer/list'}">
                        <i class="fa fa-group"></i>
                        <span class="nav-label">客户</span>
                    </a>
                </li>

            </ul>
        </div>
    </nav>
</template>
<script>
    export default{
        ready(){
            this.getUserInfo();
            this.getCats();
        },
        data(){
            return{
                user:_global.user,
                cats: {}
            }
        },
        methods: {
            getUserInfo(){
                this.$http({url: '/user/me.json', method: 'GET'}).then(function (response) {
                    this.$set('user', response.data.account)
                })
            },
            getCats(){
                this.$http.get('/cats.json').then(function (response) {
                    this.$set('cats', response.data.data);
                });
            },
            goGoodsList(){
                this.$route.router.go({path: '/goods/list'})
            }
        },
    }
</script>
