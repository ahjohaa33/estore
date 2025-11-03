<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Models\Category;
use App\Models\Slider;
use App\Models\Products;


// Route::get('/', function () {
//     return view('pages.blade.home');
// });


// //Main Routes
// Route::get('/', function(){
//     $categories = Category::latest()->paginate(10);
//     $slider = Slider::latest()->paginate(10);
//     $products = Products::latest()->paginate(10);
//     return view('pages.blade.frontend.home')->with('categories', $categories)->with('sliders', $slider)->with('products', $products);
// })->name('homeRoute');

Route::get('/bal', function(){
    return view('admin.admin2.layout2');
});

//frontend routes
Route::get('products/{slug}', [ProductsController::class, 'singleProduct'])->name('singleproductRoute');



//backend routes
Route::prefix('admin')->group(function(){

    //Navigation
    Route::get('/', [AdminController::class, 'home'])->name('admindashboard');
    Route::get('/products', [AdminController::class, 'products'])->name('adminproducts');
    Route::get('/orders', [AdminController::class, 'orders'])->name('adminorders');
    Route::get('/customers', [AdminController::class, 'customers'])->name('admincustomers');
    Route::get('/settings', [AdminController::class, 'settings'])->name('adminsettings');
    Route::get('/categories', [AdminController::class, 'categories'])->name('admincategories');
    Route::get('sliders', [AdminController::class, 'sliders'])->name('adminSliders');
    
    //category
    Route::post('/createCategory', [CategoryController::class, 'store'])->name('createcategoryadmin');
    Route::post('delete/category', [CategoryController::class, 'bulk_delete'])->name('deletecategory');

    //slider
    Route::post('/createSlider', [SliderController::class, 'store'])->name('createSlider');
    Route::post('delete/slider', [SliderController::class, 'bulkDelete'])->name('deleteSlider');

    //products
    Route::post('/v1/createproduct', [ProductsController::class, 'store'])->name('createproduct');
    Route::post('delete/products', [ProductsController::class, 'destroy'])->name('deleteproducts');
   
    
});

//cart routes
Route::prefix('cart')->group(function(){
    Route::get('/', [CartController::class, 'show'])->name('cart.show');
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/update/{item}', [CartController::class, 'updateQty'])->name('cart.update');
    Route::delete('/item/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('cart.clear');
});

//Auth
Route::get('login', [UserController::class, 'index'])->name('userlogin');
Route::post('auth', [UserController::class, 'login'])->name('authentication');


//filter routes
Route::get('filter-products', [ProductsController::class, 'filter'])->name('productfilter');


//check routes for db
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/sliders', [SliderController::class, 'index']);
Route::get('/products', [ProductsController::class, 'index']);



//client routes
Route::get('/', [ClientController::class, 'home'])->name('homeroute');