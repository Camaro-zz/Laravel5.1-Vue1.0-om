<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOmOrderGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('om_order_goods', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->comment('客户id')->default(0);
            $table->integer('order_id')->comment('订单id')->default(0);
            $table->integer('goods_id')->comment('产品id')->default(0);
            $table->decimal('fob_price',10,2)->comment('fob价格')->default(0);
            $table->integer('num')->comment('数量')->default(0);
            $table->timestamps();
            $table->index('customer_id');
            $table->comment = '订单关联商品表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('om_order_goods');
    }
}
