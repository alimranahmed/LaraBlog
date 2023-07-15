<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="shortcut icon" type="image/png" href="{{asset('img/favicon.png')}}"/>

    <title>{{$globalConfigs->site_title}}</title>

    @livewireStyles
</head>
<body>

<x-backend.navbar/>

<div class="sm:px-6 lg:px-8 py-3">
    {{$slot}}
</div>

@livewireScripts
</body>
</html>
