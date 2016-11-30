<template>
<div class="middle-box text-center loginscreen  animated fadeInDown">
    <div>
        <div>

            <h1 class="logo-name">H+</h1>

        </div>
        <h3>欢迎使用 H+</h3>

        <form class="m-t" role="form" action="" name="form">
            <div class="form-group" v-bind:class="{'has-error' :login.errors.message.login}">
                <span class="help-block" v-if="login.errors.message.login">{{login.errors.message.login}}</span>
            </div>
            <div class="form-group has-icon">
                <input v-model="auth.username" type="username" class="form-control" placeholder="用户名" required="true">
                <i class="fa fa-user clr-gray"></i>
            </div>
            <div class="form-group has-icon">
                <input v-model="auth.password" type="password" class="form-control" placeholder="密码" required="">
                <i class="fa fa-lock clr-gray"></i>
            </div>
            <div class="form-group" v-bind:class="{'has-error' :login.errors.message.captcha}">
                <input name="captcha" class="form-control captcha-code" placeholder="验证码" type="text" v-model="auth.captcha">
                <img class="captcha-img" @click="changeCaptcha" v-bind:src="captcha_src">
                <span class="help-block" v-if="login.errors.message.captcha">验证码不正确！</span>
            </div>
            <button type="button" class="btn btn-primary block full-width m-b" @click="postLogin" v-bind:disabled="login.disable">{{login.text}}</button>


            <!--<p class="text-muted text-center"> <a href="login.html#"><small>忘记密码了？</small></a> | <a href="register.html">注册一个新账号</a>
            </p>-->

        </form>
    </div>
</div>
</template>
<style>
    .captcha-code{
        width: 50%;
        float: left;
    }
    .captcha-img{
        width: 96px;
        height: 34px;
        margin-left: 20px;
        cursor: pointer;
    }
    .form-group.has-icon i {
        position: absolute;
        top: 11px;
        left: 10px;
        font-size: 14px;
    }
    .form-group.has-icon {
        position: relative;
    }
    .form-group.has-icon .form-control {
        padding-left: 28px;
    }
    .form-control {
        padding: 4px 6px;
        font-size: 12px;
        border-radius: 2px;
        box-shadow: none;
    }
</style>
<script>
    export default{
        data(){
            return {
                captcha_src:'/captcha',
                auth:{},
                login:{
                    text:'登 录',
                    disable:false,
                    errors:{
                        message:{
                            login:false,
                            captcha:false
                        }
                    }
                }
            }
        },
        methods:{
            postLogin(){
                if(!this.auth.username){
                    this.login.errors.message.login = '请输入用户名';
                    return false;
                }
                if(!this.auth.password){
                    this.login.errors.message.login = '请输入密码';
                    return false;
                }
                if(!this.auth.captcha){
                    this.login.errors.message.login = '请输入验证码';
                    return false;
                }
                this.login.text = '登录中...'
                this.login.disable = true
                this.$http.post('/auth/login.json', this.auth).then(function(response){
                    this.changeCaptcha()
                    if(!response.data.error){//登录成功
                        //this.$route.router.go({path: '/'})
                        //location.reload()
                        window.location.href='/'
                    }else{
                        this.login.text = '登 录'
                        this.login.disable = false
                        this.$set('login.errors',response.data.error)
                    }
                }, function(response){
                    console.log(response);
                });
            },
            changeCaptcha(){
                this.captcha_src = '/captcha?'+ Math.random();
            }
        }
    }

</script>
