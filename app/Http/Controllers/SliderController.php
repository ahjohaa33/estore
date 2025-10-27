<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::latest()->paginate(10);
        return response()->json([
            'status' => 200,
            'sliders' => $sliders
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
    $request->validate([
        'slider_image'       => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        'slider_title'       => 'nullable|string|max:255',
        'slider_description' => 'nullable|string',
        'slider_link'        => 'nullable|url|max:255',
    ]);

    $path = null;

    if ($request->hasFile('slider_image')) {
        // Store in "public/sliders" directory
        $path = $request->file('slider_image')->store('sliders', 'public');
    }

    $slider = Slider::create([
        'slider_image'       => $path,
        'slider_title'       => $request->slider_title,
        'slider_description' => $request->slider_description,
        'slider_link'        => $request->slider_link,
    ]);

    // ✅ Return JSON if AJAX or expects JSON
    if ($request->ajax() || $request->wantsJson()) {
        return response()->json([
            'success' => true,
            'message' => 'Slider created successfully.',
            'data'    => $slider
        ]);
    }

    // ✅ Fallback for normal form submission
    return redirect()->back()->with('success', 'Slider created successfully.');
}



    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        //
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            // No IDs selected
            return $request->ajax()
                ? response()->json(['success' => false, 'message' => 'No sliders selected for deletion.'], 400)
                : redirect()->back()->with('error', 'No sliders selected for deletion.');
        }

        // Fetch the sliders
        $sliders = Slider::whereIn('id', $ids)->get();

        foreach ($sliders as $slider) {
            // Delete image from storage if exists
            if ($slider->slider_image && Storage::disk('public')->exists($slider->slider_image)) {
                Storage::disk('public')->delete($slider->slider_image);
            }

            // Delete database record
            $slider->delete();
        }

        // JSON or Redirect Response
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Selected sliders deleted successfully.'
            ]);
        }

        return redirect()->back()->with('success', 'Selected sliders deleted successfully.');
    }
}
