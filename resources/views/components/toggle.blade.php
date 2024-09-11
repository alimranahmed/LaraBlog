@props(['text' => null, 'isEnabled' => false])
<div class="flex items-center">
    <!-- Enabled: "bg-indigo-600", Not Enabled: "bg-gray-200" -->
    <button {{$attributes}}
            type="button"
            wire:loading.attr="disabled" wire:loading.class="cursor-wait"
            @class([
                'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2',
                'bg-indigo-600' => $isEnabled,
                'bg-gray-200' => !$isEnabled,
            ])
            role="switch" aria-checked="false" aria-labelledby="annual-billing-label">

            <!-- Enabled: "translate-x-5", Not Enabled: "translate-x-0" -->
            <span aria-hidden="true"
                @class([
                    "pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out",
                    'translate-x-5' => $isEnabled,
                    'translate-x-0' => !$isEnabled,
            ])></span>
    </button>
    @if($text)
        <div class="inline ml-3">{{$text}}</div>
    @endif
</div>
