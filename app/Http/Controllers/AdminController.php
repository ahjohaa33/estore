<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class AdminController extends Controller
{
    public function home(Request $request){
        return view('admin.dashboard');
    }

    public function products(Request $request){
        return view('admin.products');
    }

    public function orders(){
        return view('admin.orders');
    }

    public function customers(){
        return view('admin.customers');
    }

    public function categories(){
        $categories = Category::orderBy('id')->paginate();
        return view('admin.categoriesadmin')->with('categories', $categories);
    }

    public function settings(){
        return view('admin.settings');
    }
}
