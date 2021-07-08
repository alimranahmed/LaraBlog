<div class="mt-3 border border-indigo-300 p-5 rounded flex justify-center">
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
                   class="px-2 py-1 ml-0 rounded-l border border-green-500 focus:border-green-700 focus:outline-none"
                   aria-label="Email"
                   placeholder="Your email">
            <button type="submit" class="px-3 py-1 mr-0 rounded-r bg-green-700 text-white hover:bg-green-800">
                Stay in touch
            </button>
            <div class="text-gray-500">No noise, unsubscribe anytime!</div>
        </form>
    @endif
</div>
