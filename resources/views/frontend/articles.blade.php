@extends('layouts.public')
@section('content')
    @include('frontend._article_list', ['articles' => $articles])
@endsection