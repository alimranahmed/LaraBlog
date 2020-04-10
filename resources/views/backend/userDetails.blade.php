@extends("layouts.admin")
@section("content")
    <div class="panel panel-default no-margin-bottom">
        <div class="panel-heading">
            <strong>Information of {{$user->name}}</strong>
        </div>
        <div class="panel-body">
            <div class="row margin-top-10">
                <div class="col-sm-6">
                    <strong class="fa fa-circle {{$user->is_active ? 'text-success':'text-grey'}}"></strong>
                    <strong class="text-lg">{{$user->name}}</strong>
                    @hasanyrole('owner|admin')
                        <a href="{{route('edit-user', ['userId' => $user->id])}}">
                            <span class="fa fa-edit text-primary"></span>
                        </a>
                    @endhasanyrole
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
                <div class="col-sm-4">{{implode(',',$user->roles->pluck('name')->toArray())}}</div>
            </div>
            @if(isset($user->reader))
                <div class="row">
                    <div class="col-sm-2 text-right"><strong>Verified?</strong></div>
                    <div class="col-sm-4">{{ $user->reader->is_verified ? 'Yes' : 'No' }}</div>
                </div>
                <div class="row">
                    <div class="col-sm-2 text-right"><strong>Notify New Article?</strong></div>
                    <div class="col-sm-4">{{ $user->reader->notify ? 'Yes' : 'No' }}</div>
                </div>
            @endif
        </div>
    </div>
@endsection
