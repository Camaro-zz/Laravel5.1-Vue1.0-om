<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOmGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('om_goods', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->comment('添加人id')->default(0);
            $table->integer('cat_id')->comment('所属类目id')->default(0);
            $table->string('product_sn',50)->comment('产品编号')->default('');
            $table->string('img',200)->comment('产品图片')->default('');
            $table->string('en_name',50)->comment('英文品名')->default('');
            $table->string('cn_name',50)->comment('中文品名')->default('');
            $table->decimal('fob_price',10,2)->comment('fob价格')->default(0);
            $table->text('car_types')->comment('适用车型');
            $table->text('mark')->comment('备注');
            $table->tinyInteger('is_deleted')->comment('是否删除,1是删除')->default(0);
            $table->timestamps();
            $table->index('cat_id');
            $table->index('product_sn');
            $table->comment = '产品表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('om_goods');
    }
}
