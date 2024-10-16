@props([
    'content' => '',
])

<div class="relative mb-4" x-data="clipboard">
    <input type="text"
    value="{{ $content }}"
    x-ref="content"
    {{ $attributes->class([
        'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full'
    ]) }}  disabled readonly>
    <button 
    x-on:click="copy"
    class="absolute end-2 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg p-2 inline-flex items-center justify-center">
        <x-heroicon-o-clipboard class="w-4 h-4"/>
    </button>

</div>

@script
<script>
    Alpine.data('clipboard', () => ({
        copy() {
            navigator.clipboard.writeText(this.$refs.content.value).then(() => {
                alert('Text copied to clipboard!');
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        }
    }));
</script>
@endscript