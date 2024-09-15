<div class="flex justify-center">
    <div>
        <div class="flex items-center gap-x-6">
            <img class="h-16 w-16 rounded-full border" src="{{\App\Models\Config::getPath(\App\Models\Config::USER_PHOTO)}}" alt="">
            <div>
                <h3 class="text-base font-semibold leading-7 tracking-tight text-gray-900">{{$user->name}}</h3>
                @if(!$user->roles->isEmpty())
                    <p class="text-sm font-semibold leading-3 text-gray-600">{{$user->roles->pluck('name')->implode(', ')}}</p>
                @endif
                <a href="{{route('backend.user.edit', $user->id)}}" wire:navigate class="text-indigo-700 hover:underline">Edit</a>
            </div>
        </div>
        <div class="text-gray-500 border-b pb-2 mb-2">Since {{$user->created_date_time_formatted}}</div>
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
