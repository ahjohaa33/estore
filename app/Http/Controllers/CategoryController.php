<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Slider;


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
        $request->validate([
            'name'           => 'required|string|max:255',
            'category_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $path = null;

        if ($request->hasFile('category_image')) {
            $path = $request->file('category_image')->store('categories', 'public');
        }

        Category::create([
            'name'           => $request->name,
            'category_image' => $path,
        ]);

        return redirect()->back()->with('success', 'Category created successfully.');
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
