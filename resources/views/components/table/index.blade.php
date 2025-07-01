@props([
    'columns' => [],
    'rows' => [],
    'fields' => [],
])

<div  custom-scrollbar class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table 
    {{ $attributes->class([
        'w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400'
    ]) }}
    {{-- class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" --}}
    >
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                @if ($columns instanceof \Illuminate\View\ComponentSlot)
                    {{ $columns }}
                @else
                    @foreach ($columns as $column)
                    <th scope="col" class="px-6 py-3">
                        {{ $column }}
                    </th>
                    @endforeach
                @endif
            </tr>
        </thead>
        @if ($slot->isEmpty())
        <tbody>
            @foreach ($rows as $row)
                <x-table.row>
                    @foreach ($fields as $field)
                        <x-table.column>
                            {{ $row[$field] }}
                        </x-table>
                    @endforeach
                    @isset($actions)
                        {{ $actions }}
                    @endisset
                </x-table>
            @endforeach
        </tbody>
        @else
            {{ $slot }}
        @endif
    </table>
</div>

@script
<script>
    Alpine.data('table', () => ({
        
    }));
</script>
@endscript