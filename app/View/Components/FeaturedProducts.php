<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Products;

class FeaturedProducts extends Component
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
        $featured = Products::where('is_featured', true)->withAvg('reviews', 'rating')->withCount('reviews')
                        ->take(20) 
                        ->get();
        return view('components.featured-products')->with('featured', $featured);
    }
}
