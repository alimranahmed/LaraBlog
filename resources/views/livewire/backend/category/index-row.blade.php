<tr>
    @if($editing)
        <form>
            <td class="px-6 py-4">
                <x-backend.form.input type="text"
                                      wire:model.defer="categoryData.name"
                                      name="category.name"
                                      class="w-full"/>
            </td>
            <td class="px-6 py-4" colspan="2">
                <x-backend.form.input type="text"
                                      wire:model.defer="categoryData.alias"
                                      name="category.alias"
                                      class="w-full"/>
            </td>
            <td class="px-6 py-4" wire:click="update">
                <x-backend.form.button>Save</x-backend.form.button>
            </td>
        </form>
    @else
        <x-backend.table.td>
            {{$category->name}}<br>
            @if($category->articles->count() > 0)
                <a href="{{route('backend.article.index', ['category' => $category->id])}}" class="text-indigo-500">
                    {{$category->articles->count().' '.Str::plural('article', $category->articles->count())}}
                </a>
            @else
                <div class="text-gray-400">No article</div>
            @endif
        </x-backend.table.td>
        <x-backend.table.td>{{$category->alias}}</x-backend.table.td>
        <x-backend.table.td>
            <div class="flex">
                <x-toggle :isEnabled="$category->is_active" wire:click="toggleActive"/>
                <x-status class="ml-3"
                          :text="$category->is_active ? 'Active' : 'Inactive'"
                          :state="$category->is_active ? 'positive' : 'negative'"
                />
            </div>
        </x-backend.table.td>
        <x-backend.table.td>
            <span wire:click="startEditing" class="text-indigo-700 hover:underline cursor-pointer">Edit</span>
            <span wire:confirm="Are you sure to delete?"
                  wire:click="destroy({{$category}})"
                  class="ml-1 cursor-pointer text-red-700 hover:underline">Delete</span>
        </x-backend.table.td>
    @endif
</tr>
