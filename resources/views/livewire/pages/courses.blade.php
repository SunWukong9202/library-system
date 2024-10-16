<x-slot:header>
    <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Courses') }}
        </h2>

        <x-primary-button x-on:click="$dispatch('open-course-form')">
            {{ __('See Form') }}
        </x-primary-button>
    </div>
</x-slot>

<x-shell.page class="flex flex-col gap-8" 
x-data="{ showCourseForm : false }" 
>
    <div 
        x-show="showCourseForm"
        x-on:open-course-form.window="showCourseForm = true";
        x-on:close-course-form.window="showCourseForm = false";
        class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg"
    >
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ isset($form->course) ? __('Edit Course Form') : __('Create Course Form') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Please fill all the fields required (they are specified with a *)') }}
            </p>
        </header>

        <form class="max-w-xl space-y-6 mt-6" wire:submit="{{ isset($form->course) ? 'update' : 'create' }}"> 
            <div class="text-white">
                <x-input-label for="name" :value="__('Name').' *'" />
                <x-text-input wire:model="form.name" id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('form.name')" />
            </div>

            <div> 
                <x-input-label for="key" :value="__('Key').' *'" />
                <x-text-input x-mask="999999" wire:model="form.key" id="key" name="key" type="text" class="mt-1 block w-full" required autofocus autocomplete="key" />
                <x-input-error class="mt-2" :messages="$errors->get('form.key')" />
            </div>
            
            <div> 
                <x-input-label for="credits">
                    {{ __('Credits').' *' }}
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Please provide values beetwen 1 and 16') }}
                    </p>
                </x-input-label>
                <x-text-input x-mask="99" wire:model="form.credits" x-on:change="$wire.form.credits = Math.min(Math.max(1, $event.target.value), 16)" id="credits" name="credits" type="number" min="1" max="16" class="mt-1 block w-full" required autofocus autocomplete="credits" />
                <x-input-error class="mt-2" :messages="$errors->get('form.credits')" />
            </div>

            <div x-data="{
                start: '07:00',
                end: '08:00',
                min: '07:00',
                max: '20:00',
                error: null,
                checkRange(val, min, max) {
                    this.error = null;
            
                    if (this.int(val) < this.int(min)) {
                        this.error = `Por favor selecciona una hora mayor o igual a ${min}`;
                        return min;
                    }
            
                    if (this.int(val) > this.int(max)) {
                        this.error = `Por favor selecciona una hora menor o igual a ${max}`;
                        return max;
                    }
            
                    return val;
                },
                addHoursTo(val, hours = 1) {
                    const newTime = this.int(val) + hours;
                    const hoursWithPadding = Math.min(newTime, this.int(this.max)).toString().padStart(2, '0');
                    return `${hoursWithPadding}:00`;
                },
                subHoursTo(val, hours = 1) {
                    const newTime = this.int(val) - hours;
                    const hoursWithPadding = Math.max(newTime, this.int(this.min)).toString().padStart(2, '0');
                    return `${hoursWithPadding}:00`;
                },

                int(val) {
                    return parseInt(val.split(':')[0]);
                }
            }">
                <div class="flex gap-x-8 gap-y-6 flex-wrap">
                    <div class="flex-1 min-w-60">
                        <x-input-label for="start" :value="__('Start').' *'" />
                        <x-text-input
                            x-on:input="$wire.form.start = checkRange($event.target.value, min, subHoursTo(max)); $event.target.blur()"
                            wire:model="form.start"
                            id="start"
                            name="start"
                            type="time"
                            class="mt-1 block w-full"
                            required
                            autofocus
                            autocomplete="start"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('form.start')" />
                    </div>
            
                    <div class="flex-1 min-w-60">
                        <x-input-label for="end" :value="__('End').' *'" />
                        <x-text-input
                            x-on:input="$wire.form.end = checkRange($event.target.value, addHoursTo($wire.form.start), max); $event.target.blur()"
                            wire:model="form.end"
                            x-on:change="$event.target.blur()" 
                            id="end"
                            name="end"
                            type="time"
                            class="mt-1 block w-full"
                            required
                            autofocus
                            autocomplete="end"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('form.end')" />
                    </div>
                </div>
            
                <p x-show="error" x-effect="if(error) setTimeout(() => error = null, 6000)" x-text="error" class="text-sm text-red-600 dark:text-red-400 space-y-1"></p>
            </div>
            

            <div class="flex gap-8">
                <x-secondary-button x-on:click="showCourseForm = false">
                    {{ __('Hide') }}
                </x-secondary-button>
                <x-primary-button>
                    {{ isset($form->course) ? __('Edit') :__('Create') }}
                </x-primary-button>
            </div>

        </form>
    </div>

    @if (count($courses) == 0)
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center justify-center gap-8">
            <x-application-logo class="block h-16 w-auto fill-current text-gray-800 dark:text-gray-200" />
            
            <header>
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('No Courses Available') }}
                </h2>
                
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('There are no courses listed at the moment. Please check back later or add a new course to get started.') }}
                </p>

                <div class="mt-2">
                    <x-primary-button x-on:click="showCourseForm = true">
                        {{ __('Add courses') }}
                    </x-primary-button>
                </div>
                
            </header>    
        </div>
    @else    
        <x-table :columns="['Clave', 'Nombre', 'Creditos', 'Horario', 'Acciones']">
            @foreach ($courses as $course)
                <x-table.row>
                    <x-table.column>{{ $course->key }}</x-table>
                    <x-table.column>{{ $course->name }}</x-table>
                    <x-table.column>{{ $course->credits }}</x-table>
                    <x-table.column>
                        {{ $course->start .' - '. $course->end }}
                    </x-table>
                    <x-table.column class="flex gap-2 items-center justify-center">
                        <x-primary-button 
                        wire:click="load({{ $course->id }})"
                        >
                            <x-heroicon-s-pencil class="w-4 h-4"/>
                        </x-secondary-button>
                        <x-danger-button 
                        wire:confirm="{{ __('Are you sure you want to delete this course?') }}"
                        wire:click="delete({{ $course->id }})"
                        >
                            <x-heroicon-s-trash class="w-4 h-4"/>
                        </x-danger-button>
                    </x-table>
                </x-table>
            @endforeach
        </x-table>
        <div>
            {{ $courses->links() }}
        </div>
    @endif
</x-shell>

@script
<script>
    Alpine.data('range-time-validation', () => ({
        start: '07:00',
        end: '08:00',
        min: '07:00',
        max: '20:00',
        error: null,
        checkRange(val, min, max) {
            this.error = null

            if(this.int(val) < this.int(min)) {
                this.error = `Por favor selecciona una hora mayor o igual ${min}`;
                return min
            }
            
            if(this.int(val) > this.int(max)) {
                this.error = `Por favor selecciona una hora menor o igual a ${max}`
                return max
            }

            return val;
        },
        addHoursTo(val, hours = 1) {
            return min(this.int(val) + hours, this.int(this.max)) + ':00'
        },
        subHoursTo(val, hours = 1) {
            return max(this.int(val) - hours, this.int(this.min)) + ':00'
        },
        int(val) {
            return +val.split(':')[0]
        }
    }));
</script>
@endscript