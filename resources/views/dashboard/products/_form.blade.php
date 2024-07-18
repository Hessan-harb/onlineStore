
<style>
    label{
        font-size: 20px;
        display: inline-block;
        width: 200px;
    }
</style>
@if($errors->any())

<div class="alert alert-danger">
    @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
</div>
@endif

<div class="form-group">
    <label for="">product Name: &nbsp; </label>
    <x-form.input name="name" value="{{$product->name}}" />
</div><br>



<div class="form-group">
    <label for="">description: &nbsp; </label>
    <x-form.textarea name="description" value="{{$product->description}}" /></div><br>
</div>

<div class="form-group">
    <label for="">StoreId: &nbsp; </label>
    <x-form.input name="store_id" value="{{$product->store_id}}" /></div><br>
</div><br>

<div class="form-group">
    <label for="">Tags: &nbsp; </label>
    <x-form.input name="tags" value="{{$tags}}" /></div><br>
</div><br>

<div class="form-group">
    <label for="">Category: &nbsp; </label>
    <select name="category_id"  class="form-select"aria-label="Default select example">
        <option selected>Cateogries</option>
        @foreach(App\Models\Category::all() as $category)
        <option value="{{$category->id}}" @selected(old('category_id',$product->category_id)==$category->id)>{{$category->name}}</option>
        @endforeach
       
    </select>
</div><br>



<div class="form-group">
     <label for="">product Image: &nbsp; </label>
     <input type="file" name="image">

     @if($product->image)
     <img src="{{asset('storage/' . $product->image)}}" height="50" alt="">
     @endif
</div><br>

<div class="form-group">
    <button class="btn btn-primary" type="submit">Save</button>
</div><br>

{{-- @push('styles')
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
@endpush
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
<script>
    var input = document.querySelector('[name=tags]'),
    tagify = new Tagify(input)
</script>
@endpush --}}