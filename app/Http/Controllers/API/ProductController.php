<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('index','show');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $product= Product::with('category:id,name','store:id,name','tags:id,name')->paginate();

        return  ProductResource::Collection($product);
            
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $request->validated();

        $product= Product::create($request->all());

        return $product;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product=Product::findOrFail($id);
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product=Product::findOrFail($id);
        //$product= $request->validated();

        $product->update($request->all());
        return  $product;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product=Product::findOrFail($id);
        $product->delete();
        return [
            'product deleted'
        ];
    }
}
