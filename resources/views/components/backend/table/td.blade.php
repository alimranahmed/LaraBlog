@props(['wrap' => false])
<td {{$attributes->merge(['class' => "py-4 pl-4 text-sm".($wrap ? '' : 'whitespace-no-wrap')])}}>
    {{$slot}}
</td>
