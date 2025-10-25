<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Log;
use Throwable;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Products::all();
        return response()->json([
            'status' => 200,
            'products' => $products
        ]);
    }


    public function singleProduct($slug){
        $product = Products::where('name', $slug)->get();
        $relatedproducts = Products::where('category', $product[0]->category);
        return view('pages.blade.frontend.singleproduct')->with('productdetails', $product)->with('relatedproducts', $relatedproducts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ✅ Step 1: Validation rules
        $validated = $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'category'        => ['required', 'string', 'max:255'],
            'price'           => ['required', 'numeric', 'min:0'],
            'offer_price'     => ['nullable', 'numeric', 'min:0', 'lt:price'],
            'offer_duration'  => ['nullable', 'date', 'after_or_equal:today'],
            'color'           => ['nullable', 'string'],
            
            'size'            => ['nullable', 'string'],
           
            'specification'   => ['nullable', 'string'],
            'is_fav'          => ['nullable', 'integer'],
            'in_stock'        => ['nullable', 'integer'],
            'is_featured'     => ['nullable', 'boolean'],
            'status'          => ['nullable'],
            'sale_count'      => ['nullable', 'integer', 'min:0'],
            'images'          => ['nullable', 'array'],
            'images.*'        => ['image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        DB::beginTransaction();
        $uploadedImages = [];

        try {
            // ✅ Step 2: Image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $path = $file->store('products', 'public');
                    $uploadedImages[] = $path;
                }
            }

            // ✅ Step 3: Normalize and prepare payload
            $payload = [
                'name'           => trim($validated['name']),
                'images'         => !empty($uploadedImages) ? $uploadedImages : null,
                'color'          => isset($validated['color']) ? $validated['color'] : null,
                'size'           => isset($validated['size']) ? $validated['size'] : null,
                'category'       => $validated['category'] ?? null,
                'price'          => (float) $validated['price'],
                'offer_price'    => $validated['offer_price'] ?? null,
                'offer_duration' => $validated['offer_duration'] ?? null,
                'sale_count'     => $validated['sale_count'] ?? 0,
                'specification'  => $validated['specification'] ?? null,
                'is_fav'         => $validated['is_fav'] ??  0,
                'in_stock'       => $validated['in_stock'] ?? 0,
                'is_featured'    =>(bool)($validated['is_featured']) ?? false,
                'status'         => $validated['status'],
            ];

            // ✅ Step 4: Persist product atomically
            $product = Products::create($payload);

            DB::commit();

            // ✅ Step 5: Respond accordingly
            if ($request->expectsJson() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product created successfully.',
                    'data'    => $product->fresh(),
                ], 201);
            }

            // For normal form submissions (web)
            return redirect()
                ->route('products.index')
                ->with('success', 'Product created successfully.');

        } catch (Throwable $e) {
            DB::rollBack();

            // Cleanup uploaded images if something fails
            foreach ($uploadedImages as $path) {
                Storage::disk('public')->delete($path);
            }

            Log::error('Product creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => optional($request->user())->id,
            ]);

            // JSON error response
            if ($request->expectsJson() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create product. Please try again later.',
                    'error'   => config('app.debug') ? $e->getMessage() : null,
                ], 500);
            }

            // Web (Blade) response
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create product. Please try again later.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Products $products)
    {
        $categories = Category::all();
        return view('pages.blade.backend.pages.productupload')->with('categories', $categories);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Products $products)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $products)
    {
        //
    }
}
