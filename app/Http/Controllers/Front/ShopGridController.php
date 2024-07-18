<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopGridController extends Controller
{
    public function index(Request $request)
    {
        $categories=Category::with('products')->paginate(10);

        $products=Product::with('category:name')->filterr($request->query())->paginate(10);

        return view('front.shop.index',compact('categories','products'));
    }

    public function show(Category $category)
    {
        $categoryWithProducts = Category::with('products')->findOrFail($category->id);

        $categories=Category::all();

        $products=Product::with('category:name')->paginate(10);

        return view('front.shop.show', compact('categoryWithProducts','categories','products'));
    }

}
