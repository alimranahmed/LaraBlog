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
                    <div class="text-danger">{{session('auth_error')}}</div>
                    <div class="input-group {{$errors->has('email') ? 'has-error has-feedback' : ''}}">
                        <div class="input-group-addon">@</div>
                        <input type="email" name="email" class="form-control" id="email" value="{{old('email')}}" autofocus placeholder="Email">
                    </div>
                    <div class="text-danger">{{$errors->first('email')}}</div>
                    <div class="input-group margin-top-15 {{$errors->has('password') ? 'has-error has-feedback' : ''}}">
                        <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                    </div>
                    <div class="text-danger">{{$errors->first('password')}}</div>
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