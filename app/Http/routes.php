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
    Route::get('customers.json', 'Customer\CustomerController@getCustomers');//客户列表

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
    Route::get('supplier/{id}.json', 'Goods\GoodsController@getSupplierByGoods');//通过产品获取供应商
    Route::get('suppliers/{goods_id}.json', 'Goods\GoodsController@getSuppliersByGoods');//通过产品获取供应商
    Route::delete('suppliers/{id}.json', 'Goods\GoodsController@deleteGoodsSupplier');//删除供应商关联
    Route::put('{id}.json', 'Goods\GoodsController@putGoods');//编辑商品
    Route::get('{id}.json', 'Goods\GoodsController@getGoods');//商品详情
    Route::delete('batch.json', 'Goods\GoodsController@deleteGoodses');//商品删除

    Route::post('cat/add.json', 'Goods\GoodsCatController@postCat');//添加商品类目
    Route::put('cat/{id}.json', 'Goods\GoodsCatController@putCat');//编辑商品类目
    Route::get('cat/{id}.json', 'Goods\GoodsCatController@getCat');//获取商品类目详情
    Route::delete('cat/batch.json', 'Goods\GoodsCatController@deleteCats');//删除类目

    Route::post('mfrs/{id}.json', 'Goods\GoodsController@postMfrsGoods');//添加产品生产商
    Route::get('mfrs/goods/{id}.json', 'Goods\GoodsController@getMfrsByGoods');//通过产品获取生产商

    Route::get('imgs/{id}.json', 'Goods\GoodsController@getGoodsImgs');//获取图片
    Route::post('imgs/{id}.json', 'Goods\GoodsController@postGoodsImgs');//保存图片
    Route::post('img/{id}.json', 'Goods\GoodsController@postGoodsImg');//保存图片
    Route::delete('img/{id}.json', 'Goods\GoodsController@deleteGoodsImg');//删除图片

    Route::get('car_type/{id}.json', 'Goods\GoodsController@getGoodsCarTypes');//获取车型
    Route::delete('car_type/batch.json', 'Goods\GoodsController@deleteGoodsCarTypes');//删除车型
    Route::delete('car_type/{id}.json', 'Goods\GoodsController@deleteGoodsCarType');//删除车型
    Route::post('car_type/{id}.json', 'Goods\GoodsController@postGoodsCarType');//添加车型
    Route::put('car_type/sort/{id}.json', 'Goods\GoodsController@sortGoodsCarType');//车型排序
    Route::put('car_type/{id}.json', 'Goods\GoodsController@putGoodsCarType');//编辑车型

    Route::get('pack/{id}.json', 'Goods\GoodsController@getGoodsPack');//获取包装细节
    Route::post('pack/{id}.json', 'Goods\GoodsController@postGoodsPack');//添加包装细节
    Route::put('pack/{id}.json', 'Goods\GoodsController@putGoodsPack');//修改包装细节

    Route::get('xjs/{id}.json', 'Goods\GoodsController@getGoodsXjs');//获取报价记录
});

//供应商模块
Route::group(['prefix' => 'supplier','middleware'=>$authApiMiddleware],function(){
    Route::post('add.json', 'Supplier\SupplierController@postSupplier');//添加供应商
    Route::post('add/{goods_id}.json', 'Supplier\SupplierController@postSupplierByGoods');//在产品界面添加供应商
    Route::put('sort/{id}.json', 'Supplier\SupplierController@putSupplierSort');//修改供应商排序
    Route::put('{id}.json', 'Supplier\SupplierController@putSupplier');//修改供应商
    Route::get('{id}.json', 'Supplier\SupplierController@getSupplier');//供应商详情
    Route::get('/max/id.json', 'Supplier\SupplierController@getSupplierMaxId');//获取供应商最大id
    Route::get('goods/{id}.json', 'Supplier\SupplierController@getSupplierGoods');//供应商供应的产品列表
    Route::post('goods/{id}.json', 'Supplier\SupplierController@postSupplierGoods');//供应商供应的产品添加
    Route::put('goods/{id}.json', 'Supplier\SupplierController@putSupplierGoods');//供应商供应的产品
    Route::delete('batch.json', 'Supplier\SupplierController@deleteSupplier');//供应商删除
});

//客户模块
Route::group(['prefix' => 'customer','middleware'=>$authApiMiddleware],function(){
    Route::post('add.json', 'Customer\CustomerController@postCustomer');//添加客户
    //Route::put('sort/{id}.json', 'Customer\CustomerController@putSupplierSort');//修改客户排序
    Route::put('{id}.json', 'Customer\CustomerController@putCustomer');//修改客户
    Route::get('{id}.json', 'Customer\CustomerController@getCustomer');//客户详情
    Route::delete('batch.json', 'Customer\CustomerController@deleteCustomer');//客户删除
    Route::get('xjs/{id}.json', 'Order\OrderController@getXjs');//单个客户询价记录
    Route::post('xjs/{id}.json', 'Order\OrderController@postXjs');//添加客户询价记录
    Route::put('xjs/{id}.json', 'Order\OrderController@putXj');//编辑客户询价记录
    Route::delete('xjs/{id}.json', 'Order\OrderController@deleteXj');//删除客户询价记录
    Route::get('orders/{id}.json', 'Order\OrderController@getCustomerOrders');//单个客户采购记录

    Route::get('contract_sn/{id}.json', 'Order\OrderController@getContractSn');//获取最新订单sn

    Route::get('order_info/{id}.json', 'Order\OrderController@getOrderInfo');//获取订单详情
    Route::post('order_info/{id}.json', 'Order\OrderController@postOrderInfo');//添加订单详情
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
    Route::post('add/{id}.json', 'Order\OrderController@postOrder');//添加订单
    Route::put('{id}.json', 'Order\OrderController@putOrder');//修改订单
    Route::get('{id}.json', 'Order\OrderController@getOrder');//订单详情
});

Route::any('{all}', 'HomeController@index')->where('all', '.*');