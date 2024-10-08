@props(['name'])

<select name="{{$name}}"
    {{$attributes->merge(['class' => 'block p-1 border border-indigo-300 rounded focus:outline-none focus:ring-0 focus:border-indigo-500'])}}
>
    {{$slot}}
</select>
