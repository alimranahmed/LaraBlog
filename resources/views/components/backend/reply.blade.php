@props(['reply'])

<div {{$attributes}}>
    <div class="font-semibold">
        <span
            class="border-b-2 border-indigo-500">{{\Illuminate\Support\Str::title($reply->user->name)}}</span>
        replied
    </div>
    <div>{{$reply->content}}</div>
    <div class="text-gray-500">
        @if($reply->published_date_time_formatted)
            At {{$reply->published_date_time_formatted}}
        @endif
        <x-backend.comment.publish-status :comment="$reply"/>
    </div>
    <div>
        <a href="{{route('backend.comment.edit', $reply->id)}}" class="text-indigo-700 hover:underline">Edit</a>
        <span wire:click="delete({{$reply->id}})"
              onclick="confirm('You are deleting this comment!') || event.stopImmediatePropagation()"
              class="cursor-pointer text-red-700 hover:underline">Delete</span>
    </div>
</div>
