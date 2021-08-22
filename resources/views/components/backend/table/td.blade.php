@props(['wrap' => false])
<td class="px-6 py-4 {{$wrap ? '' : 'whitespace-no-wrap'}}">
    {{$slot}}
</td>
