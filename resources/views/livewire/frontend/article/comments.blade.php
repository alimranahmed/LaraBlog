<div x-data="{show_form: false}">
    <div x-show="show_form" x-transition>
        <x-frontend.article.comment.form :article="$article"/>
        @if($isSubmitted)
            <div class="text-lg text-green-600">Comment submitted successfully!</div>
        @endif
    </div>

    <div class="my-3">

        <div class="flex items-center">
            <h2 class="border-b border-blue-300 text-xl md:text-2xl font-bold">
                Comments({{$comments->count()}})
            </h2>
            <div @click="show_form= !show_form" class="ml-3 text-xl cursor-pointer text-blue-500">+</div>
        </div>

        @foreach($comments as $comment)
            <x-frontend.article.comment :comment="$comment"></x-frontend.article.comment>
            @foreach($comment->replies as $reply)
                <x-frontend.article.reply :reply="$reply"/>
            @endforeach
        @endforeach
    </div>
</div>
