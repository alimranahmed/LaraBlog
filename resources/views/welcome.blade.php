@extends('layouts.main')
@section('content')
    @foreach($articles as $article)
        <h1>{{$article->heading}}</h1>
    @endforeach
@endsection