<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>L5 Blog</title>
        <!-- Fonts -->
        <link href="{{asset("css/app.css")}}" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="app">
            <h1>Hello App!</h1>
            <p>
                <router-link to="/foo">Go to Foo</router-link>
                <router-link to="/bar">Go to Bar</router-link>
            </p>
            <router-view></router-view>
        </div>
        <script src="{{asset("js/app.js")}}"></script>
    </body>
</html>
