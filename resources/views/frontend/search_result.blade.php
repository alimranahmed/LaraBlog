@extends('layouts.public')
@section('content')
    <div class="row text-center border-bottom">
        <h2>Search result for <strong>{{$searched->query}}</strong>
            <span class="text-grey">({{$searched->articles->count()}})</span>
        </h2>
    </div>
    @include('frontend._article_list', ['articles' => $searched->articles])
@endsection