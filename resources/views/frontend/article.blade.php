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
    <div class="row">
        <div class="col-sm-12">
            <form action="{{route('add-comment', $article->id)}}" method="post" name="add_comment_form">
                {{csrf_field()}}
                <div class="form-group {{$errors->has('content') ? 'has-error has-feedback' : ''}}">
                    <textarea name="content" class="form-control" id="comment"
                              placeholder="Comment*">{{old('content')}}</textarea>
                </div>
                <div class="form-group">
                    <input type="text" name="name" value="{{old('name')}}" class="form-control" id="name"
                           placeholder="Name">
                </div>
                <div class="form-group {{$errors->has('email') ? 'has-error has-feedback' : ''}}">
                    <input type="email" name="email" value="{{old('email')}}" class="form-control" id="email"
                           placeholder="Email">
                </div>
                <button type="submit" class="btn btn-primary">Comment</button>
            </form>
        </div>
    </div>
    @forelse($article->comments as $comment)
        <div class="row">
            <div class="col-sm-2">
                <b>{{is_null($comment->user) ? 'Someone' : $comment->user->name }}</b>&nbsp;said:
            </div>
            <div class="col-sm-12">{{$comment->content}}
                <span class="text-grey">&nbsp;at&nbsp;{{$comment->created_at}}</span>
            </div>
        </div>
    @empty
        <div class="row">
            <div class="col-sm-12">
                <span class="text-grey">No comment yet</span>
            </div>
        </div>
    @endforelse
@endsection