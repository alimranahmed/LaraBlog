@extends('layouts.admin')
@section('content')
    <div class="col-sm-offset-2 col-sm-6 margin-top-15">
        <div class="panel panel-primary">
            <div class="panel-heading text-center">
                <strong>Welcome</strong>
            </div>
            <div class="panel-body">
                <form method="post" action="{{route('login')}}">
                    {{csrf_field()}}
                    <div class="input-group">
                        <div class="input-group-addon">@</div>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                    </div>
                    <div class="input-group margin-top-15">
                        <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember_me"> Remember Me
                        </label>
                    </div>
                    <button type="submit" class="btn btn-success pull-right">Login</button>
                </form>
            </div>
        </div>
    </div>
@endsection