require('./libraries');

window.Vue = require('vue');

Vue.component('comment-form', require('./components/article/CommentForm.vue').default);
Vue.component('comments', require('./components/article/Comments.vue').default);
Vue.component('article-form', require('./components/article/ArticleForm.vue').default);


const app = new Vue({
    el: '#l5_blog'
});

