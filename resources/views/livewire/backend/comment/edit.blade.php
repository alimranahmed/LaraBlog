<div>
    <form wire:submit.prevent="update({{$comment->id}})">
        <textarea aria-label="Content"
                  class="block w-full rounded focus:outline-none border border-indigo-300 focus:border-indigo-600 px-1"
                  wire:model.defer="comment.content"></textarea>

        <div class="my-3">
            <input type="checkbox" aria-label="Published" wire:model.defer="comment.is_published" id="is-published">
            <label for="is-published">Publish</label>
        </div>

        <button type="submit" class="block py-1 px-2 rounded border border-indigo-300 hover:border-indigo-600">
            Save
        </button>
    </form>
</div>
