<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>添加产品</h5>
                </div>
                <div class="ibox-content">
                    <form method="get" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">中文品名</label>

                            <div class="col-sm-4">
                                <input type="text" v-model="goods.cn_name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">英文品名</label>

                            <div class="col-sm-4">
                                <input type="text" v-model="goods.en_name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">产品图片</label>

                            <div class="col-sm-4">
                                <div id="uploader" class="wu-example">
                                    <div id="filePicker"></div>
                                    <div class="queueList">
                                        <div id="dndArea" v-show="goods.imgs.length == 0" class="placeholder">
                                            <p>或将图片拖到这里，单次最多可选300张</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">产品类目</label>

                            <div class="col-sm-3">
                                <select v-model="goods.cat_id" data-placeholder="请选择类目..." class="chosen-select" style="width:100%;" tabindex="2">
                                    <option value="0" hassubinfo="true">请选择类目</option>
                                    <template v-for="cat in cats">
                                    <option value="{{cat.id}}" hassubinfo="true">{{cat.name}}</option>
                                    </template>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <a @click="addCat()"><i class="fa fa-plus"></i>添加类目</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">产品编号</label>

                            <div class="col-sm-4">
                                <input type="text" v-model="goods.product_sn" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">FOB价格</label>

                            <div class="col-sm-4">
                                <div class="input-group m-b">
                                    <span class="input-group-addon">$</span>
                                    <input type="number" step="0.01" v-model="goods.fob_price" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">备注</label>

                            <div class="col-sm-4">
                                <textarea class="form-control" v-model="goods.mark">

                                </textarea>
                            </div>
                        </div>
                        <template v-if="goods_id > 0">
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">管理</label>

                            <div class="col-sm-10">
                                <Goodstabs :goods_id="goods_id"></Goodstabs>
                            </div>
                        </div>
                        </template>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="button" @click="postGoods()">保存内容</button>
                                <button class="btn btn-white" type="button">取消</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default{
    ready(){
        this.getCats();
        var __this = this;
        var $ = jQuery,    // just in case. Make sure it's not an other libaray.

                $wrap = $('#uploader'),

                // 状态栏，包括进度和控制按钮
                $statusBar = $wrap.find('.statusBar'),
                $queue = $('<ul class="filelist"></ul>').appendTo( $wrap.find('.queueList') ),

                // 文件总体选择信息。
                $info = $statusBar.find('.info'),

                // 上传按钮
                $upload = $wrap.find('.uploadBtn'),

                // 没选择文件之前的内容。
                $placeHolder = $wrap.find('.placeholder'),

                // 总体进度条
                $progress = $statusBar.find('.progress').hide(),

                // 添加的文件数量
                fileCount = 0,

                // 添加的文件总大小
                fileSize = 0,

                // 优化retina, 在retina下这个值是2
                ratio = window.devicePixelRatio || 1,

                // 缩略图大小
                thumbnailWidth = 110 * ratio,
                thumbnailHeight = 110 * ratio,

                // 可能有pedding, ready, uploading, confirm, done.
                state = 'pedding',

                // 所有文件的进度信息，key为file id
                percentages = {},

                supportTransition = (function(){
                    var s = document.createElement('p').style,
                        r = 'transition' in s ||
                              'WebkitTransition' in s ||
                              'MozTransition' in s ||
                              'msTransition' in s ||
                              'OTransition' in s;
                    s = null;
                    return r;
                })(),

                // WebUploader实例
                uploader;

            if ( !WebUploader.Uploader.support() ) {
                alert( 'Web Uploader 不支持您的浏览器！如果你使用的是IE浏览器，请尝试升级 flash 播放器');
                throw new Error( 'WebUploader does not support the browser you are using.' );
            }

            // 实例化
            __this.upolader = uploader = WebUploader.create({
                pick: {
                    id: '#filePicker',
                    label: '点击选择图片'
                },
                dnd: '#uploader .queueList',
                paste: document.body,
                auto: true,
                accept: {
                    title: 'Images',
                    extensions: 'gif,jpg,jpeg,bmp,png',
                    //mimeTypes: 'image/*'
                },

                // swf文件路径
                swf: BASE_URL + '/Uploader.swf',

                disableGlobalDnd: true,

                chunked: true,
                server: '/upload.json',
                fileNumLimit: 300,
                fileSizeLimit: 5 * 1024 * 1024,    // 200 M
                fileSingleSizeLimit: 1 * 1024 * 1024    // 50 M
            });
            // 当有文件添加进来时执行，负责view的创建
            function addFile( file ) {
                var $li = $( '<li id="' + file.id + '">' +
                        '<p class="title">' + file.name + '</p>' +
                        '<p class="imgWrap"></p>'+
                        '<p class="progress"><span></span></p>' +
                        '</li>' ),

                    $btns = $('<div class="file-panel">' +
                        '<span class="cancel">删除</span></div>').appendTo( $li ),
                    $prgress = $li.find('p.progress span'),
                    $wrap = $li.find( 'p.imgWrap' ),
                    $info = $('<p class="error"></p>'),

                    showError = function( code ) {
                        switch( code ) {
                            case 'exceed_size':
                                text = '文件大小超出';
                                break;

                            case 'interrupt':
                                text = '上传暂停';
                                break;

                            default:
                                text = '上传失败，请重试';
                                break;
                        }

                        $info.text( text ).appendTo( $li );
                    };

                if ( file.getStatus() === 'invalid' ) {
                    showError( file.statusText );
                } else {
                    // @todo lazyload
                    $wrap.text( '预览中' );
                    uploader.makeThumb( file, function( error, src ) {
                        if ( error ) {
                            $wrap.text( '不能预览' );
                            return;
                        }

                        var img = $('<img src="'+src+'">');
                        $wrap.empty().append( img );
                    }, thumbnailWidth, thumbnailHeight );

                    percentages[ file.id ] = [ file.size, 0 ];
                    file.rotation = 0;
                }

                file.on('statuschange', function( cur, prev ) {
                    if ( prev === 'progress' ) {
                        $prgress.hide().width(0);
                    }

                    // 成功
                    if ( cur === 'error' || cur === 'invalid' ) {
                        console.log( file.statusText );
                        showError( file.statusText );
                        percentages[ file.id ][ 1 ] = 1;
                    } else if ( cur === 'interrupt' ) {
                        showError( 'interrupt' );
                    } else if ( cur === 'queued' ) {
                        percentages[ file.id ][ 1 ] = 0;
                    } else if ( cur === 'progress' ) {
                        $info.remove();
                        $prgress.css('display', 'block');
                    } else if ( cur === 'complete' ) {
                        $li.append( '<span class="success"></span>' );
                    }

                    $li.removeClass( 'state-' + prev ).addClass( 'state-' + cur );
                });

                $li.on( 'mouseenter', function() {
                    $btns.stop().animate({height: 30});
                });

                $li.on( 'mouseleave', function() {
                    $btns.stop().animate({height: 0});
                });

                $btns.on( 'click', 'span', function() {
                    var index = $(this).index(),
                        deg;

                    switch ( index ) {
                        case 0:
                            uploader.removeFile( file );
                            return;

                        case 1:
                            file.rotation += 90;
                            break;

                        case 2:
                            file.rotation -= 90;
                            break;
                    }

                    if ( supportTransition ) {
                        deg = 'rotate(' + file.rotation + 'deg)';
                        $wrap.css({
                            '-webkit-transform': deg,
                            '-mos-transform': deg,
                            '-o-transform': deg,
                            'transform': deg
                        });
                    } else {
                        $wrap.css( 'filter', 'progid:DXImageTransform.Microsoft.BasicImage(rotation='+ (~~((file.rotation/90)%4 + 4)%4) +')');
                    }


                });

                $li.appendTo( $queue );
            }

            // 负责view的销毁
            function removeFile( file ) {
                var $li = $('#'+file.id);

                delete percentages[ file.id ];
                updateTotalProgress();
                $li.off().find('.file-panel').off().end().remove();
                $.each(__this.goods.imgs,function(n,i){
                    if(i['id'] == file.id){
                        __this.goods.imgs.splice(n, 1);
                        return false;
                    }
                });
            }

            function updateTotalProgress() {
                var loaded = 0,
                    total = 0,
                    spans = $progress.children(),
                    percent;

                $.each( percentages, function( k, v ) {
                    total += v[ 0 ];
                    loaded += v[ 0 ] * v[ 1 ];
                } );

                percent = total ? loaded / total : 0;

                spans.eq( 0 ).text( Math.round( percent * 100 ) + '%' );
                spans.eq( 1 ).css( 'width', Math.round( percent * 100 ) + '%' );
            }

            uploader.onUploadProgress = function( file, percentage ) {
                var $li = $('#'+file.id),
                    $percent = $li.find('.progress span');

                $percent.css( 'width', percentage * 100 + '%' );
                percentages[ file.id ][ 1 ] = percentage;
                updateTotalProgress();
            };

            uploader.onFileQueued = function( file ) {
                fileCount++;
                fileSize += file.size;

                if ( fileCount === 1 ) {
                    $placeHolder.addClass( 'element-invisible' );
                    $statusBar.show();
                }

                addFile( file );
                updateTotalProgress();
            };

            uploader.onFileDequeued = function( file ) {
                fileCount--;

                removeFile( file );
                updateTotalProgress();

            };
            uploader.onUploadSuccess = function( file, response ) {
                if(response.status == true){
                    var img = {};
                     img.path = response.path
                     img.id = file.id
                    __this.goods.imgs.push(img);
                }
            };
            $upload.on('click', function() {
                if ( $(this).hasClass( 'disabled' ) ) {
                    return false;
                }

                if ( state === 'ready' ) {
                    uploader.upload();
                } else if ( state === 'paused' ) {
                    uploader.upload();
                } else if ( state === 'uploading' ) {
                    uploader.stop();
                }
            });

            $info.on( 'click', '.retry', function() {
                uploader.retry();
            } );
            $upload.addClass( 'state-' + state );
            updateTotalProgress();
    },
    data(){
        return{
            cats: [],
            imgs: [],
            goods: {
                cat_id:0,
                imgs: []
            },
            goods_id: 0
        }
    },
    methods:{
        getCats(){
            this.$http.get('/cats.json').then(function(response){
                this.$set('cats',response.data.data);
            });
        },
        addCat(){
            var __this = this;
            layer.prompt({title: '输入类目名称', formType: 0}, function(pass, index){
                if(pass != ''){
                    __this.$http.post('/goods/cat/add.json',{name:pass}).then(function (response) {
                        if(response.data.status == true){
                            $(".chosen-select").chosen("destroy");
                            __this.getCats();
                            __this.$set('goods.cat_id',response.data.data.id)
                            layer.close(index);
                        }
                    });
                }
            });
        },
        postGoods(){
            if(!this.goods.cn_name){
                toastr.error("中文品名不能为空");
                return false;
            }
            if(!this.goods.en_name){
                toastr.error("英文品名不能为空");
                return false;
            }
            if(!this.goods.product_sn){
                toastr.error("产品编号不能为空");
                return false;
            }
            this.goods.cat_id = $(".chosen-select").val();
            if(this.goods.cat_id == 0){
                toastr.error("请选择类目");
                return false;
            }
            if(this.goods.imgs.length == 0){
                toastr.error("请上传至少一张图片");
                return false;
            }
            this.$http.post('/goods/add.json',this.goods).then(function(response){
                if(response.data.status == true){
                    this.$route.router.go({path: '/goods/list'})
                }else{
                    toastr.error(response.data.msg);
                }
            });
        },
        removeImg(id, obj){
            var __this = this;
            $.each(this.goods.imgs,function (n,i) {
                if(i.id == id){
                    __this.goods.imgs.splice(n, 1);
                    return false;
                }
            })
            $(obj).remove();
        }
    },
    watch:{
        'cats':function () {
            this.$nextTick(function(){
                $(".chosen-select").chosen();
                $(".chosen-select").val(this.goods.cat_id);
                $(".chosen-select").trigger("chosen:updated");
            })
        }
    },
}
</script>
