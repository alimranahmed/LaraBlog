@props(['comment'])

<div {{
    $attributes->merge([
    'class' => "border-b border-blue-300 border-dashed leading-tight py-1"
    ]) }}>

    <h3 class="text-xs md:text-sm mb-1">
        <span class="font-semibold border-b-2 border-blue-300">{{$comment->user->name}}</span> said
    </h3>
    <div>
        {{$comment->content}}
        <div class="text-gray-500 text-xs md:text-sm">{{$comment->createdAtHuman}}</div>
    </div>
</div>
