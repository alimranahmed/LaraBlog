@props(['isMobile' => false])
<!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->

@php
    $menus = [
        'Articles' => route('backend.article.index'),
        'Comments' => route('backend.comment.index'),
        'Users' => route('users'),
        'Categories' => route('categories'),
        'Keywords' => route('keywords'),
        'Feedback' => route('feedbacks'),
        'Subscribers' => '#',
        ];
@endphp

@foreach($menus as $menu => $url)
    @php
        $isActive = $menu == 'Articles';
    @endphp
    <a href="{{$url}}" @class([
        'px-3 py-2 rounded-md font-medium',
        'text-sm' => !$isMobile,
        'text-base block' => $isMobile,
        'bg-gray-900 text-white' => $isActive,
        'text-gray-300 hover:bg-gray-700 hover:text-white' => !$isActive,
    ])>

    {{$menu}}

    </a>

@endforeach
