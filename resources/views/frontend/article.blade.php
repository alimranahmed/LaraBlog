@extends('layouts.public')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h3 class="article-heading text-center">{{$article->heading}}</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 text-justify">{{$article->content}}</div>
    </div>
    <div class="row margin-top-15">
        @include('frontend._form_comment')
    </div>
    @include('frontend.comments', ['comments' => $article->comments])
@endsection