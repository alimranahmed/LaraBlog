require('./libraries');

window.Vue = require('vue');

Vue.component('single-article', require('./components/article/SingleArticle.vue'));
Vue.component('keywords', require('./components/article/Keywords.vue'));
Vue.component('comment-form', require('./components/article/CommentForm.vue'));
Vue.component('comments', require('./components/article/Comments.vue'));


const app = new Vue({
    el: '#l5_blog'
});

