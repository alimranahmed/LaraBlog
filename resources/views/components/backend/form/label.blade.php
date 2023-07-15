@props(['required' => false])
<label {{$attributes}}>
    {{$slot}} {!! $required ? '<span class="text-red-600">*</span>' : '' !!}
</label>
