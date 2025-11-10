<?php

namespace App\View\Components;

use App\Models\Products;
use App\Models\Category;
use Illuminate\View\Component;

class ShopList extends Component
{
    public $category;
    public $sort;
    public $q; // search

    /**
     * Create a new component instance.
     *
     * You can pass <x-shop-list category="TV" /> from blade
     */
    public function __construct($category = null, $sort = null, $q = null)
    {
        // priority: explicit param → querystring
        $this->category = $category ?: request('category');
        $this->sort     = $sort ?: request('sort');
        $this->q        = $q ?: request('q');
    }

    public function render()
    {
        // base query, eager load rating if you have it
        $query = Products::query()
            ->withAvg('reviews', 'rating')   // delete if you don't have reviews
            ->withCount('reviews');          // delete if you don't have reviews

        // filter by category (your table has category as string)
        if (!empty($this->category)) {
            $query->where('category', $this->category);
        }

        // search
        if (!empty($this->q)) {
            $search = $this->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // sorting
        switch ($this->sort) {
            case 'popular':
                // change "sale_count" to your real column
                $query->orderByDesc('sale_count');
                break;

            case 'ratings':
                // from withAvg('reviews','rating') → reviews_avg_rating
                $query->orderByDesc('reviews_avg_rating');
                break;

            case 'newest':
            default:
                $query->orderByDesc('created_at');
                break;
        }

        $products = $query->paginate(20)->withQueryString();

        // get distinct categories from products to show in slider
        $categories = Category::all();

        return view('components.shop-list', [
            'products'        => $products,
            'categories'      => $categories,
            'currentCategory' => $this->category,
            'currentSort'     => $this->sort,
            'currentSearch'   => $this->q,
        ]);
    }
}

