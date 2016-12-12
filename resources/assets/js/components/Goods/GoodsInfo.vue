<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="wrapper wrapper-content animated fadeInUp">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="m-b-md">
                                    <a href="project_detail.html#" class="btn btn-white btn-xs pull-right">编辑项目</a>
                                    <h2>{{goods.product_sn}}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <ul class="filelist" v-for="img in goods.real_imgs">
                                    <li id="{{img.id}}" class="state-complete">
                                        <p class="title"></p>
                                        <p class="imgWrap">
                                            <img v-bind:src="img.img">
                                        </p>
                                        <p class="progress">
                                            <span style="display: none; width: 0px;"></span>
                                        </p>
                                        <div class="file-panel" style="height: 30px; overflow: hidden;">
                                            <span class="cancel" @click="removeImg(img.id,this)">删除</span>
                                        </div>
                                        <span class="success"></span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-sm-7" id="cluster_info">
                                <dl class="dl-horizontal">

                                    <dt>最后更新：</dt>
                                    <dd>2014年 11月7日 22:03</dd>
                                    <dt>创建于：</dt>
                                    <dd>2014年 2月16日 03:01</dd>
                                    <dt>团队成员：</dt>
                                    <dd class="project-people">
                                        <a href="project_detail.html">
                                            <img alt="image" class="img-circle" src="img/a3.jpg">
                                        </a>
                                        <a href="project_detail.html">
                                            <img alt="image" class="img-circle" src="img/a1.jpg">
                                        </a>
                                        <a href="project_detail.html">
                                            <img alt="image" class="img-circle" src="img/a2.jpg">
                                        </a>
                                        <a href="project_detail.html">
                                            <img alt="image" class="img-circle" src="img/a4.jpg">
                                        </a>
                                        <a href="project_detail.html">
                                            <img alt="image" class="img-circle" src="img/a5.jpg">
                                        </a>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <dl class="dl-horizontal">
                                    <dt>当前进度</dt>
                                    <dd>
                                        <div class="progress progress-striped active m-b-sm">
                                            <div style="width: 60%;" class="progress-bar"></div>
                                        </div>
                                        <small>当前已完成项目总进度的 <strong>60%</strong></small>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="row m-t-sm">
                            <div class="col-sm-12">
                                <div class="panel blank-panel">
                                    <div class="panel-heading">
                                        <div class="panel-options">
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a href="project_detail.html#tab-1" data-toggle="tab">团队消息</a>
                                                </li>
                                                <li><a href="project_detail.html#tab-2" data-toggle="tab">最后更新</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="panel-body">

                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab-1">
                                                <div class="feed-activity-list">
                                                    <div class="feed-element">
                                                        <a href="profile.html#" class="pull-left">
                                                            <img alt="image" class="img-circle" src="img/a1.jpg">
                                                        </a>
                                                        <div class="media-body ">
                                                            <small class="pull-right text-navy">1天前</small>
                                                            <strong>奔波儿灞</strong> 关注了 <strong>灞波儿奔</strong>.
                                                            <br>
                                                            <small class="text-muted">54分钟前 来自 皮皮时光机</small>
                                                            <div class="actions">
                                                                <a class="btn btn-xs btn-white"><i class="fa fa-thumbs-up"></i> 赞 </a>
                                                                <a class="btn btn-xs btn-danger"><i class="fa fa-heart"></i> 收藏</a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="feed-element">
                                                        <a href="profile.html#" class="pull-left">
                                                            <img alt="image" class="img-circle" src="img/profile.jpg">
                                                        </a>
                                                        <div class="media-body ">
                                                            <small class="pull-right">5分钟前</small>
                                                            <strong>作家崔成浩</strong> 发布了一篇文章
                                                            <br>
                                                            <small class="text-muted">今天 10:20 来自 iPhone 6 Plus</small>

                                                        </div>
                                                    </div>

                                                    <div class="feed-element">
                                                        <a href="profile.html#" class="pull-left">
                                                            <img alt="image" class="img-circle" src="img/a2.jpg">
                                                        </a>
                                                        <div class="media-body ">
                                                            <small class="pull-right">2小时前</small>
                                                            <strong>作家崔成浩</strong> 抽奖中了20万
                                                            <br>
                                                            <small class="text-muted">今天 09:27 来自 Koryolink iPhone</small>
                                                            <div class="well">
                                                                抽奖，人民币2000元，从转发这个微博的粉丝中抽取一人。11月16日平台开奖。随手一转，万一中了呢？
                                                            </div>
                                                            <div class="pull-right">
                                                                <a class="btn btn-xs btn-white"><i class="fa fa-thumbs-up"></i> 赞 </a>
                                                                <a class="btn btn-xs btn-white"><i class="fa fa-heart"></i> 收藏</a>
                                                                <a class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> 评论</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="feed-element">
                                                        <a href="profile.html#" class="pull-left">
                                                            <img alt="image" class="img-circle" src="img/a3.jpg">
                                                        </a>
                                                        <div class="media-body ">
                                                            <small class="pull-right">2天前</small>
                                                            <strong>天猫</strong> 上传了2张图片
                                                            <br>
                                                            <small class="text-muted">11月7日 11:56 来自 微博 weibo.com</small>
                                                            <div class="photos">
                                                                <a target="_blank" href="http://24.media.tumblr.com/20a9c501846f50c1271210639987000f/tumblr_n4vje69pJm1st5lhmo1_1280.jpg">
                                                                    <img alt="image" class="feed-photo" src="img/p1.jpg">
                                                                </a>
                                                                <a target="_blank" href="http://37.media.tumblr.com/9afe602b3e624aff6681b0b51f5a062b/tumblr_n4ef69szs71st5lhmo1_1280.jpg">
                                                                    <img alt="image" class="feed-photo" src="img/p3.jpg">
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="feed-element">
                                                        <a href="profile.html#" class="pull-left">
                                                            <img alt="image" class="img-circle" src="img/a4.jpg">
                                                        </a>
                                                        <div class="media-body ">
                                                            <small class="pull-right text-navy">5小时前</small>
                                                            <strong>在水一方Y</strong> 关注了 <strong>那二十年的单身</strong>.
                                                            <br>
                                                            <small class="text-muted">今天 10:39 来自 iPhone客户端</small>
                                                            <div class="actions">
                                                                <a class="btn btn-xs btn-white"><i class="fa fa-thumbs-up"></i> 赞 </a>
                                                                <a class="btn btn-xs btn-white"><i class="fa fa-heart"></i> 收藏</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="tab-pane" id="tab-2">

                                                <table class="table table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>状态</th>
                                                        <th>标题</th>
                                                        <th>开始时间</th>
                                                        <th>结束时间</th>
                                                        <th>说明</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <span class="label label-primary"><i class="fa fa-check"></i> 已完成</span>
                                                        </td>
                                                        <td>
                                                            文档在线预览功能
                                                        </td>
                                                        <td>
                                                            11月7日 22:03
                                                        </td>
                                                        <td>
                                                            11月7日 20:11
                                                        </td>
                                                        <td>
                                                            <p class="small">
                                                                已经测试通过
                                                            </p>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <span class="label label-primary"><i class="fa fa-check"></i> 解决中</span>
                                                        </td>
                                                        <td>
                                                            会员登录
                                                        </td>
                                                        <td>
                                                            11月7日 22:03
                                                        </td>
                                                        <td>
                                                            11月7日 20:11
                                                        </td>
                                                        <td>
                                                            <p class="small">
                                                                测试中
                                                            </p>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <span class="label label-primary"><i class="fa fa-check"></i> 解决中</span>
                                                        </td>
                                                        <td>
                                                            会员积分
                                                        </td>
                                                        <td>
                                                            11月7日 22:03
                                                        </td>
                                                        <td>
                                                            11月7日 20:11
                                                        </td>
                                                        <td>
                                                            <p class="small">
                                                                未测试
                                                            </p>
                                                        </td>

                                                    </tr>


                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default{
        created(){
            this.goods_id = this.$route.params.id;
        },
        ready(){
            this.getGoods();
        },
        data(){
            return{
                goods: {}
            }
        },
        methods:{
            getGoods(){
                this.$http.get('/goods/'+this.goods_id+'.json').then(function(response){
                    if(response.data.status == true){
                        this.$set('goods', response.data.data);
                    }else{
                        toastr.error(response.data.msg);
                    }
                });
            }
        }
    }
</script>
