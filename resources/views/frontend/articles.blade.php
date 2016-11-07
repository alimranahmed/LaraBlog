@extends('layouts.public')
@section('content')
    @include('frontend.article_list', ['articles' => $articles])
@endsection