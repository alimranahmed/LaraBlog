require('./libraries');


/*window.Laravel = {csrfToken: '{{ csrf_token() }}'};

Vue.http.interceptors.push(function (request, next) {
    request.headers['X-CSRF-TOKEN'] = Laravel.csrfToken;

    next();
});*/

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('content');

import Echo from "laravel-echo"

window.Pusher = require('pusher-js');

var pusher = new Pusher('bbadb783c3924ad225f7', {
    authEndpoint: "/broadcasting/auth",
    encrypted: true
});
/*
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'bbadb783c3924ad225f7',
    cluster: 'mt1'
});

window.Echo.private('visitor-activity')
    .listen('comment-on-article', function(e){
        console.debug(e);
});*/
