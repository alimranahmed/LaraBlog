<x-backend>
    <div class="flex flex-row">
        <div class="basis-1/3">
            <x-backend.table>
                <x-slot name="head">
                    <tr>
                        <x-backend.table.th class="text-center">Latest Comments</x-backend.table.th>
                    </tr>
                </x-slot>

                <x-slot name="body">
                    @forelse($latestComments as $comment)
                        <tr>
                            <x-backend.table.td class="text-gray-600">
                                <span class="font-medium">{{$comment->user->name}}</span><br>
                                <span class="text-slate-400">{{$comment->createdAtHumanDiff}}</span><br>
                                {{$comment->content}}
                            </x-backend.table.td>
                        </tr>
                    @empty
                    @endforelse
                </x-slot>
            </x-backend.table>
        </div>
        <div class="basis-1/3">
            <x-backend.table>
                <x-slot name="head">
                    <tr>
                        <x-backend.table.th class="text-center">Latest Feedback</x-backend.table.th>
                    </tr>
                </x-slot>

                <x-slot name="body">
                    @forelse($latestFeedbacks as $feedback)
                        <tr>
                            <x-backend.table.td class="text-gray-600">
                                <span class="font-medium">{{$feedback->name}}</span><br>
                                <span class="text-slate-400">{{$feedback->createdAtHumanDiff}}</span><br>
                                {{$feedback->content}}
                            </x-backend.table.td>
                        </tr>
                    @empty
                        <x-backend.table.td colspan="100" class="text-gray-400 text-center">No new feedback</x-backend.table.td>
                    @endforelse
                </x-slot>
            </x-backend.table>
        </div>
        <div class="basis-1/3">
            <x-backend.table>
                <x-slot name="head">
                    <tr>
                        <x-backend.table.th class="text-center" colspan="100">Articles Categories</x-backend.table.th>
                    </tr>
                </x-slot>

                <x-slot name="body">
                    @forelse($categories as $category)
                        <tr>
                            <x-backend.table.td class="text-gray-600">
                                <span class="font-medium">{{$category->name}}</span>
                            </x-backend.table.td>
                            <x-backend.table.td class="text-gray-600">
                                <span class="text-slate-400">{{$category->articles_count}}</span><br>
                            </x-backend.table.td>
                        </tr>
                    @empty
                        <x-backend.table.td colspan="100" class="text-gray-400 text-center">No new feedback</x-backend.table.td>
                    @endforelse
                </x-slot>
            </x-backend.table>
        </div>
    </div>
</x-backend>
