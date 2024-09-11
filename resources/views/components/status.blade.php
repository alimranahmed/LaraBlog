@props(['text', 'state' => 'positive'])
@php
    $statusClasses = match ($state) {
        'positive' => 'bg-green-100 text-green-700',
        'negative' => 'bg-red-100 text-red-700',
        'neutral' => 'bg-red-100 text-gray-600',
    }
@endphp

<span {{$attributes->merge(['class' => "inline-flex items-center rounded-full px-2 py-1 text-xs font-medium whitespace-nowrap ".$statusClasses])}}>{{$text}}</span>
