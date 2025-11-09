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
        //
    }


    public function singleProduct($slug)
    {
        return view('frontend.single-product', ['slug'=> $slug] );
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
        // 1. very basic validation
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'nullable|numeric|min:0',
            'offer_price' => 'nullable|numeric|min:0',
            'images.*'    => 'nullable|image|max:8096', // 4MB per image
        ]);

        Log::info('Product store request received', [
            'payload' => $request->all()
        ]);

        // will hold paths of images we upload so we can delete on failure
        $uploadedImagePaths = [];

        DB::beginTransaction();

        try {
            Log::info('DB transaction started for product create');

            // 2. handle images (if any)
            $imagesArray = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $img) {
                    if ($img->isValid()) {
                        // store in storage/app/public/products
                        $path = $img->store('products', 'public');
                        $imagesArray[] = $path; // frontend-friendly path
                        $uploadedImagePaths[] = 'public/' . $path; // actual storage path for rollback
                        Log::info('Image uploaded', ['path' => $path]);
                    }
                }
            } else {
                Log::info('No images found in request');
            }

            // 3. prepare data (make it "enter at ease")
            $data = [
                'name'          => $request->input('name'),
                'images'        => $imagesArray, // will be cast to json by model
                'category'      => $request->input('category'),
                'price'         => $request->input('price', 0),
                'offer_price'   => $request->input('offer_price'),
                'offer_duration'=> $request->input('offer_duration'), // must be valid datetime if sent
                'sale_count'    => $request->input('sale_count', 0),
                'specification' => $request->input('specification'),
                'is_fav'        => $request->boolean('is_fav', false) ? 1 : 0,
                'is_featured'   => $request->boolean('is_featured', false) ? 1 : 0,
                'in_stock'      => $request->input('in_stock', 0),
                'status'        => $request->input('status', 'active'),
            ];

            // optional: color & size may come as JSON/string/array — normalize to array
            $color = $request->input('color');
            if ($color) {
                // allow "red,green" style too
                $data['color'] = is_array($color) ? $color : array_map('trim', explode(',', $color));
            }

            $size = $request->input('size');
            if ($size) {
                $data['size'] = is_array($size) ? $size : array_map('trim', explode(',', $size));
            }

            Log::info('Prepared product data', $data);

            // 4. create product
            $product = Products::create($data);

            Log::info('Product created successfully', [
                'product_id' => $product->id
            ]);

            DB::commit();
            Log::info('DB transaction committed for product create');

            // final response
            return response()->json([
                'success' => true,
                'message' => 'Product created successfully.',
                'data'    => $product->fresh(),
            ], 201);

        } catch (Throwable $e) {

            Log::error('Error while creating product, starting rollback', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            DB::rollBack();

            // delete uploaded images because transaction failed
            if (!empty($uploadedImagePaths)) {
                foreach ($uploadedImagePaths as $path) {
                    if (Storage::exists($path)) {
                        Storage::delete($path);
                        Log::info('Rolled back & deleted image', ['path' => $path]);
                    }
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to create product.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }




    /**
     * Display the specified resource.
     */
    public function show(Products $products)
    {
        //
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
public function destroy(Products $products, Request $request)
{
    // Get selected product IDs (bulk delete)
    $ids = $request->input('ids', []);

    if (!empty($ids)) {
        // Fetch all selected products
        $items = Products::whereIn('id', $ids)->get();

        foreach ($items as $item) {
            // ✅ Delete all image fields if they exist
            $imageFields = ['image', 'image2', 'image3', 'image4'];

            foreach ($imageFields as $field) {
                if (!empty($item->$field) && Storage::disk('public')->exists($item->$field)) {
                    Storage::disk('public')->delete($item->$field);
                }
            }

            // ✅ Delete the product record itself
            $item->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Selected products and their images deleted successfully.'
        ]);
    }

    // ✅ Handle single delete (optional for RESTful delete route)
    if ($products && $products->exists) {
        $imageFields = ['image', 'image2', 'image3', 'image4'];

        foreach ($imageFields as $field) {
            if (!empty($products->$field) && Storage::disk('public')->exists($products->$field)) {
                Storage::disk('public')->delete($products->$field);
            }
        }

        $products->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product and its images deleted successfully.'
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'No products selected or invalid request.'
    ]);
}

    public function filter(Request $request)
    {
        $query = Products::query();

        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $products = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return view('components.admin-products', compact('products'))->render();
        }

        return view('components.admin-products', compact('products'));
    }
}
