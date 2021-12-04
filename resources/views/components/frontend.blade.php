@props(['title' => $globalConfigs->site_title])
<x-frontend.header :title="$title"/>

{{$slot}}

<x-frontend.footer/>
