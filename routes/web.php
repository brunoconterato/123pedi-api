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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix'=>'api', 'as'=>'api.'], function(){

    Route::group(['prefix'=>'admin', 'middleware'=>'auth.checkrole:admin', 'as'=>'admin.'], function(){
        Route::resource('categories',
            'API\Admin\AdminCategoriesController',
                ['except'=>[
                    'create','edit','destroy'
                ]
            ]);
    });
    
    
    Route::group(['prefix'=>'retailer', 'middleware'=>'auth.checkrole:retailer', 'as'=>'retailer.'], function(){
        Route::resource('orders',
            'API\Retailer\RetailerOrdersController', [
                'except' => [
                    'create','store','edit','update','destroy'
                ]
            ]);

        Route::patch('order/{id}/update_status', [
            'uses'=> 'API\Retailer\RetailerOrdersController@updateStatus',
            'as'=> 'orders.update_status'
        ]);
    });
});

Auth::routes();

Route::get('/home', 'HomeController@index');