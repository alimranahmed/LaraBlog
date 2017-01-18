@extends("layouts.admin")
@section("content")
    <form action="{{route('update-user', ['userId' => $user->id])}}" class="margin-top-15" method="post">
        <input type="hidden" name="_method" value="PUT">
        {{csrf_field()}}
        <div class="form-group">
            <input type="text" name="name" id="name" value="{{$user->name}}" class="form-control" placeholder="Name">
        </div>
        <div class="form-group">
            <input type="text" name="username" id="name" value="{{$user->username}}" class="form-control" placeholder="Username">
        </div>
        <div class="form-group">
            <input type="text" name="email" id="name" value="{{$user->email}}" class="form-control" placeholder="Email">
        </div>
        <div class="form-group">
            <button class="btn btn-success" type="submit">Update</button>
        </div>
    </form>
@endsection