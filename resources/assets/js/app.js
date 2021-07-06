require('./libraries');

import Alpine from 'alpinejs'
window.Alpine = Alpine
Alpine.start()

window.Vue = require('vue');

//Bootstrap
Vue.component('comment-form', require('./components/bootstrap/article/CommentForm.vue').default);
Vue.component('comments', require('./components/bootstrap/article/Comments.vue').default);
Vue.component('article-form', require('./components/bootstrap/article/ArticleForm.vue').default);

const app = new Vue({
    el: '#l5_blog'
});

