<!doctype html>
<html>
    <head>
    </head>
    <body>
        <h2>A new Article has been published in Imran's Blog about {{$article->category->name}}</h2>
        <h2>{{$article->heading}}<h2>
        <p>{{substr($article->content, 0, 50)}}...</p>
        <a href="{{route('get-article', [$article->id])}}">Read More</a>
    <body>
</html>
