@extends('emails.master')
@section('content')
    <h2>Hi, <strong>{{$user->name}}</strong></h2>
    <p>You have requested to be notified when new article published on {{$globalConfigs->site_name}}
        Click the link bellow to confirm</p><br>
    <a href="{{route('confirm-subscribe', [$user->id])."?token=".$user->token}}">Click to confirm </a>
@endsection