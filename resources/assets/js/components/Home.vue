<template>
    <div id="wrapper">
        <!--左侧导航开始-->
        <Navbar></Navbar>
        <!--左侧导航结束-->
        <!--右侧部分开始-->
        <Content></Content>
        <!--右侧部分结束-->
        <!--右侧边栏开始-->
        <Rightsidebar></Rightsidebar>
        <!--右侧边栏结束-->
        <!--mini聊天窗口开始-->
        <Minichat></Minichat>
        <!--mini聊天窗口结束-->
    </div>
</template>
<style>

</style>
<script>
    import Navbar from './Navbar.vue'
    import Content from './Content.vue'
    import Rightsidebar from './RightSidebar.vue'
    import Minichat from './MiniChat.vue'
    import Login from './Auth/Login.vue'

    export default {
        components: {
            Navbar,
            Content,
            Rightsidebar,
            Minichat,
            Login
        },
        data(){

        },
        replace: false
    }
</script>
