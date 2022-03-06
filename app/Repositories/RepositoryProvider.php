<?php


namespace App\Repositories;

use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
            'App\Repositories\Category\CategoryInterface',
            'App\Repositories\Category\CategoryRepository'
        );

        $this->app->bind(
            'App\Repositories\Product\ProductInterface',
            'App\Repositories\Product\ProductRepository'
        );

        $this->app->bind(
            'App\Repositories\Order\OrderInterface',
            'App\Repositories\Order\OrderRepository'
        );

        $this->app->bind(
            'App\Repositories\Customer\CustomerInterface',
            'App\Repositories\Customer\CustomerRepository'
        );

        $this->app->bind(
            'App\Repositories\OrderDiscount\OrderDiscountInterface',
            'App\Repositories\OrderDiscount\OrderDiscountRepository'
        );

        $this->app->bind(
            'App\Repositories\Cart\CartInterface',
            'App\Repositories\Cart\CartRepository'
        );
    }

}
