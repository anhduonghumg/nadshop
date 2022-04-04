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
