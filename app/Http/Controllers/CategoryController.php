<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Slider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Exception;


class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        
        return response()->json([
            'status' => 200,
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        // return view('categories.create');
    }

    /**
     * Store a newly created category in storage.
     */
public function store(Request $request)
{
    // Validate input
    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:categories,name',
        'category_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    DB::beginTransaction();

    try {
        // Handle image upload if provided
        $imagePath = null;
        if ($request->hasFile('category_image')) {
            $imagePath = $request->file('category_image')->store('categories', 'public');
        }

        // Create category
        $category = Category::create([
            'name' => $validated['name'],
            'category_image' => $imagePath,
        ]);

        DB::commit();

        Log::info('Category created successfully', [
            'category_id' => $category->id,
            'name' => $category->name,
        ]);

        // ✅ Return JSON if API request
        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Category created successfully.',
                'data' => $category
            ], 201);
        }

        // ✅ Otherwise, handle as web form
        return redirect()->back()->with('success', 'Category created successfully.');

    } catch (Exception $e) {
        DB::rollBack();

        Log::error('Failed to create category', [
            'error_message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'input' => $request->all(),
        ]);

        // ✅ JSON error response if request expects JSON
        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create category. Please try again later.',
                'error' => $e->getMessage(),
            ], 500);
        }

        // ✅ Otherwise, redirect back with error for web requests
        return redirect()->back()->withErrors('Failed to create category. Please try again.');
    }
}

    /**
     * Display the specified category.
     */
    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'category_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $path = $category->category_image;

        if ($request->hasFile('category_image')) {
            // Delete old image if exists
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            $path = $request->file('category_image')->store('categories', 'public');
        }

        $category->update([
            'name'           => $request->name,
            'category_image' => $path,
        ]);

        return redirect()->back()->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->category_image && Storage::disk('public')->exists($category->category_image)) {
            Storage::disk('public')->delete($category->category_image);
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
