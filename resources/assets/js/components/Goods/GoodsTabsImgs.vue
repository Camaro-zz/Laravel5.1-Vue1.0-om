<template>
    <div class="full-height-scroll" v-if="edit">
        <div class="table-responsive" style="margin-top:10px">
            <a @click="cancelGoodsImgs()" class="btn btn-warning" style="float:right">取消编辑</a>
            <a @click="updateGoodsImgs()" class="btn btn-info" style="float:right;margin-right:15px">保存图片</a>
        </div>
        <div class="table-responsive imgs-sortable-list" style="margin-top:10px;display:inline-block">
            <template v-for="img in imgs">
                <div id="{{img}}_edit" class="fancybox-box ui-sortable-handle" @mouseenter="showPanel($event)" @mouseleave="hidePanel($event)">
                    <div class="file-panel">
                        <span class="cancel" @click="removeImg($index,img)">删除</span>
                    </div>
                    <a class="fancybox" href="{{img}}">
                        <img  alt="image" v-bind:src="img" />
                    </a>
                </div>
            </template>
            <a class="add-imgs" id="dropz"></a>
        </div>
    </div>
    <div class="full-height-scroll" v-if="!edit">
        <div class="table-responsive" style="margin-top:10px">
            <a @click="editGoodsImgs()" class="btn btn-info" style="float:right">编辑图片</a>
        </div>
        <div class="table-responsive imgs-sortable-list" style="margin-top:10px;display:inline-block">
            <template v-for="img in imgs">
                <div id="{{img}}" class="fancybox-box ui-sortable-handle">
                    <a class="fancybox" href="{{img}}">
                        <img  alt="image" v-bind:src="img" />
                    </a>
                </div>
            </template>
        </div>
    </div>
</template>
<style>

</style>
<script>
    export default{
        props: ['goods_id','goods'],
        ready(){
            this.getGoodsImgs();
            var _this = this;
            $(".imgs-sortable-list").sortable({
                //handle: ".ui-sortable-handle",
                items: "> div",
                scroll: false,
                update: function (event, ui) {
                    _this.sortImgs($(this).sortable("toArray"))
                }
            }).disableSelection();
            $('.fancybox').fancybox({
                openEffect: 'none',
                closeEffect: 'none'
            });
        },
        data(){
            return{
                imgs:{},
                imgs_sort:[],
                edit: false
            }
        },
        methods:{
            getGoodsImgs(){
                this.$http.get('/goods/imgs/'+this.goods_id+'.json').then(function(response){
                    this.$set('imgs',response.data);
                });
            },
            updateGoodsImgs(){
                this.$http.post('/goods/imgs/'+this.goods_id+'.json',this.imgs).then(function(response){
                    toastr.success('图片上传成功');
                    this.edit = false
                });
            },
            removeImg(index,img){
                this.imgs.splice(index,1)
                if(index == 0){
                    this.goods.img = this.imgs[0]
                }
                this.$http.delete('/goods/img/'+this.goods_id+'.json?img='+img).then(function (response) {
                    
                });
            },
            sortImgs(sort){
                var img_length = this.imgs.length;
                var _this = this;
                $.each(sort,function (n, i) {
                    var m = {};
                    m.sort = img_length - n;
                    m.img = i;
                    _this.imgs_sort.push(m);
                });
                this.$http.post('/goods/img/'+this.goods_id+'.json',this.imgs_sort).then(function(response){
                    this.$set('goods.img',sort[0])
                    this.$set('imgs_sort',[]);
                });
            },
            showPanel(event){
                $(event.target).find('.file-panel').stop().animate({height: 30});

            },
            hidePanel(event){
                $(event.target).find('.file-panel').stop().animate({height: 0});

            },
            editGoodsImgs(){
                this.edit = true
            },
            cancelGoodsImgs(){
                this.edit = false
            }
        },
        watch:{
            'edit': function (val) {
                if(val){
                    var _this = this;
                    $("#dropz").dropzone({
                        url: "/upload.json",
                        //maxFiles: 10,
                        maxFilesize: 512,
                        acceptedFiles: ".png,.jpg,.jpeg,.gif",
                        previewTemplate: '<div></div>',
                        success:function (file, response, e) {
                            console.log(file);
                            if(response.status == true){
                                _this.imgs.push(response.path);
                                _this.goods.img = _this.imgs[0]
                            }
                        },
                        dictFileTooBig: '图片太大了',
                        dictInvalidInputType: '类型不对'
                    });
                }
            }
        }
    }
</script>
