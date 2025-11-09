<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Cart;

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
    public function boot()
    {
        View::composer('*', function ($view) {
            $request = request();
            $token = $request->cookie('cart_token');

            $count = 0;
            if ($token) {
                $cart = Cart::where('token', $token)->first();
                if ($cart) {
                    $count = $cart->items()->sum('qty');
                }
            }

            $view->with('globalCartCount', $count);
        });
    }
}
