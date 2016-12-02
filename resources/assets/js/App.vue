<template>
	<div v-if="route=='/auth/login'">
		<router-view></router-view>
	</div>
	<div id="app" v-else>
		<!--左侧导航开始-->
		<Navbar></Navbar>
		<!--左侧导航结束-->
		<!--右侧部分开始-->
		<div id="page-wrapper" class="gray-bg dashbard-1">
			<Topbar></Topbar>
			<div class="wrapper wrapper-content animated fadeInUp">
				<router-view></router-view>
			</div>
			<div class="footer fixed">
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
	import Topbar from './components/TopBar.vue'

    export default {
		ready(){
			this.route = this.$route.path
		},
        components: {
            Navbar,
            Content,
            Rightsidebar,
            Minichat,
			Topbar
        },
        data(){
			return{
				route:''
			}
        },
        replace: false
    }
</script>