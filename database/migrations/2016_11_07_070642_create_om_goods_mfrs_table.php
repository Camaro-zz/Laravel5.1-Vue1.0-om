<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOmGoodsMfrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('om_goods_mfrs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('goods_id')->comment('产品id')->default(0);
            $table->string('mfrs_sn',50)->comment('原厂编号')->default('');
            $table->string('mfrs_name',50)->comment('生产商名称')->default('');
            $table->tinyInteger('sort')->comment('排序，数值越大越靠前')->default(0);
            $table->timestamps();
            $table->index('goods_id');
            $table->comment = '生产商与产品关联表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('om_goods_mfrs');
    }
}
