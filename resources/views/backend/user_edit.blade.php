@extends("layouts.admin")
@section("content")
    <div class="panel panel-default no-margin-bottom">
        <div class="panel-heading">
            <strong>Edit Information of {{$user->name}}</strong>
        </div>
        <div class="panel-body">
            <form action="{{route('update-user', ['userId' => $user->id])}}" class="margin-top-15" method="post">
                <input type="hidden" name="_method" value="PUT">
                {{csrf_field()}}
                <div class="form-group {{$errors->has('role_id') ? "has-error" : ""}}">
                    <select name="role" class="form-control">
                        <option value="" readonly="true">Select User Role*</option>
                        @foreach($roles as $role)
                            <option value="{{$role->name}}" {{!$user->roles->isEmpty() && $user->roles->first()->name ==
                            $role->name ? 'selected' : ''}}>{{ucfirst($role->name)}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group {{$errors->has('name') ? "has-error" : ""}}">
                    <input type="text" name="name" id="name" value="{{$user->name}}" class="form-control" placeholder="Name*">
                </div>
                <div class="form-group {{$errors->has('username') ? "has-error" : ""}}">
                    <input type="text" name="username" id="username" value="{{$user->username}}" class="form-control" placeholder="Username">
                </div>
                <div class="form-group {{$errors->has('email') ? "has-error" : ""}}">
                    <input type="text" name="email" id="email" value="{{$user->email}}" class="form-control" placeholder="Email*">
                </div>
                <div class="form-group {{$errors->has('password') ? "has-error" : ""}}">
                    <input type="password" name="password" id="password" value="" class="form-control" placeholder="Password">
                </div>
                <div class="form-group {{$errors->has('is_active') ? "has-error" : ""}}">
                    <input type="checkbox" name="is_active" id="is_active" {{$user->is_active ? 'checked' : ''}}>
                    <label for="is_active">Active</label>
                </div>
                <div class="form-group {{$errors->has('role_id') ? "has-error" : ""}}">
                    <button class="btn btn-success" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
