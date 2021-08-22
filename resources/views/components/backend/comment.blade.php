@props(['comment'])

<div {{$attributes}}>
    <div class="font-semibold">
        <span class="border-b-2 border-indigo-500">{{\Illuminate\Support\Str::title($comment->user->name)}}</span>
        commented
    </div>
    <div>{{$comment->content}}</div>
    <div class="text-gray-500">
        @if($comment->published_date_time_formatted)
            At {{$comment->published_date_time_formatted}}
        @endif
        <x-backend.comment.publish-status :comment="$comment"/>
    </div>
    <div>
        <a href="{{route('backend.comment.edit', $comment->id)}}" class="text-indigo-700 hover:underline">Edit</a>
    </div>
</div>
