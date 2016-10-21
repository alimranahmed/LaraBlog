var Vue = require('vue/dist/vue.js');
var VueRouter = require('vue-router');
require('vue-resource');

Vue.use(VueRouter);

var articles = require('./components/articles.vue');

var routes = [
    { path: '/', component: articles },
    { path: '/articles', component: articles }
];

var router = new VueRouter({
    routes:routes // short for routes: routes
});

var app = new Vue({}).$mount('#app');

//Load vue and vue resource
// window.Vue = require('vue');

//Generate csrf token
// window.Laravel = { csrfToken: '{{ csrf_token() }}' };
//
// Vue.http.interceptors.push(function(request, next){
//     request.headers['X-CSRF-TOKEN'] = Laravel.csrfToken;
//
//     next();
// });