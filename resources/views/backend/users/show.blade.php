<x-backend>
    <div class="flex justify-center">
        <div>
            <div>
                {{$user->name}}
                @if(!$user->roles->isEmpty())
                    <span class="text-gray-600">({{$user->roles->pluck('name')->implode(', ')}})</span>
                @endif
                <a href="{{route('backend.user.edit', $user->id)}}" class="text-indigo-700 hover:underline">Edit</a>
            </div>
            <div class="text-gray-500 border-b mb-5">Since {{$user->created_date_time_formatted}}</div>
            <div class="text-gray-600">{{$user->username}}</div>
            <div class="text-blue-600">{{$user->email}}</div>
            @if($user->is_active)
                <div
                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                    Active
                </div>
            @else
                <div
                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                    Inactive
                </div>
            @endif
            @if(optional($user->reader)->is_verified)
                <div
                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                    Verified
                </div>
            @else
                <div
                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                    Not Verified
                </div>
            @endif
            @if(optional($user->reader)->notify)
                <div
                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                    Notify
                </div>
            @else
                <div
                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                    Don't Notify
                </div>
            @endif
        </div>
    </div>
</x-backend>
