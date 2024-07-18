@props([
    'type'=>'text', 'name','value'=>''
    ])

<input type="{{$type}}" class="text-gray-700 rounded-3" name="{{$name}}" 
      value="{{old($name) ?? $value}}">