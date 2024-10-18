<div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center justify-center gap-8">
    <x-application-logo class="block h-16 w-auto fill-current text-gray-800 dark:text-gray-200" />
    
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('No Users Available') }}
        </h2>
        
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('There are no users listed at the moment. Please check back later or add a new user to get started.') }}
        </p>

        <div class="mt-2">
            {{ $slot }}
        </div>
        
    </header>    
</div>