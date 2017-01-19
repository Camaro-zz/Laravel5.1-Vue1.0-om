<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOmGoodsPackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('om_goods_pack', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('goods_id')->comment('产品id')->default(0);
            $table->integer('num')->comment('装箱数')->default(0);
            $table->decimal('length',10,2)->comment('规格：长')->default(0);
            $table->decimal('width',10,2)->comment('规格：宽')->default(0);
            $table->decimal('height',10,2)->comment('规格：高度')->default(0);
            $table->decimal('gw',10,2)->comment('毛重')->default(0);
            $table->decimal('nw',10,2)->comment('净重')->default(0);
            $table->string('pack_type',50)->comment('包装类型')->default('');
            $table->text('mark')->comment('备注');
            $table->tinyInteger('is_deleted')->comment('是否删除,1是删除')->default(0);
            $table->timestamps();
            $table->index('goods_id');
            $table->comment = '产品包装细节表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
