<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function home(Request $request){
        return view('frontend.home');
    }
}
