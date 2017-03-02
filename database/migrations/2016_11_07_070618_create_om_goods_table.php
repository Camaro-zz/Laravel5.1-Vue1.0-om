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
            $table->string('hs_code',50)->comment('HS编码')->default('');
            $table->tinyInteger('fyi_status')->comment('出货状态')->default(0);
            $table->decimal('tax_rate',10,2)->comment('退税率')->default(0);
            $table->text('report_key')->comment('报关要素')->default('');
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
