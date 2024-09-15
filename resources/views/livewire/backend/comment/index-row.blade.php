<tr>
    <x-backend.table.td :wrap="true">
        <section>
            <a href="{{route('get-article', $comment->article->slug)}}" target="_blank" class="hover:underline font-semibold text-slate-700">
                {{mb_substr($comment->article->heading, 0, 70)}}
                {{mb_strlen($comment->article->heading)  > 70 ? '...' : '' }}<br>
            </a>
        </section>
        <section class="my-1 italic">
            <span class="mr-1 h-1 rounded-lg pl-0.5 bg-slate-400"></span>
            <span>“</span>
            <a href="{{route('backend.comment.show', $comment->id)}}" class="hover:underline text-slate-600">
                {{mb_substr($comment->content, 0, 70)}}
                {{mb_strlen($comment->content)  > 70 ? '...' : '' }}
            </a>
            <span>”</span>
        </section>
        <section>
            @if($comment->published_date_time_formatted)
                <span class="mt-1 text-gray-500">{{$comment->published_date_time_formatted}}</span>
            @endif
        </section>
        <section>
            @php
                $totalReplies = $comment->replies->count();
            @endphp
            @if($comment->replies->count() > 0)
                <a href="{{route('backend.comment.show', $comment->id)}}" class="text-indigo-500">
                    {{$comment->replies->count().' '.Str::plural('reply', $totalReplies)}}
                </a>
            @else
                <span class="text-gray-400">No reply</span>
            @endif
        </section>
    </x-backend.table.td>
    <x-backend.table.td>
        <span>{{$comment->user->name}}</span><br>
        <span class="text-gray-500">{{$comment->user->email}}</span>
    </x-backend.table.td>
{{--    <x-backend.table.td :wrap="true">--}}
{{--        <a href="{{route('get-article', $comment->article->id)}}" target="_blank" class="hover:underline">--}}
{{--            {{mb_substr($comment->article->heading, 0, 70)}}--}}
{{--            {{mb_strlen($comment->article->heading)  > 70 ? '...' : '' }}<br>--}}
{{--        </a>--}}
{{--    </x-backend.table.td>--}}
    <x-backend.table.td>
        <div class="flex">
            <x-toggle :isEnabled="$comment->is_published" wire:click="togglePublish"/>
            <x-status class="ml-3"
                :text="$comment->is_published ? 'Published' : 'No published'"
                :state="$comment->is_published ? 'positive' : 'negative'"/>
        </div>
    </x-backend.table.td>
    <x-backend.table.td>
        <a href="{{route('backend.comment.edit', $comment->id)}}" class="text-indigo-700 hover:underline">Edit</a>
        <span wire:confirm="Are you sure to delete?"
              wire:click="destroy({{$comment}})"
              class="ml-1 cursor-pointer text-red-700 hover:underline">
            Delete
        </span>
    </x-backend.table.td>
</tr>
