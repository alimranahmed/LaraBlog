@extends('layouts.public')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h3 class="article-heading text-center">{{$article->heading}}</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">{{$article->content}}</div>
    </div>
@endsection