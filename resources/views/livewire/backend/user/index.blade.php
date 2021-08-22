<div>
    <div class="mb-3">
        <a href="{{route('backend.user.create')}}">
            <x-backend.form.button>Add New User</x-backend.form.button>
        </a>
    </div>

    <x-backend.table>
        <x-slot name="head">
            <tr>
                <x-backend.table.th>User</x-backend.table.th>
                <x-backend.table.th>Status</x-backend.table.th>
                <x-backend.table.th></x-backend.table.th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach($users as $user)
                <tr>
                    <x-backend.table.td>
                        <div>
                            {{$user->name}}
                            @if(!$user->roles->isEmpty())
                                <span class="text-gray-600">({{$user->roles->pluck('name')->implode(', ')}})</span>
                            @endif
                        </div>
                        <div class="text-gray-500">Since {{$user->created_date_time_formatted}}</div>
                        <div class="text-gray-600">{{$user->username}}</div>
                        <div class="text-blue-600">{{$user->email}}</div>
                    </x-backend.table.td>
                    <x-backend.table.td>
                        @if($user->is_active)
                            <div wire:click="toggleActive({{$user->id}})"
                                 class="cursor-pointer px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Active
                            </div>
                        @else
                            <div wire:click="toggleActive({{$user->id}})"
                                 class="cursor-pointer px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
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
                    </x-backend.table.td>
                    <x-backend.table.td>
                        <a href="{{route('backend.user.edit', $user->id)}}"
                           class="text-indigo-700 hover:underline">Edit</a>
                        <span wire:click="delete({{$user->id}})"
                              onclick="confirm('You are deleting this user') || event.stopImmediatePropagation()"
                              class="cursor-pointer text-red-700 hover:underline">Delete</span>
                    </x-backend.table.td>
                </tr>
            @endforeach
        </x-slot>
    </x-backend.table>
    <div class="mt-3">
        {{$users->links()}}
    </div>
</div>
