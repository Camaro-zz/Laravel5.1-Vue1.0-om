<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOmCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('om_customer', function (Blueprint $table) {
            $table->increments('id');
            $table->string('customer_sn',50)->comment('客户编号')->default('');
            $table->string('name',50)->comment('客户名称')->default('');
            $table->string('country',50)->comment('国家')->default('');
            $table->string('contact',50)->comment('联系人')->default('');
            $table->string('address',50)->comment('地址')->default('');
            $table->string('email',50)->comment('邮箱')->default('');
            $table->string('tel',20)->comment('电话')->default('');
            $table->string('mobile',20)->comment('手机')->default('');
            $table->text('mark')->comment('备注');
            $table->tinyInteger('sort')->comment('排序，数值越大越靠前')->default(0);
            $table->timestamps();
            $table->index('customer_sn');
            $table->comment = '客户表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('om_customer');
    }
}
