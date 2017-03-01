<!doctype html>
<html lang="en">
<body>
    <h2>Hi, <strong>{{$comment->user->name}}</strong></h2>
    <p>A comment has been published on Al- Imran's Blog from you mail. Click the link bellow to confirm your comment</p>
    <h4>Comment Content:</h4>
    <p>{{$comment->content}}</p>
    <a href="{{route('confirm-comment', [$comment->id])."?token=".$comment->token}}">Click to confirm your comment</a>
</body>
</html>