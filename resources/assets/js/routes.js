var Vue = require('vue');
var VueRouter = require('vue-router');

Vue.use(VueRouter);
import Foo from './components/Example.vue';
import Bar from './components/Example.vue';

var routes = [
    { path: '/foo', component: Foo },
    { path: '/bar', component: Bar }
];

var router = new VueRouter({
    routes // short for routes: routes
});

var app = new Vue({router}).$mount('#app')

//
// var Vue = require('vue');
// var VueRouter = require('vue-router');
//
// Vue.use(VueRouter);
//
// var App = Vue.extend({});
//
// var router = new VueRouter();
//
// var foo = Vue.extend({
//     template: 'Welcome to the <b>home page</b>!'
// });
//
// var bar = Vue.extend({
//     template: 'Look at all the people who work here!'
// });
//
// router.map({
//     '/': {
//         component: foo
//     },
//     '/people': {
//         component: bar
//     }
// });
//
// router.start(App, '#app');