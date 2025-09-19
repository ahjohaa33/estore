<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use App\Models\Category;

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
        // Validate inputs
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'images.*'      => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category'      => 'required|string',
            'price'         => 'required|numeric|min:0',
            'size'          => 'nullable|string|max:50',
            'specification' => 'nullable|string',
            'is_fav'        => 'nullable',
            'in_stock'      => 'nullable|integer|min:0',
            'status'        => 'required|string',
        ]);

      
        // Handle multiple image uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public'); // stores in storage/app/public/products
                $imagePaths[] = $path;
            }
        }

        // Save product
        $product = new Products();
        $product->name          = $validated['name'];
        $product->images        = $imagePaths; // store as JSON
        $product->category      = $validated['category'];
        $product->price         = $validated['price'];
        $product->size          = $validated['size'] ?? null;
        $product->specification = $validated['specification'] ?? null;
        $product->is_featured       = $request->has('is_featured') ? 1 : 0;
        $product->in_stock      = $validated['in_stock'] ?? 0;
        $product->status        = $validated['status'];
        $product->save();

        return redirect()->back()->with('success', 'Product added successfully!');
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
