<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function (){
    return redirect('/admin');
});

Route::any('wechat/{toekn}', 'WechatController@serve');
Route::any('wechat/menu', 'WechatController@getMenu');
Route::any('wechat/create-menu', 'WechatController@createMenu');
Route::any('testsend', 'WechatController@testSend');

