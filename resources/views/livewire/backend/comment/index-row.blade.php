<tr wire:loading.class="opacity-25">
    <x-backend.table.td :wrap="true">
        <a href="{{route('backend.comment.show', $comment->id)}}" class="hover:underline">
            {{mb_substr($comment->content, 0, 70)}}
            {{mb_strlen($comment->content)  > 70 ? '...' : '' }}
        </a><br>
        @if($comment->published_date_time_formatted)
            <span class="text-gray-600">{{$comment->published_date_time_formatted}}</span><br>
        @endif
        <span class="text-indigo-500">
            @php
                $totalReplies = $comment->replies->count();
            @endphp
            <a href="{{route('backend.comment.show', $comment->id)}}">
                {{$totalReplies < 1 ? 'No reply' : $totalReplies.' '.\Illuminate\Support\Str::plural('reply', $totalReplies)}}
            </a>
        </span>
    </x-backend.table.td>
    <x-backend.table.td>
        <span>{{$comment->user->name}}</span><br>
        <span class="text-gray-600">{{$comment->user->email}}</span>
    </x-backend.table.td>
    <x-backend.table.td :wrap="true">
        <a href="{{route('get-article', $comment->article->id)}}" target="_blank" class="hover:underline">
            {{mb_substr($comment->article->heading, 0, 70)}}
            {{mb_strlen($comment->article->heading)  > 70 ? '...' : '' }}<br>
        </a>
    </x-backend.table.td>
    <x-backend.table.td>
        @if($comment->is_published)
            <span wire:click="togglePublish"
                  class="cursor-pointer px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                Published
            </span>
        @else
            <span wire:click="togglePublish"
                  class="cursor-pointer px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                Not Published
            </span>
        @endif
    </x-backend.table.td>
    <x-backend.table.td>
        <a href="{{route('backend.comment.edit', $comment->id)}}" class="text-indigo-700 hover:underline">Edit</a>
        <span onclick="confirm('Are you sure to delete?') || event.stopImmediatePropagation()"
              wire:click="destroy({{$comment}})"
              class="ml-1 cursor-pointer text-red-700 hover:underline">
            Delete
        </span>
    </x-backend.table.td>
</tr>
