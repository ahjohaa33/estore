<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Products;
use Carbon\Carbon;

class BestSeller extends Component
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
        $bestSeller = Products::where('updated_at', '>=', Carbon::now()->subDays(7))
                    ->withAvg('reviews', 'rating')   // adds: reviews_avg_rating
                    ->withCount('reviews')
                    ->orderBy('sale_count', 'desc')
                    ->take(4)
                    ->get();
        return view('components.best-seller')->with('bestseller', $bestSeller);
    }
}
