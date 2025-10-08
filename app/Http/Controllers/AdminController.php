<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function settings(){
        return view('admin.settings');
    }
}
