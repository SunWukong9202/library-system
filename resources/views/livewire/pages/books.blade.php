<x-slot:header>
    <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Books') }}
        </h2>
        
        <x-primary-button x-on:click="$dispatch('open-form', '{{ $form->name }}')">
            {{ __('See Form') }}
        </x-primary-button>
    </div>
</x-slot>
@use('App\Enums\Role')

<x-shell.page class="flex flex-col gap-8" x-data>    

    <x-form.book :name="$form->name" :$form />

    @if (count($books) == 0)
       <x-empty.book>
            <x-primary-button x-on:click="$dispatch('open-form', '{{ $form->name }}')">
                {{ __('Add Books') }}
            </x-primary-button>
       </x-empty>
    @else 
        <x-table :columns="['ISBN', 'Titulo', 'Copias', 'Acciones']">
            @foreach ($books as $book)
                <x-table.row>
                    <x-table.column>{{ $book->isbn }}</x-table>
                    <x-table.column>{{ $book->title }}</x-table>
                    <x-table.column>{{ $book->copies }}</x-table>
                    <x-table.column class="flex gap-2 items-center justify-center">
                        <x-primary-button 
                        wire:click="proxyAction('load', {{ $book->id }})"
                        >
                            <x-heroicon-s-pencil class="w-4 h-4"/>
                        </x-secondary-button>
                        @can(Role::Admin)
                            <x-danger-button 
                            wire:confirm="{{ __('Are you sure you want to delete this book?') }}"
                            wire:click="proxyAction('delete', {{ $book->id }})"
                            >
                                <x-heroicon-s-trash class="w-4 h-4"/>
                            </x-danger-button>
                        @endcan
                    </x-table>
                </x-table>
            @endforeach
        </x-table>

        <div>
            {{ $books->links() }}
        </div>
    @endif
</x-shell>