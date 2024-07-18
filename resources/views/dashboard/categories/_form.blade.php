
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
    <label for="">Category Name: &nbsp; </label>
    <x-form.input name="name" value="{{$category->name}}" />
</div><br>

<div class="form-group">
    <label for="">Category Parent: &nbsp; </label>
    <select name="parent_id">
        <option value="">primary category</option>
        @foreach($parents as $parent)
        <option value="{{$parent->id}}" @selected($category->parent_id == $parent->id)>
            {{$parent->name ?? ''}}</option>
        @endforeach
    </select>
</div><br>

<div class="form-group">
    <label for="">description: &nbsp; </label>
    <x-form.textarea name="description" value="{{$category->description}}" /></div><br>

<div class="form-group">
     <label for="">Category Image: &nbsp; </label>
     <input type="file" name="image">

     @if($category->image)
     <img src="{{asset('storage/' . $category->image)}}" height="50" alt="">
     @endif

</div><br>

<div class="form-group">
    <button class="btn btn-primary" type="submit">Save</button>
</div><br>