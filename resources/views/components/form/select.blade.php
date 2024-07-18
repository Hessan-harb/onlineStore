
@props([
     'name','value'=>'','options','text','selected'
    ])

<select class="form-select"aria-label="Default select example" name="{{$name}}" id="">
    @foreach($options as $value=>$text)
    <option value="{{$value}}" @selected($value == $selected)>{{$text}}</option>
    @endforeach
</select>