@include('layouts._header')
@include('layouts._navbar')
{{--@include('layouts._sidebar')--}}
<div class="main-container container-fluid">
    @yield('content')
</div>
@include('layouts._footer')