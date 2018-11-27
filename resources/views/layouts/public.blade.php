@include('layouts._header')
@include('layouts._navbar')
@include('layouts._alert')
<div class="main-container container" id="main_content">
    {{--<h1 class="text-center border-bottom" id="site-heading">{{$globalConfigs->site_title}}</h1>--}}
    <div class="col-sm-offset-1 col-sm-10">
        @yield('content')
    </div>
</div>
@include('layouts._footer')