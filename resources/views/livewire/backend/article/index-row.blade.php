<tr>
    <x-backend.table.td :wrap="true">
        <article>
            <a href="{{route('get-article', $article->slug)}}"
               class="hover:underline" target="_blank">
                {{$article->heading}}
            </a>
        </article>
        <section class="text-gray-500">
            On {{$article->categoryName}}
        </section>
        <section class="text-gray-500">
            At {{$article->created_date_time_formatted}}
            in {{ucfirst($article->language)}}
        </section>
        <section>
            @if($article->comment_count > 0)
            <a href="{{route('backend.comment.index', ['article' => $article->id])}}" class="text-indigo-500">
                {{$article->comment_count.' '.Str::plural('comment', $article->comment_count)}}
            </a>
            @else
                <span class="text-gray-400">No comment</span>
            @endif
        </section>
    </x-backend.table.td>
    <x-backend.table.td>
        <div class="flex">
            <x-toggle :isEnabled="$article->is_published" wire:click="togglePublish"/>
            <x-status class="ml-3"
                :text="$article->is_published ? 'Published' : 'Not Published'"
                :state="$article->is_published ? 'positive' : 'negative'"></x-status>
        </div>
        <section class="text-gray-500">
            @if($article->is_published)
                {{$article->published_at_human_diff}}<br>
            @endif
            Updated: {{$article->updated_at_human_diff}}
        </section>
    </x-backend.table.td>
    <x-backend.table.td>
        <a href="{{route('backend.article.edit', $article->id)}}" class="text-indigo-700 hover:underline">
            Edit
        </a>
        <a wire:click="destroy" class="ml-1 text-red-700 hover:underline cursor-pointer"
           wire:confirm="Are you sure to delete?">
            Delete
        </a>
    </x-backend.table.td>
</tr>
