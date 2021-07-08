<x-app>

    @forelse($articles as $article)
        <x-article :article="$article"></x-article>
    @empty
        <div class="text-gray-500 text-center my-2 text-2xl">Not available</div>
    @endforelse

    {{method_exists($articles, 'links') ? $articles->links() : ''}}

    <livewire:subscribe/>

</x-app>
