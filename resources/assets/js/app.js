require('./libraries');


/*window.Laravel = {csrfToken: '{{ csrf_token() }}'};

Vue.http.interceptors.push(function (request, next) {
    request.headers['X-CSRF-TOKEN'] = Laravel.csrfToken;

    next();
});*/

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('content');