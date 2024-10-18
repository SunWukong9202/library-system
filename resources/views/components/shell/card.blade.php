@props([
    'available' => true,
])
<div 
{{ $attributes->class([
    'p-4 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600 shadow-lg rounded-lg border-l-4',
    'border-l-indigo-400 dark:border-l-indigo-600 cursor-pointer' => $available,
    'border-l-red-400 dark:border-l-red-600 cursor-not-allowed' => !$available,
]) }}

{{-- class="cursor-not-allowed" --}}
{{-- class="p-4 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600 shadow-lg rounded-lg border-l-4 border-l-indigo-400 dark:border-l-indigo-600 cursor-pointer" --}}
>
    {{ $slot }}
</div>