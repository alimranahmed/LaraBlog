//load bootstrap.js file of current directory
require('./libraries');
require('./routes.js');
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

// Vue.component('example', require('./components/articles.vue'));

// const app = new Vue({
//     el: 'body',
//     data: {
//         "articles": []
//     },
//     methods: {
//         getArticles: function(){
//             this.$http.get('index.php/api/article').then(function (response) {
//                 console.debug(response.data);
//                 this.articles = response.data;
//             });
//         }
//     }
// });
