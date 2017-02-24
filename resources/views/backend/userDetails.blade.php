@extends("layouts.admin")
@section("content")
    <div class="row margin-top-10">
        <div class="col-sm-6">
            <strong class="fa fa-circle {{$user->is_active ? 'text-success':'text-primary'}}"></strong>
            <strong class="text-lg">{{$user->name}}</strong>
            @if(\Entrust::hasRole(['owner','admin']))
                <a href="{{route('edit-user', ['userId' => $user->id])}}">
                    <span class="fa fa-edit text-primary"></span>
                </a>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2 text-right"><strong>Username</strong></div>
        <div class="col-sm-4">{{$user->username}}</div>
    </div>
    <div class="row">
        <div class="col-sm-2 text-right"><strong>Last IP</strong></div>
        <div class="col-sm-4">{{$user->last_ip}}</div>
    </div>
    <div class="row">
        <div class="col-sm-2 text-right"><strong>Email</strong></div>
        <div class="col-sm-4">{{$user->email}}</div>
    </div>
    <div class="row">
        <div class="col-sm-2 text-right"><strong>Roles</strong></div>
        <div class="col-sm-4">{{implode(',',$user->roles->pluck('display_name')->toArray())}}</div>
    </div>
@endsection