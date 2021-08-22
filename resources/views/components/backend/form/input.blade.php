@props(['type' => 'text', 'name'])
<input type="{{$type}}" name="{{$name}}"
    {{$attributes->merge(['class' => 'p-1 border border-indigo-300 rounded focus:outline-none focus:border-indigo-500'])}}
>

@error($name)
<div class="text-red-600">{{$message}}</div>
@enderror
