@props(['keyword'])
<a href="{{route('articles-by-keyword', [$keyword->name])}}"
   class="py-1 px-2
           font-semibold
           bg-indigo-400
           rounded-lg text-xs
           text-gray-50
           whitespace-no-wrap
           hover:text-white hover:bg-indigo-500
           focus:outline-none focus:text-white focus:bg-indigo-500">
    {{$keyword->name}}
</a>
