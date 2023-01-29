@props(['title' => $globalConfigs->site_title, 'article' => null])
<x-frontend.header :title="$title" :article="$article"/>

{{$slot}}

<x-frontend.footer/>
