@extends('layouts.public')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h3 class="heading">{{$article->heading}}</h3>
            <span class="time">published {{$article->published_at}}</span>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">{{$article->content}}</div>
    </div>
@endsection