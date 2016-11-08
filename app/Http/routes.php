<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');

Route::get('captcha.json', 'Auth\AuthController@getCaptcha');

//用户验证
Route::group(['prefix' => 'auth'], function(){
    $Auth = 'Auth\AuthController@';

    Route::post('login.json', $Auth . 'postLogin');//登录
    Route::get('logout.json', $Auth . 'getLogout');//登出
    Route::get('resetpwd', 'Auth\PasswordController@resetPwd');//重设密码
});

Route::group(['prefix' => 'goods'], function(){
    Route::post('add.json', 'Goods\GoodsController@addGoods');//添加商品
});