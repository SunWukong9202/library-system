@use('App\Enums\Role')

<x-shell.page class="flex flex-col gap-8" x-data>    
    @if ($books->count() == 0)
       <x-empty.book>
            @if (auth()->user()->role != Role::Student)
            <x-nav-link :href="route('books')" wire:navigate>
                {{ __('Add Books') }}
            </x-nav-link>
            @endif
       </x-empty>
    @else 
        <h2 class="text-xl font-semibold  text-gray-900 dark:text-gray-100">
            {{ __("Top Requested Books: Readers' Favorites!") }}
        </h2>
        <x-table :columns="['Ranking', 'Titulo', 'Popularidad']">
            @foreach ($books as $book)
                <x-table.row>
                    <x-table.column>
                        @if (in_array($loop->index + 1, [1,2,3]))
                        <div 
                        @class([
                            'flex flex-col gap-4 items-center justify-center',
                            'text-yellow-300' => $loop->index == 0,
                            'text-orange-300' => $loop->index == 2
                        ])
                        >
                            <x-heroicon-s-trophy class="w-16 h-16"/>
                            {{ $loop->index + 1 }}
                        </div>
                        @else
                            <div class="flex flex-col items-center justify-center">
                                {{ $loop->index + 1 }}
                            </div>
                        @endif
                    </x-table>
                    <x-table.column>{{ $book->title }}</x-table>
                    <x-table.column>
                        <div class="flex gap-1">
                            @for ($i = 0; $i < $book->users_count; $i++)
                                <div 
                                @class([
                                    'p-2 rounded-sm',
                                    [
                                        'bg-emerald-100', 'bg-emerald-200', 'bg-emerald-300', 'bg-emerald-400', 'bg-emerald-500',
                                        'bg-green-100', 'bg-green-200', 'bg-green-300', 'bg-green-400', 'bg-green-500',
                                        'bg-yellow-100', 'bg-yellow-200', 'bg-yellow-300', 'bg-yellow-400', 'bg-yellow-500',
                                        'bg-amber-100', 'bg-amber-200', 'bg-amber-300', 'bg-amber-400', 'bg-amber-500',
                                        'bg-orange-100', 'bg-orange-200', 'bg-orange-300', 'bg-orange-400', 'bg-orange-500',
                                        'bg-red-100', 'bg-red-200', 'bg-red-300', 'bg-red-400', 'bg-red-500'
                                    ][min($loop->index * 5 + $i, 29)] => true,
                                ])
                                ></div>
                            @endfor
                        
                        </div>
                    </x-table>
                </x-table>
            @endforeach
        </x-table>

        <div>
            {{ $books->links() }}
        </div>
    @endif

    @if ($readers->count() == 0)
       <x-empty.user>
            @if (auth()->user()->role != Role::Student)
            <x-nav-link :href="route('books')" wire:navigate>
                {{ __('Add Users') }}
            </x-nav-link>
            @endif
       </x-empty>
    @else 
        <h2 class="text-xl font-semibold  text-gray-900 dark:text-gray-100">
            {{ __("Top Readers") }}
        </h2>
        <x-table :columns="['Ranking', 'Lector', '# Prestamos']">
            @foreach ($readers as $reader)
                <x-table.row>
                    <x-table.column>
                        @if (in_array($loop->index + 1, [1,2,3]))
                        <div 
                        @class([
                            'flex flex-col gap-4 items-center justify-center',
                            'text-yellow-300' => $loop->index == 0,
                            'text-orange-300' => $loop->index == 2
                        ])
                        >
                            <x-heroicon-s-trophy class="w-16 h-16"/>
                            {{ $loop->index + 1 }}
                        </div>
                        @else
                            <div class="flex flex-col items-center justify-center">
                                {{ $loop->index + 1 }}
                            </div>
                        @endif
                    </x-table>
                    <x-table.column>{{ $reader->name }}</x-table>
                    <x-table.column>
                        <div class="flex gap-1">
                            @for ($i = 0; $i < $reader->books_count; $i++)
                                <div 
                                @class([
                                    'p-1 rounded-sm',
                                    // [
                                    //     'bg-emerald-100', 'bg-emerald-200', 'bg-emerald-300', 'bg-emerald-400', 'bg-emerald-500',
                                    //     'bg-green-100', 'bg-green-200', 'bg-green-300', 'bg-green-400', 'bg-green-500',
                                    //     'bg-yellow-100', 'bg-yellow-200', 'bg-yellow-300', 'bg-yellow-400', 'bg-yellow-500',
                                    //     'bg-amber-100', 'bg-amber-200', 'bg-amber-300', 'bg-amber-400', 'bg-amber-500',
                                    //     'bg-orange-100', 'bg-orange-200', 'bg-orange-300', 'bg-orange-400', 'bg-orange-500',
                                    //     'bg-red-100', 'bg-red-200', 'bg-red-300', 'bg-red-400', 'bg-red-500'
                                    // ][min($loop->index * 5 + $i, 29)] => true,
                                ])
                                >
                                 <x-heroicon-s-book-open class="w-4 h-4 rotate-45" />
                                </div>
                            @endfor
                        
                        </div>
                    </x-table>
                </x-table>
            @endforeach
        </x-table>

        <div>
            {{ $readers->links() }}
        </div>
    @endif
</x-shell>