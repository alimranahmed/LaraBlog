@props(['article'])

<div class="py-3 border-b border-dashed border-blue-300">

    <!--    Heading-->
    <h2 class="xs:text-md sm:text-xl md:text-2xl leading-tight mb-2">
        <a href="{{route('get-article', $article->slug)}}"
           class="text-slate-700 hover:text-gray-900 focus:outline-none focus:text-gray-900">
            {{$article->heading}}
        </a>
    </h2>

    <!--    Published at and author -->
    <div class="justify-between items-center">

        <div class="text-gray-600 text-xs md:text-sm w-full md:w-2/3">
            {{$article->published_date_formatted}}, on
            <a href="{{route('articles-by-category', $article->category->alias)}}"
               class="text-gray-600 hover:text-blue-600 focus:outline-none focus:text-blue-700">
                {{$article->category->name}}
            </a>
            <span class="whitespace-no-wrap">by <span class="text-gray-800">{{$article->user->name}}</span></span>
        </div>
    </div>
</div>
