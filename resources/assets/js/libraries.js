
window._ = require('lodash');

//load Jquery & bootstrap
window.$ = window.jQuery = require('jquery');
require('bootstrap-sass');

//Load vue and vue resource
window.Vue = require('vue');
require('vue-resource');
require('./navbar-autohide');
require('./alert-autohide');
require('./script');

//Generate csrf token
window.Laravel = { csrfToken: '{{ csrf_token() }}' };

Vue.http.interceptors.push(function(request, next){
    request.headers['X-CSRF-TOKEN'] = Laravel.csrfToken;

    next();
});




/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from "laravel-echo"

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });
