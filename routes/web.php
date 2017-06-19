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

        Route::patch('orders/{id}/update_status', [
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
        
        Route::patch('/orders/{orderId}/cancel_order', 'API\Customer\CustomerOrdersController@cancelOrder');
    });

    Route::group(['prefix'=>'unregistered', 'as'=>'unregistered.'], function(){
        Route::resource('orders',
            'API\Unregistered\UnregisteredCustomerOrdersController', [
                'except' => [
                    'index', 'create','edit','update','destroy', 'show'
                ]
            ]);

        Route::patch('/orders/{orderId}/cancel_order', 'API\Unregistered\UnregisteredCustomerOrdersController@cancelOrder');
    });

    Route::group(['prefix' => 'search', 'as' => 'search.'], function () {
        Route::get('stocksearch', 'API\Search\StockSearchController@index');
    });

    Route::group(['prefix' => 'information', 'as' => 'information.'], function(){
        Route::resource('search_term',
            'API\Information\SearchGetterController', [
                'except' => [
                    'index', 'create','edit','update','destroy', 'show'
                ]
            ]);

        Route::resource('cart_item',
            'API\Information\CartItemGetterController', [
                'except' => [
                    'index', 'create','edit','update','destroy', 'show'
                ]
            ]);

        Route::resource('user_message',
            'API\Information\UserMessageGetterController', [
                'except' => [
                    'index', 'create','edit','update','destroy', 'show'
                ]
            ]);
    });
});

