@include('layouts._header')
@include('layouts._navbar')
@include('layouts._alert')
<div class="main-container container-fluid no-padding">
    <h1 class="text-center border-bottom" id="site-heading">Al- Imran Ahmed</h1>
    <aside class="col-sm-2 no-padding">
        @if(Auth::check())
            @include('layouts._sidebar')
        @endif
    </aside>
    <div class="col-sm-10">
        @yield('content')
    </div>
</div>
@yield('inPageJS')
@include('layouts._footer')
