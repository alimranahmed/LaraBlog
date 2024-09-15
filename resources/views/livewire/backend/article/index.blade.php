<div>
    <section>
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">Articles</h1>
                <form class="mt-3">
                    <x-backend.form.input name="query" wire:model.live="query" placeholder="Search article" autofocus/>
                    <select name="category" wire:model.live.change="category" aria-label="Category"
                            class="p-1 border border-indigo-300 rounded focus:outline-none focus:border-indigo-500 mt-3 sm:mt-0">
                        <option value="">All categories</option>
                        @foreach($navCategories as $category)
                            <option value="{{$category->id}}" {{request('category') == $category->id ? 'selected' : ''}}>
                                {{$category->name}}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <a href="{{route('backend.article.create')}}">
                    <x-backend.form.button>Add New Article</x-backend.form.button>
                </a>
            </div>
        </div>
    </section>

    <x-backend.table wire:loading.class="opacity-50 cursor-wait">
        <x-slot name="head">
            <tr>
                <x-backend.table.th>Title</x-backend.table.th>
                <x-backend.table.th>Publication</x-backend.table.th>
                <x-backend.table.th></x-backend.table.th>
            </tr>
        </x-slot>

        <x-slot name="body">
            @forelse($articles as $article)
                <livewire:backend.article.index-row :article="$article" wire:key="{{$article->id}}"/>
            @empty
                <tr>
                    <x-backend.table.td colspan="100" class="text-gray-500 text-center">No article found</x-backend.table.td>
                </tr>
            @endforelse
        </x-slot>
    </x-backend.table>

    <section class="pt-3">
        {{$articles->links()}}
    </section>
</div>
