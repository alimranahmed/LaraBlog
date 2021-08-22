<x-backend>
    <div>
        <div>
            <strong>Welcome</strong>
        </div>
        <div>
            <form method="post" action="{{route('login')}}">
                {{csrf_field()}}
                <div class="text-red-600">{{session('auth_error')}}</div>
                <div>
                    <x-backend.form.input type="email" name="email" class="form-control" id="email" value="{{old('email')}}" autofocus
                           placeholder="Email"/>
                </div>
                <div class="mt-3">
                    <x-backend.form.input type="password" name="password" class="form-control" id="password" placeholder="Password"/>
                </div>
                <div>
                    <label>
                        <input type="checkbox" name="remember_me"> Remember Me
                    </label>
                </div>
                <x-backend.form.button>Login</x-backend.form.button>
            </form>
        </div>
    </div>
</x-backend>
