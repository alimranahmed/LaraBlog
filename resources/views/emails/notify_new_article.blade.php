<!doctype html>
<html>
    <head>
    </head>
    <body>
        <h4>Dear subscriber,</h4>
        <p>A new Article has been published in {{$globalConfigs->site_name}} about {{$article->category->name}}</p>
        <h2>{{$article->heading}}</h2>
        <div>{{substr($article->content, 0, 100)}}...</div>
        <a href="{{route('get-article', [$article->id])}}">Read More</a>
        <a href="{{route('un-subscribe', ['userId' => $user->id, 'token' => $user->token])}}">Unsubscribe</a>
    </body>
</html>
