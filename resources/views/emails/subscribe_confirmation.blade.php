@extends('emails.master')
@section('content')
    <h2>Dear <strong>{{$user->name}}</strong></h2>
    <p>You have requested to be notified when new article published on <strong>{{$globalConfigs->site_name}}</strong>
        Click the link bellow to confirm</p><br>
    <a href="{{route('confirm-subscribe', [$user->id])."?token=".$user->token}}">Click to confirm </a>
@endsection