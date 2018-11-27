@forelse($articles as $article)
    <div class="row article-list">
        <div class="col-sm-12">
            <div class="row">
                <a href="{{route('get-article', [$article->id, make_slug($article->heading)])}}">
                    <h3 class="heading">{{$article->heading}}</h3>
                </a>
            </div>
            <div class="row margin-top-5">
                <div class="col-md-8 no-padding">
                    <span class="time">published {{$article->publishedAtHuman}} on</span>
                    <a href="{{route('articles-by-category', $article->category->alias)}}">{{$article->category->name}}</a>
                    <span class="text-grey"> by {{$article->user->name}}</span>
                    <span class="text-grey {{!$article->hit_count ? 'hide':''}}">
                        ({{$article->hit_count}} {{$article->hit_count > 1 ? 'reads' : 'read'}})
                    </span>
                </div>
                <div class="text-right col-md-4 no-padding">
                    @foreach($article->keywords as $keyword)
                        <a href="{{route('articles-by-keyword', [$keyword->name])}}">
                            <span class="label label-info">{{$keyword->name}}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="row text-grey">
        <div class="col-sm-12"><h3>Not Available</h3></div>
    </div>
@endforelse
{{method_exists($articles, 'links') ? $articles->links() : ''}}