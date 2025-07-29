import Pusher from 'pusher-js';
import Echo from 'laravel-echo';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'rspcqi8dnk99kldrgo9c',
    wsHost: window.location.hostname,
    wsPort: 8080, // 👈 WebSocket port used by Reverb
    forceTLS: false,
    cluster: 'mt1',
    disableStats: true,
    encrypted: true, // 👈 make sure it's encrypted
    enabledTransports: ['ws'],
});
