window._ = require('lodash');
window.Popper = require('popper.js').default;


try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}


window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

hljs = require('highlightjs/highlight.pack.js');

//load custom js
require('./alert-autohide');
require('./indent-textarea-by-tab');
require('./script');

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
