<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SliderController;
use App\Models\Category;
use App\Models\Slider;


Route::get('/', function () {
    return view('pages.blade.home');
});


//Main Routes
Route::get('/', function(){
    $categories = Category::latest()->paginate(10);
    $slider = Slider::latest()->paginate(10);
    return view('pages.blade.frontend.home')->with('categories', $categories)->with('sliders', $slider);
})->name('homeRoute');

//backend routes


Route::prefix('admin')->group(function(){
    Route::get('/', function(){
        return view('pages.blade.backend.pages.categoryandslider');
    })->name('adminRoute');
    Route::get('/product/upload', function(){
        return view('pages.blade.backend.pages.productupload');
    });
    Route::post('/createCategory', [CategoryController::class, 'store'])->name('createCategory');
    Route::post('/createSlider', [SliderController::class, 'store'])->name('createSlider');
});


//check routes for db
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/sliders', [SliderController::class, 'index']);