<div>
    <section class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
        @foreach($keywords as $keyword)
            <div class="rounded border border-indigo-300 pl-2">
                <div class="flex justify-between">
                    <div>{{$keyword->name}}</div>
                    <x-tni-x-circle-o wire:confirm="Are you sure to delete"
                        wire:click="delete({{$keyword->id}})"
                        class="w-3 h-3 bg-white text-gray-600 hover:text-red-700 -mt-1 -mr-1 cursor-pointer"/>
                </div>
                <a class="text-indigo-400" href="{{route('backend.article.index', ['keyword' => $keyword->name])}}">
                    {{$keyword->articles->count()}} {{\Illuminate\Support\Str::plural('article', $keyword->articles->count())}}
                </a><br>
                <span class="text-gray-500">{{$keyword->created_at_human_diff}}</span>
            </div>
        @endforeach
    </section>

    <section class="mt-3">
        {{$keywords->links()}}
    </section>

    @if($keywords->isEmpty())
        <div class="w-full h-96 flex justify-center items-center">
            <span class="text-5xl text-gray-300">Nothing here!</span>
        </div>
    @endif
</div>
