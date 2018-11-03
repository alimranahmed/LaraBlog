<template>
    <div class="col-sm-12" id="comment-form">
        <form action="#" method="post" onsubmit="return false;" name="add_comment_form" v-on:submit="addComment(comment)">
            <div class="form-group col-sm-12 no-padding">
                <textarea name="content" class="form-control" id="comment" rows="3" v-model="comment.content" placeholder="Comment*" required></textarea>
            </div>

            <div class="form-group col-sm-6 no-padding-left">
                <input type="text" name="name" value="" class="form-control" v-model="comment.name" id="name" placeholder="Name*" required>
            </div>

            <div class="form-group col-sm-6 no-padding-right">
                <input type="email" name="email" value="" class="form-control" v-model="comment.email" id="email" placeholder="Email*" required>
            </div>

            <div class="form-group col-sm-6 col-sm-offset-6 no-padding-right checkbox">
                <label>
                    <input type="checkbox" name="notify" v-model="comment.notify"> Notify me about new article
                </label>
                <button type="submit" class="btn btn-primary pull-right"
                        id="submit-comment-btn">Comment
                </button>
            </div>

        </form>
    </div>
</template>

<script>
    import * as Ladda from 'ladda';
    import {alertError, alertSuccess} from "@/script";

    export default {
        props: {
            add_comment_url: String,
        },
        data() {
            return {
                comment: {
                    content: '',
                    name: '',
                    email: '',
                    notify: false,
                },
            }
        },

        methods: {
            addComment(comment) {
                let l = Ladda.create(document.querySelector('#submit-comment-btn'));
                l.start();

                axios.post(this.add_comment_url, comment)
                    .then(response => {
                        //hide comment form
                        $("#comments").html(response.body);
                        $('#comment-form').hide();
                        alertSuccess('Success! you comment will be published soon');
                        //clear form values
                        $('input').val('');
                        $('textarea').val('');
                        l.stop();
                    })
                    .catch(error => {
                        alertError(error);
                        l.stop();
                    });
            }
        }
    }
</script>

<style scoped>

</style>