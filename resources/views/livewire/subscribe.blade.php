<div class="mt-10 border border-indigo-300 p-5 rounded flex justify-center w-full">
    @if($isSubscribed)
        <div class="text-green-700">
            Thanks! You have subscribed successfully.
        </div>
    @else
        <form wire:submit.prevent="subscribe">
            <input type="email"
                   wire:model.defer="email"
                   required
                   name="email"
                   class="px-2 py-1 rounded border border-green-400 focus:border-green-600 focus:outline-none"
                   aria-label="Email"
                   placeholder="Your email">
            <button type="submit" class="px-3 py-1 mt-3 md:mt-0 rounded bg-green-600 text-white hover:bg-green-700">
                Stay in touch
            </button>
            <div class="text-gray-500">No noise, unsubscribe anytime!</div>
        </form>
    @endif
</div>
