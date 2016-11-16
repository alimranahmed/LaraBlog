@include('layouts._header')
@include('layouts._navbar')
<div class="main-container container-fluid no-padding-left">
    <aside class="col-sm-2 no-padding">
        @if(Auth::check())
            @include('layouts._sidebar')
        @endif
    </aside>
    <div class="col-sm-10">
        @yield('content')
    </div>
</div>
@include('layouts._footer')
