<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Products;

class ProductDetails extends Component
{
    public $product;

    public function __construct($slug)
    {
        $this->product = Products::where('name', $slug)->with([
                'reviews' => fn($q) => $q->with('user')->latest()->take(20), // show top 20
            ])->withAvg('reviews', 'rating')->withCount('reviews')->firstOrFail();
    }

    public function render()
    {
        return view('components.product-details');
    }
}

