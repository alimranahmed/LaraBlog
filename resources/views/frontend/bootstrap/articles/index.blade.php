@extends('layouts.public')
@section('content')
    @include('frontend.bootstrap.articles._lang_filters')
    @include('frontend.bootstrap.articles._article_list', ['articles' => $articles])
@endsection
