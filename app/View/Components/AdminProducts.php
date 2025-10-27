<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Products;
use App\Models\Category;

class AdminProducts extends Component
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
        $products = Products::orderByDesc('id')->paginate(10);
        $cats = Category::all();
        return view('components.admin-products')->with('products', $products)->with('cats', $cats);
    }
}
