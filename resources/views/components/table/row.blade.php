
<tr 
{{ $attributes->class([
    'bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600'
]) }}
{{-- class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600" --}}
>
    {{ $slot }}
</tr>