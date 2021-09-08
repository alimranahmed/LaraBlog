@props(['wrap' => false])
<td {{$attributes->merge(['class' => "px-6 py-4 ".($wrap ? '' : 'whitespace-no-wrap')])}}>
    {{$slot}}
</td>
