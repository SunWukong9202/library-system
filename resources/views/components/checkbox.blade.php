@props([
    'id' => 'checkbox',
])

<div 
x-data

x-id="['{{ $id }}']"
{{ $attributes->class([
    'block'
]) }}
{{-- class="block" --}}
>
    <label x-bind:for="$id('{{ $id }}')" class="inline-flex items-center">
        <input 
        {{ $attributes->whereDoesntStartWith('class') }}
        x-bind:id="$id('{{ $id }}')" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" >
        @isset($label)
        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">
            {{ $label }}
        </span>
        @endisset
    </label>
</div>