<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOmOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('om_order', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->comment('客户id')->default(0);
            $table->string('contract_sn',50)->comment('合同编号')->default('');
            $table->decimal('price',10,2)->comment('合同金额')->default(0);
            $table->string('manager',50)->comment('负责人')->default('');
            $table->text('mark')->comment('备注');
            $table->tinyInteger('is_deleted')->comment('是否删除,1是删除')->default(0);
            $table->timestamp('buy_at')->comment('下单时间')->default('0-0-0-0');
            $table->timestamp('order_at')->comment('交货时间')->default('0-0-0-0');
            $table->timestamps();
            $table->index('customer_id');
            $table->index('contract_sn');
            $table->comment = '订单表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('om_order');
    }
}
