@props(['keywords'])
<div class="text-left">
    @foreach($keywords as $keyword)
        @if(!$loop->first)&nbsp;@endif
        <x-article.tag :keyword="$keyword"></x-article.tag>
    @endforeach
</div>
