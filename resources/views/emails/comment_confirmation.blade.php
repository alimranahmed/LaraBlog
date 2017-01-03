<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    <h2>Hi, <strong>{{$comment->user->name}}</strong></h2>
    <p>A comment has been published on Al- Imran's Blog from you mail. Click the link bellow to confirm your comment</p>
    <h4>Comment Content:</h4>
    <p>{{$comment->content}}</p>
    <a href="{{route('confirm-comment', [$comment->id, $comment->token])}}">Click to confirm your comment</a>
</body>
</html>