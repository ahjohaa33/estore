<?php

namespace App\View\Components;

use App\Models\Products;
use App\Models\Category;
use Illuminate\View\Component;

class Shop extends Component
{
    public $category;
    public $sort;

    public function __construct($sort = null)
    {
        
        $this->sort = $sort;
    }

    public function render()
    {
        // get distinct categories from products table
        $categories = Category::all();


        // base query
        $query = Products::withAvg('reviews', 'rating')->withCount('reviews');

        // filter by category string from products table
        if ($this->category) {
            $query->where('category', $this->category);
        }

        // sorting (param or querystring)
        $sort = $this->sort ?: request('sort');

        switch ($sort) {
            case 'popular':
                // change to your real column if you have one
                $query->orderByDesc('sale_count');
                break;

            case 'ratings':
                $query->orderByDesc('rating');
                break;

            case 'newest':
            default:
                $query->orderByDesc('created_at');
                break;
        }

        $products = $query->paginate(24);

        return view('components.shop', [
            'categories'      => $categories,
            'products'        => $products,
            'currentCategory' => $this->category,
            'currentSort'     => $sort,
        ]);
    }
}

