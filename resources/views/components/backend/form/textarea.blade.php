@props(['type' => 'text', 'name', 'rounded' => true])

@php
$class = $rounded ? 'rounded' : '';
@endphp

<textarea type="{{$type}}" name="{{$name}}"
    {{$attributes->merge(['class' => "p-1 border border-indigo-300 focus:outline-none focus:ring-0 focus:border-indigo-500 $class"])}}
>{{$slot}}</textarea>
