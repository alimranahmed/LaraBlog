<!doctype html>
<html lang="en">
<body>
<h2>Hi, <strong>{{$globalConfigs->copyright_owner}}</strong></h2>
<p>A user has respond on {{$globalConfigs->site_name}}</p>
<h3>Response:</h3>
<p>{{$comment->content}}</p>
<p>Using mail {{$comment->user->email}}</p>
<a href="{{$url}}">Click to see</a>
</body>
</html>