<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Products;

class TopProducts extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $topProducts = Products::withAvg('reviews', 'rating')->withCount('reviews')->orderBy('sale_count', 'desc')
                        ->take(8) 
                        ->get();
        return view('components.top-products')->with('products', $topProducts);
    }
}
