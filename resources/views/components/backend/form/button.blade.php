@props(['type' => 'submit'])
<button type="{{$type}}"
    wire:loading.attr="disabled" wire:loading.class="cursor-wait"
    {{$attributes->merge(['class' => 'bg-indigo-300 hover:bg-indigo-500 rounded py-1 px-2 focus:outline-none'])}}>
    {{$slot}}
</button>
