<template>
    <div class="row">
        <h1 v-for="article in articles" @click='getArticles()'>{{article.heading }}</h1>
    </div>
</template>

<script>
    export default {
        name: 'article-list',
        data: function() {
            return {
                "articles": [
                    {"heading": "Nothing","content":"something"}
                ],
            }
        },
        ready: function(){
            console.debug('inside ready() function');
            this.getArticles();
        },

        methods: {
            getArticles: function(){
                console.debug('inside getArticles() function');
                this.$http.get('index.php/api/article').then(function (response) {
                    console.debug(response.data);
                    this.articles = response.data;
                });
            }
        }
    };

</script>
