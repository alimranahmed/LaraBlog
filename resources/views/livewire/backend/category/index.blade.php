<div>
    <x-backend.table>
        <x-slot name="head">
            <tr>
                <x-backend.table.th>Name</x-backend.table.th>
                <x-backend.table.th>Alias</x-backend.table.th>
                <x-backend.table.th>Articles</x-backend.table.th>
                <x-backend.table.th>Status</x-backend.table.th>
                <x-backend.table.th></x-backend.table.th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach($categories as $category)
                <livewire:backend.category.index-row :category="$category->id"/>
            @endforeach
        </x-slot>
    </x-backend.table>

    <div class="pt-3">
        {{$categories->links()}}
    </div>
</div>
