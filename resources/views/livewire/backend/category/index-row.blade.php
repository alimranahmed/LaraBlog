<tr wire:loading.class="opacity-50">

    @if($editing)
        <form>
            <td class="px-6 py-4">
                <x-backend.form.input type="text" wire:model.defer="categoryData.name" name="category.name"
                                      class="w-full"/>
            </td>
            <td class="px-6 py-4" colspan="2">
                <x-backend.form.input type="text" wire:model.defer="categoryData.alias" name="category.alias"
                                      class="w-full"/>
            </td>
            <td class="px-6 py-4" wire:click="update">
                <x-backend.form.button>Save</x-backend.form.button>
            </td>
        </form>
    @else
        @php
            $articleCount = $category->articles->count();
        @endphp

        <x-backend.table.td>
            {{$category->name}}<br>
            <a href="{{route('backend.article.index', ['category' => $category->id])}}" class="text-indigo-500">
                {{$articleCount <=0 ? 'No article' : $articleCount.' '.\Illuminate\Support\Str::plural('article', $articleCount)}}
            </a>
        </x-backend.table.td>
        <x-backend.table.td>{{$category->alias}}</x-backend.table.td>
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
            <span wire:click="startEditing" class="text-indigo-700 hover:underline cursor-pointer">Edit</span>
            <span onclick="confirm('Are you sure to delete?') || event.stopImmediatePropagation()"
                  wire:click="destroy({{$category}})"
                  class="ml-1 cursor-pointer text-red-700 hover:underline">Delete</span>
        </x-backend.table.td>
    @endif
</tr>
