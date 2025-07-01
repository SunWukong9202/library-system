<x-slot:header>
    {{-- <div class="flex flex-col md:flex-row md:items-center gap-4">
        <h2 class=" font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Movements') }}
        </h2>
        <div class="flex flex-col sm:flex-row gap-4 sm:items-center md:flex-1 md:max-w-lg md:ml-auto">
            <x-primary-button
            class="flex-1" 
            x-on:click="$dispatch('open-transaction', '{{ $form?->name ?? '' }}')">
                {{ __('Register a borrow') }}
            </x-primary-button>
    
            <x-primary-button 
            class="flex-1"
            x-on:click="$dispatch('open-transaction', '{{ $form?->name ?? '' }}')">
                {{ __('Register a return') }}
            </x-primary-button>
        </div>
    </div> --}}
    <div class="flex justify-between items-center gap-4">
        <h2 class=" font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Movements') }}
        </h2>
        <x-primary-button x-on:click="$dispatch('open-form', '{{ $borrowForm }}')">
            {{ __('Register a borrow') }}
        </x-primary-button>
    </div>
</x-slot>
@use('App\Enums\Role')
@use('App\Enums\Transaction')

<x-shell.page 
x-on:form-borrow="$wire.registerBorrow($wire.selected.id)"
x-modelable="selected"
wire:model="selected"
x-data="{ 
    selected: null,
}"
x-on:select="console.log($event.detail); selected = $event.detail"
x-on:book-picked="$wire.picks.push($event.detail)"
x-on:unselect="selected = null; $wire.picks.forEach(el => $dispatch('book-returned', el))"
class="flex flex-col gap-8" >   
    
    <x-form.borrow :name="$borrowForm">
    
    <div 
    x-show="selected">
        <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">
            {{ __("You've selected this student now you can assign books to it.if you want to unselect him/her click the card below.") }}
        </p>
        <x-shell.card 
            x-on:click="$dispatch('unselect')">
            <p class="text-sm font-medium text-gray-900 truncate dark:text-white" x-text="selected?.key" ></p>
            <p class="text-sm text-gray-500 truncate dark:text-gray-400" x-text="selected?.name"></p>
        </x-shell>

        <div class="flex flex-col lg:flex-row gap-4">
            <div class="flex-1 py-4">
                <div class="mb-4">
                    <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Here you can search for the books the student want to borrow.') }}
                    </p>
                    
                    <div class="relative" x-on:keydown.enter.prevent="">
                    
                        <x-text-input wire:model.live.debounce="bookTerm"
                        class="mt-1 block w-full rounded-r-none" autofocus />
                        <x-heroicon-s-magnifying-glass class="w-5 h-5 absolute right-2 -translate-y-1/2 inset-y-1/2 dark:text-white " />
                    </div>
                </div>
                    
                @if (count($books) == 0 && empty($bookTerm))
                    <x-empty.book>
                        <x-nav-link :href="route('books')" wire:navigate>
                            {{ __('Add Books') }}
                        </x-nav-link>
                    </x-empty>
                @elseif (count($books) == 0)
                    <div class="h-32 text-md dark:text-white flex items-center justify-center">
                        {{ __('No results found for') . ': ' }} <b>"{{ $userTerm }}"</b>    
                    </div>
                @else
                    <div custom-scrollbar class="flex flex-col gap-4 max-h-[512px] pr-4 overflow-y-auto relative">
                        <x-loading wire:loading />
                        {{-- //key, name, | email --}}
                        @foreach ($books as $book)
                            <x-shell.card x-data="{ 
                                available: {{ json_encode($book->copies > 0) }},
                                id: {{ $book->id }},
                                copies: {{ $book->copies }}, 
                                pick(book) {
                                    if(this.copies > 0) {
                                        this.$dispatch('book-picked', book)
                                        this.copies = Math.max(this.copies - 1, 0);
                                    }
                                },
                                handleReturn(book) {
                                    if(book.id != this.id) return;
                                    this.copies += 1;
                                    $wire.picks = $wire.picks.filter(el => el != book)
                                }
                            }"
                            x-bind:class="{
                                'border-l-red-400 dark:border-l-red-600 cursor-not-allowed': !(copies > 0),
                                'border-l-indigo-400 dark:border-l-indigo-600 cursor-pointer': copies > 0
                            }"
                            x-on:book-returned.window="handleReturn($event.detail)"
                            x-on:click="pick({{ json_encode($book->makeHidden(['created_at', 'updated_at'])) }});" 
                            class="flex">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                        {{ $book->isbn }}
                                    </p>
                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                        {{ $book->title }}
                                    </p>    
                                </div>
                                <div class="max-w-4 dark:text-white text-base font-semibold items-center justify-center flex">
                                    <div class="p-4 rounded-full flex items-center justify-center" x-bind:class="{'bg-indigo-600': copies > 0, 'bg-red-600': !(copies > 0)}" x-text="copies" ></div>
                                </div>
                                
                            </x-shell>
                        @endforeach
                    </div>
                    <div class="mt-4 mr-4">
                        {{ $students->links() }}
                    </div>
                @endif
            </div>
            <div 
            class="flex-1 py-4 mt-4 flex flex-col gap-4 max-h-[512px]" custom-scrollbar> 
                <template x-for="(book, idx) in $wire.picks" x-bind:key="idx">
                    <x-shell.card x-on:click="$dispatch('book-returned', book);" class="flex">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white" x-text="book.isbn"></p>
                            <p class="text-sm text-gray-500 truncate dark:text-gray-400" x-text="book.title"></p>    
                        </div>
                            <div class="max-w-4 dark:text-white text-base font-semibold items-center justify-center flex">
                                <div class="p-4 rounded-full bg-indigo-600 flex items-center justify-center" x-text="1"></div>
                            </div>
                    </x-shell>

                </template>
            </div>
        </div>
    </div>
    
    <div x-show="!selected">
        <div>
            <p class="mb-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('If the student isnt registered. you can add it by clicking below') }}
            </p>
            <x-primary-button x-on:click="$dispatch('open-form', 'form-user')">
                {{ __('Add New Student') }}
            </x-primary-button>
        </div>

        <div class="flex flex-col lg:flex-row gap-4">
            <div class="flex-1 py-4">
                <div class="mb-4">
                    <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Here you can search for the student to which you want to register a borrow.') }}
                    </p>
                    
                    <div class="relative" x-on:keydown.enter.prevent="">
                    
                        <x-text-input wire:model.live.debounce="userTerm"
                        class="mt-1 block w-full rounded-r-none" autofocus />
                        <x-heroicon-s-magnifying-glass class="w-5 h-5 absolute right-2 -translate-y-1/2 inset-y-1/2 dark:text-white " />
                    </div>
                </div>
                    
                @if (count($students) == 0 && empty($userTerm))
                    <x-empty.user>
                        <x-nav-link :href="route('users')" wire:navigate>
                            {{ __('Add Users') }}
                        </x-nav-link>
                    </x-empty>
                @elseif (count($students) == 0)
                    <div class="h-32 text-md dark:text-white flex items-center justify-center">
                        {{ __('No results found for') . ': ' }} <b>"{{ $userTerm }}"</b>    
                    </div>
                @else
                    <div custom-scrollbar class="flex flex-col gap-4 max-h-[512px] pr-4 overflow-y-auto relative">
                        <x-loading wire:loading />
                        {{-- //key, name, | email --}}
                        @foreach ($students as $student)
                            <x-shell.card x-on:click="$dispatch('select', {{ json_encode($student) }})">
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                    {{ $student->key }}
                                </p>
                                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                    {{ $student->name }}
                                </p>
                                
                            </x-shell>
                        @endforeach
                    </div>
                    <div class="mt-4 mr-4">
                        {{ $students->links() }}
                    </div>
                @endif
            </div>
            <div>
                <x-form.user name="form-user" :$form class="!py-10"/>
            </div>
        </div>
    </div>
    </x-form>

    @if (count($transactions) == 0)
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center justify-center gap-8">
            <x-application-logo class="block h-16 w-auto fill-current text-gray-800 dark:text-gray-200" />
            
            <header>
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('No Borrows yet maded') }}
                </h2>
                
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('There are no borrows listed at the moment. Please check back later or register a new borrow to get started.') }}
                </p>

                <div class="mt-2">
                    <x-primary-button x-on:click="$dispatch('open-form', '{{ $borrowForm }}')">
                        {{ __('Register a borrow') }}
                    </x-primary-button>
                </div>
                
            </header>    
        </div>
    @else 
        <x-table custom-scrollbar :columns="['Clave', 'Alumno' ,'ISBN', 'Titulo', 'Prestado', 'Devuelto', 'Acciones']">
            @foreach ($transactions as $transaction)
                <x-table.row>
                    <x-table.column>
                        {{ $transaction->user_key }}
                    </x-table.column>

                    <x-table.column>
                        {{ $transaction->user_name }}
                    </x-table.column>

                    <x-table.column>
                        {{ $transaction->book_isbn }}
                    </x-table.column>

                    <x-table.column>
                        {{ $transaction->book_title }}
                    </x-table.column>

                    <x-table.column>
                        {{ $this->formatTimestamp($transaction->pivot_created_at) }}
                    </x-table.column>

                    <x-table.column>
                        @if ($transaction->type == Transaction::Borrow->value)
                            Pendiente
                        @else
                            {{ $this->formatTimestamp($transaction->pivot_updated_at) }}
                        @endif
                    </x-table.column>

                    <x-table.column class="flex gap-2 items-center justify-center">
                        @if ($transaction->type == Transaction::Borrow->value)
                            <x-primary-button 
                                wire:confirm="{{ __('messages.book_returning', [
                                    'student' => $transaction->user_name,
                                    'book' => $transaction->book_title,
                                    'copies' => 1
                                ])}}"
                                wire:click="registerReturn({{ $transaction->pivot_id }}, {{ $transaction->book_id }})">
                                {{ __('Register a return') }}
                            </x-primary-button>
                        @endif
                    </x-table.column>
                </x-table.row>
            @endforeach
        </x-table>

        <div>
            {{ $transactions->links() }}
        </div>
    @endif
</x-shell>