Route::group(['prefix'=>'retailer', 'middleware'=>'auth', 'as'=>'retailer.'], function(){

    //TODO: Verificar se estas 3 rotas comentadas estão problemáticas
    Route::get('orders', ['as'=>'orders.index', 'uses'=> 'Retailer\RetailerOrdersController@index']);
    Route::get('orders/vieworder/{id}', ['as'=>'orders.vieworder', 'uses'=> 'Retailer\RetailerOrdersController@viewOrder']);
    Route::post('orders/update/{id}', ['as'=>'orders.update', 'uses'=> 'Retailer\RetailerOrdersController@update']);

    Route::get('stock/index', ['as'=>'stock.index', 'uses'=> 'Retailer\StockController@index']);
    Route::get('stock/create', ['as'=>'stock.create', 'uses'=> 'Retailer\StockController@create']);
    Route::post('stock/store', ['as'=>'stock.store','uses'=>'Retailer\StockController@store']);
    Route::get('stock/edit/{id}', ['as'=>'stock.edit', 'uses'=> 'Retailer\StockController@edit']);
    Route::post('stock/update/{id}', ['as'=>'stock.update','uses'=>'Retailer\StockController@update']);
    Route::get('stock/destroy/{id}', ['as'=>'stock.destroy', 'uses'=>'Retailer\StockController@destroy']);
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

Route::group(['prefix'=>'admin', 'middleware'=>'auth.checkrole:admin', 'as'=>'admin.'], function(){
    Route::get('categories', 'Admin\CategoriesController@index');
    Route::get('categories/create', ['as'=>'categories.create', 'uses'=>'Admin\CategoriesController@create']);
    Route::post('categories/store', ['as'=>'categories.store', 'uses'=>'Admin\CategoriesController@store']);
    Route::get('categories/index', ['as'=>'categories.index', 'uses'=>'Admin\CategoriesController@index']);
    Route::post('categories/update/{id}', ['as'=>'categories.update', 'uses'=>'Admin\CategoriesController@update']);
    Route::get('categories/edit/{id}', ['as'=>'categories.edit', 'uses'=>'Admin\CategoriesController@edit']);

    Route::get('clients', 'Admin\ClientsController@index');
    Route::get('clients/create', ['as'=>'clients.create', 'uses'=>'Admin\ClientsController@create']);
    Route::post('clients/store', ['as'=>'clients.store', 'uses'=>'Admin\ClientsController@store']);
    Route::get('clients/index', ['as'=>'clients.index', 'uses'=>'Admin\ClientsController@index']);
    Route::post('clients/update/{id}', ['as'=>'clients.update', 'uses'=>'Admin\ClientsController@update']);
    Route::get('clients/edit/{id}', ['as'=>'clients.edit', 'uses'=>'Admin\ClientsController@edit']);

    Route::get('retailers', ['as'=>'retailers', 'uses'=>'Admin\RetailersController@index']);
    Route::get('retailers/create', ['as'=>'retailers.create', 'uses'=>'Admin\RetailersController@create']);
    Route::post('retailers/store', ['as'=>'retailers.store', 'uses'=>'Admin\RetailersController@store']);
    Route::get('retailers/index', ['as'=>'retailers.index', 'uses'=>'Admin\RetailersController@index']);
    Route::post('retailers/update/{id}', ['as'=>'retailers.update', 'uses'=>'Admin\RetailersController@update']);
    Route::get('retailers/edit/{id}', ['as'=>'retailers.edit', 'uses'=>'Admin\RetailersController@edit']);

    //Group for admin stock controll over some retailer
    Route::group(['prefix'=>'retailers/stock', 'middleware'=>'auth.checkrole:admin', 'as'=>'retailers.stock.'], function() {
        Route::get('index/{retailerId}', ['as' => 'index', 'uses' => 'Admin\RetailersController@stock']);
        Route::get('create/{retailerId}', ['as'=>'create', 'uses'=>'Admin\RetailersController@createStockItem']);
        Route::post('store/{retailerId}', ['as'=>'store', 'uses'=>'Admin\RetailersController@storeStockItem']);
        Route::get('edit/{retailerId}', ['as' => 'edit', 'uses' => 'Admin\RetailersController@editStockItem']);
        Route::post('update/{retailerId}', ['as'=>'update', 'uses'=>'Admin\RetailersController@updateStockItem']);
        Route::get('destroy/{retailerId}', ['as' => 'destroy', 'uses' => 'Admin\RetailersController@destroyStockItem']);
    });

    Route::get('products', 'Admin\ProductsController@index');
    Route::get('products/create/', ['as'=>'products.create', 'uses'=>'Admin\ProductsController@create']);
    Route::post('products/store', ['as'=>'products.store', 'uses'=>'Admin\ProductsController@store']);
    Route::get('products/index', ['as'=>'products.index', 'uses'=>'Admin\ProductsController@index']);
    Route::post('products/update/{id}', ['as'=>'products.update', 'uses'=>'Admin\ProductsController@update']);
    Route::get('products/edit/{id}', ['as'=>'products.edit', 'uses'=>'Admin\ProductsController@edit']);
    Route::get('products/destroy/{id}', ['as'=>'products.destroy', 'uses'=>'Admin\ProductsController@destroy']);
    Route::get('products/deleteImage/{id}', ['as'=>'products.deleteImage','uses'=>'Admin\ProductsController@deleteImage']);

    Route::get('orders', ['as'=>'orders.index', 'uses'=>'Admin\OrdersController@index']);
    Route::get('orders/create', ['as'=>'orders.create', 'uses'=> 'Admin\OrdersController@create']);
    Route::post('orders/store', ['as'=>'orders.store', 'uses'=> 'Admin\OrdersController@store']);
    Route::get('orders/{id}', ['as'=>'orders.edit', 'uses'=>'Admin\OrdersController@edit']);
    Route::post('orders/update/{id}', ['as'=>'orders.update','uses'=>'Admin\OrdersController@update']);
    Route::get('orders/deleteImage/{id}', ['as'=>'orders.deleteImage','uses'=>'Admin\OrdersController@deleteImage']);

    Route::get('unregisteredorders', ['as'=>'unregisteredorders.index', 'uses'=>'Admin\UnregisteredOrdersController@index']);
    Route::get('unregisteredorder/create', ['as'=>'unregisteredorders.create', 'uses'=> 'Admin\UnregisteredOrdersController@create']);
    Route::post('unregisteredorder/store', ['as'=>'unregisteredorders.store', 'uses'=> 'Admin\UnregisteredOrdersController@store']);
    Route::get('unregisteredorders/{id}', ['as'=>'unregisteredorders.edit', 'uses'=>'Admin\UnregisteredOrdersController@edit']);
    Route::post('unregisteredorders/update/{id}', ['as'=>'unregisteredorders.update','uses'=>'Admin\UnregisteredOrdersController@update']);
    Route::get('unregisteredorders/deleteImage/{id}', ['as'=>'unregisteredorders.deleteImage','uses'=>'Admin\UnregisteredOrdersController@deleteImage']);
});
