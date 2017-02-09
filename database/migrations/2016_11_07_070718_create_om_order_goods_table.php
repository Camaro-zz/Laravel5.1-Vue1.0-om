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
            $table->integer('uid')->comment('添加人id')->default(0);
            $table->integer('customer_id')->comment('客户id')->default(0);
            $table->integer('order_id')->comment('订单id')->default(0);
            $table->integer('supplier_id')->comment('供应商id')->default(0);
            $table->string('mfrs_sn',50)->comment('原厂编号')->default('');
            $table->integer('goods_id')->comment('产品id')->default(0);
            $table->decimal('fob_price',10,2)->comment('fob价格')->default(0);
            $table->decimal('tax_price',10,2)->comment('采购价（含）')->default(0);
            $table->decimal('price',10,2)->comment('采购价（不含）')->default(0);
            $table->tinyInteger('type')->comment('0是询价记录,1是采购记录（即订单）')->default(0);
            $table->integer('num')->comment('数量')->default(0);
            $table->tinyInteger('is_deleted')->comment('是否删除,1是删除')->default(0);
            $table->timestamps();
            $table->index('customer_id');
            $table->index('goods_id');
            $table->index('order_id');
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
