<x-frontend>
    <div>
        <h1 class="font-semibold sm:text-xl md:text-2xl mb-1 leading-tight">
            {{$article->heading}}
        </h1>
        <div class="text-gray-600 text-xs md:text-sm mb-3">
            Published {{$article->createdAtHuman}} on
            <a href="{{route('articles-by-category', $article->category->alias)}}"
               class="text-blue-400 hover:text-blue-700 focus:outline-none focus:text-blue-700">
                {{$article->category->name}}
            </a>
            <span class="whitespace-no-wrap">by <span class="text-gray-800">{{$article->user->name}}</span></span>
        </div>
        <div class="text-sm md:text-lg leading-relaxed">
            {!! $article->contentAsHtml !!}
        </div>
        <div class="mb-3">
            <x-frontend.article.tags :keywords="$article->keywords"></x-frontend.article.tags>
        </div>
    </div>

    @if(!$relatedArticles->isEmpty())
        <div class="mb-3">
            <h2 class="border-b border-blue-300 text-xl md:text-2xl font-bold">
                More articles on
                <a href="{{route('articles-by-category', ['categoryAlias' => $article->category->alias])}}"
                   class="text-blue-400 hover:text-blue-700 focus:outline-none focus:text-blue-700">
                    {{$article->category->name}}
                </a>
            </h2>
            @foreach($relatedArticles as $relatedArticle)
                <x-frontend.article :article="$relatedArticle"></x-frontend.article>
            @endforeach
        </div>
    @endif

    @if($article->is_comment_enabled)
        <livewire:frontend.article.comments :article="$article"/>
    @endif

    <livewire:frontend.subscribe/>

</x-frontend>
