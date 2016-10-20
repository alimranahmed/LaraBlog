var Vue = require('vue/dist/vue.js');
var VueRouter = require('vue-router');

Vue.use(VueRouter);

// var Foo = require('./components/Example.vue');
var Foo = { template: '<div>foo</div>' };
var Bar = { template: '<div>bar</div>' };

var routes = [
    { path: '/foo', component: Foo },
    { path: '/bar', component: Bar }
];

var router = new VueRouter({
    routes:routes // short for routes: routes
});

var app = new Vue({router:router}).$mount('#app');