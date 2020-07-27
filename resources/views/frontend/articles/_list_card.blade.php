<div class="py-2 border-b border-dashed border-blue-300">

    <!--    Heading-->
    <h2 class="xs:text-md sm:text-xl md:text-2xl leading-tight mb-2 font-semibold">
        <a href="{{route('get-article', [$article->id, make_slug($article->heading)])}}"
           class="text-gray-800 hover:text-gray-900 focus:outline-none focus:text-gray-900">
            {{$article->heading}}
        </a>
    </h2>

    <!--    Published at and author-->
    <div class="md:flex justify-between items-center">

        <div class="text-gray-600 text-xs md:text-sm">
            Published {{$article->publishedAtHuman}} on
            <a href="{{route('articles-by-category', $article->category->alias)}}"
               class="text-blue-400 hover:text-blue-700 focus:outline-none focus:text-blue-700">
                {{$article->category->name}}
            </a>
            <span class="whitespace-no-wrap">by <span class="text-gray-800">{{$article->user->name}}</span></span>
        </div>


        <!--      Tags-->
        @include('frontend.articles._tag', ['article' => $article])

    </div>
</div>
