<template>
    <div>
        <div class="row">
            <div class="col-sm-12">
                <h1 class="article-heading text-xlg no-margin-bottom">{{ article.heading }}</h1>
                <div class="margin-bottom-10">
                    <span class="text-grey">Written {{ article.createdAtHuman }}</span>
                    <span class="text-grey">by {{ article.user.name }} on </span>
                    <a v-bind:href="article_by_category_url">{{ article.category.name}}</a>
                    <a v-if="article.isEditable"
                       v-bind:href="article_edit_url">
                        <span class="fa fa-edit"></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 text-justify text-md" v-html="article.content"></div>
        </div>
        <hr class="margin-bottom-10 margin-top-10">
    </div>
</template>

<script type="application/javascript">
    import * as hljs from "highlightjs";

    export default {
        mounted() {
            hljs.initHighlightingOnLoad();
        },

        props: {
            article: Object,
            article_edit_url: String,
            article_by_category_url: String,
        }
    }
</script>

<style scoped>

</style>