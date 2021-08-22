@props(['keyword'])
<a href="{{route('articles-by-keyword', [$keyword->name])}}"
   class="pb-1 px-2
           font-semibold
           bg-indigo-200
           rounded-lg text-xs
           text-gray-800
           whitespace-no-wrap
           hover:text-white hover:bg-indigo-400
           focus:outline-none focus:text-white focus:bg-indigo-400">
    {{$keyword->name}}
</a>
