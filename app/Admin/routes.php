<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->resource('example', 'ExampleController');  //测试
    $router->resource('set-account', 'SetAccountController');  //设置微信帐户
    $router->resource('set-menu', 'SetMenuController');  //设置菜单
    $router->resource('replies', 'ReplyController');  //关键词回复
});
