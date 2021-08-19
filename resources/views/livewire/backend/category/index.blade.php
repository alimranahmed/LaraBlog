<div>
    <x-backend.form.button wire:click="startAdding" class="mb-3">Add New Category</x-backend.form.button>

    <x-backend.table>
        <x-slot name="head">
            <tr>
                <x-backend.table.th>Name</x-backend.table.th>
                <x-backend.table.th>Alias</x-backend.table.th>
                <x-backend.table.th>Status</x-backend.table.th>
                <x-backend.table.th></x-backend.table.th>
            </tr>
        </x-slot>
        <x-slot name="body">

            @if($adding)
                <form>
                    <tr>
                        <td class="px-6 py-4">
                            <x-backend.form.input type="text" wire:model.defer="category.name" name="category.name"
                                                  class="w-full" placeholder="Name"/>
                        </td>
                        <td class="px-6 py-4" colspan="2">
                            <x-backend.form.input type="text" wire:model.defer="category.alias" name="category.alias"
                                                  class="w-full" placeholder="Alias"/>
                        </td>
                        <td class="px-6 py-4" wire:click="store">
                            <x-backend.form.button>Add</x-backend.form.button>
                        </td>
                    </tr>
                </form>
            @endif

            @foreach($categories as $category)
                <livewire:backend.category.index-row :category="$category->id" wire:key="{{$category->id}}"/>
            @endforeach
        </x-slot>
    </x-backend.table>

    <div class="pt-3">
        {{$categories->links()}}
    </div>
</div>
