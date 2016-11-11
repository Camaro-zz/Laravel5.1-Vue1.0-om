<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOmSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('om_supplier', function (Blueprint $table) {
            $table->increments('id');
            $table->string('supplier_sn')->comment('供应商编号')->default('');
            $table->string('name')->comment('供应商名称')->default('');
            $table->string('contacts')->comment('联系人')->default('');
            $table->string('tel')->comment('电话')->default('');
            $table->string('mobile')->comment('手机')->default('');
            $table->string('qq')->comment('QQ')->default('');
            $table->string('website')->comment('网站')->default('');
            $table->string('address')->comment('地址')->default('');
            $table->tinyInteger('sort')->comment('排序，数值越大越靠前')->default(0);
            $table->text('mark')->comment('备注');
            $table->tinyInteger('is_deleted')->comment('是否删除,1是删除')->default(0);
            $table->timestamps();
            $table->index('supplier_sn');
            $table->comment = '供应商表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('om_supplier');
    }
}
