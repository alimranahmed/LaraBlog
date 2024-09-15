@php use App\Models\Config;use Illuminate\Support\Str; @endphp
<div>
    <div class="flex">
        @foreach([Config::FAVICON, Config::USER_PHOTO] as $file_name)
            <form class="mr-3" wire:submit="saveConfigFile('{{$file_name}}')">
                <div class="text-center">{{Str::title($file_name)}}</div>
                <img src="{{${$file_name} ? ${$file_name}->temporaryUrl() : $existingPaths[$file_name] }}" class="w-32 h-32 bg-indigo-100 border p-1 rounded mb-2" alt="Favicon">

                <label for="{{$file_name}}" class="cursor-pointer mt-1">
                    <input id="{{$file_name}}" type="file" wire:model="{{$file_name}}" class="sr-only"/>
                    <span class="text-slate-900 rounded px-2 leading-6 text-sm bg-indigo-300 hover:bg-indigo-400 py-1"
                          wire:target="{{$file_name}}"
                          wire:loading.attr="disabled"
                          wire:loading.class="cursor-wait animate-pulse"
                    >Change</span>
                </label>

                @if(${$file_name} && !$errors->has('file_name'))
                    <button class="text-slate-900 rounded px-2 leading-6 text-sm bg-green-300 hover:bg-green-400"
                            wire:target="saveFavicon"
                            wire:loading.attr="disabled"
                            wire:loading.class="cursor-wait animate-pulse">Save
                    </button>
                @else
                    <span class="text-slate-900 rounded px-2 leading-6 text-sm bg-red-300 hover:bg-red-400 py-1 cursor-pointer"
                          wire:target="resetConfigFile"
                          wire:loading.attr="disabled"
                          wire:loading.class="cursor-wait animate-pulse"
                          wire:click="resetConfigFile('{{$file_name}}')"
                    >Reset</span>
                @endif
            </form>
        @endforeach
    </div>

    @error(Config::FAVICON)
        <div class="text-red-500 text-sm italic">{{ $message }}</div>
    @enderror

    @error(Config::USER_PHOTO)
        <div class="text-red-500 text-sm italic">{{ $message }}</div>
    @enderror
</div>
