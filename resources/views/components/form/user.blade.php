@props([
    'name',
    'show' => false,
    'form',
])
@use('App\Enums\Role')

<x-form.showable :$name :$show :$attributes>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ isset($form->user) ? __('Edit User Form') : __('Create User Form') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Please fill all the fields required (they are specified with a *)') }}
        </p>
    </header>

    @if(isset($form->user) && auth()->user()->role == Role::Admin)
    <div class="mt-6 flex flex-col gap-2">
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('If you just want to generate a new password for this user click below') }}
        </p>
        <x-primary-button class="w-max" wire:click="proxyAction('regenerate')">
            Regenerate Password
        </x-primary-button>
    </div>
    @endif

    <form class="max-w-xl space-y-6 mt-6" 
    wire:submit="proxyAction('{{ isset($form->user) ? 'update' : 'create' }}')"
    > 
        <div class="text-white">
            <x-input-label for="name" :value="__('Name').' *'" />
            <x-text-input wire:model="form.name" id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('form.name')" />
        </div>

        @can(Role::Admin)
            <div>
                <x-input-label for="email" :value="__('Email').' *'" />
                <x-text-input wire:model="form.email" id="email" name="email" type="email" class="mt-1 block w-full" required autocomplete="email" />
                <x-input-error class="mt-2" :messages="$errors->get('form.email')" />
            </div>
        @endcan

        <div> 
            <x-input-label for="key" :value="__('Key').' *'" />
            <x-text-input x-mask="999999" wire:model="form.key" id="key" name="key" type="text" class="mt-1 block w-full" required autofocus autocomplete="key" />
            <x-input-error class="mt-2" :messages="$errors->get('form.key')" />
        </div>
        @can(Role::Admin)
            <div>
                <x-input-label for="role" :value="__('Role').' *'" />
                <x-select id="role" wire:model="form.role">
                    @foreach (Role::cases() as $role)
                        <option value="{{ $role }}">{{ __($role->value) }}</option>
                    @endforeach
                </x-select>
                <x-input-error class="mt-2" :messages="$errors->get('form.role')" />
            </div>
        @endcan

        <div class="flex gap-8">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Hide') }}
            </x-secondary-button>
            <x-primary-button>
                {{ isset($form->user) ? __('Edit') :__('Create') }}
            </x-primary-button>
        </div>

    </form>
</x-form>


{{-- <div 
x-show="showUserForm"
x-on:open-user-form.window="showUserForm = true";
x-on:close-user-form.window="showUserForm = false";
class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ isset($form->user) ? __('Edit User Form') : __('Create User Form') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Please fill all the fields required (they are specified with a *)') }}
        </p>
    </header>

    @isset($form->user)
    <div class="mt-6 flex flex-col gap-2">
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('If you just want to generate a new password for this user click below') }}
        </p>
        <x-primary-button class="w-max" wire:click="regenerate">
            Regenerate Password
        </x-primary-button>
    </div>
    @endisset

    <form class="max-w-xl space-y-6 mt-6" wire:submit="{{ isset($form->user) ? 'update' : 'create' }}"> 
        <div class="text-white">
            <x-input-label for="name" :value="__('Name').' *'" />
            <x-text-input wire:model="form.name" id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('form.name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email').' *'" />
            <x-text-input wire:model="form.email" id="email" name="email" type="email" class="mt-1 block w-full" required autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('form.email')" />
        </div>

        <div> 
            <x-input-label for="key" :value="__('Key').' *'" />
            <x-text-input x-mask="999999" wire:model="form.key" id="key" name="key" type="text" class="mt-1 block w-full" required autofocus autocomplete="key" />
            <x-input-error class="mt-2" :messages="$errors->get('form.key')" />
        </div>

        <div>
            <x-input-label for="role" :value="__('Role').' *'" />
            <x-select id="role" wire:model="form.role">
                @foreach (Role::cases() as $role)
                    <option value="{{ $role }}">{{ __($role->value) }}</option>
                @endforeach
            </x-select>
            <x-input-error class="mt-2" :messages="$errors->get('form.role')" />
        </div>

        <div class="flex gap-8">
            <x-secondary-button x-on:click="showUserForm = false">
                {{ __('Hide') }}
            </x-secondary-button>
            <x-primary-button>
                {{ isset($form->user) ? __('Edit') :__('Create') }}
            </x-primary-button>
        </div>

    </form>
</div> --}}
