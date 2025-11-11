<?php

namespace App\View\Components;

use App\Models\Category;
use App\Models\Products;
use Illuminate\View\Component;

class ProductCategory extends Component
{
    public string $category;   // passed from blade
    public ?Category $categoryModel = null;
    

    public function __construct(string $category)
    {
        $this->category = $category;
    }

    public function render()
    {
        // current request values (for search / sort / page)
        $search = request('q');           // ?q=keyword
        $sort   = request('sort');        // ?sort=price_asc etc.

        // find category by name or slug
        $cat = Category::where('name', $this->category)
            
            ->first();

        // if no category found, send empty paginator
        if (!$cat) {
            $products = Products::whereRaw('1=0')->paginate(12);
            return view('components.product-category', [
                'categoryName' => $this->category,
                'category'     => null,
                'products'     => $products,
                'search'       => $search,
                'sort'         => $sort,
            ]);
        }

        $query = Products::where('category', $cat->name);

        // search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  
                  ->orWhere('specification', 'like', "%{$search}%");
            });
        }

        // sort
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('offer_price')->orderBy('price');
                break;
            case 'price_desc':
                $query->orderByDesc('offer_price')->orderByDesc('price');
                break;
            case 'name_asc':
                $query->orderBy('name');
                break;
            default:
                // latest
                $query->latest();
                break;
        }

        // paginate
        $products = $query->paginate(12)->appends(request()->query());

        return view('components.product-category', [
            'categoryName' => $cat->name,
            'category'     => $cat,
            'category_image' => $cat->category_image,
            'products'     => $products,
            'search'       => $search,
            'sort'         => $sort,
        ]);
    }
}

