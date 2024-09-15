<!--Medium Device-->
<div class="mb-0 py-2 justify-between items-center hidden md:flex">
    <a href="/" class="flex items-center">
        <img src="{{\App\Models\Config::getPath(\App\Models\Config::USER_PHOTO)}}" alt="logo" class="rounded-full h-10 w-10 object-cover object-center">
        <div class="ml-4 font-semibold">Al Imran Ahmed</div>
    </a>
    <form action="{{route("search-article")}}">
        <div class="flex">
            <input name="query_string"
                   placeholder="Search..."
                   aria-label="Query string"
                   required
                   class="rounded-l-full border-l border-t border-b border-blue-200 outline-none px-2 bg-gray-100 focus:bg-white focus:ring-0 focus:outline-none focus:border-blue-200 w-full appearance-none"
            >
            <button class="px-2 text-blue-800 focus:outline-none rounded-r-full border-r border-t border-b border-blue-200">
                <x-svg icon="search"/>
            </button>
        </div>
    </form>
    <div>
        <a href="{{route('articles')}}" class="uppercase hover:underline">Blog</a>
        <a href="{{route('page.about')}}" class="uppercase hover:underline ml-4">About</a>
    </div>
</div>

<!--Small device-->
<div class="mb-0 py-2 md:hidden">
    <div class="flex justify-between items-center">

        <a href="/" class="flex items-center">
            <img src="{{\App\Models\Config::getPath(\App\Models\Config::USER_PHOTO)}}" alt="logo"
                 class="rounded-full h-10 w-10 object-cover object-center">
            <div class="ml-4 font-semibold">Al Imran Ahmed</div>
        </a>

        <a class="rounded-full text-red-900 bg-red-500 hidden sm-hide-menu"
           onclick="document.querySelector('.sm-navs').classList.add('hidden');
                document.querySelector('.sm-show-menu').classList.remove('hidden');
                document.querySelector('.sm-hide-menu').classList.add('hidden');">
            <x-svg icon="cross"/>
        </a>

        <a class="inset rounded-full text-blue-900 sm-show-menu"
           onclick="document.querySelector('.sm-navs').classList.remove('hidden');
                document.querySelector('.sm-show-menu').classList.add('hidden');
                document.querySelector('.sm-hide-menu').classList.remove('hidden');">
            <x-svg icon="search"/>
        </a>
    </div>

    <div class="sm-navs hidden">
        <form action="{{route("search-article")}}">
            <div class="mt-4 flex">
                <input name="query_string"
                       aria-label="Query string"
                       required
                       class="rounded-l-full border-l border-t border-b border-blue-200 outline-none px-2 bg-gray-100 focus:bg-white w-full appearance-none">
                <button type="submit" class="px-2 text-blue-800 focus:outline-none rounded-r-full border-r border-t border-b border-blue-200">
                    <x-svg icon="search"/>
                </button>
            </div>
        </form>
        <div class="mt-4">
            <a href="{{route('articles')}}" class="uppercase hover:underline">Blog</a>
        </div>
        <div class="my-4">
            <a href="{{route('page.about')}}" class="uppercase hover:underline">About</a>
        </div>
    </div>
</div>

