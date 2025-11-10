<?php

namespace App\View\Components;

use App\Models\Products;
use Illuminate\View\Component;

class Shop extends Component
{
    public $category;
    public $sort;

    public function __construct($category = null, $sort = null)
    {
        $this->category = $category;
        $this->sort = $sort;
    }

    public function render()
    {
        // get distinct categories from products table
        $categories = Products::query()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->get()
            ->pluck('category'); // gives simple array-like collection

        // base query
        $query = Products::query();

        // filter by category string from products table
        if ($this->category) {
            $query->where('category', $this->category);
        }

        // sorting (param or querystring)
        $sort = $this->sort ?: request('sort');

        switch ($sort) {
            case 'popular':
                // change to your real column if you have one
                $query->orderByDesc('sold_count');
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

