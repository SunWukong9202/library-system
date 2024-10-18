@props([
    'name',
    'show' => false,
])
@use('App\Enums\Role')

<x-form.showable :$name :$show >
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Register a borrow') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Select the card of the student to assign it the books he/she want to borrow.') }}
        </p>
    </header>

    <div
    {{ $attributes }}
    class="space-y-6 mt-6" 
    > 
        {{ $slot }}

        <div class="flex gap-8">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Hide') }}
            </x-secondary-button>
            <x-primary-button x-on:click="$dispatch('{{ $name }}')">
                {{ __('register') }}
            </x-primary-button>
        </div>

    </div>
</x-form>

