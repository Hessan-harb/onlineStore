@props([
    'name','value'=>''
    ])

<textarea  class="text-gray-700 rounded-3" name="{{$name}}" 
    placeholder="{{$name}}">{{old($name) ?? $value}}</textarea>