<div>
    <section>
        <x-backend.comment :comment="$comment"></x-backend.comment>
    </section>
    <section class="ml-10">
        @foreach($comment->replies as $reply)
            <x-backend.reply :reply="$reply" class="mt-3"></x-backend.reply>
        @endforeach
    </section>
    <section class="ml-10">
        <form wire:submit.prevent="submitReply">
            <div class="mt-3 font-semibold">Your Reply</div>
            <textarea
                class="block border border-indigo-300 rounded mt-2 w-full px-1 focus:border-indigo-600 focus:outline-none"
                aria-label="content" rows="3" wire:model.defer="reply.content"></textarea>
            <button type="submit" class="border border-indigo-300 hover:border-indigo-600 block px-2 py-1 rounded mt-3">
                Reply
            </button>
        </form>
    </section>
</div>
