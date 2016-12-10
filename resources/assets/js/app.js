require('./libraries');


window.Laravel = {csrfToken: '{{ csrf_token() }}'};

Vue.http.interceptors.push(function (request, next) {
    request.headers['X-CSRF-TOKEN'] = Laravel.csrfToken;

    next();
});