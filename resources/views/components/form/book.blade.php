@props([
    'name',
    'show' => false,
    'form',
    'model' => 'book'
])
@use('App\Enums\Role')

<x-form.showable :$name :$show >
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ isset($form->$model) ? __('Edit Book Form') : __('Create Book Form') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Please fill all the fields required (they are specified with a *)') }}
        </p>
    </header>

    <form 
    x-data="isbn"
    class="max-w-xl space-y-6 mt-6" 
    x-on:submit.prevent="!calcISBN($wire.form.isbn) ||
    $wire.proxyAction('{{ isset($form->$model) ? 'update' : 'create' }}')"
    > 
        <div>
            <x-input-label for="title" :value="__('Title').' *'" />
            <x-text-input wire:model="form.title" id="title" type="text" class="mt-1 block w-full" required autocomplete="title" />
            <x-input-error class="mt-2" :messages="$errors->get('form.title')" />
        </div>

        <div class="text-white" >
            <x-input-label for="isbn">
                {{ __('ISBN').' *' }}
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    
                    {{ __('Mark the checkbox below if you want to fill an ISBN 13') }}
                    <div class="block">
                        <label for="isbn13" class="inline-flex items-center">
                         <input 
                            x-on:change="$wire.form.isbn = ''; checksum = ''"
                            wire:model="form.isbn13" id="isbn13" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('ISBN 13') }}</span>
                        </label>
                    </div>
                </p>
            </x-input-label>
            <div class="flex ">
                <x-text-input 
                x-show="$wire.form.isbn13"
                x-on:input="checksum = ISBN13Checksum($event.target.value); $wire.form.isbn += checksum"
                x-mask="999-9-999-99999"
                wire:model="form.isbn" id="isbn" type="text" class="mt-1 block w-full rounded-r-none" required autofocus />

                <x-text-input 
                x-show="!$wire.form.isbn13"
                x-mask="9-999-99999"
                x-on:input="checksum = ISBN10Checksum($event.target.value); $wire.form.isbn += checksum"
                wire:model="form.isbn" id="isbn" type="text" class="mt-1 block w-full rounded-r-none" required autofocus />
                
                <x-text-input 
                readonly
                x-bind:value="checksum"
                class="rounded-l-none min-w-8 mt-1"
                />

            </div>

            <x-input-error class="mt-2" :messages="$errors->get('form.isbn')" />
            <p x-show="error" x-effect="if(error) setTimeout(() => error = null, 2000)" x-text="error" class="text-sm text-red-600 dark:text-red-400 space-y-1"></p>

        </div>

        <div> 
            <x-input-label for="copies">
                {{ __('Copies').' *' }}
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Please provide values beetwen 1 and 255') }}
                </p>
            </x-input-label>
            
            <x-text-input x-mask="999" wire:model="form.copies" x-on:change="$wire.form.copies = Math.min(Math.max(1, $event.target.value), 255)" id="copies" type="number" min="1" max="255" class="mt-1 block w-full" required autofocus autocomplete="copies" />
            <x-input-error class="mt-2" :messages="$errors->get('form.copies')" />
        </div>

        <div class="flex gap-8">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Hide') }}
            </x-secondary-button>
            <x-primary-button>
                {{ isset($form->$model) ? __('Edit') :__('Create') }}
            </x-primary-button>
        </div>

    </form>
</x-form>

@script
<script>
    Alpine.data('isbn', () => ({
        error: null,
        checksum: '',
        validate(isbn) {
            
            isbn = isbn.replace(/-/g, '');

            const digits = isbn.split('').map(Number);
            
            if(!$wire.form.isbn13) {
                if (digits.length < 9) {
                    this.error = '{{ __('ISBN-10 must be 9 digits.') }}';
                }
            } else {
                if (digits.length < 12) {
                    this.error = '{{ __('ISBN-13 must be 12 digits.') }}';
                }
            }

            return this.error ? '' : digits;
        },
        calcISBN(isbn) {
            this.checksum = '';
            console.log(isbn);
            checksum = this.ISBNChecksum(isbn);
            console.log(isbn, 'checksum: ' + checksum);
            $wire.form.isbn += checksum;
            return this.error ? '' : 'Valid';
        },
        ISBNChecksum(isbn) {
            if($wire.form.isbn13) {
                return isbn.length == 17
                    ? ''
                    : this.ISBN13Checksum(isbn)
            } else {
                return isbn.length == 13
                    ? ''
                    :this.ISBN10Checksum(isbn)
            }
        },
        ISBN10Checksum(isbn) {
            const digits = this.validate(isbn)
            
            if(this.error) return '';

            let sum = 0;
            for (let i = 0; i < digits.length; i++) {
                sum += digits[i] * (i + 1);
            }
            
            const checksum = sum % 11;

            return '-' + (checksum === 10 ? 'X' : checksum.toString());
        },
        ISBN13Checksum(isbn) {
            const digits = this.validate(isbn)
            
            if(this.error) return '';

            let sum = 0;
            for (let i = 0; i < digits.length; i++) {
                sum += digits[i] * (i % 2 === 0 ? 1 : 3);
            }
            const checksum = (10 - (sum % 10)) % 10;
            return "-" + checksum.toString();
        }
    }));
</script>
@endscript

