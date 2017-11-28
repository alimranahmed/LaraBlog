@extends('emails.master')
@section('content')
    <h2>Dear <strong>{{$comment->user->name}}</strong></h2>

    <p>A comment has been published on <strong>{{$globalConfigs->site_name}}</strong> using your email</p>

    <h4 style="margin-bottom: 15px;">Comment Content:</h4>
    <p style="border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; padding: 10px;">{{$comment->content}}</p>
    <a href="{{route('confirm-comment', [$comment->id])."?token=".$comment->token}}">Click here confirm your comment</a>
@endsection