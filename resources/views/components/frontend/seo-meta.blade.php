@props(['article' => null])
@if(isset($article))
    @php
        $meta = [
            'author' => $article->user->name,
            'title' => $article->heading,
            'description' => \Illuminate\Support\Arr::get($article->meta, 'description', mb_substr($article->content, 0, 152).'...'),
            'image' => \Illuminate\Support\Arr::get($article->meta, 'image_url', asset('img/user.png')),
            'url' => route('get-article', $article->slug),
            'site' => url('/'),
            'site_name' => config('app.name'),
            'keywords' => $article->keywords->isEmpty() ? 'imranic-show' : $article->keywords->pluck('name')->implode(', '),
        ]
    @endphp
    <x-frontend.meta.twitter :meta="$meta"/>
    <x-frontend.meta.facebook :meta="$meta"/>
    <x-frontend.meta.google :meta="$meta"/>
@else
    <meta name="author" content="{{config('app.name')}}"/>
    <meta name="keywords" content="php, laravel, python, javascript, golang, machine-learning"/>
    <meta name="description" content="Technical Blog of Al Imran Ahmed. He writes about Programming mostly related to PHP, Laravel, Javascript, Python, Machine Learning, Go Lang etc."/>
@endif
