import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';


window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


window.Pusher = Pusher;


window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true,
});


window.Echo.channel('my-channel')
    .listen('.task.created', (event) => {
        console.log('Task Created Event:', event);
        alert(`New Task Created: ${event.title}`);
    });
