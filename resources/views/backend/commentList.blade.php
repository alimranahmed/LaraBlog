<x-backend>
    <x-backend.table>
        <x-slot name="head">
            <tr>
                <x-backend.table.th>Comment</x-backend.table.th>
                <x-backend.table.th>By</x-backend.table.th>
                <x-backend.table.th>Article</x-backend.table.th>
                <x-backend.table.th>Status</x-backend.table.th>
                <x-backend.table.th></x-backend.table.th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach($comments as $comment)
                <tr>
                    <x-backend.table.td :wrap="true">
                        {{mb_substr($comment->content, 0, 70)}}
                        {{mb_strlen($comment->content)  > 70 ? '...' : '' }}<br>
                        <span class="text-gray-600">{{$comment->createdAtHuman}}</span>
                    </x-backend.table.td>
                    <x-backend.table.td>
                        <span>{{$comment->user->name}}</span><br>
                        <span class="text-gray-600">{{$comment->user->email}}</span>
                    </x-backend.table.td>
                    <x-backend.table.td :wrap="true">
                        <a href="{{route('get-article', $comment->article->id)}}" target="_blank">
                            {{mb_substr($comment->article->heading, 0, 70)}}
                            {{mb_strlen($comment->article->heading)  > 70 ? '...' : '' }}<br>
                        </a>
                    </x-backend.table.td>
                    <x-backend.table.td>
                        @if($comment->is_published)
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Published
                            </span>
                        @else
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Not Published
                            </span>
                        @endif
                    </x-backend.table.td>
                    <x-backend.table.td>
                        <a href="#" class="text-indigo-700">Edit</a>
                        <a href="{{route('backend.comment.delete', $comment->id)}}" class="text-red-700"
                           onclick="return confirm('Are you sure to delete?')">
                            Delete
                        </a>
                    </x-backend.table.td>
                </tr>
            @endforeach
        </x-slot>
    </x-backend.table>

    <div class="pt-3">
        {{$comments->links()}}
    </div>

</x-backend>
