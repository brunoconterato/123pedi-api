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

use Drinking\Models\OAuthClient;
use Drinking\Models\User;
use GuzzleHttp\Client;

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

        Route::get('stocksearch', 'API\Customer\StockSearchController@index');
    });

    Route::group(['prefix'=>'unregistered', 'as'=>'unregistered.'], function(){
        Route::resource('orders',
            'API\Unregistered\UnregisteredCustomerOrdersController', [
                'except' => [
                    'index', 'create','edit','update','destroy', 'show'
                ]
            ]);

        Route::patch('/order/{orderId}/cancel_order', 'API\Unregistered\UnregisteredCustomerOrdersController@cancelOrder');
    });
});

Route::group(['prefix'=>'retailer', 'middleware'=>'auth', 'as'=>'retailer.'], function(){
    Route::get('order', ['as'=>'order.index', 'uses'=> 'RetailerOrdersController@index']);
    Route::get('order/vieworder/{id}', ['as'=>'order.vieworder', 'uses'=> 'RetailerOrdersController@viewOrder']);
    Route::post('order/update/{id}', ['as'=>'order.update', 'uses'=> 'RetailerOrdersController@update']);

    Route::get('stock/index', ['as'=>'stock.index', 'uses'=> 'retailer\StockController@index']);
    Route::get('stock/create', ['as'=>'stock.create', 'uses'=> 'retailer\StockController@create']);
    Route::post('stock/store', ['as'=>'stock.store','uses'=>'retailer\StockController@store']);
    Route::get('stock/edit/{id}', ['as'=>'stock.edit', 'uses'=> 'retailer\StockController@edit']);
    Route::post('stock/update/{id}', ['as'=>'stock.update','uses'=>'retailer\StockController@update']);
    Route::get('stock/destroy/{id}', ['as'=>'stock.destroy', 'uses'=>'retailer\StockController@destroy']);
});

Auth::routes();

Route::get('/home', 'HomeController@index');

//Route::get('/getdeadlinetocancelorderdt/{orderid}', 'API\Customer\CustomerOrdersController@getDeadLineToCancelOrderDT');
Route::get('/remainingtimetocancelorderdt/{orderid}', 'API\Customer\CustomerOrdersController@getRemainingTimeToCancelOrderDT');

//Route para registrar usuários de clientes da API (password grant type)
//TODO: Make transaction into database
//TODO: Modificar a rota /register-user para cliar novo client inclusive, não somente user
//TODO: Configurar para verificar se o cliente já existe, se já existir não precisa fazer muita coisa que tá a
Route::post('/register-user', 'API\Customer\AuthenticationController@registerUser');


