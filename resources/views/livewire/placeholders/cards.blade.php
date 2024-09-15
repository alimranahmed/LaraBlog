<div class="animate-pulse">
    <section class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
        @for($i = 1; $i <= 15; $i++)
            <div class="rounded border border-slate-300 pl-2">
                <div class="flex justify-between">
                    <div class="h-2 bg-gray-300 rounded"></div>
                    <div class="w-3 h-3 bg-gray-300 -mt-1 -mr-1 rounded-full"></div>
                </div>
                <div class="my-3 h-2 w-40 rounded bg-gray-300"></div>
                <div class="my-3 h-2 w-32 rounded bg-gray-300"></div>
                <div class="my-3 h-1 w-40 rounded bg-gray-300"></div>
            </div>
        @endfor
    </section>

    <!-- Pagination skeleton -->
    <div class="mt-3 flex justify-between w-full">
        <div class="h-2 bg-gray-300 rounded w-60"></div>
        <div class="h-8 bg-gray-300 rounded w-32"></div>
    </div>
</div>
