@extends('emails.master')
@section('content')
    <h2>Hi</h2>

    <p><strong>{{$comment->user->name}}</strong> has respond to a comment thread you are following on <strong>{{$globalConfigs->site_name}}</strong></p>

    <h4 style="margin-bottom: 15px;">Response:</h4>
    <p style="border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; padding: 10px;">{{$comment->content}}</p>
    <a href="{{route('get-article', [$comment->article->id])}}">Click here to see the discussion</a>
@endsection