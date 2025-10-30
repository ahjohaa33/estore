<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Products;

class RelatedProducts extends Component
{
    public $product;
    /**
     * Create a new component instance.
     */
    public function __construct($category)
    {
        $this->product = Products::where('category', $category)->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {

        return view('components.related-products');
    }
}
