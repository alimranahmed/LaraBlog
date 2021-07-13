@props(['keywords'])
<div class="text-left">
    @foreach($keywords as $keyword)
        @if(!$loop->first)&nbsp;@endif
        <x-frontend.article.tag :keyword="$keyword"></x-frontend.article.tag>
    @endforeach
</div>
