<div class="py-12">
    <div 
    {{ $attributes->class([
        'max-w-7xl mx-auto sm:px-6 lg:px-8'
    ]) }}
    {{-- class="max-w-7xl mx-auto sm:px-6 lg:px-8" --}}
    >
        {{ $slot }}
    </div>
</div>

{{-- <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div 
        {{ $attributes->class([
            'bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg'
        ]) }}
        >
            {{ $slot }}
        </div>
    </div>
</div> --}}

        {{-- class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg" --}}
