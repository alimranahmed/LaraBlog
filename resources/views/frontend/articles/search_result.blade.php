<x-frontend>
    <div class="text-xl text-center border-b">
        Searched <strong>"{{$searched->query}}"</strong>
    </div>
    @forelse($searched->articles as $article)
        <x-frontend.article :article="$article"></x-frontend.article>
    @empty
        <div class="text-gray-500 text-center my-2 text-2xl">Not result available</div>
    @endforelse

    {{method_exists($searched->articles, 'links') ? $searched->articles->links() : ''}}

    <livewire:frontend.subscribe/>

</x-frontend>
