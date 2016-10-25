@extends('layouts.public')
@section('content')
    @foreach($articles as $article)
        <a href="{{route('get-article', $article->id)}}">
            <h3>{{$article->heading}}</h3>
            <span>published on {{$article->published_at}}</span>
        </a>
    @endforeach
@endsection