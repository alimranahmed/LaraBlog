@props(['title', 'article' => null])
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @if(isset($article))
        <x-frontend.twitter-card-meta :article="$article"/>
        <meta name="description" content="{{mb_substr($article->content, 0, 152)}}..." />
    @else
        <meta name="description" content="Technical Blog of Al Imran Ahmed. He writes about Programming mostly related to PHP, Laravel, Javascript, Python, Machine Learning etc." />
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])

{{--    <link rel="stylesheet" href="{{asset('css/prism.css')}}"/>--}}

    <link rel="shortcut icon" type="image/png" href="{{asset('img/favicon.png')}}"/>

    <title>{{$title}}</title>

    {{$slot}}

    <x-frontend.google-analytics/>

    @livewireStyles

</head>
<body class="bg-gray-50">
<div class="border-b border-blue-200 mb-3">

    <div class="max-w-2xl md:max-w-4xl mx-auto px-5 lg:px-0">
        <x-frontend.navbar/>
    </div>

</div>


<div class="max-w-2xl md:max-w-4xl mx-auto px-5 lg:px-0 min-h-screen">

