@props(['title' => $globalConfigs->site_title, 'article' => null])
@props(['title', 'article' => null])
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <x-frontend.seo-meta :article="$article"></x-frontend.seo-meta>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link rel="shortcut icon" type="image/png" href="{{\App\Models\Config::getPath(\App\Models\Config::FAVICON)}}"/>

        <title>{{$title}}</title>

        <x-frontend.google-analytics/>

    </head>
    <body class="bg-gray-50 text-slate-800">
        <div class="border-b border-blue-200 mb-3">

            <div class="max-w-2xl mx-auto px-5 lg:px-0">
                <x-frontend.navbar/>
            </div>

        </div>

        <div class="max-w-2xl mx-auto px-5 lg:px-0 min-h-screen">

            {{$slot}}

        </div>
        <div class="mt-4 p-4 border-t border-blue-200 md:flex md:justify-between text-center">
            <div>
                <?php echo '&copy; ' . (new DateTime())->format('Y') . ' Al Imran Ahmed' ?>
                <div>Proudly build with:
                    <a href="https://github.com/alimranahmed/larablog" class="text-indigo-600" target="_blank">Larablog</a>
                </div>
            </div>

            <x-frontend.social-links class="justify-center my-3 md:my-0"/>

            <div>
                <a href="{{route('contact')}}" class="border-b border-dotted border-indigo-600">Contact</a>
            </div>
        </div>
    </body>
</html>
