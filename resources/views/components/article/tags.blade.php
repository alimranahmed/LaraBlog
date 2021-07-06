@props(['keywords'])
<div>
    @foreach($keywords as $keyword)
        <x-article.tag :keyword="$keyword"></x-article.tag>
    @endforeach
</div>
