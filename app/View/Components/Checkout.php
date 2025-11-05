<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Http\Request;
use App\Support\HandlesCart;

class Checkout extends Component
{
    use HandlesCart;

    public $cart;
    public $items;
    public $totals;
    /**
     * Create a new component instance.
     */
    public function __construct(Request $request)
    {
        $cart = $this->getCart($request)->load('items.product');

        $this->cart   = $cart;
        $this->items  = $cart->items;
        $this->totals = $cart->totals();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.checkout');
    }
}
