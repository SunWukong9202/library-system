import './bootstrap';
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import sort from '@alpinejs/sort'

//using behavior pattern
document.addEventListener('input', event => {
    let el = event.target;
    if(!el.dataset.limitToHours) return;
    let hour = el.value.split(':')[0]
    el.value = `${hour}:00`
});

Alpine.plugin(sort)
 
Livewire.start()