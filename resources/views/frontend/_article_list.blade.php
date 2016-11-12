@forelse($articles as $article)
    <a href="{{route('get-article', $article->id)}}">
        <div class="row article-list">
            <h3 class="heading">{{$article->heading}}</h3>
            <span class="time">published {{$article->published_at}}</span>
            <span class="text-grey {{!$article->hit_count ? 'hide':''}}">
                (visited {{$article->hit_count}} time)
            </span>
        </div>
    </a>
@empty
    <div class="row text-grey">
        <h3>No Article Found</h3>
    </div>
@endforelse