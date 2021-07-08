@props(['reply', 'is_reply' => false,])

<div {{
    $attributes->merge([
    'class' => "border-b border-blue-300 border-dashed leading-tight py-1 ml-5"
    ]) }}>

    <h3 class="text-xs md:text-sm mb-1">
        <span class="font-semibold border-b-2 border-blue-300">{{$reply->user->name}}</span> replied
    </h3>
    <div>
        {{$reply->content}}
        <div class="text-gray-500 text-xs md:text-sm">{{$reply->createdAtHuman}}</div>
    </div>
</div>
