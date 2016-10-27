@extends('layouts.public')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h3 class="article-heading text-center">{{$article->heading}}</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">{{$article->content}}</div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <h4>Comments</h4>
        </div>
    </div>
    @forelse($article->comments as $comment)
        <div class="row">
            <div class="col-sm-12">{{$comment->content}}</div>
        </div>
    @empty
        <div class="row">
            <div class="col-sm-12">
                <span class="text-grey">No comment yet</span>
            </div>
        </div>
    @endforelse
@endsection