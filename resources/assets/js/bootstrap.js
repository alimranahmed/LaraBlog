
window._ = require('lodash');

//load Jquery & bootstrap
window.$ = window.jQuery = require('jquery');
require('bootstrap-sass');
// require('materialize-css');

//Load vue and vue resource
window.Vue = require('vue');
require('vue-resource');

/**
 * register a HTTP interceptor to attach the "CSRF" header to each of
 * the outgoing requests issued by this application.
 */

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
