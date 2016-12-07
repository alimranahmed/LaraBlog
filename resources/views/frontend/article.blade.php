@extends('layouts.public')
@section('content')
    <div class="row" v-on:click="test()">
        <div class="col-sm-12">
            <h3 class="article-heading text-lg">{{$article->heading}}</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 text-justify text-md">{{$article->content}}</div>
    </div>
    <div class="row margin-top-15" style="display: none;" id="comment-form">
        @include('frontend._form_comment')
    </div>
    <div class="row">
        <div class="col-sm-12">
            <strong class="text-lg">Comments({{count($article->comments)}})</strong>
            <span class="fa fa-3x fa-commenting-o text-primary pointer" id="comment-btn" title="Post a comment"></span>
        </div>
    </div>
    <hr class="margin-bottom-15 margin-top-10">
    @include('frontend._comments', ['comments' => $article->comments])
@endsection