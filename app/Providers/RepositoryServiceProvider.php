<?php

namespace Drinking\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Drinking\Repositories\CategoryRepository',
            'Drinking\Repositories\CategoryRepositoryEloquent'
        );

        $this->app->bind(
            'Drinking\Repositories\ProductRepository',
            'Drinking\Repositories\ProductRepositoryEloquent'
        );

        $this->app->bind(
            'Drinking\Repositories\ClientRepository',
            'Drinking\Repositories\ClientRepositoryEloquent'
        );

        $this->app->bind(
            'Drinking\Repositories\UserRepository',
            'Drinking\Repositories\UserRepositoryEloquent'
        );

        $this->app->bind(
            'Drinking\Repositories\OrderRepository',
            'Drinking\Repositories\OrderRepositoryEloquent'
        );

        $this->app->bind(
            'Drinking\Repositories\RetailerRepository',
            'Drinking\Repositories\RetailerRepositoryEloquent'
        );

        $this->app->bind(
            'Drinking\Repositories\StockItemRepository',
            'Drinking\Repositories\StockItemRepositoryEloquent'
        );

        $this->app->bind(
            'Drinking\Repositories\OAuthClientRepository',
            'Drinking\Repositories\OAuthClientRepositoryEloquent'
        );

        $this->app->bind(
            'Drinking\Repositories\UnregisteredOrderRepository',
            'Drinking\Repositories\UnregisteredOrderRepositoryEloquent'
        );

        $this->app->bind(
            'Drinking\Repositories\UnregisteredOrderItemRepository',
            'Drinking\Repositories\UnregisteredOrderItemRepositoryEloquent'
        );

        $this->app->bind(
            'Drinking\Repositories\SearchRepository',
            'Drinking\Repositories\SearchRepositoryEloquent'
        );
        
        $this->app->bind(
            'Drinking\Repositories\CartItemGetterRepository',
            'Drinking\Repositories\CartItemGetterRepositoryEloquent'
        );

        $this->app->bind(
            'Drinking\Repositories\UserMessageGetterRepository',
            'Drinking\Repositories\UserMessageGetterRepositoryEloquent'
        );
    }
}
