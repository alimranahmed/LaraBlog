@props(['article'])

@php
    $comments = $article->comments->where('parent_comment_id', null);
@endphp
<div>
    <x-article.comment.form :article="$article"></x-article.comment.form>
</div>

<div class="my-3">
    <h2 class="border-b border-blue-300 text-xl md:text-2xl font-bold">
        Comments({{$comments->count()}})
    </h2>
    @foreach($comments as $comment)
        <x-article.comment :comment="$comment"></x-article.comment>
        @foreach($comment->replies as $reply)
            <x-article.reply :reply="$reply"></x-article.reply>
        @endforeach
    @endforeach
</div>
