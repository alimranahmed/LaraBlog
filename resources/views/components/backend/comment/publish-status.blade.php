@props(['comment'])

@if($comment->is_published)
    <span
        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
        Published
    </span>
@else
    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
        Not Published
    </span>
@endif
