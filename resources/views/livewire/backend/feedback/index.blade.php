<div>
    <section class="grid grid-cols-3 gap-3">
        @foreach($feedbacks as $feedback)
            <div class="border border-indigo-300 rounded px-3 py-1">
                <div class="flex justify-between">
                    <div>{{$feedback->name}}</div>
                    <x-tni-x-circle-o
                        onclick="confirm('You are closing this feedback') || event.stopImmediatePropagation()"
                        wire:click="close({{$feedback->id}})"
                        class="w-4 h-4 text-gray-600 hover:text-red-700 -mr-5 -mt-2 bg-white cursor-pointer"/>
                </div>
                <div class="text-gray-500">{{$feedback->email}}</div>
                <div class="text-gray-500">{{$feedback->created_at_human_diff}}</div>
                @if($feedback->is_resolved)
                    <div wire:click="toggleResolved({{$feedback->id}})"
                          class="cursor-pointer px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        Resolved
                    </div>
                @else
                    <div wire:click="toggleResolved({{$feedback->id}})"
                          class="cursor-pointer px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                        Not Resolved
                    </div>
                @endif
                <div>{{$feedback->content}}</div>
            </div>
        @endforeach
    </section>
    <div class="mt-3">
        {{$feedbacks->links()}}
    </div>
</div>
