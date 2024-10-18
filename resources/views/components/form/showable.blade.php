@props([
    'name',
    'show' => false,
])

<div 
x-data="{ show: @js($show) }"
x-cloak
x-show="show"
x-on:open-form.window="$event.detail == '{{ $name }}' ? show = true : null";
x-on:close-form.window="$event.detail == '{{ $name }}' ? show = false : null";
x-on:close.stop="show = false"
{{ $attributes->class([
    'p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg'
]) }}
{{-- class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg" --}}
>
    {{ $slot }}
</div>