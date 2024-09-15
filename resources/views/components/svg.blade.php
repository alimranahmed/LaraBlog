@props(['icon'])

@php
    $path = match ($icon) {
        'search' => 'M16.32 14.9l5.39 5.4a1 1 0 0 1-1.42 1.4l-5.38-5.38a8 8 0 1 1 1.41-1.41zM10 16a6 6 0 1 0 0-12 6 6 0 0 0 0 12z',
        'cross' => 'M16.24 14.83a1 1 0 0 1-1.41 1.41L12 13.41l-2.83 2.83a1 1 0 0 1-1.41-1.41L10.59 12 7.76 9.17a1 1 0 0 1 1.41-1.41L12 10.59l2.83-2.83a1 1 0 0 1 1.41 1.41L13.41 12l2.83 2.83z',
        'cross1' => 'M6 18L18 6M6 6l12 12',
        'burger' => 'M4 6h16M4 12h16M4 18h16',
    }
@endphp

<svg xmlns="http://www.w3.org/2000/svg"
     viewBox="0 0 24 24"
     width="18"
     height="18"
     aria-hidden="true"
    {{$attributes}}>
    <path fill="currentColor" d="{{$path}}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
</svg>
