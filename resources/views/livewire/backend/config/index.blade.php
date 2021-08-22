<div>
    <x-backend.table>
        <x-slot name="head">
            <x-backend.table.th>Name</x-backend.table.th>
            <x-backend.table.th>Value</x-backend.table.th>
            <x-backend.table.th></x-backend.table.th>
        </x-slot>
        <x-slot name="body">
            @foreach($configs as $config)
                <tr>
                    @if($editingConfig && $editingConfig->id == $config->id)
                        <form>
                            <x-backend.table.td>
                                <x-backend.form.input wire:model.defer="editingConfig.name" name="config.name" disabled></x-backend.form.input>
                            </x-backend.table.td>
                            <x-backend.table.td>
                                <x-backend.form.input wire:model.defer="editingConfig.value" name="config.name"></x-backend.form.input>
                            </x-backend.table.td>
                            <x-backend.table.td>
                                <x-backend.form.button wire:click="update({{$config}})">Update</x-backend.form.button>
                            </x-backend.table.td>
                        </form>
                    @else
                        <x-backend.table.td>{{$config->name}}</x-backend.table.td>
                        <x-backend.table.td>{{$config->value}}</x-backend.table.td>
                        <x-backend.table.td>
                            <span class="cursor-pointer text-indigo-700 hover:underline"
                                  wire:click="startEditing({{$config}})">Edit</span>
                        </x-backend.table.td>
                    @endif
                </tr>
            @endforeach
        </x-slot>
    </x-backend.table>
</div>
