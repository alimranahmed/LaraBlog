@include('layouts.frontend._header')

@foreach(range(1, 10) as $i)
    @include('frontend.articles._list_card')
@endforeach

@include('layouts.frontend._footer')
