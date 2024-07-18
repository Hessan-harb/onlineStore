<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategeriesController extends Controller
{
    
    public function index()
    {
        if(Gate::denies('categories.view')){
            return abort(403);
        }

        $request=request();

        $categories=Category::/*leftJoin('categories as parents','parents.id','=','categories.parent_id')
            ->select([
                'categories.*',
                'parents.name as parent_name',
            ])*/
            with('parent')
            // ->select('categories.*')
            // ->selectRaw('(SELECT COUNT(*) FROM products WHERE category_id =categories.id) as product_count')
            ->withCount(['products as products_number'=>function($query){
                $query->where('status','=','active');
            }])
            
            ->filter($request->query())
            ->latest()
            ->paginate(10);

        return view('dashboard.categories.index',compact('categories'));
    }
 
    public function create()
    {
        if(!Gate::allows('categories.create')){
            return abort(403);
        }

        $parents=Category::all();

        $category=new Category();

        return view('dashboard.categories.create',compact('parents','category'));

    }

    public function show(Category $category){
        return view('dashboard.categories.show',[
            'category'=>$category
        ]);
    }
   
    public function store(CategoryRequest $request)
    {
        Gate::authorize('categories.create');

        $request->validated();
        
        $request->merge([
            'slug'=>Str::slug($request->post('name'))
        ]);

        $data=$request->except('image');

       $data['image']=$this->uploadImage($request);

        $category=Category::create($data);

        return redirect()->route('categories.index')->with('success','Category Created');
    }

   
    public function edit($id)
    {
        Gate::authorize('categories.update');

        try{

            $category=Category::findOrFail($id);
        }
        catch(\Exception $e){

            return redirect()->back()->withError("Something Wrong");
        }

        $parents=Category::where('id','<>',$id)

            ->where(function($query) use ($id){

                $query->whereNull('parent_id')

                    ->where('parent_id','<>',$id);
            })
            ->get();

        return view('dashboard.categories.edit',compact('category','parents'));
    }

   
    public function update(UpdateCategoryRequest $request, string $id)
    {

        $request->validated();

        $category=Category::find($id);

        $old_image=$category->image;

        $data=$request->except('image');

        $new_image=$this->uploadImage($request);

        if($new_image){
            $data['image']=$new_image;
        }

        $category->update($data);

        if($old_image && $new_image){
            Storage::disk('public')->delete($old_image);
        }

        return redirect()->route('categories.index')

            ->with('success','Category Updated Successfully');
    }

    
    public function destroy(string $id)
    {
        Gate::authorize('categories.delete');
        $category=Category::findOrFail($id);

        $category->delete();

        

        return redirect()
            ->route('categories.index')
            ->with('success','Category Deleted ');

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
        $categories=Category::onlyTrashed()->paginate();

        return view('dashboard.categories.trash',compact('categories'));
    }

    public function restore(Request $request,$id){

        $category=Category::onlyTrashed()->findOrFail($id);

        $category->restore();

        return redirect()->route('categories.trash')->with('success','category restored!');
    }

    public function forcedelete(Request $request,$id){

        $category=Category::onlyTrashed()->findOrFail($id);

        $category->forceDelete();

        if($category->image){
            Storage::disk('public')->delete($category->image);
        }

        return redirect()->route('categories.trash')->with('success','category deleted!');
    }
}
