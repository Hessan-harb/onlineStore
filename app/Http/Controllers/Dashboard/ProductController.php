<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Jobs\ImportProducts;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products=Product::with(['category','store'])->filterr($request->query())->paginate(10);
       
        return view('dashboard.products.index',compact('products'));
    }

//to viedo hasmany realationship 8.1


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $product=new Product();
        $categories=Category::all();

        return view('dashboard.products.create',compact('product','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $request->validated();

        $request->merge([
            'slug'=>Str::slug($request->post('name')),
        ]);

        $data=$request->except('image');

        $data['image']=$this->uploadImage($request);

        $product=Product::create($data);

        return redirect()->route('products.index')->with('success','product created done!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $product=Product::findOrFail($id);
        $categories=Category::all();
        $tags=implode(',' , $product->tags()->pluck('name')->toArray());
        return view('dashboard.products.edit',compact('product','categories','tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $request->validated();

        $product=Product::findOrFail($id);

        $data=$request->except('image','tags');

        $old_image=$product->image;

        $new_image=$this->uploadImage($request);

        if($new_image){
            $data['image']=$new_image;
        }

        $product->update($data);

        $tags=explode(',',$request->post('tags'));

        $tag_ids=[];

        $saved_tags=Tag::all();

        foreach($tags as $t_name){
            $slug=Str::slug($t_name);
            $tag=$saved_tags->where('slug',$slug)->first();
            if(!$tag){
                $tag=Tag::create([
                    'name'=>$t_name,
                    'slug'=>$slug,
                ]);
            }
            $tag_ids[]=$tag->id;
        }

        $product->tags()->sync($tag_ids);

        if($old_image && $new_image){
            Storage::disk('public')->delete($old_image);
        }

        return redirect()->route('products.index')->with('success','product updated done!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $prodcut=Product::findOrFail($id);

        $prodcut->delete();

        return redirect()->route('products.index')->with('success','product deleted');
    }

    public function uploadImage(Request $request){
        if(!$request->hasFile('image')){
            return;
        }
        $file= $request->file('image');
        $path=$file->store('uploads',[
            'disk'=>'public'
        ]);

         return $path;
    }
    
    public function trash(){
        $products=Product::onlyTrashed()->paginate();

        return view('dashboard.products.trash',compact('products'));
    }

    public function restore(Request $request,$id){

        $product=Product::onlyTrashed()->findOrFail($id);

        $product->restore();

        return redirect()->route('products.trash')->with('success','product restored!');
    }

    public function forcedelete(Request $request,$id){

        $product=Product::onlyTrashed()->findOrFail($id);

        $product->forceDelete();

        if($product->image){
            Storage::disk('public')->delete($product->image);
        }

        return redirect()->route('products.trash')->with('success','product deleted!');
    }

    
}
