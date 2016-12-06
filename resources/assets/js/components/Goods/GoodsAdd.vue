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
                                <div id="uploader-demo">
                                    <div id="fileList" class="uploader-list"></div>
                                    <div id="filePicker">选择图片</div>
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
                                <input type="number" step="0.01" v-model="goods.fob_price" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">适用车型</label>

                            <div class="col-sm-4">
                                <textarea class="form-control" v-model="goods.car_types">

                                </textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">备注</label>

                            <div class="col-sm-4">
                                <textarea class="form-control" v-model="goods.mark">

                                </textarea>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="submit">保存内容</button>
                                <button class="btn btn-white" type="submit">取消</button>
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
        var $ = jQuery,
                $list = $('#fileList'),
        // 优化retina, 在retina下这个值是2
                ratio = window.devicePixelRatio || 1,

        // 缩略图大小
                thumbnailWidth = 100 * ratio,
                thumbnailHeight = 100 * ratio,

        // Web Uploader实例
                uploader;

        // 初始化Web Uploader
        uploader = WebUploader.create({

            // 自动上传。
            auto: true,

            // swf文件路径
            swf: BASE_URL + '/js/Uploader.swf',

            // 文件接收服务端。
            server: '/upload.json',

            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: '#filePicker',

            // 只允许选择文件，可选。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                //mimeTypes: 'image/gif,image/jpeg,image/jpg,image/png,image/bmp'
            }
        });

        // 当有文件添加进来的时候
        uploader.on( 'fileQueued', function( file ) {
            var $li = $(
                            '<div id="' + file.id + '" class="file-item thumbnail">' +
                            '<img><i @click="remove(this)" class="upload-img-remove-i fa fa-remove"></i><div class="upload-img-remove"></div>' +
                            '</div>'
                    ),
                    $img = $li.find('img');

            $list.append( $li );

            // 创建缩略图
            uploader.makeThumb( file, function( error, src ) {
                if ( error ) {
                    $img.replaceWith('<span>不能预览</span>');
                    return;
                }

                $img.attr( 'src', src );
            }, thumbnailWidth, thumbnailHeight );
        });

        // 文件上传过程中创建进度条实时显示。
        uploader.on( 'uploadProgress', function( file, percentage ) {
            var $li = $( '#'+file.id ),
                    $percent = $li.find('.progress span');

            // 避免重复创建
            if ( !$percent.length ) {
                $percent = $('<p class="progress"><span></span></p>')
                        .appendTo( $li )
                        .find('span');
            }

            $percent.css( 'width', percentage * 100 + '%' );
        });

        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader.on( 'uploadSuccess', function( file, response) {
            console.log(response)
            if(response.status == true){
                __this.setImgsUrl(response);
                $( '#'+file.id ).addClass('upload-state-done');
            }else{
                var $li = $( '#'+file.id ),
                        $error = $li.find('div.error');

                // 避免重复创建
                if ( !$error.length ) {
                    $error = $('<div class="error"></div>').appendTo( $li );
                }

                $error.text('上传失败');
            }
        });

        // 文件上传失败，现实上传出错。
        uploader.on( 'uploadError', function( file ) {
            var $li = $( '#'+file.id ),
                    $error = $li.find('div.error');

            // 避免重复创建
            if ( !$error.length ) {
                $error = $('<div class="error"></div>').appendTo( $li );
            }

            $error.text('上传失败');
        });

        // 完成上传完了，成功或者失败，先删除进度条。
        uploader.on( 'uploadComplete', function( file ) {
            $( '#'+file.id ).find('.progress').remove();
        });
    },
    data(){
        return{
            cats: [],
            goods: {
                cat_id:0
            },
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
            if(this.goods.cn_name){
                return false;
            }
            if(this.goods.en_name){
                return false;
            }
            if(this.goods.product_sn){
                return false;
            }
            if(this.goods.cat_id == 0){
                return false;
            }
        },
        setImgsUrl(){
            alert(1);
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
