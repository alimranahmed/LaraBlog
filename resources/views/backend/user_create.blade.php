@extends("layouts.admin")
@section("content")
    <form action="{{route('store-user')}}" class="margin-top-15" method="post">
        {{csrf_field()}}
        <div class="form-group">
            <input type="text" name="name" id="name" value="" class="form-control" placeholder="Name">
        </div>
        <div class="form-group">
            <input type="text" name="username" id="username" value="" class="form-control" placeholder="Username">
        </div>
        <div class="form-group">
            <input type="text" name="email" id="email" value="" class="form-control" placeholder="Email">
        </div>
        <div class="form-group">
            <input type="password" name="password" id="password" value="" class="form-control" placeholder="Password">
        </div>
        <div class="form-group">
            <button class="btn btn-success" type="submit">Add</button>
        </div>
    </form>
@endsection