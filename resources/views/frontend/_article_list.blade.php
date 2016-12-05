@forelse($articles as $article)
    <a href="{{route('get-article', $article->id)}}">
        <div class="row article-list">
            <h3 class="heading">{{$article->heading}}</h3>
            <span class="time">published {{$article->publishedAtHuman}}</span>
            <span class="text-grey {{!$article->hit_count ? 'hide':''}}">
                ({{$article->hit_count}} {{$article->hit_count > 1 ? 'reads' : 'read'}})
            </span>
        </div>
    </a>
@empty
    <div class="row text-grey">
        <h3>No Article Found</h3>
    </div>
@endforelse