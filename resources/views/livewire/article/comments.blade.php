<div x-data="{show_form: false}">
    <div x-show="show_form" x-transition>
        <x-article.comment.form :article="$article"></x-article.comment.form>
    </div>

    <div class="my-3">

        <div class="flex items-center">
            <h2 class="border-b border-blue-300 text-xl md:text-2xl font-bold">
                Comments({{$comments->count()}})
            </h2>
            <div @click="show_form= !show_form" class="ml-3 text-xl cursor-pointer text-blue-500">+</div>
        </div>

        @foreach($comments as $comment)
            <x-article.comment :comment="$comment"></x-article.comment>
            @foreach($comment->replies as $reply)
                <x-article.reply :reply="$reply"></x-article.reply>
            @endforeach
        @endforeach
    </div>
</div>
