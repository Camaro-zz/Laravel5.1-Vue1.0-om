<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOmGoodsImgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('om_goods_img', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('goods_id')->comment('产品id')->default(0);
            $table->string('img',100)->comment('图片地址')->default('');
            $table->tinyInteger('sort')->comment('排序，数值越高越靠前')->default(0);
            $table->tinyInteger('is_deleted')->comment('是否删除,1是删除')->default(0);
            $table->timestamps();
            $table->index('goods_id');
            $table->comment = '产品图片表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('om_goods_img');
    }
}
