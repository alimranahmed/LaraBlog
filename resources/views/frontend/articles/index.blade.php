<x-frontend>

    @forelse($articles as $article)
        <x-frontend.article :article="$article"/>
    @empty
        <div class="text-gray-500 text-center my-2 text-2xl">Not available</div>
    @endforelse

    <div class="mt-3">
        {{method_exists($articles, 'links') ? $articles->links() : ''}}
    </div>

    <livewire:frontend.subscribe/>

</x-frontend>
