@extends("layouts.admin")
@section("content")
    <div class="row margin-top-10">
        <div class="col-sm-4">
            <strong class="text-lg">{{$user->name}}</strong>
            <a href="{{route('edit-user', ['userId' => $user->id])}}">
                <span class="fa fa-edit text-primary"></span>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-1 text-right"><strong>Username</strong></div>
        <div class="col-sm-4">{{$user->username}}</div>
    </div>
    <div class="row">
        <div class="col-sm-1 text-right"><strong>Last IP</strong></div>
        <div class="col-sm-4">{{$user->last_ip}}</div>
    </div>
    <div class="row">
        <div class="col-sm-1 text-right"><strong>Email</strong></div>
        <div class="col-sm-4">{{$user->email}}</div>
    </div>
    <div class="row">
        <div class="col-sm-1 text-right"><strong>Roles</strong></div>
        <div class="col-sm-4">{{implode(',',$user->roles->pluck('display_name')->toArray())}}</div>
    </div>
@endsection