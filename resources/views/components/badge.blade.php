@use('App\Enums\Transaction')
@props([
    'type' => Transaction::Delayed,
])

@if ($type == Transaction::Return->value)
<span class="bg-green-100 text-green-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
    {{ $slot }}
</span>
@elseif ($type == Transaction::Borrow->value)
<span class="bg-yellow-100 text-yellow-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">
    {{ $slot }}    
    </span>
@else
<span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">
    {{ $slot }}
</span>
@endif