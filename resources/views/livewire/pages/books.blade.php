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

    
<x-shell.page class="flex flex-col gap-8" x-data>
    
    <p x-text="$wire.form.isbn"></p>

    <x-form.book :name="$form->name" :$form />

    @if (count($books) == 0)
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center justify-center gap-8">
            <x-application-logo class="block h-16 w-auto fill-current text-gray-800 dark:text-gray-200" />
            
            <header>
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('No Books Available') }}
                </h2>
                
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('There are no books listed at the moment. Please check back later or add a new book to get started.') }}
                </p>

                <div class="mt-2">
                    <x-primary-button x-on:click="$dispatch('open-form', '{{ $form->name }}')">
                        {{ __('Add Books') }}
                    </x-primary-button>
                </div>
                
            </header>    
        </div>
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
                        <x-danger-button 
                        wire:confirm="{{ __('Are you sure you want to delete this book?') }}"
                        wire:click="proxyAction('delete', {{ $book->id }})"
                        >
                            <x-heroicon-s-trash class="w-4 h-4"/>
                        </x-danger-button>
                    </x-table>
                </x-table>
            @endforeach
        </x-table>

        <div>
            {{ $books->links() }}
        </div>
    @endif
</x-shell>