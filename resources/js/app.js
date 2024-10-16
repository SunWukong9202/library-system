import './bootstrap';

//using behavior pattern
document.addEventListener('input', event => {
    let el = event.target;
    if(!el.dataset.limitToHours) return;
    let hour = el.value.split(':')[0]
    el.value = `${hour}:00`
});