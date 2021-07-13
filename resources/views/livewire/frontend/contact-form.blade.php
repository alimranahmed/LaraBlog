<div>
    @if($isSubmitted)
        <h2 class="text-lg mt-10 text-center text-green-700">
            Your messaged sent successfully! Thanks for your message.
        </h2>
        <div class="text-center mt-3">
            Go <a href="{{route('home')}}" class="underline text-indigo-600">home</a>
        </div>
    @else
        <h2 class="text-lg text-center">Waiting to hear from you!</h2>

        <form class="mt-5" wire:submit.prevent="submit">
            <div class="flex-row md:flex">
                <div class="md:mr-3 w-full md:w-1/2">
                    <input wire:model.defer="name"
                           class="px-2 py-1 border border-indigo-300 rounded w-full"
                           type="text"
                           name="name"
                           placeholder="Name*"
                           aria-label="You name">
                    @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mt-3 w-full md:mt-0 md:w-1/2">
                    <input wire:model.defer="email"
                           class="px-2 py-1 border border-indigo-300 rounded w-full"
                           type="email"
                           name="email"
                           placeholder="Email*"
                           aria-label="Email">
                    @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

            </div>
            <div class="mt-3">
            <textarea wire:model.defer="content"
                      class="px-2 py-1 border border-indigo-300 rounded w-full"
                      type="text"
                      rows="4"
                      name="content"
                      placeholder="Message*"
                      aria-label="Message"></textarea>
                @error('content') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <button class="mt-3 px-3 border border-indigo-300 rounded hover:bg-indigo-300">Send</button>

        </form>
    @endif
</div>
