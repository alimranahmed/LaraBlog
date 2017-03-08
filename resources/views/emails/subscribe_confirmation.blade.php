<!doctype html>
<html lang="en">
<body>
    <h2>Hi, <strong>{{$user->name}}</strong></h2>
    <p>You have requested for the subscription on {{$globalConfigs->site_name}}
        Click the link bellow to confirm your subscription</p>
    <a href="{{route('confirm-subscribe', [$user->id])."?token=".$user->token}}">Click to confirm your subscription</a>
</body>
</html>