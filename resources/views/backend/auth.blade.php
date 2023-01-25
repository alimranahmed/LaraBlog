<x-backend>
    <div class="flex justify-center px-4">
        <div class="w-full sm:w-1/4">
            <div>
                <h2>Welcome...</h2>
            </div>
            <div>
                <form method="post" action="{{route('login')}}">
                    {{csrf_field()}}
                    <div class="text-red-600">{{session('auth_error')}}</div>
                    <div>
                        <x-backend.form.input type="email" name="email" class="w-full mt-5" id="email"
                                              value="{{old('email')}}" autofocus
                                              placeholder="Email"/>
                    </div>
                    <div>
                        <x-backend.form.input type="password" name="password" class="w-full mt-3" id="password"
                                              placeholder="Password"/>
                    </div>
                    <div class="my-3">
                        <label>
                            <input type="checkbox" name="remember_me"> Remember Me
                        </label>
                    </div>
                    <x-backend.form.button>Login</x-backend.form.button>
                    <div class="mt-5">
                        <a href="{{route('home')}}"
                           class="text-slate-700 underline decoration-dotted hover:decoration-solid hover:text-blue-500">
                            Go to Home
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-backend>
