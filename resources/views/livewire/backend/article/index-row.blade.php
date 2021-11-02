<tr wire:loading.class="opacity-25">
    <x-backend.table.td :wrap="true">
        <article>
            <a href="{{route('get-article', [$article->id, make_slug($article->heading)])}}"
               class="hover:underline" target="_blank">
                {{$article->heading}}
            </a>
        </article>
        <section class="text-gray-600">
            On {{$article->categoryName}}
        </section>
        <section class="text-gray-600">
            At {{$article->created_date_time_formatted}}
            in {{ucfirst($article->language)}}
        </section>
        <section class="text-indigo-500">
            <a href="{{route('backend.comment.index', ['article' => $article->id])}}">
                {{$article->comment_count < 1 ? 'No comment' : $article->comment_count.' '.\Illuminate\Support\Str::plural('comment', $article->comment_count)}}
            </a>
        </section>
    </x-backend.table.td>
    <x-backend.table.td>
        @if($article->is_published)
            <span wire:click="togglePublish"
                  class="cursor-pointer px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                Published
            </span>
            <section class="text-gray-600">
                {{$article->published_at_human_diff}}<br>
                Updated: {{$article->updated_at_human_diff}}
            </section>
        @else
            <span wire:click="togglePublish"
                  class="cursor-pointer px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                Not Published
            </span>
        @endif
    </x-backend.table.td>
    <x-backend.table.td>
        <a href="{{route('backend.article.edit', $article->id)}}" class="text-indigo-700 hover:underline">
            Edit
        </a>
        <a wire:click="destroy" class="ml-1 text-red-700 hover:underline cursor-pointer"
           onclick="return confirm('Are you sure to delete?') || event.stopImmediatePropagation()">
            Delete
        </a>
    </x-backend.table.td>
</tr>
