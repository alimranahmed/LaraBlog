<tr wire:loading.class="opacity-50">
    <x-backend.table.td>{{$category->name}}</x-backend.table.td>
    <x-backend.table.td>{{$category->alias}}</x-backend.table.td>
    <x-backend.table.td>{{$category->articles->count()}}</x-backend.table.td>
    <x-backend.table.td>
        @if($category->is_active)
            <span wire:click="toggleActive"
                  class="cursor-pointer px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                Active
            </span>
        @else
            <span wire:click="toggleActive"
                  class="cursor-pointer px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                Inactive
            </span>
        @endif
    </x-backend.table.td>
    <x-backend.table.td>
        <a>Edit</a>
        <span onclick="confirm('Are you sure to delete?') || event.stopImmediatePropagation()"
              wire:click="destroy({{$category}})"
              class="ml-1 cursor-pointer text-red-700 hover:underline">Delete</span>
    </x-backend.table.td>
</tr>
