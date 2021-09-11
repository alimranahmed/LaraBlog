<div class="flex justify-center">
    <form wire:submit.prevent="update" class="w-full md:w-1/4 px-3">
        <div>
            <x-backend.form.input type="password" wire:model.defer="old_password" name="old_password" placeholder="Old Password*" class="w-full"/>
        </div>
        <div class="mt-3">
            <x-backend.form.input type="password" wire:model.defer="new_password" name="new_password" placeholder="New Password*" class="w-full"/>
        </div>
        <div class="mt-3">
            <x-backend.form.input type="password" wire:model.defer="confirm_new_password" name="confirm_new_password" placeholder="Confirm New Password*" class="w-full"/>
        </div>
        <div class="mt-3">
            <x-backend.form.button wire:loading.class="d-none" class="d-block">Update Password</x-backend.form.button>
        </div>
    </form>
</div>
