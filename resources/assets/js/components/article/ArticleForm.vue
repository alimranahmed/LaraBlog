<template>
    <form :action="url" method="post" v-on:submit.prevent="storeArticle(article)">
        <div class="form-group">
            <input type="text" class="form-control" name="heading" v-model="article.heading"
                   placeholder="*Heading..." required>
        </div>
        <div class="form-group">
            <select class="form-control" name="category_id" v-model="article.category_id">
                <option :value="category.id" v-for="category in categories">
                    {{category.name}}
                </option>
            </select>
        </div>
        <div class="form-group">
            <markdown-editor v-model="article.content" ref="markdownEditor"></markdown-editor>
        </div>
        <div class="text-grey">
            Tips for keywords: separate your keywords by space. Some popular keywords are:
        </div>
        <div class="form-group">
            <strong>Keywords: </strong><label id="keywords-show"></label>
            <input type="text" id="keyword"
                   v-on:keyup="formatKeyword('#keyword', '#keywords-show')"
                   v-model="article.keywords"
                   class="form-control" name="keywords" placeholder="Keywords" required>
        </div>
        <div class="form-group">
            <div v-for="language in languages">
                <input :id="'radio-'+language.key" type="radio" name="language"
                       v-model="article.language"
                       :value="language.key">
                <label :for="'radio-'+language.key">{{language.value}}</label>
            </div>
        </div>
        <div class="form-group">
            <input type="checkbox" name="is_comment_enabled"
                   value="1"
                   v-model="article.is_comment_enabled"
                   checked id="comment-enabled">
            <label for="comment-enabled">Comment Allowed</label>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success" id="submit-btn">Create</button>
        </div>
    </form>
</template>

<script>
    import markdownEditor from 'vue-simplemde/src/markdown-editor';
    import * as Ladda from 'ladda';

    export default {
        name: "ArticleForm",
        components: {
            markdownEditor
        },
        props: {
            categories: Array,
            languages: Array,
            url: String,
        },
        data() {
            return {
                article: {
                    heading: '',
                    category_id: 1,
                    content: '',
                    keywords: '',
                    language: 'ben',
                    is_comment_enabled: true,
                }
            }
        },
        methods: {
            formatKeyword(inputId, displayId) {

                let keywords = $(inputId).val().split(' ');
                let htmlToShow = '';
                for (var i = 0; i < keywords.length; i++) {
                    htmlToShow += "<span class='label label-info margin-right-5'>" + keywords[i] + "</span>";
                }
                $(displayId).html(htmlToShow);
            },
            storeArticle(article) {
                let l = Ladda.create(document.querySelector('#submit-btn'));
                l.start();

                self = this;

                axios.post(this.url, article)
                    .then(function (response) {
                        console.log(response);
                        //show success alert
                        let successAlert = $('#success-alert');
                        successAlert.show();
                        successAlert.fadeOut(1000 * 10);
                        $('#success-msg').html(response.data.message);
                        //clear form values
                        self.article = {
                            heading: '',
                            category_id: 1,
                            content: '',
                            keywords: '',
                            language: 'ben',
                            is_comment_enabled: true,
                        };
                        l.stop();
                    })
                    .catch(function (error) {
                        console.log(error);
                        //show error alert
                        let errorAlert = $('#error-alert');
                        errorAlert.show();
                        errorAlert.fadeOut(1000 * 10);
                        $('#error-msg').html(error.message);
                        l.stop();
                    })
            }
        }
    }
</script>

<style scoped>
    @import '~simplemde/dist/simplemde.min.css';
</style>