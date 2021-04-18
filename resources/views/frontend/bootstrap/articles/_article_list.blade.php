@forelse($articles as $article)
    @include("frontend.bootstrap.articles._list_card")
@empty
    <div class="row text-grey">
        <div class="col-sm-12"><h3>Not Available</h3></div>
    </div>
@endforelse
{{method_exists($articles, 'links') ? $articles->links() : ''}}
