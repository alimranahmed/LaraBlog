@extends('layouts.public')
@section('content')
    @foreach($articles as $article)
        <a href="{{route('get-article', $article->id)}}">
            <h2>{{$article->heading}}</h2>
            <span>published on {{$article->published_at}}</span>
        </a>
    @endforeach
@endsection