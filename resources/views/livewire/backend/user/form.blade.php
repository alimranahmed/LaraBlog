<div class="flex justify-center">
    <form wire:submit.prevent="submit" class="w-full md:w-1/4 px-3">
        <div>
            <x-backend.form.select wire:model.defer="user.role" name="user.role">
                <option value="">Select role*</option>
                @foreach($roles as $role)
                    <option value="{{$role->id}}">{{ucwords($role->name)}}</option>
                @endforeach
            </x-backend.form.select>
        </div>

        <div class="mt-3">
            <x-backend.form.input wire:model.defer="user.name" name="user.name" placeholder="Name*" class="w-full"/>
        </div>
        <div class="mt-3">
            <x-backend.form.input wire:model.defer="user.username" name="user.username" placeholder="Username" class="w-full"/>
        </div>
        <div class="mt-3">
            <x-backend.form.input wire:model.defer="user.email" name="user.email" placeholder="Email*" class="w-full"/>
        </div>
        <div class="mt-3">
            <x-backend.form.button>Save</x-backend.form.button>
        </div>
    </form>
</div>
