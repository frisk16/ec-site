<?php

use Illuminate\Routing\Router;
use App\Admin\Controllers\UserController;
use App\Admin\Controllers\MajorCategoryController;
use App\Admin\Controllers\CategoryController;
use App\Admin\Controllers\ProductController;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');

    $router->resource('users', UserController::class);
    $router->resource('major_categories', MajorCategoryController::class);
    $router->resource('categories', CategoryController::class);
    $router->resource('products', ProductController::class);

});
