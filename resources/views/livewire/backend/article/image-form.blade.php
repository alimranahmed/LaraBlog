<div>
    <form>
        <div class="flex w-full justify-center rounded-lg border-4 border-dashed border-gray-200 px-6 py-5">
            <div class="text-center">

                <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                </svg>

                <div class="mt-4 flex text-sm leading-6 text-gray-600">
                    <label for="image_file" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                        <span>Upload a file</span>
                        <input id="image_file" name="image_file" wire:model.live="image_file" type="file" class="sr-only">
                    </label>
                    <p class="pl-1">or drag and drop</p>
                </div>

                <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 2MB</p>

            </div>
        </div>

        @error('image_file')
            <div class="text-red-500 text-xs italic">{{ $message }}</div>
        @enderror

        @foreach($files as $file)
            <div class="flex items-center mt-3">
                <img src="{{$file['url']}}" alt="Image" class="object-cover border inline-block h-20 w-20 rounded-md">
                <div class="align-top ml-5 text-sm">
                    <div>
                        <span class="text-gray-900">{{$file['name']}}</span>
                        <span class="text-gray-400">({{$file['size']}})</span>
                    </div>
                    <div class="text-indigo-400 italic mb-1">{{$file['url']}}</div>
                    <span class="text-xs py-1 px-1 rounded cursor-pointer bg-slate-400 text-white hover:bg-slate-600"
                          @click="copyText('{{$file['url']}}')">Use</span>

                    <button type="button"
                        class="text-xs py-1 px-1 rounded cursor-pointer bg-red-400 text-white hover:bg-red-600"
                        wire:click="delete('{{$file['uuid']}}')"
                        wire:loading.class="cursor-wait"
                        wire:loading.attr="disabled"
                        wire:target="delete">Delete</button>
                </div>
            </div>
        @endforeach

        <div class="text-green-600 animate-pulse" wire:loading wire:target="image_file">
            File is being uploaded...
        </div>

    </form>
</div>
@push('scripts')
    <script>
        function copyText(text) {
            text = "<img src='"+text+"' loading='lazy' role='presentation' alt='Image'>"
            if (navigator.clipboard) {
                // If the Clipboard API is available, use it
                navigator.clipboard.writeText(text)
                    .then(() => {
                        //alert('Copied to clipboard!');
                    })
                    .catch(err => {
                        console.error('Failed to copy using navigator.clipboard: ', err);
                    });
            } else {
                // Fallback for older browsers
                let textarea = document.createElement('textarea');
                textarea.value = text;
                document.body.appendChild(textarea);
                textarea.select();
                try {
                    document.execCommand('copy');
                    //alert('Copied to clipboard!');
                } catch (err) {
                    console.error('Fallback: Unable to copy using legacy', err);
                }
                document.body.removeChild(textarea);
            }
        }
    </script>
@endpush
