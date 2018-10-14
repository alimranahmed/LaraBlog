require('./libraries');

window.Vue = require('vue');

Vue.component('comment-form', require('./components/article/CommentForm.vue'));
Vue.component('comments', require('./components/article/Comments.vue'));
Vue.component('article-form', require('./components/article/ArticleForm.vue'));


const app = new Vue({
    el: '#l5_blog'
});

