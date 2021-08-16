@props(['name'])

<select  name="{{$name}}"
    {{$attributes->merge(['class' => 'p-1 border border-indigo-300 rounded focus:outline-none focus:border-indigo-500'])}}
>
    {{$slot}}
</select>
