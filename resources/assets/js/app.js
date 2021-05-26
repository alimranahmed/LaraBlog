require('./libraries');

window.Vue = require('vue');

let frontendDesign = process.env.MIX_FRONTEND_DESIGN;

if (frontendDesign === 'tailwindcss') {
    Vue.component('comment-form', require('./components/tailwindcss/article/CommentForm.vue').default);
    Vue.component('comments', require('./components/tailwindcss/article/Comments.vue').default);
    Vue.component('article-form', require('./components/tailwindcss/article/ArticleForm.vue').default);

} else if (frontendDesign === 'bootstrap') {
    //Bootstrap
    Vue.component('comment-form', require('./components/bootstrap/article/CommentForm.vue').default);
    Vue.component('comments', require('./components/bootstrap/article/Comments.vue').default);
    Vue.component('article-form', require('./components/bootstrap/article/ArticleForm.vue').default);
}
const app = new Vue({
    el: '#l5_blog'
});

