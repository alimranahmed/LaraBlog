@extends('emails.master')
@section('content')
<h2>Hi <strong>{{$globalConfigs->copyright_owner}}</strong></h2>
<p>A user has respond on <strong>{{$globalConfigs->site_name}}</strong></p>

<h3 style="margin-bottom: 15px;">Response:</h3>

<p style="border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; padding: 10px;">{{$comment->content}}</p>

<p style="margin-top:15px;">Using mail {{$comment->user->email ?? '<<unknown>>'}}</p>

<a href="{{$url}}">Click to see</a>
@endsection
