@include('frontend.tailwindcss.layouts._header')
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
        @include('frontend.tailwindcss.articles._tag')
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
            @include('frontend.tailwindcss.articles._list_card', ['article' => $relatedArticle])
        @endforeach
    </div>
@endif

@if($article->is_comment_enabled)
    <div>
        @include('frontend.tailwindcss.articles._comment_form')
    </div>
@endif

<div class="my-3">
    <h2 class="border-b border-blue-300 text-xl md:text-2xl font-bold">
        Comments
    </h2>
    @foreach($article->comments->where('parent_comment_id', null) as $comment)
        @include('frontend.tailwindcss.articles._comment', ['article' => $article, 'comment' => $comment])
    @endforeach
</div>

@include('frontend.tailwindcss.layouts._footer')
