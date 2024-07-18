<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){

        $products=Product::with('category')->active()->take(8)->get();
        $categories=Category::all();
        return view('front.home',compact('products','categories'));
    }
}
