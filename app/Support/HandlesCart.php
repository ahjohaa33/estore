<?php

namespace App\Support;

use App\Models\Cart;
use App\Models\Products;
use Illuminate\Http\Request;

trait HandlesCart
{
    protected function getCart(Request $request): Cart
    {
        $token = $request->cookie('cart_token');

        if ($token) {
            $cart = Cart::firstOrCreate(['token' => $token], ['currency' => 'BDT']);
        } else {
            $cart = Cart::create(['currency' => 'BDT']);
            cookie()->queue(cookie()->forever(
                name: 'cart_token',
                value: $cart->token,
                path: '/',
                domain: null,
                secure: app()->environment('production'),
                httpOnly: true,
                raw: false,
                sameSite: 'Lax'
            ));
        }

        if (auth()->check() && !$cart->user_id) {
            $cart->user_id = auth()->id();
            $cart->save();
        }

        return $cart;
    }

    protected function resolvePrice(Products $p): float
    {
        if ($p->offer_price) {
            return (float) $p->offer_price;
        }
        return (float) $p->price;
    }
}
