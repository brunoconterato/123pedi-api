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

use Drinking\Models\OrderItem;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix'=>'api', 'as'=>'api.'], function(){

    Route::group(['prefix'=>'admin', 'as'=>'admin.'], function(){
        Route::resource('categories',
            'API\Admin\AdminCategoriesController',
                ['except'=>[
                    'create','edit','destroy'
                ]
            ]);
    });
    
    
    Route::group(['prefix'=>'retailer', 'middleware'=>'auth:api', 'as'=>'retailer.'], function(){
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
    
    Route::group(['prefix'=>'customer', 'middleware'=>'auth:api', 'as'=>'customer.'], function(){
        Route::resource('orders',
            'API\Customer\CustomerOrdersController', [
                'except' => [
                    'create','edit','update','destroy'
                ]
            ]);
        
        Route::patch('/order/{orderId}/cancel_order', 'API\Customer\CustomerOrdersController@cancelOrder');
    });
});

Auth::routes();

Route::get('/home', 'HomeController@index');



//Route::get('/getdeadlinetocancelorderdt/{orderid}', 'API\Customer\CustomerOrdersController@getDeadLineToCancelOrderDT');
Route::get('/remainingtimetocancelorderdt/{orderid}', 'API\Customer\CustomerOrdersController@getRemainingTimeToCancelOrderDT');



//Provavelmente deletar
//Route::group(['prefix'=>'apitester','as'=>'apitester'], function(){
//    Route::group(['prefix'=>'customer', 'as'=>'customer.'], function(){
//        $http = new GuzzleHttp\Client;
//
//        factory(OrderItem::class, 2)->create()->each(function($orderItem){
//            $orderItem->save();
//        });
//    });
//});