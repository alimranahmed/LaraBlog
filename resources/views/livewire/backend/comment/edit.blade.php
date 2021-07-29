<div>
    <form wire:submit.prevent="update({{$comment->id}})">
        <textarea aria-label="Content" wire:model.defer="comment.content" class="border"></textarea>
        <input type="checkbox" aria-label="Published" wire:model.defer="comment.is_published">

        <button type="submit" class="border px-2">Save</button>
    </form>
</div>
