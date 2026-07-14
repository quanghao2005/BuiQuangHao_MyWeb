<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // Import class Paginator

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // Share categories and brands to all views
        \Illuminate\Support\Facades\View::composer('client.*', function ($view) {
            $view->with('sharedCategories', \App\Models\Category::where('status', 1)->get());
            $view->with('sharedBrands', \App\Models\Brand::where('status', 1)->get());
        });
    }
}
