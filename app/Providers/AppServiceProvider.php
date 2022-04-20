<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Page;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            \App\Repositories\Page\PageRepositoryInterface::class,
            \App\Repositories\Page\PageRepository::class,
        );
        $this->app->singleton(
            \App\Repositories\CategoryPost\CategoryPostRepositoryInterface::class,
            \App\Repositories\CategoryPost\CategoryPostRepository::class,
        );
        $this->app->singleton(
            \App\Repositories\Post\PostRepositoryInterface::class,
            \App\Repositories\Post\PostRepository::class,
        );
        $this->app->singleton(
            \App\Repositories\CategoryProduct\CategoryProductRepositoryInterface::class,
            \App\Repositories\CategoryProduct\CategoryProductRepository::class,
        );
        $this->app->singleton(
            \App\Repositories\Brand\BrandRepositoryInterface::class,
            \App\Repositories\Brand\BrandRepository::class,
        );
        $this->app->singleton(
            \App\Repositories\User\UserRepositoryInterface::class,
            \App\Repositories\User\UserRepository::class,
        );
        $this->app->singleton(
            \App\Repositories\Product\ProductRepositoryInterface::class,
            \App\Repositories\Product\ProductRepository::class,
        );
        $this->app->singleton(
            \App\Repositories\Color\ColorRepositoryInterface::class,
            \App\Repositories\Color\ColorRepository::class,
        );
        $this->app->singleton(
            \App\Repositories\Size\SizeRepositoryInterface::class,
            \App\Repositories\Size\SizeRepository::class,
        );
        $this->app->singleton(
            \App\Repositories\Image\ImageRepositoryInterface::class,
            \App\Repositories\Image\ImageRepository::class,
        );
        $this->app->singleton(
            \App\Repositories\ProductDetail\ProductDetailRepositoryInterface::class,
            \App\Repositories\ProductDetail\ProductDetailRepository::class,
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
