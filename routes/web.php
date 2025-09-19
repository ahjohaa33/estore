<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductsController;
use App\Models\Category;
use App\Models\Slider;
use App\Models\Products;


Route::get('/', function () {
    return view('pages.blade.home');
});


//Main Routes
Route::get('/', function(){
    $categories = Category::latest()->paginate(10);
    $slider = Slider::latest()->paginate(10);
    $products = Products::latest()->paginate(10);
    return view('pages.blade.frontend.home')->with('categories', $categories)->with('sliders', $slider)->with('products', $products);
})->name('homeRoute');



//backend routes
Route::prefix('admin')->group(function(){
    Route::get('/', function(){
        return view('pages.blade.backend.pages.categoryandslider');
    })->name('adminRoute');

    Route::get('/product/upload', [ProductsController::class, 'show'])->name('showproductform');

    Route::post('/createCategory', [CategoryController::class, 'store'])->name('createCategory');
    Route::post('/createSlider', [SliderController::class, 'store'])->name('createSlider');
    Route::post('/createproduct', [ProductsController::class, 'store'])->name('createproduct');
});


//check routes for db
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/sliders', [SliderController::class, 'index']);
Route::get('/products', [ProductsController::class, 'index']);