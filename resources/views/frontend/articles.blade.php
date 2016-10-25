@extends('layouts.public')
@section('content')
    @foreach($articles as $article)
        <a href="{{route('get-article', $article->id)}}"><h1>{{$article->heading}}</h1></a>
    @endforeach
@endsection