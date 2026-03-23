<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        // Share basket item count with every view so the navbar badge stays live.
        View::composer('*', function ($view) {
            $basketCount = 0;

            if (Auth::check()) {
                $basket = Auth::user()->basket()->with('basketItems')->first();
                $basketCount = $basket
                    ? $basket->basketItems->sum('quantity')
                    : 0;
            }

            $view->with('basketCount', $basketCount);
        });
    }
}
