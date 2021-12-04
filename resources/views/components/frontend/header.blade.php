@props(['title'])
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('build/css/app.css')}}">

    <link rel="stylesheet" href="{{asset('css/prism.css')}}"/>

    <link rel="shortcut icon" type="image/png" href="{{asset('img/favicon.png')}}"/>

    <title>{{$title}}</title>

    {{$slot}}

    <x-frontend.google-analytics/>

    @livewireStyles

</head>
<body class="bg-gray-100">
<div class="border-b border-blue-200 mb-3">

    <div class="mx-6 sm:mx-20 md:mx-32 lg:mx-56 px-1 sm:px-10 md:px-16 lg:px-16 xl:px-32">
        <x-frontend.navbar/>
    </div>

</div>


<div class="mx-6 sm:mx-20 md:mx-32 lg:mx-56 px-1 sm:px-10 md:px-16 lg:px-16 xl:px-32 min-h-screen">

