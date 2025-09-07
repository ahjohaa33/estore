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

    Slider::create([
        'slider_image'       => $path,
        'slider_title'       => $request->slider_title,
        'slider_description' => $request->slider_description,
        'slider_link'        => $request->slider_link,
    ]);

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
}
