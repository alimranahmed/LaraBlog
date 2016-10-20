import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)
const Foo = { template: '<div>foo</div>' }
const Bar = { template: '<div>bar</div>' }

const routes = [
    { path: '/foo', component: Foo },
    { path: '/bar', component: Bar }
]

const router = new VueRouter({
    routes // short for routes: routes
})

const app = new Vue({
    router
}).$mount('#app')


// var Vue = require('vue');
// var VueRouter = require('vue-router');
//
// Vue.use(VueRouter);
//
// var App = Vue.extend({});
//
// var router = new VueRouter();
//
// var Home = Vue.extend({
//     template: 'Welcome to the <b>home page</b>!'
// });
//
// var People = Vue.extend({
//     template: 'Look at all the people who work here!'
// });
//
// router.map({
//     '/': {
//         component: Home
//     },
//     '/people': {
//         component: People
//     }
// });
//
// router.start(App, '#app');