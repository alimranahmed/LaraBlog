@extends("layouts.admin")
@section("content")
    <div class="panel panel-default no-margin-bottom">
        <div class="panel-heading">
            <strong>Add User</strong>
        </div>
        <div class="panel-body">
            <form action="{{route('store-user')}}" class="margin-top-15" method="post">
                {{csrf_field()}}
                <div class="form-group {{$errors->has('role_id') ? "has-error" : ""}}">
                    <select name="role" class="form-control">
                        <option value="">Select User Role*</option>
                        @foreach($roles as $role)
                            <option value="{{$role->name}}">{{ucfirst($role->name)}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group {{$errors->has('name') ? "has-error" : ""}}">
                    <input type="text" name="name" id="name" value="" class="form-control" placeholder="Name*">
                </div>
                <div class="form-group {{$errors->has('username') ? "has-error" : ""}}">
                    <input type="text" name="username" id="username" value="" class="form-control" placeholder="Username">
                </div>
                <div class="form-group {{$errors->has('email') ? "has-error" : ""}}">
                    <input type="text" name="email" id="email" value="" class="form-control" placeholder="Email*">
                </div>
                <div class="form-group {{$errors->has('password') ? "has-error" : ""}}">
                    <input type="password" name="password" id="password" value="" class="form-control" placeholder="Password*">
                </div>
                <div class="form-group">
                    <button class="btn btn-success" type="submit">Add</button>
                </div>
            </form>
        </div>
    </div>
@endsection
