<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('姓名');
            $table->string('username')->unique()->comment('用户名');
            $table->string('email')->unique()->comment('邮箱');
            $table->string('avatar')->comment('头像');
            $table->string('password');
            $table->tinyInteger('is_admin')->comment('是否为管理员,1是0否')->default(0);
            $table->rememberToken();
            $table->tinyInteger('is_deleted')->comment('是否删除,1是删除')->default(0);
            $table->timestamps();
            $table->comment = '用户表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
