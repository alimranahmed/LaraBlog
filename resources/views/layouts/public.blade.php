@include('layouts._header')
@include('layouts._navbar')
<div class="main-container container" id="app">
    <div class="col-sm-offset-1 col-sm-10">
        @yield('content')
    </div>
</div>
@include('layouts._footer')