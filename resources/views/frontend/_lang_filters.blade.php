<div class="lang-filter">
    <a class="btn btn-sm btn-default {{!request('lang') ? 'active' : ''}}" href="{{route('articles')}}">All</a>

    @foreach(config('fields.lang') as $lang => $fullLang)
        <a class="btn btn-sm btn-default {{request('lang') == $lang ? 'active' : ''}}"
           href="{{route('articles', ['lang' => $lang])}}">{{$fullLang}}</a>
    @endforeach
</div>