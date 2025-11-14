<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Return JSON suggestions for the autocomplete.
     */
    public function suggestions(Request $request)
    {
        $q = trim($request->query('q', ''));

        if ($q === '') {
            return response()->json([]);
        }

        // Basic search - search name, sku, and short description. Limit to 8 results.
        $products = Products:: // adjust fields to your model
            where('name', 'like', "%{$q}%")
            
            ->orWhere('specification', 'like', "%{$q}%")
            ->limit(8)
            ->get();

        $results = $products->map(function ($p) {
                    // Decode json image array (in case it's stored as string)
                $images = is_string($p->images) ? json_decode($p->images, true) : $p->images;

                // Determine first image if available
                $imageUrl = (!empty($images) && isset($images[0]))
                    ? asset('storage/' . $images[0])
                    : asset('images/product-placeholder.png');

            return [
                'id'    => $p->id,
                'name'  => $p->name,
                'price' => $p->price ?? null,
                // image URL: adjust to your storage scheme (public storage, CDN, etc.)
                'image' => $imageUrl,
                // generate product URL (use slug if available)
                'url'   => route('products.show', $p->name),
            ];
        });

        return response()->json($results);
    }

    /**
     * Optional: full search results page when user submits the form.
     */
    public function index(Request $request)
    {
        $q = trim($request->query('q', ''));
        $products = collect();

        if ($q !== '') {
            $products = Products::where('name', 'like', "%{$q}%")
                
                ->orWhere('specification', 'like', "%{$q}%")
                ->paginate(24)
                ->appends(['q' => $q]);
        }

        return view('search.results', compact('products', 'q'));
    }
}

