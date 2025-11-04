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
        // ---------- DEBUG: raw incoming ----------
        Log::info('Incoming Product Request (raw)', $request->all());

        // ---- Helpers (inline closures) ----
        $parseJsonishArray = function ($value) {
            // Accept array directly
            if (is_array($value)) {
                return array_values(array_unique(array_filter(array_map(
                    fn($v) => is_string($v) ? trim($v) : $v,
                    $value
                ), fn($v) => $v !== '' && $v !== null)));
            }

            // Try JSON
            if (is_string($value)) {
                $trim = trim($value);
                if ($trim !== '') {
                    // Try strict JSON first
                    $decoded = json_decode($trim, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        return array_values(array_unique(array_filter(array_map(
                            fn($v) => is_string($v) ? trim($v) : $v,
                            $decoded
                        ), fn($v) => $v !== '' && $v !== null)));
                    }
                    // Fallback: comma-separated list
                    $parts = array_map('trim', explode(',', $trim));
                    $parts = array_values(array_unique(array_filter($parts, fn($v) => $v !== '')));
                    return $parts ?: null;
                }
            }

            return null; // keep null if empty/invalid
        };

        $bool01 = function ($value, $default = 0) {
            // Accept 1/0, "1"/"0", true/false, "true"/"false", on/off, yes/no
            if (is_bool($value)) return $value ? 1 : 0;

            // PHP filter handles many string forms
            $v = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if ($v === null) {
                // Try numeric forms
                if ($value === 1 || $value === '1') return 1;
                if ($value === 0 || $value === '0') return 0;
                return $default ? 1 : 0;
            }
            return $v ? 1 : 0;
        };

        $intOrNull = fn($v) => is_numeric($v) ? (int)$v : null;
        $floatOrNull = fn($v) => is_numeric($v) ? (float)$v : null;

        // ---- Gentle normalization (no hard validation) ----
        $name           = trim((string) $request->input('name', ''));
        $category       = trim((string) $request->input('category', ''));
        $price          = $floatOrNull($request->input('price'));
        $offer_price    = $floatOrNull($request->input('offer_price'));
        $offer_duration = $request->input('offer_duration'); // keep raw; DB cast can handle or store string

        // If offer_price > price, keep but you can also auto-correct or null it
        // $offer_price = ($offer_price !== null && $price !== null && $offer_price >= $price) ? null : $offer_price;

        $color          = $parseJsonishArray($request->input('color'));
        $size           = $parseJsonishArray($request->input('size'));

        $specification  = $request->input('specification'); // string or null
        $is_fav         = $bool01($request->input('is_fav', 0), 0);
        $in_stock       = $intOrNull($request->input('in_stock')) ?? 0;
        $is_featured    = $bool01($request->input('is_featured', 0), 0); // <— robust
        $status         = $request->input('status', 'active'); // default
        $sale_count     = $intOrNull($request->input('sale_count')) ?? 0;

        // ---------- DEBUG: normalized ----------
        Log::info('Normalized Product Payload (pre-upload)', [
            'name'           => $name,
            'category'       => $category,
            'price'          => $price,
            'offer_price'    => $offer_price,
            'offer_duration' => $offer_duration,
            'color'          => $color,        // expect array or null
            'size'           => $size,         // expect array or null
            'specification'  => $specification,
            'is_fav'         => $is_fav,       // 0/1
            'in_stock'       => $in_stock,
            'is_featured'    => $is_featured,  // 0/1
            'status'         => $status,
            'sale_count'     => $sale_count,
        ]);

        $uploadedImages = [];

        try {
            DB::beginTransaction();

            // ---- Images ----
            if ($request->hasFile('images')) {
                foreach ((array) $request->file('images') as $file) {
                    if ($file && $file->isValid()) {
                        $uploadedImages[] = $file->store('products', 'public');
                    }
                }
            }

            // ---- Build payload for DB ----
            $payload = [
                'name'           => $name ?: 'Untitled Product',
                'category'       => $category ?: null,
                'price'          => $price ?? 0.0,
                'offer_price'    => $offer_price,
                'offer_duration' => $offer_duration ? (string) $offer_duration : null,

                // Arrays → rely on $casts in model (see note below)
                'color'          => $color,   // array|null
                'size'           => $size,    // array|null

                'specification'  => $specification ?: null,
                'is_fav'         => $is_fav,        // 0/1
                'in_stock'       => $in_stock,
                'is_featured'    => $is_featured,   // 0/1
                'status'         => in_array($status, ['active','draft','inactive','outofstock'], true) ? $status : 'active',
                'sale_count'     => $sale_count,

                // Save images array (model cast to json/array)
                'images'         => !empty($uploadedImages) ? $uploadedImages : null,
            ];

            // ---------- DEBUG: final payload ----------
            Log::info('Final Product Payload (to DB)', $payload);

            $product = Products::create($payload);

            DB::commit();

            // JSON response (AJAX)
            if ($request->expectsJson() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product created successfully.',
                    'data'    => $product->fresh(),
                ], 201);
            }

            // Web response
            return redirect()
                ->back()
                ->with('success', 'Product created successfully.');

        } catch (Throwable $e) {
            DB::rollBack();

            // Cleanup uploaded files on error
            foreach ($uploadedImages as $path) {
                Storage::disk('public')->delete($path);
            }

            Log::error('Product creation failed', [
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
                'user_id' => optional($request->user())->id,
            ]);

            if ($request->expectsJson() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create product. Please try again later.',
                    'error'   => config('app.debug') ? $e->getMessage() : null,
                ], 500);
            }

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
