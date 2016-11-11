<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOmGoodsCatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('om_goods_cat', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->comment('上级类目id')->default(0);
            $table->string('name',50)->comment('类目名称')->default('');
            $table->timestamps();
            $table->index('parent_id');
            $table->tinyInteger('is_deleted')->comment('是否删除,1是删除')->default(0);
            $table->comment = '产品类目表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('om_goods_cat');
    }
}
