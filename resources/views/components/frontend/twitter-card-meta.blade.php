@props(['article'])

<meta name="twitter:card" content="summary" />
<meta name="twitter:site" content="{{url('/')}}" />
<meta name="twitter:title" content="{{$article->heading}}" />
<meta name="twitter:description" content="{{mb_substr($article->content, 0, 152)}}..." />
<meta name="twitter:image" content="{{asset('img/user.png')}}" />
