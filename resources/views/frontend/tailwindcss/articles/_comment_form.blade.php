<form action="{{route('add-comment', $article->id)}}" method="post">
    @csrf
<textarea placeholder="Comment" aria-label="Comment"
          class="px-2 py-1
        w-full rounded-lg
        text-justify text-sm md:text-base
        border border-blue-200 block appearance-none leading-normal
        bg-gray-100
        focus:outline-none focus:bg-white focus:border-blue-300"></textarea>
    <div class="flex mt-4">
        <input placeholder="Name" aria-label="Name"
               class="px-2 py-1
        w-full rounded-lg
        text-justify text-sm md:text-base
        border border-blue-200 block appearance-none leading-normal
        bg-gray-100
        focus:outline-none focus:bg-white focus:border-blue-300">
        <input placeholder="Email" aria-label="Email"
               class="px-2 py-1 ml-4
        w-full rounded-lg
        text-justify text-sm md:text-base
        border border-blue-200 block appearance-none leading-normal
        bg-gray-100
        focus:outline-none focus:bg-white focus:border-blue-300">
    </div>
    <div class="flex justify-between pt-4">
        <div>
            <input type="checkbox"> Notify me about new article
        </div>
        <button class="rounded-full border border-blue-200 bg-blue-400 px-3 focus:outline-none up">Comment</button>
    </div>
</form>
