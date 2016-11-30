y<template>
	<div v-if="route=='/auth/login'">
		<router-view></router-view>
	</div>
	<div id="app" v-else>
		<!--左侧导航开始-->
		<Navbar></Navbar>
		<!--左侧导航结束-->
		<!--右侧部分开始-->
		<div id="page-wrapper" class="gray-bg dashbard-1">
			<div class="row border-bottom">
				<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
					<div class="navbar-header"><a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
						<!--<form role="search" class="navbar-form-custom" method="post" action="search_results.html">
                            <div class="form-group">
                                <input type="text" placeholder="请输入您需要查找的内容 …" class="form-control" name="top-search" id="top-search">
                            </div>
                        </form>-->
					</div>
					<ul class="nav navbar-top-links navbar-right">
						<li class="dropdown hidden-xs">
							<a class="right-sidebar-toggle" aria-expanded="false">
								<i class="fa fa-tasks"></i> 主题
							</a>
						</li>
					</ul>
				</nav>
			</div>
			<div class="row content-tabs">
				<button class="roll-nav roll-left J_tabLeft"><i class="fa fa-backward"></i>
				</button>
				<nav class="page-tabs J_menuTabs">
					<div class="page-tabs-content">
						<a href="javascript:;" class="active J_menuTab" data-id="index_v1.html">首页</a>
					</div>
				</nav>
				<button class="roll-nav roll-right J_tabRight"><i class="fa fa-forward"></i>
				</button>
				<div class="btn-group roll-nav roll-right">
					<button class="dropdown J_tabClose" data-toggle="dropdown">关闭操作<span class="caret"></span>

					</button>
					<ul role="menu" class="dropdown-menu dropdown-menu-right">
						<li class="J_tabShowActive"><a>定位当前选项卡</a>
						</li>
						<li class="divider"></li>
						<li class="J_tabCloseAll"><a>关闭全部选项卡</a>
						</li>
						<li class="J_tabCloseOther"><a>关闭其他选项卡</a>
						</li>
					</ul>
				</div>
				<a href="/auth/logout.json" class="roll-nav roll-right J_tabExit"><i class="fa fa fa-sign-out"></i> 退出</a>
			</div>
			<div class="row J_mainContent" id="content-main">
				<router-view></router-view>
			</div>
			<div class="footer">
				<div class="pull-right">&copy; 2016-fuck <a href="" target="_blank">what the fuck</a>
				</div>
			</div>
		</div>
		<!--右侧部分结束-->
		<!--右侧边栏开始-->
		<Rightsidebar></Rightsidebar>
		<!--右侧边栏结束-->
		<!--mini聊天窗口开始-->
		<Minichat></Minichat>
		<!--mini聊天窗口结束-->
	</div>
</template>
<script>
	import Navbar from './components/Navbar.vue'
    import Rightsidebar from './components/RightSidebar.vue'
    import Minichat from './components/MiniChat.vue'
    import Content from './components/Content.vue'

    export default {
		ready(){
			this.route = this.$route.path
		},
        components: {
            Navbar,
            Content,
            Rightsidebar,
            Minichat,
        },
        data(){
			return{
				route:''
			}
        },
        replace: false
    }
</script>