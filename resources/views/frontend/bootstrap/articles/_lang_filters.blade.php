<div class="lang-filter hidden-xs hidden-sm">
    <a class="btn btn-sm btn-default {{!request('lang') ? 'active' : ''}}" href="{{url(request()->url())}}">All</a>
    @foreach(config('fields.lang') as $lang => $fullLang)
        @php
            $route = request()->route();
            $fullUrl = route($route->action['as'], array_merge($route->parameters, ['lang' => $lang]));
        @endphp
        <a class="btn btn-sm btn-default {{request('lang') == $lang ? 'active' : ''}}"
           href="{{$fullUrl}}">{{$fullLang}}</a>
    @endforeach
</div>