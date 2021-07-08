@extends('emails.master')
@section('content')
    <h2>Dear Reader</h2>
    <p>You have expressed your interested to stay connected with <strong>{{$globalConfigs->site_name}}</strong>
        Click the link bellow to confirm</p><br>
    <a href="{{route('subscription.confirm')."?token=".$subscriber->token}}">
        Click to confirm
    </a>
@endsection
