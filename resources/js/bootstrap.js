import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key:"4f7c3e031993995d4ffb",
    cluster: eu,
    forceTLS: true
});
