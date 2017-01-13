@extends("layouts.admin")
@section("content")
    <div class="row">
        <div class="col-sm-2">Name:</div>
        <div class="col-sm-4">{{$user->name}}</div>
    </div>
    <div class="row">
        <div class="col-sm-2">Email:</div>
        <div class="col-sm-4">{{$user->email}}</div>
    </div>
    <div class="row">
        <div class="col-sm-2">Roles:</div>
        <div class="col-sm-4">{{implode(',',$user->roles->pluck('display_name')->toArray())}}</div>
    </div>
@endsection