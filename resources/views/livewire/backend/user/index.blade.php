<div>
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-base font-semibold leading-6 text-gray-900">Users</h1>
            <p class="mt-2 text-sm text-gray-700">A list of all the users.</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <a href="{{route('backend.user.create')}}">
                <x-backend.form.button>Add New User</x-backend.form.button>
            </a>
        </div>
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
                        <div class="flex">
                            <x-toggle :isEnabled="$user->is_active" wire:click="toggleActive({{$user->id}})"/>

                            <x-status class="ml-3"
                                :text="optional($user->reader)->is_verified ? 'Verified' : 'Not Verified'"
                                :state="optional($user->reader)->is_verified ? 'positive' : 'negative'"/>

                            <x-status class="ml-3"
                                :text='optional($user->reader)->notify ? "Notify" : "No Notify"'
                                :state="optional($user->reader)->notify ? 'positive' : 'negative'"/>
                        </div>
                    </x-backend.table.td>
                    <x-backend.table.td>
                        <a href="{{route('backend.user.edit', $user->id)}}"
                           class="text-indigo-700 hover:underline">Edit</a>

                        <span wire:click="delete({{$user->id}})"
                              wire:confirm="You are deleting this user"
                              class="ml-1 cursor-pointer text-red-700 hover:underline">Delete</span>
                    </x-backend.table.td>
                </tr>
            @endforeach
        </x-slot>
    </x-backend.table>
    <div class="mt-3">
        {{$users->links()}}
    </div>
</div>
