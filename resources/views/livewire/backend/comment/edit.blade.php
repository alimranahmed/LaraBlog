<div>
    <form wire:submit.prevent="update({{$comment->id}})">
        <textarea aria-label="Content"
                  class="block w-full rounded focus:outline-none border border-indigo-300 focus:border-indigo-600 px-1"
                  wire:model="content"></textarea>

        <div class="my-3">
            <input type="checkbox" aria-label="Published" wire:model="is_published" id="is-published">
            <label for="is-published">Publish</label>
        </div>

        <x-backend.form.button>Save</x-backend.form.button>
    </form>
</div>
