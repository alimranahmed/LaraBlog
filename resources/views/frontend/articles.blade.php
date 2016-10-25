@extends('layouts.public')
@section('content')
    @foreach($articles as $article)
        <a href="{{route('get-article', $article->id)}}">
            <div class="row article-list">
                <h3 class="heading">{{$article->heading}}</h3>
                <span class="time">publised {{$article->published_at}}</span>
            </div>
        </a>
    @endforeach
@endsection