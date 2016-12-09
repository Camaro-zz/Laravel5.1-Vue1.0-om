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
$authApiMiddleware = 'auth.api';
Route::get('/', 'HomeController@index');

Route::get('captcha', 'Auth\AuthController@getCaptcha');

//用户验证
Route::group(['prefix' => 'auth'], function(){
    $Auth = 'Auth\AuthController@';

    Route::post('login.json', $Auth . 'postLogin');//登录
    Route::get('logout.json', $Auth . 'getLogout');//登出
    Route::get('resetpwd', 'Auth\PasswordController@resetPwd');//重设密码
    Route::get('login', $Auth . 'getLogin');
});

Route::group(['prefix' => 'user'], function(){
    Route::get('me.json', 'Users\UsersController@getMe');
});

Route::group(['middleware'=>$authApiMiddleware],function(){
    Route::put('pass.json', ['as' => 'userPass', 'uses' => 'Users\UsersController@putPassword']);//修改密码

    Route::get('suppliers.json', 'Supplier\SupplierController@getSuppliers');//供应商列表

    Route::get('goods.json', 'Goods\GoodsController@getGoodses');//供应商详情
    Route::get('cats.json', 'Goods\GoodsCatController@getCats');//获取商品类目列表
    Route::get('orders.json', 'Order\OrderController@getOrders');//获取订单列表
    Route::post('upload.json', 'UploadController@upload');//上传图片
});

//商品模块
Route::group(['prefix' => 'goods','middleware'=>$authApiMiddleware], function(){
    Route::post('add.json', 'Goods\GoodsController@postGoods');//添加商品
    Route::post('supplier/{id}.json', 'Goods\GoodsController@postSupplierGoods');//添加供应商商品
    Route::put('supplier/{id}.json', 'Goods\GoodsController@putSupplierGoods');//添加供应商商品
    Route::put('{id}.json', 'Goods\GoodsController@putGoods');//编辑商品
    Route::get('{id}.json', 'Goods\GoodsController@getGoods');//商品详情
    Route::delete('batch.json', 'Goods\GoodsController@deleteGoodses');//商品删除

    Route::post('cat/add.json', 'Goods\GoodsCatController@postCat');//添加商品类目
    Route::put('cat/{id}.json', 'Goods\GoodsCatController@putCat');//编辑商品类目
    Route::get('cat/{id}.json', 'Goods\GoodsCatController@getCat');//获取商品类目详情
    Route::delete('cat/batch.json', 'Goods\GoodsCatController@deleteCats');//删除类目

    Route::post('mfrs/{id}.json', 'Goods\GoodsController@postMfrsGoods');//添加产品生产商
    Route::get('mfrs/goods/{id}.json', 'Goods\GoodsController@getMfrsByGoods');//通过产品获取生产商
});

//供应商模块
Route::group(['prefix' => 'supplier','middleware'=>$authApiMiddleware],function(){
    Route::post('add.json', 'Supplier\SupplierController@postSupplier');//添加供应商
    Route::put('sort.json', 'Supplier\SupplierController@putSort');//修改供应商排序
    Route::put('{id}.json', 'Supplier\SupplierController@putSupplier');//修改供应商
    Route::get('{id}.json', 'Supplier\SupplierController@getSupplier');//供应商详情
    Route::delete('batch.json', 'Supplier\SupplierController@deleteSupplier');//供应商删除
});

//生产商模块
Route::group(['prefix' => 'mfrs','middleware'=>$authApiMiddleware],function(){
    Route::put('sort/{id}.json', 'Mfrs\MfrsController@putMfrsSort');//修改排序
    Route::put('{id}.json', 'Mfrs\MfrsController@putMfrs');//修改生产商
    Route::get('{id}.json', 'Mfrs\MfrsController@getMfrs');//生产商详情
    Route::delete('{id}.json', 'Mfrs\MfrsController@deleteMfrs');//生产商删除
});


//订单模块
Route::group(['prefix' => 'order','middleware'=>$authApiMiddleware],function(){
    Route::post('add.json', 'Order\OrderController@postOrder');//添加订单
    Route::put('{id}.json', 'Order\OrderController@putOrder');//修改订单
    Route::get('{id}.json', 'Order\OrderController@getOrder');//订单详情
});

Route::any('{all}', 'HomeController@index')->where('all', '.*');