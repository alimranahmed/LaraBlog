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
            <div class="col-sm-12">published at {{$comment->created_at}}</div>
        </div>
    @empty
        <div class="row">
            <div class="col-sm-12">
                <span class="text-grey">No comment yet</span>
            </div>
        </div>
    @endforelse
    <div class="row">
        <div class="col-sm-12">
            <form action="{{route('add-comment', $article->id)}}" method="post">
                {{csrf_field()}}
                <div class="form-group">
                    <textarea type="text" name="content" class="form-control" id="comment" placeholder="Comment"></textarea>
                </div>
                <div class="form-group">
                    <input type="text" name="name" class="form-control" id="name" placeholder="Name">
                </div>
                <button type="submit" class="btn btn-primary">Commit</button>
            </form>
        </div>
    </div>
@endsection