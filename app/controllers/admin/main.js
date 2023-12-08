document.addEventListener('DOMContentLoaded', function () {
    let today = new Date();
    let hour = today.getHours();
    let greeting = '';
    if (hour < 12) {
        greeting = 'Buenos días';
    } else if (hour < 19) {
        greeting = 'Buenas tardes';
    } else if (hour <= 23) {
        greeting = 'Buenas noches';
    }
    document.getElementById('greeting').textContent = greeting;
});

